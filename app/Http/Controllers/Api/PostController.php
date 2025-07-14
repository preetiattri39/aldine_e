<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostShare;
use App\Models\Reply;
use App\Traits\SendResponseTrait;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use SendResponseTrait;

    /**
     * functionName : index
     * createdDate  : 07-04-2025
     * purpose      : get all posts
     */
    public function index(Request $request){
        $userId = auth()->id();

        $query = Post::with([
            'user:id,first_name,email,profile_pic'
        ])->withCount([
            'likedByUsers as total_likes',
            'allComments as total_comments'
        ]);

        // Filter by current user
        $query->where('user_id', $userId);

        // Optional: Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $posts = $query->latest()->get();

        // Attach is_liked status
        $posts->transform(function ($post) use ($userId) {
            $post->is_liked = $post->likedByUsers()->where('user_id', $userId)->exists() ? 1 : 0;
            return $post;
        });

        return $this->apiResponse('success', 200, 'All posts fetched successfully', $posts);
    }




    /*end method index */




    /**
     * functionName : store
     * createdDate  : 07-04-2025
     * purpose      : save post
     */
    public function store(Request $request)
{
    $request->validate([
        'content' => 'required|string|max:5000',
        'title' => 'required|string|max:30',
        'type' => 'required|string|exists:post_types,slug',
        'images' => 'nullable|array',
        
    ]);

    // Store images as JSON

    $post = Post::create([
        'user_id' => auth()->id(),
        'content' => $request->content,
        'title' => $request->title,
        'type' => $request->type,
        'images' => $request->images,
    ]);

    return $this->apiResponse('success', 200, 'Post created successfully', $post);
}



    /*end method store */

    /**
     * functionName : update
     * createdDate  : 07-04-2025
     * purpose      : update post
     */

   public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:30',
        'content' => 'required|string|max:5000',
        'type' => 'required|string|exists:post_types,slug',
        'images' => 'nullable|array',
        'images.*' => 'url'
    ]);

    $post = Post::where('id', $id)->where('user_id', auth()->id())->first();

    if (!$post) {
        return $this->apiResponse('error', 404, 'Post not found or unauthorized');
    }

    $post->update([
        'title' => $request->title,
        'content' => $request->content,
        'type' => $request->type,
        'images' => $request->has('images') ? $request->images : $post->images,
    ]);

    return $this->apiResponse('success', 200, 'Post updated successfully', $post);
}

    /*end method update */


    /**
     * functionName : show
     * createdDate  : 07-04-2025
     * purpose      : get particular post and its replies
     */
    public function show($id)
    {

        $post = Post::with([
            'user:id,first_name,email,profile_pic',
            'replies' => function ($query) {
                $query->with(['user:id,first_name,email,profile_pic', 'repliesRecursive']);
            }
        ])
        ->withCount([
            'likedByUsers as total_likes',
            'allComments as total_comments'
        ])
        ->find($id);

       

        if (!$post) {
            return $this->apiResponse('error', 404, 'Post not found');
        }
    
        // Check if current user liked this post
        $post->is_liked_by_user = $post->likedByUsers()->where('user_id', auth()->id())->exists();
    
        return $this->apiResponse('success', 200, 'Post fetched successfully', $post);
    }
    

    /*end method show */

    /**
     * functionName : destroy
     * createdDate  : 07-04-2025
     * purpose      : delete particular post
     */
    public function destroy(string $id)
    {
        $post = Post::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$post) {
            return $this->apiResponse('error', 404, 'Post not found or unauthorized');
        }

        $post->delete();

        return $this->apiResponse('success', 200, 'Post deleted successfully');
    }
    /*end method destroy */


    /**
     * functionName : pinPost
     * createdDate  : 07-04-2025
     * purpose      : pin a  post
     */

    public function pinPost($id)
    {
        $user = auth()->user();
        $post = Post::findOrFail($id);

        // Check if post already pinned by the user
        $alreadyPinned = $user->pinnedPosts()->where('post_id', $id)->exists();

        if ($alreadyPinned) {
            return $this->apiResponse('warning', 409, 'Post already pinned');
        }

        $user->pinnedPosts()->attach($post);

        return $this->apiResponse('success', 200, 'Post pinned successfully');
    }

    /*end method pinPost */


     /**
     * functionName : unpinPost
     * createdDate  : 07-04-2025
     * purpose      : unpin a  post
     */

    public function unpinPost($id){
            $user = auth()->user();
            $post = Post::findOrFail($id);

            $user->pinnedPosts()->detach($post);

            return $this->apiResponse('success', 200, 'Post unpinned successfully');
    }
     /*end method unpinPost */


      /**
     * functionName : likePost
     * createdDate  : 07-04-2025
     * purpose      : like a  post
     */
     public function likePost($id){
       
    try {
        $user = auth()->user();
        $post = Post::findOrFail($id);

        if ($user->likedPosts()->where('post_id', $id)->exists()) {
            return $this->apiResponse('warning', 409, 'Post already liked');
        }

        $user->likedPosts()->attach($post);

        return $this->apiResponse('success', 200, 'Post liked successfully');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return $this->apiResponse('error', 404, 'Post not found');
    } catch (\Exception $e) {
        return $this->apiResponse('error', 500, 'Something went wrong: ' . $e->getMessage());
    }
}




    /**
     * functionName : unlikePost
     * createdDate  : 07-04-2025
     * purpose      : unlike a  post
     */

    public function unlikePost($id){
        $user = auth()->user();
        $post = Post::findOrFail($id);

        $user->likedPosts()->detach($post);

        return $this->apiResponse('success', 200, 'Post unliked successfully');
    }

	public function getSharedRecipients()
	{
	    $senderId = auth()->id();

	    // Get the latest shared post per recipient, avoiding duplicates
	    $latestShares = PostShare::with('recipient') // assumes recipient() relation defined
		->where('sender_id', $senderId)
		->orderBy('created_at', 'desc')
		->get()
		->unique('recipient_id') // avoid duplicate users
		->values(); // reset keys
		
	    // Optional: Format only necessary recipient info
	    $recipients = $latestShares->map(function ($share) use ($senderId) {
		    $recipient = $share->recipient;
		    // Get the latest PostShare entry between the sender and this recipient
		    $lastShare = PostShare::where(function ($query) use ($senderId, $recipient) {
			    $query->where('sender_id', $senderId)
				  ->where('recipient_id', $recipient->id);
			})
			->orWhere(function ($query) use ($senderId, $recipient) {
			    $query->where('sender_id', $recipient->id)
				  ->where('recipient_id', $senderId);
			})
			->orderBy('created_at', 'desc')
			->first();

		    // Retrieve the post title if post_id exists
		    $lastPostTitle = $lastShare && $lastShare->post ? $lastShare->post->title : null;

		    return [
			'recipient_id'     => $share->recipient_id,
			'recipient_image'  => $share->recipient->profile_pic,
			'name'             => $recipient->full_name ?? '',
			'email'            => $recipient->email ?? '',
			'last_shared_at'   => $share->created_at->toDateTimeString(),
			'last_message'     => $lastPostTitle,
			'sent_time_ago'    => $lastShare ? $lastShare->created_at->diffForHumans() : null,
			'unread_count'     => $unreadcount ?? '',
			'status'           => $isOnline ?? '',
		    ];
		});
		
	    return $this->apiResponse('success', 200, 'List of users shared with', $recipients);
	}


}
