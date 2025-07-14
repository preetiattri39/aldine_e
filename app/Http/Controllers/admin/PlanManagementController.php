<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanManagementController extends Controller
{
    /**
     * functionName : getList
     * createdDate  : 30-08-2024
     * purpose      : Get the list for all the Plan
    */
    public function getList(Request $request){
        try{
            $plans = Plan::when($request->filled('search_keyword'),function($query) use($request){
                $query->where(function($query) use($request){
                    $query->where('title','like',"%$request->search_keyword%")
                        ->orWhere('ios_id','like',"%$request->search_keyword%")
                        ->orWhere('android_id','like',"%$request->search_keyword%");
                });
            })
            ->when($request->filled('status'),function($query) use($request){
                $query->where('status',$request->status);
            })
            ->orderBy("id","desc")->paginate(10);
            return view("admin.plan.list",compact("plans"));
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method getList**/

    /**
     * functionName : add
     * createdDate  : 30-08-2024
     * purpose      : add the Plan
    */
    public function add(Request $request){
        try{
            if($request->isMethod('get')){
                return view("admin.plan.add");
            }elseif( $request->isMethod('post') ){
                $rules = [
                    'title'             => 'required',
                    'device_number'     => 'required',
                    'price'             => 'required',
                    'duration'      => 'required',
                ];
                
                $validator = Validator::make($request->all(), $rules);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                
                
                Plan::Create([
                    'title'         => $request->title,
                    'device_number' => $request->device_number,
                    'price'         => $request->price,
                    'duration'   => $request->duration ? $request->duration : null,
                    'feature'       => $request->feature ? $request->feature : null,
                ]);

                return redirect()->route('admin.plan.list')->with('success','Plan '.config('constants.SUCCESS.ADD_DONE'));
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
                $plan = Plan::find($id);
                return view("admin.plan.edit",compact('plan'));
            }elseif( $request->isMethod('post') ){
                
                $rules = [
                    'title'             => 'required',
                    'device_number'        => 'required',
                    'price'            => 'required',            
                    'duration'       => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

               

                Plan::where('id' , $id)->update([
                    'title'          => $request->title,
                    'device_number'  => $request->device_number,
                    'price'          => $request->price,
                    'duration'    => $request->duration ? $request->duration : null,
                    'feature'        => $request->feature ? $request->feature : null,
                ]);

                return redirect()->route('admin.plan.list')->with('success','Plan '.config('constants.SUCCESS.UPDATE_DONE'));
            }
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method edit**/

    /**
     * functionName : delete
     * createdDate  : 18-07-2024
     * purpose      : Delete the pla by id
    */
    public function delete($id){
        try{
            Plan::where('id',$id)->delete();

            return response()->json(["status" => "success","message" => "Plan ".config('constants.SUCCESS.DELETE_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method delete**/

    /**
     * functionName : changeStatus
     * createdDate  : 18-07-2024
     * purpose      : Update the Plan status
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
           
            Plan::where('id',$request->id)->update(['status' => $request->status]);

            return response()->json(["status" => "success","message" => "Plan status ".config('constants.SUCCESS.CHANGED_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method changeStatus**/
}
