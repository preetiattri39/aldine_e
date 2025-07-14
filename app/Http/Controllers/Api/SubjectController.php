<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Category, UserFavoriteSubject};
use App\Traits\SendResponseTrait;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    use SendResponseTrait;

     /**
     * functionName : index
     * createdDate  : 03-04-2025
     * purpose      : get all subjects
    */

    public function index()
    {
        $subjects = Category::with(['subcategories' => function ($query) {
            // Eager load questions for each subcategory filtered by matching category_id & subcategory_id
            $query->with(['quickSolveQuestions' => function ($q) {
                // Optionally add filters or counts on quick_solve_questions here
                $q->withCount([
                    'reactions as like_count' => fn($q) => $q->where('reaction_type', 'like'),
                    'reactions as dislike_count' => fn($q) => $q->where('reaction_type', 'dislike'),
                ])->with('replies');
            }]);
        }])->get();

        return $this->apiResponse('success', 200, config('constants.SUCCESS.FETCH_DONE'), $subjects);
     }


     /*end method index */


      /**
     * functionName : index
     * createdDate  : 03-04-2025
     * purpose      : get all subjects
    */

    public function getFavSubjects()
    {
        $subjects = UserFavoriteSubject::with('category')->where('user_id',Auth::id())->get();
        return $this->apiResponse('success', 200, config('constants.SUCCESS.FETCH_DONE'), $subjects);
    }

     /*end method index */

     /**
     * functionName : store
     * createdDate  : 03-04-2025
     * purpose      : save subjects
    */ 

    public function store(Request $request)
{
    $request->validate([
        'subject_id'   => 'required|array',
        'subject_id.*' => 'exists:categories,id',
    ]);

    $userId = Auth::id();
    $addedSubjects = [];

    foreach ($request->subject_id as $categoryId) {
        // Skip if already exists
        $exists = UserFavoriteSubject::where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->exists();

        if (!$exists) {
            $addedSubjects[] = UserFavoriteSubject::create([
                'user_id' => $userId,
                'category_id' => $categoryId,
            ]);
        }
    }

    if (!empty($addedSubjects)) {
        return $this->apiResponse('success', 200, 'New subjects ' . config('constants.SUCCESS.CREATE_DONE'), $addedSubjects);
    } else {
        return $this->apiResponse('success', 200, 'No new subjects were added. All were already marked as favorite.', []);
    }
}


     /*end method store */


     /**
     * functionName : update
     * createdDate  : 03-04-2025
     * purpose      : update subjects
    */ 

    public function update(Request $request, $id)
    {
        $subject = UserFavoriteSubject::find($id);

        if (!$subject) {
            return $this->apiResponse('error', 404, 'Subject ' . config('constants.ERROR.NOT_FOUND'));
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $subject->update(['category_id' => $request->category_id]);

        return $this->apiResponse('success', 200, 'Subject ' . config('constants.SUCCESS.UPDATE_DONE'), $subject);
    }


     /*end method update */


      /**
     * functionName : store
     * createdDate  : 03-04-2025
     * purpose      : delete subjects
    */ 

    public function destroy($id)
    {
        $subject = UserFavoriteSubject::find($id);

        if (!$subject) {
            return $this->apiResponse('error', 404, config('constants.ERROR.NOT_FOUND'));
        }

        $subject->delete();

        return $this->apiResponse('success', 200, 'Subject ' . config('constants.SUCCESS.DELETE_DONE'));
    }

    /*end method destroy */
}
