<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Traits\SendResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubCategoryController extends Controller
{
    use SendResponseTrait;
    /**
     * functionName : getList
     * createdDate  : 28-05-2025
     * purpose      : Get the list for all the subcategory
     */
    public function getList(Request $request)
    {
        try {
            $subcategory = SubCategory::with('category')
            ->when($request->filled('search_keyword'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search_keyword%");
                });
            })
                ->when($request->filled('category_name'), function ($query) use ($request) {
                    $query->whereHas('category', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->category_name . '%');
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
            return view("admin.subcategory.list", compact("subcategory"));
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method getList**/

    /**
     * functionName : add
     * createdDate  : 28-05-2025
     * purpose      : add the subcategory
     */
    public function add(Request $request)
    {
        try {
            if ($request->isMethod('get')) {

                $categories = Category::all();

                return view("admin.subcategory.add", compact('categories'));
            } elseif ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'name' => [
                        'required',
                        'string',
                        'max:50',
                        Rule::unique('categories', 'name')
                    ]

                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $subcategory = SubCategory::Create([
                    'category_id'   => $request->category_id,
                    'name'          => $request->name,
                    'description'    => $request->description ? $request->description : '',
                ]);

                return redirect()->route('admin.subcategory.list')->with('success', 'Subcategory ' . config('constants.SUCCESS.ADD_DONE'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method add**/

    /**
     * functionName : edit
     * createdDate  : 28-05-2025
     * purpose      : edit the subcategory
     */
    public function edit(Request $request, $id)
    {
        try {
            if ($request->isMethod('get')) {
                $subcategory = SubCategory::find($id);
                $categories = Category::all();
                return view("admin.subcategory.edit", compact('subcategory','categories'));
            } elseif ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'name' => [
                        'required',
                        'string',
                        'max:50',
                        Rule::unique('categories', 'name')->ignore($id),
                    ],
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $subcategory = SubCategory::find($id);



                SubCategory::where('id', $id)->update([
                    'category_id'   => $request->category_id,
                    'name'          => $request->name,
                    'description'    => $request->description ? $request->description : '',

                ]);

                return redirect()->route('admin.subcategory.list')->with('success', 'Subcategory ' . config('constants.SUCCESS.UPDATE_DONE'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method edit**/

    /**
     * functionName : delete
     * createdDate  : 28-05-2025
     * purpose      : Delete the Subcategory by id
     */
    public function delete($id)
    {
        try {

            SubCategory::where('id', $id)->delete();

            return response()->json(["status" => "success", "message" => "Subcategory " . config('constants.SUCCESS.DELETE_DONE')], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", $e->getMessage()], 500);
        }
    }
    /**End method delete**/

    /**
     * functionName : changeStatus
     * createdDate  : 28-05-2025
     * purpose      : Update the subcategory status
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

            SubCategory::where('id', $request->id)->update(['status' => $request->status]);

            return response()->json(["status" => "success", "message" => "Subcategory status " . config('constants.SUCCESS.CHANGED_DONE')], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", $e->getMessage()], 500);
        }
    }
    /**End method changeStatus**/
}
