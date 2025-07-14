<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\SendResponseTrait;
use App\Models\{StudyRoom, StudyRoomMember, StudyRoomMessage, StudyRoomRequest,ChatRoom,ChatRoomUser};

class StudyRoomController extends Controller
{
    use SendResponseTrait;

   public function index()
{
    try {
        $user = auth()->user();
        if (!$user) {
            return $this->apiResponse(
                "error",
                401,
                "Unauthorized: No valid token provided."
            );
        }

        $rooms = StudyRoom::withCount([
            "members as approved_members_count" => function ($q) {
                $q->where("status", "approved");
            },
            "requests as pending_requests_count" => function ($q) {
                $q->where("status", "pending");
            },
        ])
            ->whereDoesntHave("members", function ($q) use ($user) {
                $q->where("user_id", $user->id)->where(
                    "status",
                    "approved"
                );
            })
            ->with([
                "members" => function ($q) use ($user) {
                    $q->where("user_id", $user->id)->select(
                        "room_id",
                        "status",
                        "user_id"
                    );
                },
                "requests" => function ($q) use ($user) {
                    $q->where("user_id", $user->id)->select(
                        "room_id",
                        "status",
                        "user_id"
                    );
                },
            ])
            ->get()
            ->map(function ($room) {
                $memberStatus = $room->members->first()?->status;
                $requestStatus = $room->requests->first()?->status;

                $room->user_status = $memberStatus ?? ($requestStatus ?? null);

                // 🔍 Fetch chat room based on naming convention
                $chatRoom = \App\Models\ChatRoom::where('name', 'StudyRoom_' . $room->id)->first();
                $room->chat_room_id = $chatRoom?->id ?? null;

                unset($room->members);
                unset($room->requests);

                return $room;
            });

        return $this->apiResponse(
            "success",
            200,
            "All Study Rooms fetched successfully",
            $rooms
        );
    } catch (\Exception $e) {
        return $this->apiResponse(
            "error",
            500,
            "Server Error: " . $e->getMessage()
        );
    }
}


    public function sendJoinRequest(Request $request, $roomId)
    {
        $user = auth()->user();
        $room = StudyRoom::findOrFail($roomId);

        // If user already a member
        $existingMember = StudyRoomMember::where("room_id", $roomId)
            ->where("user_id", $user->id)
            ->first();

        if ($existingMember) {
            return $this->apiResponse(
                "error",
                409,
                "You are already a member of this room."
            );
        }

        // Check if room is full
        $memberCount = StudyRoomMember::where("room_id", $roomId)->count();
        if ($room->max_allowed !== null && $memberCount >= $room->max_allowed) {
            return $this->apiResponse(
                "error",
                403,
                "This group is full. Try another one or create your own."
            );
        }

        // For public room, auto approve and join chat
        if ($room->type === "public") {
            StudyRoomMember::create([
                "room_id" => $roomId,
                "user_id" => $user->id,
                "status" => "approved",
            ]);

            // Get chat room by study room naming convention
            $chatRoom = ChatRoom::where(
                "name",
                "StudyRoom_" . $room->id
            )->first();

            if ($chatRoom) {
                $alreadyInChat = ChatRoomUser::where(
                    "chat_room_id",
                    $chatRoom->id
                )
                    ->where("user_id", $user->id)
                    ->exists();

                if (!$alreadyInChat) {
                    ChatRoomUser::create([
                        "chat_room_id" => $chatRoom->id,
                        "user_id" => $user->id,
                    ]);
                }
            }

            return $this->apiResponse(
                "success",
                200,
                "You have joined the public room and chat."
            );
        }

        // Check if already requested
        $existingRequest = StudyRoomRequest::where("room_id", $roomId)
            ->where("user_id", $user->id)
            ->where("status", "pending")
            ->first();

        if ($existingRequest) {
            return $this->apiResponse(
                "error",
                409,
                "Join request already sent and pending."
            );
        }

        // Create request for private room
        StudyRoomRequest::create([
            "room_id" => $roomId,
            "user_id" => $user->id,
            "status" => "pending",
        ]);

        return $this->apiResponse(
            "success",
            200,
            "Join request sent successfully."
        );
    }

    public function createStudyRoom(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "type" => "required|in:public,private",
        ]);

        $user = auth()->user();

        // Generate unique room code
        $code = strtoupper(uniqid("ROOM"));

        // Create study room
        $room = StudyRoom::create([
            "creator_id" => $user->id,
            "name" => $request->name,
            "code" => $code,
            "description" => $request->description,
            "type" => $request->type,
        ]);

        // Auto-add creator as approved member
        StudyRoomMember::create([
            "room_id" => $room->id,
            "user_id" => $user->id,
            "status" => "approved",
        ]);

        // Create corresponding chat room
        $chatRoom = ChatRoom::create([
            "name" => "StudyRoom_" . $room->id,
        ]);

        // Add creator to chat room
        ChatRoomUser::create([
            "chat_room_id" => $chatRoom->id,
            "user_id" => $user->id,
        ]);

        return $this->apiResponse(
            "success",
            200,
            "Study room and chat room created successfully.",
            [
                "study_room" => $room,
                "chat_room" => $chatRoom,
            ]
        );
    }

    public function respondToJoinRequest(Request $request)
    {
        $request->validate([
            "request_id" => "required|exists:study_room_requests,id",
            "action" => "required|in:accept,reject",
        ]);

        $joinRequest = StudyRoomRequest::findOrFail($request->request_id);
        $room = StudyRoom::findOrFail($joinRequest->room_id);

        // Check if the logged-in user is the creator of the room
        if ($room->creator_id !== auth()->id()) {
            return $this->apiResponse(
                "error",
                403,
                "You are not authorized to respond to this request."
            );
        }

        if ($joinRequest->status !== "pending") {
            return $this->apiResponse(
                "error",
                400,
                "This request has already been handled."
            );
        }

        // Update request status
        $joinRequest->status =
            $request->action === "accept" ? "accepted" : "rejected";
        $joinRequest->save();

        // If accepted, add to members and chat room
        if ($request->action === "accept") {
            // Add to study room members
            StudyRoomMember::create([
                "room_id" => $room->id,
                "user_id" => $joinRequest->user_id,
                "status" => "approved",
            ]);

            // Get or create chat room associated with the study room
            $chatRoom = ChatRoom::where(
                "name",
                "StudyRoom_" . $room->id
            )->first();

            if ($chatRoom) {
                // Check if user already in chat
                $exists = ChatRoomUser::where("chat_room_id", $chatRoom->id)
                    ->where("user_id", $joinRequest->user_id)
                    ->exists();

                if (!$exists) {
                    // Add user to chat room
                    ChatRoomUser::create([
                        "chat_room_id" => $chatRoom->id,
                        "user_id" => $joinRequest->user_id,
                    ]);
                }
            }
        }

        return $this->apiResponse(
            "success",
            200,
            "Request {$request->action}ed successfully."
        );
    }
}
