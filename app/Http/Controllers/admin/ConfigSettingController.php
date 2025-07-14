<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ConfigSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigSettingController extends Controller
{
    /**
     * functionName : smtpInformation
     * createdDate  : 14-06-2024
     * purpose      : update the smtp information
    */
    public function smtpInformation(Request $request){
        try{
            if($request->isMethod('get')){
                $smtpDetail = ConfigSetting::where('type','smtp')->pluck('value','key');
                return view("admin.config-setting.smtp",compact('smtpDetail'));
            }elseif( $request->isMethod('post') ){
                $validator = Validator::make($request->all(), [
                    'from_email'    => 'required|email:rfc,dns',
                    'host'          => 'required',
                    'port'          => 'required',
                    'username'      => 'required|email:rfc,dns',
                    'from_name'     => 'required',
                    'password'      => 'required',
                    'encryption'    => 'required|in:tls,ssl',
                ]);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                
                ConfigSetting::updateOrCreate(['type' => 'smtp','key' => 'from_email'],['value' => $request->from_email]);
                ConfigSetting::updateOrCreate(['type' => 'smtp','key' => 'host'],['value' => $request->host]);
                ConfigSetting::updateOrCreate(['type' => 'smtp','key' => 'port'],['value' => $request->port]);
                ConfigSetting::updateOrCreate(['type' => 'smtp','key' => 'username'],['value' => $request->username]);
                ConfigSetting::updateOrCreate(['type' => 'smtp','key' => 'from_name'],['value' => $request->from_name]);
                ConfigSetting::updateOrCreate(['type' => 'smtp','key' => 'password'],['value' => $request->password]);
                ConfigSetting::updateOrCreate(['type' => 'smtp','key' => 'encryption'],['value' => $request->encryption]);
               
                return redirect()->back()->with('success','SMTP information '.config('constants.SUCCESS.UPDATE_DONE'));
            }
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method smtpInformation**/

    /**
     * functionName : stripeInformation
     * createdDate  : 14-06-2024
     * purpose      : update the stripe information
    */
    public function stripeInformation(Request $request){
        try{
            if($request->isMethod('get')){
                $stripeDetail = ConfigSetting::where('type','stripe')->pluck('value','key');
                return view("admin.config-setting.stripe",compact('stripeDetail'));
            }elseif( $request->isMethod('post') ){
                $validator = Validator::make($request->all(), [
                    'STRIPE_KEY'    => 'required',
                    'STRIPE_SECRET' => 'required',
                ]);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                
                ConfigSetting::updateOrCreate(['type' => 'stripe','key' => 'STRIPE_KEY'],['value' => $request->STRIPE_KEY]);
                ConfigSetting::updateOrCreate(['type' => 'stripe','key' => 'STRIPE_SECRET'],['value' => $request->STRIPE_SECRET]);
                
                return redirect()->back()->with('success','Stripe information '.config('constants.SUCCESS.ADD_DONE'));
            }
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method stripeInformation**/

    /**
     * functionName : configInformation
     * createdDate  : 03-07-2024
     * purpose      : update the config information
    */
    public function configInformation(Request $request){
        try{
            if($request->isMethod('get')){
                $configDetail = ConfigSetting::where('type','config')->pluck('value','key');
                return view("admin.config-setting.config",compact('configDetail'));
            }elseif( $request->isMethod('post') ){
                $validator = Validator::make($request->all(), [
                    'instagram'     => 'required',
                    'reddit' => 'required',
                    'tiktok' => 'required',
                 
                ]);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                
                ConfigSetting::updateOrCreate(['type' => 'config','key' => 'instagram'],['value' => $request->instagram]);
                ConfigSetting::updateOrCreate(['type' => 'config','key' => 'reddit'],['value' => $request->reddit]);
                ConfigSetting::updateOrCreate(['type' => 'config','key' => 'tiktok'],['value' => $request->tiktok]);
             
                
                return redirect()->back()->with('success','Config information '.config('constants.SUCCESS.UPDATE_DONE'));
            }
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method configInformation**/

    /**
     * functionName : payPalInformation
     * createdDate  : 28-08-2024
     * purpose      : update the stripe information
    */
    public function payPalInformation(Request $request){
        try{
            if($request->isMethod('get')){
                $paypalDetail = ConfigSetting::where('type','paypal')->pluck('value','key');
                return view("admin.config-setting.paypal",compact('paypalDetail'));
            }elseif( $request->isMethod('post') ){
                $validator = Validator::make($request->all(), [
                    'PAYPAL_CLIENT_ID'      => 'required',
                    'PAYPAL_CLIENT_SECRET'  => 'required',
                    'PAYPAL_MODE'           => 'required|in:sandbox,live'
                ]);
                
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                
                ConfigSetting::updateOrCreate(['type' => 'paypal','key' => 'PAYPAL_CLIENT_ID'],['value' => $request->PAYPAL_CLIENT_ID]);
                ConfigSetting::updateOrCreate(['type' => 'paypal','key' => 'PAYPAL_CLIENT_SECRET'],['value' => $request->PAYPAL_CLIENT_SECRET]);
                ConfigSetting::updateOrCreate(['type' => 'paypal','key' => 'PAYPAL_MODE'],['value' => $request->PAYPAL_MODE]);
                
                return redirect()->back()->with('success','Pay Pal information '.config('constants.SUCCESS.UPDATE_DONE'));
            }
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method stripeInformation**/
}
