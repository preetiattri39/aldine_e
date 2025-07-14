<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Post;
use App\Traits\SendResponseTrait;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    use SendResponseTrait;

    /**
     * functionName : replyToPost
     * createdDate  : 07-04-2025
     * purpose      :reply to a perticular post
     */
    public function replyToPost(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $reply = Reply::create([
            'post_id' => $postId,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'parent_id' => null,
        ]);

        return $this->apiResponse('success', 200, 'Reply added to post successfully', $reply);
    }

    /*end method replyToPost */

    /**
     * functionName : replyToReply
     * createdDate  : 07-04-2025
     * purpose      :reply to a perticular reply
     */
    public function replyToReply(Request $request, $postId, $replyId)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $reply = Reply::create([
            'post_id' => $postId,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'parent_id' => $replyId,
        ]);

        return $this->apiResponse('success', 200, 'Reply added to reply successfully', $reply);
    }

    /*end method replyToReply */


    /**
     * functionName : showRepliesForPost
     * createdDate  : 07-04-2025
     * purpose      : Get Replies For Particular Post
     */
    public function showRepliesForPost($postId)
    {
        $replies = Reply::with(['user', 'children'])
            ->where('post_id', $postId)
            ->whereNull('parent_id')
            ->get();

        return $this->apiResponse('success', 200, 'Replies fetched successfully', $replies);
    }
    /*end method showRepliesForPost */

    /**
     * functionName : update
     * createdDate  : 07-04-2025
     * purpose      : Update reply
     */

    public function update(Request $request, $replyId)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $reply = Reply::where('id', $replyId)->where('user_id', auth()->id())->first();

        if (!$reply) {
            return $this->apiResponse('error', 404, 'Reply not found or unauthorized');
        }

        $reply->content = $request->content;
        $reply->save();

        return $this->apiResponse('success', 200, 'Reply updated successfully', $reply);
    }

    /*end method update */

    /**
     * functionName : Delete
     * createdDate  : 07-04-2025
     * purpose      : Delete reply
     */
    public function destroy($replyId)
    {
        $reply = Reply::where('id', $replyId)->where('user_id', auth()->id())->first();

        if (!$reply) {
            return $this->apiResponse('error', 404, 'Reply not found or unauthorized');
        }

        $reply->delete();

        return $this->apiResponse('success', 200, 'Reply deleted successfully');
    }

    /*end method destroy */
}
