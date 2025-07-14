<?php

use App\Models\Category;
use App\Models\ConfigSetting;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

/**
 * functionName : authId
 * createdDate  : 30-05-2024
 * purpose      : Get the id of the logged in user
 */
if(!function_exists('authId')){
    function authId(){
        if(Auth::check())
            return Auth::user()->id;
        return null;
    }
}
/** end methd authId */

/*
 * functionName : authUserPlanType
 * createdDate  : 30-05-2024
 * purpose      : Get the purchased plan of the logged in user
*/
if(!function_exists('authUserPlanType')){
    function authUserPlanType(){
        $user = User::find(authId());
        if($user){
            return $user->plan_type;
        }
        return null;
    }
}
/** end methd authUserPlanType */


/*
 * functionName : getRoleNameById
 * createdDate  : 30-05-2024
 * purpose      : Get the role name with the user Id
*/
if(!function_exists('getRoleNameById')){
    function getRoleNameById($id){
        $user = User::find($id);
        if($user){
            return $user->role->name;
        }
        return null;
    }
}
/** end methd getRoleNameId */


/*
 * functionName : deviceTokenById
 * createdDate  : 25-08-2024
 * purpose      : Get the device token by the user Id
*/
if(!function_exists('deviceTokenById')){
    function deviceTokenById($id){
        $user = User::find($id);
        if($user){
            return $user->device_token;
        }
        return null;
    }
}
/** end methd deviceTokenById */

/*
 * functionName : deviceTypeById
 * createdDate  : 25-08-2024
 * purpose      : Get the device type by the user Id
*/
if(!function_exists('deviceTypeById')){
    function deviceTypeById($id){
        $user = User::find($id);
        if($user){
            return $user->device_type;
        }
        return "android";
    }
}
/** end methd deviceTypeById */

/*
 * functionName : userNameById
 * createdDate  : 30-05-2024
 * purpose      : Get user name by id
*/
if(!function_exists('userNameById')){
    function userNameById($id){
        $user = User::where('id',$id)->withTrashed()->first();
        if($user){
            return ($user->first_name ?? '' ).' '.($user->last_name ?? '') ;
        }
        return '';
    }
}
/** end methd userNameById */


/*
 * functionName : convertDate
 * createdDate  : 03-06-2024
 * purpose      : convert the date format 
*/
if(!function_exists('convertDate')){
    function convertDate($date, $format = 'd M Y, h:i A'){
        $date = Carbon::parse($date);
        $formattedDate = $date->format($format);
        return $formattedDate;
    }
}
/** end methd convertDate */

/*
 * functionName : UserImageById
 * createdDate  : 04-06-2024
 * purpose      : To get the userImage by id
*/
if(!function_exists('userImageById')){
    function userImageById($id){
       $user =  User::find($id);

       if($user &&!is_null($user->profile_pic))
            return  $user->profile_pic ;
        else
            return asset('images/user_dummy.png');
    }
}
/** end methd userImageById */

/*
 * functionName : replyDiffernceCalculate
 * createdDate  : 04-06-2024
 * purpose      : To get the differnce of the post uploading
*/
if(!function_exists('replyDiffernceCalculate')){
    function replyDiffernceCalculate($date){
        $startDate = Carbon::now();
        $endDate = Carbon::parse($date);
        $formattedDate = $startDate->diff($endDate);
        // return $formattedDate->format('%S');
        if($formattedDate->format('%S') < 60 && $formattedDate->format('%I') == 0 && $formattedDate->format('%H') == 0 && $formattedDate->format('%d') == 0 && $formattedDate->format('%m') == 0 && $formattedDate->format('%y') == 0)
            // return $formattedDate->format('%S').' sec';
            return 'few sec';
        elseif($formattedDate->format('%I') < 60 && $formattedDate->format('%H') == 0 &&  $formattedDate->format('%d') == 0 && $formattedDate->format('%m') == 0 && $formattedDate->format('%y') == 0)
            return $formattedDate->format('%I').' mins';
        elseif($formattedDate->format('%H') < 24 && $formattedDate->format('%d') == 0 && $formattedDate->format('%m') == 0 && $formattedDate->format('%y') == 0)
            return $formattedDate->format('%H').' hrs';
        elseif($formattedDate->format('%d') < 31 && $formattedDate->format('%m') == 0 && $formattedDate->format('%y') == 0)
            return $formattedDate->format('%d').' days';
        elseif($formattedDate->format('%m') < 31 && $formattedDate->format('%y') == 0)
            return $formattedDate->format('%d').' days';
        elseif($formattedDate->format('%y') < 31)
            return $formattedDate->format('%y').' years';
        return '';  
    }
}
/** end methd replyDiffernceCalculate */

/*
 Method Name:    readNotification
 Purpose:        read notifications
 Params:         
*/  
if (!function_exists('readNotification')) {
    function readNotification($userId)
    {
        User::find($userId)->notifications()
            ->whereNull('read_at')
            ->update(['read_at'=>now()]);
    }
 }
/* End Method read notifications */


