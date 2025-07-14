<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use App\Traits\SendResponseTrait;

class AnnouncementController extends Controller
{
    use SendResponseTrait;


  /**
     * functionName : index
     * createdDate  : 18-04-2025
     * purpose      : fecth annoucement listing
     * 
     */
    public function index(Request $request){
        $announcement = Announcement::when($request->filled('search_keyword'), function($query) use($request) {
            $query->where(function($query) use($request) {
                $query->where('title', 'like', "%" . $request->search_keyword . "%")
                      ->orWhere('message', 'like', "%" . $request->search_keyword . "%");
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
        ->orderBy("id", "desc")
        ->paginate(10);


        return view('admin.announcements.list', compact('announcement'));
    }

     /**End method index **/


      /**
     * functionName : Create
     * createdDate  : 18-04-2025
     * purpose      : return to announcement create page
     * 
     */
    public function create(){
        return view('admin.announcements.create');
    }
     /**End method create**/


    /**
     * functionName : send
     * createdDate  : 17-04-2025
     * purpose      :  send announcement to subscribers
     * 
     */

    public function send(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Save to DB
        $announcement = Announcement::create([
            'title'   => $request->title,
            'message' => $request->message,
        ]);

        // Fetch subscribers' emails
        $emails = NewsletterSubscriber::where('status', 1)->pluck('email');

        // Get email template
        $template = $this->getTemplateByName('Newsletter_Announcement');

        if ($template) {
            foreach ($emails as $email) {
                if ($email) {
                    
                    $stringToReplace = ['{{$name}}', '{{companyName}}', '{{YEAR}}','{{title}}','{!!message!!}'];
                        $stringReplaceWith = [
                           'Subscriber', // Or use optional name field if available
                        'EDUPALZ',
                        date('Y'),
                        $announcement->title,
                        $announcement->message,

                    ];

                    $emailBody = str_replace($stringToReplace, $stringReplaceWith, $template->template);

                    $emailData = $this->mailData(
                        $email,
                        str_replace(['{{companyName}}'], [config('app.name')], $template->subject),
                        $emailBody,
                        'Newsletter_Announcement',
                        $template->id
                    );

                      // dd($emailData);
                    $this->mailSend($emailData);
                
                }
            }
        }

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement sent successfully!');
    }

     /**End method send**/


       /**
     * functionName : delete
     * createdDate  : 18-04-2025
     * purpose      : Delete the newsletter  by id
    */
    public function delete($id)
{
    try {
        // Find the language or fail with 404
        $language = Announcement::findOrFail($id);

        // Delete the language
        $language->delete();

        return response()->json([
            "status" => "success",
            "message" => "Announcement " . config('constants.SUCCESS.DELETE_DONE')
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            "status" => "error", 
            "message" => "Announcement not found"
        ], 404);
    } catch(\Exception $e) {
        // Log the error for debugging
        \Log::error('Announcement deletion error: ' . $e->getMessage());
        
        return response()->json([
            "status" => "error", 
            "message" => "An error occurred while deleting the Announcement"
        ], 500);
    }
}
    /**End method delete**/

    /**
     * functionName : changeStatus
     * createdDate  : 18-04-2025
     * purpose      : Update the newsletter status status
    */
    public function changeStatus(Request $request){
        try{
            
            Announcement::where('id',$request->id)->update(['status' => $request->status]);
            return response()->json(["status" => "success","message" => "Announcement status ".config('constants.SUCCESS.CHANGED_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method changeStatus**/
}
