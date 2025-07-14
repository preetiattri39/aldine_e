<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Contact};
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;
use App\Traits\SendResponseTrait;

class ContactController extends Controller

{
    use SendResponseTrait;
    /**
     * functionName : getList
     * createdDate  : 18-07-2024
     * purpose      : Get the list for all the FAQ
     */
    public function getList(Request $request)
    {
        try {
            $faq = Contact::when($request->filled('search_keyword'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search_keyword%")
                        ->orWhere('email', 'like', "%$request->search_keyword%");
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
            return view("admin.contact.list", compact("faq"));
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method getList**/


    public function edit(Request $request, $id)
    {
        try {
            if ($request->isMethod('get')) {
                $contact = Contact::findOrFail($id);
                return view("admin.contact.edit", compact('contact'));
            } elseif ($request->isMethod('post')) {
                $contact = Contact::findOrFail($id);
    
                $request->validate([
                    'reply' => 'required|string',
                ]);
    
                // Get template
                $template = $this->getTemplateByName('Contact_Reply');
                if ($template) {
                    // Replace placeholders in template
                    $stringToReplace = ['{{$name}}', '{{$companyName}}', '{{$user_message}}', '{{$reply_message}}', '{{YEAR}}'];
                    $stringReplaceWith = [
                        $contact->name,
                        config('app.name'), // or hardcode your company name
                        $contact->message,
                        $request->reply,
                        date('Y')
                    ];
    
                    $emailBody = str_replace($stringToReplace, $stringReplaceWith, $template->template);
    
                    // Assuming mailData() and mailSend() are your custom methods
                    $emailData = $this->mailData(
                        $contact->email,
                        str_replace(['{{$companyName}}'], [config('app.name')], $template->subject),
                        $emailBody,
                        'Contact_Reply',
                        $template->id
                    );

                    $contact->reply = $request->reply;
                    $contact->is_replied = 1;
                    $contact->save();
    
                    $this->mailSend($emailData);


                }
    
                return redirect()->route('admin.contact.list')->with('success', 'Reply sent successfully!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }


    /**
     * functionName : delete
     * createdDate  : 11-04-2025
     * purpose      : Delete the contact by id
    */
    public function delete($id){
        try{
           
            $contact = Contact::where('id',$id)->delete();

            return response()->json(["status" => "success","message" => "Contact ".config('constants.SUCCESS.DELETE_DONE')], 200);
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
    /**End method delete**/
    
}
