<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ManagefAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManageFAQController extends Controller
{

    /**
     * functionName : getList
     * createdDate  : 18-07-2024
     * purpose      : Get the list for all the FAQ
    */
    public function getList(Request $request){
        try{
            $faq = ManagefAQ::when($request->filled('search_keyword'),function($query) use($request){
                $query->where(function($query) use($request){
                    $query->where('question','like',"%$request->search_keyword%")
                        ->orWhere('answer','like',"%$request->search_keyword%");
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
            return view("admin.contentPage.f-a-q.list",compact("faq"));
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method getList**/

    /**
     * functionName : add
     * createdDate  : 18-07-2024
     * purpose      : add the FAQ
    */
    public function add(Request $request){
        try{
            if($request->isMethod('get')){
                return view("admin.contentPage.f-a-q.add");
            }elseif( $request->isMethod('post') ){
                $rules = [
                    'question'        => 'required',
                    'answer'          => 'required',
                ];
                
                $validator = Validator::make($request->all(), $rules);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                
                
                ManagefAQ::Create([
                    'question'             => $request->question,
                    'answer'               => $request->answer,
                ]);

                return redirect()->route('admin.f-a-q.list')->with('success','FAQ '.config('constants.SUCCESS.ADD_DONE'));
            }
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method add**/

    /**
     * functionName : edit
     * createdDate  : 18-07-2024
     * purpose      : edit the FAQ
    */
    public function edit(Request $request,$id){
        try{
            if($request->isMethod('get')){
                $faq = ManagefAQ::find($id);
                return view("admin.contentPage.f-a-q.edit",compact('faq'));
            }elseif( $request->isMethod('post') ){
                
                $rules = [
                    'question'         => 'required',
                    'answer'           => 'required',
                ];
                $validator = Validator::make($request->all(), $rules);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                ManagefAQ::where('id' , $id)->update([
                    'question'          => $request->question,
                    'answer'            => $request->answer,
                ]);

                return redirect()->route('admin.f-a-q.list')->with('success','FAQ '.config('constants.SUCCESS.UPDATE_DONE'));
            }
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method edit**/

    /**
     * functionName : delete
     * createdDate  : 18-07-2024
     * purpose      : Delete the FAQ by id
    */
    public function delete($id){
        try{
            ManagefAQ::where('id',$id)->delete();

            return response()->json(["status" => "success","message" => "FAQ ".config('constants.SUCCESS.DELETE_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method delete**/

    /**
     * functionName : changeStatus
     * createdDate  : 18-07-2024
     * purpose      : Update the FAQ status
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
           
            ManagefAQ::where('id',$request->id)->update(['status' => $request->status]);

            return response()->json(["status" => "success","message" => "FAQ status ".config('constants.SUCCESS.CHANGED_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method changeStatus**/
}
