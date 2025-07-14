<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostShare;
use App\Traits\SendResponseTrait;


class PostShareController extends Controller
{
    use SendResponseTrait;

    public function share(Request $request){
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'recipient_ids' => 'required|array|min:1',
            'recipient_ids.*' => 'exists:users,id',
            'share_type' => 'required|in:named,anonymous',
        ]);

        $senderId = auth()->id();
        $sharedPosts = [];

        foreach ($request->recipient_ids as $recipientId) {
            $sharedPosts[] = PostShare::create([
                'post_id' => $request->post_id,
                'sender_id' => $senderId,
                'recipient_id' => $recipientId,
                'share_type' => $request->share_type,
            ]);
        }

        return $this->apiResponse('success', 200, 'Post shared successfully with selected users', $sharedPosts);
    }

}