/*
 Method Name: Upload Files
 Purpose:     Upload Files
 Params:      $request,$path
*/  
if(!function_exists('uploadFile'))
{
    function uploadFile($file, $path)
    {
        if ($file) {
            // $ext      = $file->getClientOriginalExtension();
            // $filename = Carbon::now()->format('YmdHis') . '_' . rand(00000, 99999) . '.' . $ext;
            // $file->move(public_path('images'), $filename);

            // // $result   = Storage::disk('public')->putFileAs($path, $file, $filename);
            // return $filename ? $filename : false;

            $imageName = time().'.'.$file->getClientOriginalExtension();  
            $file->storeAs('public/'.$path, $imageName);
            return $imageName ? $imageName : false;
        }
        return false;
    }
}

/*
 Method Name: Delete Files
 Purpose:     Delete Files
 Params:      $name,$path
*/  

if(!function_exists('deleteFile'))
{
   function deleteFile($name,$path)
   {
        if($name)
        {
            $deleteImage = 'public/'.$path . $name;
            if (Storage::exists($deleteImage)) {
                Storage::delete($deleteImage);
            }
            // $filePath = public_path($path . $name);
            // if (File::exists($filePath)) {
            //     // Delete the file
            //     File::delete($filePath);
            // }
        }
        return false;
   }
}

/*
 Method Name: Delete Files
 Purpose:     Delete Files
 Params:      $name,$path
*/  

if(!function_exists('generateRandomString'))
{
    function generateRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=[]{}|;:,.<>?';
        $charactersLength = strlen($characters);
        $randomString = '';

        // Ensure at least one of each type of character
        $hasDigit = false;
        $hasSpecial = false;
        $hasLowercase = false;
        $hasUppercase = false;

        while (strlen($randomString) < $length) {
            $char = $characters[rand(0, $charactersLength - 1)];
            
            if (ctype_digit($char)) {
                $hasDigit = true;
            } elseif (ctype_lower($char)) {
                $hasLowercase = true;
            } elseif (ctype_upper($char)) {
                $hasUppercase = true;
            } elseif (!ctype_alnum($char)) {
                $hasSpecial = true;
            }

            $randomString .= $char;
        }

        if (!$hasDigit || !$hasSpecial || !$hasLowercase || !$hasUppercase) {
            return generateRandomString($length);
        }

        return $randomString;
    }
}

/*
 Method Name:    encryptData
 Purpose:        encrypt data
 Params:         [data, encryptionMethod, secret]
*/  
if (!function_exists('encryptData')) {
    function encryptData(string $data, string $encryptionMethod = null, string $secret = null)
    {
        $encryptionMethod = config('constants.encryptionMethod');
        $secret = config('constants.secrect');
        try {
            $iv = substr($secret, 0, 16);
            $jsencodeUserdata = str_replace('/', '!', openssl_encrypt($data, $encryptionMethod, $secret, 0, $iv));
            $jsencodeUserdata = str_replace('+', '~', $jsencodeUserdata);
 
            return $jsencodeUserdata;
        } catch (\Exception $e) {
            return null;
        }
    }
 }
 /* End Method encryptData */
 
 /*
 Method Name:    decryptData
 Purpose:        Decrypt data
 Params:         [data, encryptionMethod, secret]
 */  
 if (!function_exists('decryptData')) {
    function decryptData(string $data, string $encryptionMethod = null, string $secret = null)
    {
        // return $data;
        $encryptionMethod = config('constants.encryptionMethod');
        $secret = config('constants.secrect');
        
        try {
            $iv = substr($secret, 0, 16);
            $data = str_replace('!', '/', $data);
            $data = str_replace('~', '+', $data);
            $jsencodeUserdata = openssl_decrypt($data, $encryptionMethod, $secret, 0, $iv);
            return $jsencodeUserdata;
        } catch (\Exception $e) {
           return null;
        }
    }
 }

/*
 Method Name:    CategoryNameById
 Purpose:        Decrypt data
 Params:         [data, encryptionMethod, secret]
 */  
if (!function_exists('categoryNameById')) {
    function categoryNameById($id)
    {
        return Category::find($id) ? Category::find($id)->name : 'N/A';
    }
 }

/*
 Method Name:    getAdmimId
 Purpose:        get the admin id
 Params:         [type]
*/  
if (!function_exists('getAdmimId')) {
    function getAdmimId()
    {
        $role = Role::where('name' , config('constants.ROLES.ADMIN'))->first();
        $admin = User::where('role_id',$role->id)->first();
        return  $admin->id;
    }
}

/*
 Method Name:    paypalObjectCreation
 Purpose:        Intialization of payment objection creation
 Params:        []
*/  

if (!function_exists('paypalObjectCreation')) {
    function    paypalObjectCreation(){
        try{
            $provider = new PayPalClient;
            $provider = \PayPal::setProvider();
                
            $setting = ConfigSetting::where('type','paypal')->pluck('value','key');
                    
            $config = [
                'mode'                      =>  $setting['PAYPAL_MODE'],
                    $setting['PAYPAL_MODE']    => [
                    'client_id'         => $setting['PAYPAL_CLIENT_ID'],
                    'client_secret'     => $setting['PAYPAL_CLIENT_SECRET'],
                    'app_id'            => 'APP-80W284485P519543T',
                ],
                'payment_action' => 'Sale',
                'currency'       => 'USD',
                'locale'         => 'en_US',
                'notify_url'     => 'https://your-app.com/paypal/notify',
                'validate_ssl'   => true,

            ];
                    
            $provider->setApiCredentials($config);
            $provider->getAccessToken();

            return $provider;
        }catch(\Exception $e){
            return response()->json(["status" =>"error", $e->getMessage()],500);
        }
    }
}