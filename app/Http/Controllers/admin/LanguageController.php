<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Language};
use App\Traits\SendResponseTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LanguageController extends Controller
{
     use SendResponseTrait;
    /**
     * functionName : getList
     * createdDate  : 31-05-2024
     * purpose      : Get the list for all the category
    */
    public function getList(Request $request){
        try{
            $category = Language::when($request->filled('search_keyword'),function($query) use($request){
                            $query->where(function($query) use($request){
                                $query->where('name','like',"%$request->search_keyword%");
                                    
                            });
                        })
                        ->when($request->filled('status'),function($query) use($request){
                            $query->where('status',$request->status);
                        })
                        ->when($request->filled('start_date'), function ($query) use ($request) {
                            $query->whereDate('created_at', '>=', $request->start_date);
                        })
                        ->when($request->filled('end_date'), function ($query) use ($request) {
                            $query->whereDate('created_at', '<=', $request->end_date);
                        })
                        ->orderBy("id","desc")->paginate(10);
            return view("admin.language.list",compact("category"));
        }catch(\Exception $e){
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
                return view("admin.language.add");
            } elseif ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:25|unique:languages,name,NULL,id,deleted_at,NULL',
                    'code' => 'required|string|max:10|unique:languages,code,NULL,id,deleted_at,NULL',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                Language::create([
                    'name' => $request->name,
                    'code' => $request->code,
                    'is_default' => $request->is_default ? 1 : 0,
                ]);

                return redirect()->route('admin.language.list')->with('success', 'Language added successfully');
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
            $language = Language::findOrFail($id);
    
            // Handle GET request - show the edit form
            if ($request->isMethod('get')) {
                return view("admin.language.edit", compact('language')); // Fixed typo: langauge -> language
            }
    
            // Handle POST request - validate and update
            $validator = Validator::make($request->all(), [
                'name' => [
                    'required',
                    'string',
                    'max:25',
                    Rule::unique('languages', 'name')->whereNull('deleted_at')->ignore($id), // Fixed table name
                ],
                'code' => ['required', 'string', 'min:2', 'max:10'], // Optional but recommended
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $language->update([
                'name' => $request->name,
                'code' => $request->code,
                'is_default' => $request->has('is_default') ? 1 : 0,
            ]);
    
            return redirect()->route('admin.language.list') // Fixed typo: langauge -> language
                             ->with('success', 'Language ' . config('constants.SUCCESS.UPDATE_DONE'));
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
        // Find the language or fail with 404
        $language = Language::findOrFail($id);
        
        // Check if it's the default language before deleting
        if ($language->is_default) {
            return response()->json([
                "status" => "error",
                "message" => "Cannot delete the default language"
            ], 422);
        }
        
        // Delete the language
        $language->delete();

        return response()->json([
            "status" => "success",
            "message" => "Language " . config('constants.SUCCESS.DELETE_DONE')
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            "status" => "error", 
            "message" => "Language not found"
        ], 404);
    } catch(\Exception $e) {
        // Log the error for debugging
        \Log::error('Language deletion error: ' . $e->getMessage());
        
        return response()->json([
            "status" => "error", 
            "message" => "An error occurred while deleting the language"
        ], 500);
    }
}
    /**End method delete**/

    /**
     * functionName : changeStatus
     * createdDate  : 31-05-2024
     * purpose      : Update the category status
    */
    public function changeStatus(Request $request){
        try{
            
            $validator = Validator::make($request->all(), [
                'id'        => 'required',
                "status"    => "required|in:0,1",
            ]);
            if ($validator->fails()) {
                if($request->ajax()){
                    return response()->json(["status" =>"error", "message" => $validator->errors()->first()],422);
                }
            }
           
            Language::where('id',$request->id)->update(['status' => $request->status]);

            return response()->json(["status" => "success","message" => "Language status ".config('constants.SUCCESS.CHANGED_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method changeStatus**/
}
