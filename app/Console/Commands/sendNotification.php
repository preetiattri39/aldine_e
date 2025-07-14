<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Traits\SendResponseTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;

class sendNotification extends Command
{
    use SendResponseTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $today = Carbon::today();

        \Log::info( Carbon::now());
        $Orders = Order:: whereNotNull('payment_id')->where('expiry_date', '>=', $today)->get();
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
                    $this->sendPushNotification(deviceTokenById($order->user_id) , "Its your Aldine E time","you can scratch (because 24 hours have passed since the last scratch): It's your Aldine E time! ".$order->order_id,'Aldine E_day',$order->user_id,$order->toArray());
                    
                    $order->is_notified = 1;
                    $order->save();
                }
            }
        }
    }
}
