<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{Category};
use App\Traits\SendResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    use SendResponseTrait;
    /**
     * functionName : getList
     * createdDate  : 31-05-2024
     * purpose      : Get the list for all the category
     */
    public function getList(Request $request)
    {
        try {
            $category = Category::when($request->filled('search_keyword'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search_keyword%");
                });
            })
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->when($request->filled('start_date'), function ($query) use ($request) {
                    $query->whereDate('created_at', '>=', $request->start_date);
                })
                ->when($request->filled('end_date'), function ($query) use ($request) {
                    $query->whereDate('created_at', '<=', $request->end_date);
                })
                ->orderBy("id", "desc")->paginate(10);
            return view("admin.category.list", compact("category"));
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method getList**/

    /**
     * functionName : add
     * createdDate  : 31-05-2024
     * purpose      : add the category
     */
    public function add(Request $request)
    {
        try {
            if ($request->isMethod('get')) {

                return view("admin.category.add");
            } elseif ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'name' => [
                        'required',
                        'string',
                        'max:50',
                        Rule::unique('categories', 'name')->whereNull('deleted_at'),
                    ]

                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }


                $category = Category::Create([
                    'name'          => $request->name,
                    'description'    => $request->description ? $request->description : '',
                ]);

                return redirect()->route('admin.category.list')->with('success', 'Category ' . config('constants.SUCCESS.ADD_DONE'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method add**/

    /**
     * functionName : edit
     * createdDate  : 31-05-2024
     * purpose      : edit the category
     */
    public function edit(Request $request, $id)
    {
        try {
            if ($request->isMethod('get')) {
                $category = Category::find($id);
                return view("admin.category.edit", compact('category'));
            } elseif ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'name' => [
                        'required',
                        'string',
                        'max:50',
                        Rule::unique('categories', 'name')->whereNull('deleted_at')->ignore($id),
                    ],
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $category = Category::find($id);



                Category::where('id', $id)->update([
                    'name'          => $request->name,
                    'description'    => $request->description ? $request->description : '',

                ]);

                return redirect()->route('admin.category.list')->with('success', 'Category ' . config('constants.SUCCESS.UPDATE_DONE'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method edit**/

    /**
     * functionName : delete
     * createdDate  : 31-05-2024
     * purpose      : Delete the Category by id
     */
    public function delete($id)
    {
        try {

            Category::where('id', $id)->delete();

            return response()->json(["status" => "success", "message" => "Category " . config('constants.SUCCESS.DELETE_DONE')], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", $e->getMessage()], 500);
        }
    }
    /**End method delete**/

    /**
     * functionName : changeStatus
     * createdDate  : 31-05-2024
     * purpose      : Update the category status
     */
    public function changeStatus(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'id'        => 'required',
                "status"    => "required|in:0,1",
            ]);
            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(["status" => "error", "message" => $validator->errors()->first()], 422);
                }
            }

            Category::where('id', $request->id)->update(['status' => $request->status]);

            return response()->json(["status" => "success", "message" => "Category status " . config('constants.SUCCESS.CHANGED_DONE')], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", $e->getMessage()], 500);
        }
    }
    /**End method changeStatus**/
}
