<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\{User,Order};
use Illuminate\Http\Request;
use App\Traits\SendResponseTrait;
use Carbon\Carbon;

class SendNotificationController extends Controller
{
    use SendResponseTrait;
    public function sendNotifications(Request $request)
    {
        $today = Carbon::today();

        \Log::info( Carbon::now());
        $Orders = order:: whereNotNull('payment_id')->where('expiry_date', '>=', $today)->get();
        foreach ($Orders as $order) {
            if($order->is_notified == 1)
                continue;

            if ($order->orderCard()->where('is_scratched', 0)->count() == 0) 
                continue;

            $lastScratchedDate = Carbon::parse($order->last_scratched_time);
            $timeDifference = $lastScratchedDate->diffInHours(Carbon::now());
        
            if ($timeDifference < 24) {
                continue;
            }else{
                if(deviceTokenById($order->user_id) != null){
                    $this->sendPushNotification(deviceTokenById($order->user_id) , "Its your Aldine E time","Your daily dose of positivity is waiting to be revealed to you 🎉 ".$order->order_id,'Aldine E_day',$order->user_id,$order->toArray());
                    
                    $order->is_notified = 1;
                    $order->save();
                }
            }
        }

        // 7th scratched notification
        // $users =  User::where('status',1)->get();
        // foreach ($users as $user) {
        //     if($user->is_notified == 1 && $user->day_count == 7)
        //         continue;
        //     if($user->day_count == 7 && $user->is_notified == 0 && $user->scratched_date != date('Y-m-d')){
        //         if(deviceTokenById($user->id) != null){
        //             $this->sendPushNotification(deviceTokenById($user->id) , "Congratulations🎉."," Its your 7th scratch day.🎉 ",'7th_Aldine E_day',$user->id,$user->toArray());
                    
        //             $user->is_notified = 1;
        //             $user->save();
        //         }
        //     }
            
        // }

        return true;
    }
}
