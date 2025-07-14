<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 
use App\Traits\SendResponseTrait;
use App\Models\{ChatRoom, ChatRoomUser, ChatMessage,StudyRoom};

class ChatController extends Controller
{
    use SendResponseTrait;

     /**
     * functionName : create
     * createdDate  : 15-04-2025
     * purpose      : Create Chat room
     */

    public function create(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255|unique:chat_rooms,name',
        ]);

        // Create the chat room
        $chatRoom = ChatRoom::create([
            'name' => $request->name,
            
        ]);

       return $this->apiResponse('success', 200, 'Chat Room created successfully', $chatRoom);
    }

     
     /*end method create */

     /**
     * functionName : addUserToRoom
     * createdDate  : 15-04-2025
     * purpose      : Add user to chat room so that they can send and view messages
     */
     
 
    public function addUserToRoom(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'chat_room_id' => 'required|exists:chat_rooms,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Check if the user is already in the chat room 
        $existing = ChatRoomUser::where('chat_room_id', $request->chat_room_id)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existing) {
           return $this->apiResponse('error', 200, 'User already added to the chat room.');
        }

        // Add user to the chat room
        $chatRoomUser = ChatRoomUser::create([
            'chat_room_id' => $request->chat_room_id,
            'user_id' => $request->user_id,
        ]);

        return $this->apiResponse('success', 200, 'User Added sucesfully in chat room', $chatRoomUser);

    }
     /*end method addUserToRoom */


     /**
     * functionName : saveMessage
     * createdDate  : 15-04-2025
     * purpose      : Send message to a chat roon and save in database
     */


public function saveMessage(Request $request)
{
    $request->validate([
        'chat_room_id' => 'required|exists:chat_rooms,id',
        'sender_id'    => 'required|exists:users,id',
        'message'      => 'nullable|string',
        'image'        => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        'voice'        => 'nullable|file|mimes:mp3,wav,ogg|max:5120',
        'type'         => 'required'
    ]);

    $data = [
        'chat_room_id' => $request->chat_room_id,
        'sender_id'    => $request->sender_id,
        'message'      => $request->message,
        'type'        =>  $request->type,
    ];

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('images', $imageName, 'public');
        $data['image_url'] = config('app.url') . '/storage/' . $path;
    }

    if ($request->hasFile('voice')) {
        $voice = $request->file('voice');
        $voiceName = time() . '_' . uniqid() . '.' . $voice->getClientOriginalExtension();
        $path = $voice->storeAs('images', $voiceName, 'public');
        $data['voice_url'] = config('app.url') . '/storage/' . $path;
    }

    $message = ChatMessage::create($data);

    // Notify socket server
   try {
        Http::post(env('SOCKET_IO_URL') . '/emit-message', [
            'chat_room_id' => $request->chat_room_id,
            'message' => [
                'sender_id'   => $request->sender_id,
                'text'        => $request->message,
                'image'       => $data['image_url'] ?? null,
                'voice'       => $data['voice_url'] ?? null,
                'time'        => now()->format('h:i A'),
                'date'        => now()->format('Y-m-d'),
            ]
        ]);
    } catch (\Exception $e) {
        \Log::error("Socket emit failed: " . $e->getMessage());
    }



    return response()->json([
        'status'  => 'success',
        'message' => 'Message saved successfully',
        'data'    => $message,
    ]);
}


      /*end method saveMessage */
     

public function getUserChatRooms()
{
    $currentUserId = auth()->id();

    if (!$currentUserId) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Unauthenticated'
        ], 401);
    }

    // Get all study rooms where the user is a member
    $chatRooms = StudyRoom::whereHas('members', function ($q) use ($currentUserId) {
        $q->where('user_id', $currentUserId);
    })->with('members')->get();

    $data = $chatRooms->map(function ($room) use ($currentUserId) {

        // Get the related ChatRoom using naming convention: StudyRoom_{id}
        $chatRoomName = 'StudyRoom_' . $room->id;

        $chatRoom = ChatRoom::where('name', $chatRoomName)->first();



        // Get the latest message if the ChatRoom exists
        $lastMessage = $chatRoom
            ? ChatMessage::where('chat_room_id', $chatRoom->id)->latest('created_at')->first()
            : null;




        return [
            'room_id'        => $room->id,
            'name'           => $room->name,
            'is_group'       => (bool) $room->is_group,
            'avatar'         => $room->is_group
                                ? asset("storage/group-avatars/{$room->id}.png")
                                : asset("storage/users/" . (optional($room->members->first(fn($m) => $m->id !== $currentUserId))->profile_picture ?? 'default.png')),
             'chat_room_id' =>   $chatRoom->id ?? null,                
            
            'latest_message' => $lastMessage ? [
                'sender_id' => $lastMessage->sender_id,
                'text'      => $lastMessage->message,
                'image_message'      => $lastMessage->image_url,
                'vioice_message'      => $lastMessage->voice_url,
                'sent_at'   => $lastMessage->created_at->diffForHumans(),
            ] : null,

            'unread_count'   => $chatRoom
                                ? ChatMessage::where('chat_room_id', $chatRoom->id)
                                    ->where('sender_id', '!=', $currentUserId)
                                    ->where('is_read', 0)
                                    ->count()
                                : 0,
        ];
    });

    return response()->json([
        'status' => 'success',
        'chats'   => $data
    ]);
}


public function getAllMessagesInRoom($room_id)
{
    $room = ChatRoom::findOrFail($room_id);

    $messages = ChatMessage::with('sender')
        ->where('chat_room_id', $room_id)
        ->orderBy('created_at', 'asc')
        ->get()
        ->map(function ($msg) {
            return [
                'id'          => $msg->id,
                'sender_id'   => $msg->sender_id,
                'sender_name' => $msg->sender->first_name ?? 'Unknown',
                'sender_avatar' => $msg->sender?->profile_pic 
                                   ? asset('storage/users/' . $msg->sender->profile_pic)
                                   : asset('storage/users/default.png'),
                'text'        => $msg->message,
                'image'       => $msg->image_url,
                'voice'       => $msg->voice_url,
                'time'        => $msg->created_at->format('h:i A'),
                'date'        => $msg->created_at->format('Y-m-d'),
            ];
        });

    return response()->json([
        'status'  => 'success',
        'room_id' => $room_id,
        'messages'=> $messages
    ]);
}



}


