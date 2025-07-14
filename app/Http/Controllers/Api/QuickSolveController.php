<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\QuickSolveQuestion;
use App\Models\QuickSolveReply;
use App\Models\QuickSolveReplyReaction;
use App\Models\QuickSolveQuestionReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\SendResponseTrait;

class QuickSolveController extends Controller
{
    use SendResponseTrait;
    //  Get questions by category
    public function getByCategory($category_id = null)
    {
  
        try {
            $query = QuickSolveQuestion::withCount([
                'reactions as like_count' => fn($q) => $q->where('reaction_type', 'like'),
                'reactions as dislike_count' => fn($q) => $q->where('reaction_type', 'dislike'),
            ])
            ->with(['replies']);

            // Apply category filter only if category_id is provided
            if (!is_null($category_id)) {
                $query->where('category_id', $category_id);
            }

            $questions = $query->paginate(10);
            
            $customData = [
		'questions' => $questions->items(),
		'current_page' => $questions->currentPage(),
		'last_page' => $questions->lastPage(),
		'per_page' => $questions->perPage(),
		'total' => $questions->total(),
	   ];

            return $this->apiResponse('success', 200, 'Questions fetched successfully', $customData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //  Get questions by category & subcategory
    public function getBySubCategory(Request $request)
	{
	    try {
		$category_ids = $request->input('category_id');
		$subcategory_ids = $request->input('subcategory_id');

		// Ensure both inputs are arrays
		$category_ids = is_array($category_ids) ? $category_ids : explode(',', $category_ids);
		$subcategory_ids = is_array($subcategory_ids) ? $subcategory_ids : explode(',', $subcategory_ids);

		// Load categories
		$categories = Category::whereIn('id', $category_ids)->get();
		if ($categories->isEmpty()) {
		    return $this->apiResponse('error', 404, 'No matching categories found');
		}

		// Fetch questions with relationships and counts
		$questions = QuickSolveQuestion::withCount([
		        'reactions as like_count' => fn($q) => $q->where('reaction_type', 'like'),
		        'reactions as dislike_count' => fn($q) => $q->where('reaction_type', 'dislike'),
		    ])
		    ->with(['replies', 'subcategory', 'category'])
		    ->whereIn('category_id', $category_ids)
		    ->whereIn('subcategory_id', $subcategory_ids)
		    ->get();

		// Group questions by category and then by subcategory
		/*$grouped = $questions->groupBy('category_id')->map(function ($categoryGroup) {
		    $category = $categoryGroup->first()->category;

		    // Group by subcategory
		    $subcategories = $categoryGroup->groupBy('subcategory_id')->map(function ($subGroup) {
		        $subcategory = $subGroup->first()->subcategory;
		        
		         $cleanedQuestions = $subGroup->map(function ($question) {
                             $question->makeHidden(['category', 'subcategory']);
                             return $question;
                         });
        
		        return [
		            'subcategory_id' => $subcategory->id,
		            'subcategory_name' => $subcategory->name,
		            'questions' => $cleanedQuestions->values(),
		        ];
		    })->values();

		    return [
		        'category_id' => $category->id,
		        'category_name' => $category->name,
		        'subcategories' => $subcategories,
		    ];
		})->values();*/
		
		// Flatten the questions with category and subcategory info
                $flatData = $questions->map(function ($question) {
                    return [
                        'question_id'      => $question->id,
                        'question'         => $question->question,
                	'category_id'      => $question->category->id,
                	'category_name'    => $question->category->name,
                	'subcategory_id'   => $question->subcategory->id,
                	'subcategory_name' => $question->subcategory->name,
                	'user_id'          => $question->user_id,
                	'hours_earned'     => $question->hours_earned,
                	'coins'            => $question->coins,
                	'points'           => $question->points,
                	'like_count'       => $question->like_count,
                	'dislike_count'    => $question->dislike_count,
                	'created_at'       => $question->created_at,
                	'updated_at'       => $question->updated_at,
                	'replies'          => $question->replies,
                   ];
        	});

		return $this->apiResponse('success', 200, 'Questions grouped by category and subcategory', $flatData);

	    } catch (\Exception $e) {
		return response()->json(['error' => $e->getMessage()], 500);
	    }
	}



    //  Save a question
    public function store(Request $request)
    {
        $question = QuickSolveQuestion::create([
            'category_id' => $request->category_id ?? null,
            'subcategory_id' => $request->subcategory_id ?? null,
            'user_id' => Auth::id(),
            'question' => $request->question,
            'hours_earned' => $request->hours_earned ?? 0,
            'coins' => $request->coins ?? 0,
            'points' => $request->points ?? 0,
        ]);
        return $this->apiResponse('success', 200, 'question created successfully', $question);
    }

    // Update a question
    public function update(Request $request, $id)
    {
        $question = QuickSolveQuestion::findOrFail($id);
        $question->update($request->only(['question', 'hours_earned', 'coins', 'points']));
        return $this->apiResponse('success', 200, 'question updated successfully', $reply);


    }

    //  Delete a question
    public function destroy($id)
    {
        QuickSolveQuestion::destroy($id);
        return $this->apiResponse('success', 200, 'question deleted successfully');

    }

    //  Add a reply
    public function addReply(Request $request)
    {
        $reply = QuickSolveReply::create([
            'question_id' => $request->question_id,
            'user_id' => Auth::id(),
            'reply' => $request->reply,
        ]);
        return $this->apiResponse('success', 200, 'reply created successfully', $reply);
    }

    //  Edit a reply
    public function updateReply(Request $request, $id){
        $reply = QuickSolveReply::findOrFail($id);
        $reply->update(['reply' => $request->reply]);
        return $this->apiResponse('success', 200, 'Reply updated successfully', $reply);
    }


    //  Delete a reply
    public function deleteReply($id)
    {
        QuickSolveReply::destroy($id);
        return $this->apiResponse('success', 200, 'reply deleted successfully');
    }

    //  Like/Dislike a reply
    public function reactToReply(Request $request, $reply_id)
    {
        $reaction = QuickSolveReplyReaction::updateOrCreate(
            ['reply_id' => $reply_id, 'user_id' => Auth::id()],
            ['reaction_type' => $request->reaction_type]
        );
        return $this->apiResponse('success', 200, 'Reaction added successfully', $reaction);
    }
    public function reactToQuestion(Request $request, $question_id){
        $request->validate([
            'reaction_type' => 'required|in:like,dislike',
        ]);

        $reaction = QuickSolveQuestionReaction::updateOrCreate(
            [
                'question_id' => $question_id,
                'user_id' => Auth::id(),
            ],
            [
                'reaction_type' => $request->reaction_type
            ]
        );

        return $this->apiResponse('success', 200, 'Question reaction updated', $reaction);
    }
}

