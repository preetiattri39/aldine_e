<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{ContentPage,Contact};
use App\Models\ManagefAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Traits\SendResponseTrait;

class ContentPageController extends Controller
{

    use SendResponseTrait;
    /**
     * functionName : contentPage
     * createdDate  : 13-06-2024
     * purpose      : get and update the content page detail
    */
    public function contentPageDetail(Request $request , $slug){
        try{
            if($request->isMethod('get')){
               $content_detail =  ContentPage::where('slug',$slug)->first();
                return view("admin.contentPage.update",compact('content_detail'));
            }elseif( $request->isMethod('post') ){
                $rules = [
                    'title'         => 'required|string|max:255',
                    'content'       => 'required',
                ];
                
                $validator = Validator::make($request->all(), $rules);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                
               
               ContentPage::where('slug',$slug)->update([
                    'title'     => $request->title,
                    'content'     => $request->content,
               ]);

                return redirect()->back()->with('success',ucfirst(str_replace('-', ' ', $slug)).' '.config('constants.SUCCESS.UPDATE_DONE'));
            }
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method add**/

    /**
     * functionName : contentPage
     * createdDate  : 02-09-2024
     * purpose      : get content page detail for web
    */
    public function contentPage($slug){
        try{
        
            if(in_array($slug,['privacy-and-policy','about-us','terms-and-conditions','delete-account-steps'])){
                $content_detail =  ContentPage::where('slug',$slug)->first();

                return view("admin.content-page",compact('content_detail'));
            }elseif($slug == 'FAQ'){
                $content_detail = ManagefAQ::where('status',1)->orderBy('id','desc')->get();

                return view("admin.content-page",compact('content_detail'));
            } else{
                return redirect()->back()->with("error", 'Not Found');
            }
            
            
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method contentPage**/

    /**
     * functionName : storeContact
     * createdDate  : 15-04-2025
     * purpose      : send message through contact us
    */
    public function storeContact(Request $request){
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'message' => 'required|string'
            ]);

            $contact = Contact::create($validated);

            if ($contact) {
                $template = $this->getTemplateByName('Contact_submit');

                if ($template) {
                    // Replace placeholders in template
                    $stringToReplace = ['{{$name}}', '{{$companyName}}', '{{YEAR}}'];
                    $stringReplaceWith = [
                        $contact->name,
                        config('app.name'),
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

                    $this->mailSend($emailData);

                }
            }

            return redirect()->back()->with('success', 'Thank you for reaching out. We will get back to you soon!');

        } catch (\Exception $e) {
            // Log the error or handle as needed
            \Log::error('Contact form submission failed: '.$e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
        }
    }
     /**End method storeContact**/



}
