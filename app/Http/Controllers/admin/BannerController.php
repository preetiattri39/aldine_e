<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * functionName : getList
     * createdDate  : 13-06-2024
     * purpose      : Get the list for all the banner
    */
    public function getList(Request $request){
        try{
            $banners = Banner::when($request->filled('search_keyword'),function($query) use($request){
                $query->where(function($query) use($request){
                    $query->where('title','like',"%$request->search_keyword%")
                        ->orWhere('discount_code','like',"%$request->search_keyword%");
                });
            })
            ->when($request->filled('status'),function($query) use($request){
                $query->where('status',$request->status);
                ->when($request->filled('start_date'), function ($query) use ($request) {
                    $query->whereDate('created_at', '>=', $request->start_date);
                })
                ->when($request->filled('end_date'), function ($query) use ($request) {
                    $query->whereDate('created_at', '<=', $request->end_date);
                })
            })->orderBy("id","desc")->paginate(10);
            return view("admin.banner.list",compact("banners"));
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method getList**/

    /**
     * functionName : add
     * createdDate  : 13-06-2024
     * purpose      : add the banner
    */
    public function add(Request $request){
        try{
            if($request->isMethod('get')){
                return view("admin.banner.add");
            }elseif( $request->isMethod('post') ){
                $rules = [
                    'title'         => 'required|string|max:255',
                    'image'         => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'type'          => 'required|in:default,subscription,contact-Aldine E'
                ];
                
                $validator = Validator::make($request->all(), $rules);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                
                $path = '';
                if($request->hasFile('image')){
                    $path = uploadFile($request->file('image'),'images');
                }

                $code = '';
                do{
                    $code = strtoupper(\Str::random(7));
                }while(Banner::where('discount_code',$code)->count());
                
                Banner::Create([
                    'title'             => $request->title,
                    'type'              => $request->type,
                    'discount_code'     => $code,
                    'description'       => $request->description ? $request->description : '',
                    'path'              => $path
                ]);

                return redirect()->route('admin.banner.list')->with('success','Banner '.config('constants.SUCCESS.ADD_DONE'));
            }
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method add**/

    /**
     * functionName : edit
     * createdDate  : 13-06-2024
     * purpose      : edit the card detail
    */
    public function edit(Request $request,$id){
        try{
            if($request->isMethod('get')){
                $banner = Banner::find($id);
                return view("admin.banner.edit",compact('banner'));
            }elseif( $request->isMethod('post') ){
                
                $rules = [
                    'title'         => 'required|string|max:255',
                    'type'          => 'required|in:default,subscription,contact-Aldine E',
                    'image'         => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ];
                $validator = Validator::make($request->all(), $rules);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $banner = Banner::find($id);
                $path = $banner->path;
                
                if($request->hasFile('image')){
                    deleteFile($path,'public/images');
                    $path = uploadFile($request->file('image'),'images');
                }

                Banner::where('id' , $id)->update([
                    'title'             => $request->title,
                    'type'              => $request->type,
                    'description'       => $request->description ? $request->description : '',
                    'path'              => $path,
                ]);

                return redirect()->route('admin.banner.list')->with('success','Banner '.config('constants.SUCCESS.UPDATE_DONE'));
            }
        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method edit**/

    /**
     * functionName : delete
     * createdDate  : 13-06-2024
     * purpose      : Delete the banner by id
    */
    public function delete($id){
        try{
            $banner = Banner::find($id);
            $path = $banner->path;
            if($path != "")
                deleteFile($path,'public/images');
            
            Banner::where('id',$id)->delete();

            return response()->json(["status" => "success","message" => "Banner ".config('constants.SUCCESS.DELETE_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method delete**/

    /**
     * functionName : changeStatus
     * createdDate  : 13-06-2024
     * purpose      : Update the banner status
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
           
            Banner::where('id',$request->id)->update(['status' => $request->status]);

            return response()->json(["status" => "success","message" => "Banner status ".config('constants.SUCCESS.CHANGED_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method changeStatus**/
}
