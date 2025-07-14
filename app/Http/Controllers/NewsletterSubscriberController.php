<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use App\Traits\SendResponseTrait;


class NewsletterSubscriberController extends Controller
{

     use SendResponseTrait;

    /**
     * functionName : subscribe
     * createdDate  : 17-04-2025
     * purpose      : newsletter subscribe
     * 
     */

    public function subscribe(Request $request){
        $request->validate(['email' => 'required|email|unique:newsletter_subscribers,email']);

        $subscriber = NewsletterSubscriber::create(['email' => $request->email]);

        if ($subscriber) {
            $template = $this->getTemplateByName('Newsletter_Subscribed');

            if ($template) {
                $stringToReplace = ['{{$name}}', '{{$companyName}}', '{{YEAR}}'];
                $stringReplaceWith = [
                    'Subscriber', // Or use optional name field if available
                    config('app.name'),
                    date('Y')
                ];

                $emailBody = str_replace($stringToReplace, $stringReplaceWith, $template->template);

                $emailData = $this->mailData(
                    $subscriber->email,
                    str_replace(['{{$companyName}}'], [config('app.name')], $template->subject),
                    $emailBody,
                    'Newsletter_Subscribed',
                    $template->id
                );

                $this->mailSend($emailData);
            }
        }

        return back()->with('success', 'Subscribed successfully!');
    }


    /**End method subscribe**/


      /**
     * functionName : index
     * createdDate  : 17-04-2025
     * purpose      : get newsletter subscribe listing
     * 
     */

    public function index(Request $request)
    {
        $subscribers =NewsletterSubscriber::when($request->filled('search_keyword'),function($query) use($request){
            $query->where(function($query) use($request){
                $query->where('email','like',"%$request->search_keyword%");
                    
            });
        })
        ->when($request->filled('status'),function($query) use($request){
            $query->where('status',$request->status);
        })
        ->orderBy("id","desc")->paginate(10);

        return view('admin.newsletter.list', compact('subscribers'));
    }

    /**End method index**/

    
    /**
     * functionName : delete
     * createdDate  : 17-04-2025
     * purpose      : Delete the newsletter  by id
    */
    public function delete($id){
        try{
           
            NewsletterSubscriber::where('id',$id)->delete();
            return response()->json(["status" => "success","message" => "NewsletterSubscriber ".config('constants.SUCCESS.DELETE_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method delete**/

    /**
     * functionName : changeStatus
     * createdDate  : 17-04-2025
     * purpose      : Update the newsletter status status
    */
    public function changeStatus(Request $request){

        try{
            
            
            NewsletterSubscriber::where('id',$request->id)->update(['status' => $request->status]);

            return response()->json(["status" => "success","message" => "NewsletterSubscriber status ".config('constants.SUCCESS.CHANGED_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method changeStatus**/
}
