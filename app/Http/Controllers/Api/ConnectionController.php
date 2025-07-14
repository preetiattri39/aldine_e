<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Connection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\SendResponseTrait;
use Carbon\Carbon;
class ConnectionController extends Controller
{

    use SendResponseTrait;

     /**
     * functionName : searchUsers
     * createdDate  : 04-04-2025
     * purpose      : searchUsers
    */

    // public function searchUsers(Request $request) {
    //     $query = $request->input('query');

    //     $users = User::where('first_name', 'LIKE', "%{$query}%")
    //                 ->orWhere('last_name', 'LIKE', "%{$query}%")
    //                  ->where('id', '!=', Auth::id())
    //                  ->select('id', 'first_name', 'last_name','email')
    //                  ->get();

    //     return $this->apiResponse('success', 200, 'Users ' . config('constants.SUCCESS.FETCH_DONE'), $users);
    // }

    public function searchUsers(Request $request) {
        $query = $request->input('query');
        $authUserId = Auth::id();
    
        // Get user_ids who sent a request to the current user
        $receivedRequests = Connection::where('user_id', $authUserId)
                                      ->pluck('connection_id')
                                      ->toArray();
        
        $users = User::where(function ($q) use ($query) {
                            $q->where('first_name', 'LIKE', "%{$query}%")
                              ->orWhere('last_name', 'LIKE', "%{$query}%");
                        })
                        ->where('id', '!=', $authUserId)
                        ->whereNotIn('id', $receivedRequests)
                        ->select('id', 'first_name', 'last_name', 'email')
                        ->get();
    
        return $this->apiResponse('success', 200, 'Users ' . config('constants.SUCCESS.FETCH_DONE'), $users);
    }
    



    /*end method searchUsers */

   /**
     * functionName : sendRequest
     * createdDate  : 04-04-2025
     * purpose      : sendRequest
    */
    public function sendRequest(Request $request) {
        $receiverId = $request->input('receiver_id');

        if ($receiverId == Auth::id()) {
            return $this->apiResponse('false', 400, config('constants.ERROR.SELF_CONNECTION'));
        }

        if (Connection::where(function ($query) use ($receiverId) {
            $query->where('user_id', Auth::id())
                  ->where('connection_id', $receiverId);
        })->orWhere(function ($query) use ($receiverId) {
            $query->where('user_id', $receiverId)
                  ->where('connection_id', Auth::id());
        })->exists()) {
            return $this->apiResponse('false', 404, config('constants.ERROR.REQUEST_EXISTS'));
        }

        $Connection = Connection::create([
            'user_id' => Auth::id(),
            'connection_id' => $receiverId,
            'status' => 'pending'
        ]);

        return $this->apiResponse('success', 200, config('constants.SUCCESS.REQUEST_SENT'), $Connection);
    }

     /*end method disconnectUser */

     /**
     * functionName : acceptRequest
     * createdDate  : 04-04-2025
     * purpose      : acceptRequest
    */
    public function acceptRequest($id) {
        $connection = Connection::findOrFail($id);
        $connection->update(['status' => 'accepted']);
        $Connection = Connection::findOrFail($id);
        return $this->apiResponse('success', 200, config('constants.SUCCESS.REQUEST_ACCEPTED'), $Connection);
    }

    /*end method disconnectUser */

    
     /**
     * functionName : rejectRequest
     * createdDate  : 04-04-2025
     * purpose      : rejectRequest
    */
    public function rejectRequest($id) {
        $connection = Connection::findOrFail($id);
        $connection->update(['status' => 'rejected']);
        $connection = Connection::findOrFail($id);
        return $this->apiResponse('success', 200, config('constants.SUCCESS.REQUEST_REJECTED'), $connection);
    }

    /*end method disconnectUser */

     /**
     * functionName : getConnections
     * createdDate  : 04-04-2025
     * purpose      : getConnections
    */
    public function getConnections() {
        $connections = Connection::where('status', 'accepted')
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                      ->orWhere('connection_id', Auth::id());
            })
            ->with(['user:id,first_name,email,profile_pic', 'connection:id,first_name,email,profile_pic'])
            ->get();

        return $this->apiResponse('success', 200, config('constants.SUCCESS.CONNECTIONS_FETCHED'), $connections);
    }

    public function getConnectionsOnStatus(Request $request) {
        $status = $request->input('status', 'pending'); // default to 'pending' if not provided
    
        // Validate status
        if (!in_array($status, ['pending', 'accepted', 'rejected'])) {
            return $this->apiResponse('error', 400, 'Invalid status provided.');
        }
    
        $connections = Connection::where('status', $status)
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                      ->orWhere('connection_id', Auth::id());
            })
            ->with(['user:id,first_name,email,profile_pic', 'connection:id,first_name,email,profile_pic'])
            ->get();
    
        return $this->apiResponse('success', 200, config('constants.SUCCESS.CONNECTIONS_FETCHED'), $connections);
    }
     /*end method disconnectUser */

    /**
     * functionName : disconnectUser
     * createdDate  : 07-04-2025
     * purpose      : disconnectUser
    */

    public function disconnectUser($id){
        $userId = Auth::id();

        $connection = Connection::where(function ($query) use ($userId, $id) {
            $query->where('user_id', $userId)
                  ->where('connection_id', $id);
        })->orWhere(function ($query) use ($userId, $id) {
            $query->where('user_id', $id)
                  ->where('connection_id', $userId);
        })->where('status', 'accepted')->first();

        if (!$connection) {
            return $this->apiResponse('error', 404, 'Connection not found or not accepted.');
        }

        $connection->delete();

        return $this->apiResponse('success', 200, 'Connection successfully removed.');
    }

     /*end method disconnectUser */

}
