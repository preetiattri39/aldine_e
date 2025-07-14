<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\{Banner,Category,ContentPage, ManagefAQ, Order,User,Contact};
use App\Traits\SendResponseTrait;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use SendResponseTrait;
    /**
     * functionName : home
     * createdDate  : 05-07-2024
     * purpose      : get details for the home page
    */
    public function home(){
        try{
            $categories = Category::where('categories.status', 1)
                        ->select('categories.*', DB::raw('COUNT(order_cards.id) as total_purchases'),DB::raw('AVG(order_cards.rating) as average_rating'))
                        ->join('cards', 'categories.id', '=', 'cards.category_id')
                        ->join('order_cards', 'cards.id', '=', 'order_cards.card_id')
                        ->join('orders', 'orders.id', '=', 'order_cards.order_id')
                        ->groupBy('categories.id')
                        ->orderByDesc('total_purchases')
                        ->limit(5)
                        ->get();

                $orders = Order::whereNotNull('orders.payment_id')
                    ->whereNull('orders.response_id')
                    ->where('orders.status' , 'completed')
                    ->join('payments','orders.payment_id','=','payments.id')
                    ->join('order_cards','orders.id','=','order_cards.order_id')
                    ->join('cards','order_cards.card_id','=','cards.id')
                    ->join('categories','cards.category_id','=','categories.id')
                    ->where('orders.user_id', authId())
                    ->orderByDesc('orders.created_at')
                    ->select('orders.*','payments.amount')
                    ->selectRaw('COUNT(order_cards.id) as total_cards')
                    ->selectRaw('COUNT(order_cards.id) as total_cards')
                    ->selectRaw('SUM(CASE WHEN order_cards.is_scratched = 1 THEN 1 ELSE 0 END) as scratched_cards_count')
                    ->selectRaw('GROUP_CONCAT(DISTINCT categories.name SEPARATOR ", ") as category_names')
                    ->groupBy('orders.id');

                if (authUserPlanType() == 'premium') {
                    $orders->selectRaw('0 as is_expiry');
                }else{
                    $orders->selectRaw('CASE WHEN orders.expiry_date > NOW() THEN 0 ELSE 1 END as is_expiry');
                }
                $orders = $orders->get();

                $personalized = Order::
                        whereNotNull('orders.payment_id')
                        ->whereNotNull('orders.response_id')
                        ->where('orders.status' , 'completed')
                        ->join('payments','orders.payment_id','=','payments.id')
                        ->join('order_cards','orders.id','=','order_cards.order_id')
                        ->join('cards','order_cards.card_id','=','cards.id')
                        ->join('categories','cards.category_id','=','categories.id')
                        ->where('orders.user_id', authId())
                        ->orderByDesc('orders.created_at')
                        ->select('orders.*','payments.amount')
                        ->selectRaw('COUNT(order_cards.id) as total_cards')
                        ->selectRaw('COUNT(order_cards.id) as total_cards')
                        ->selectRaw('SUM(CASE WHEN order_cards.is_scratched = 1 THEN 1 ELSE 0 END) as scratched_cards_count')
                        ->selectRaw('GROUP_CONCAT(DISTINCT categories.name SEPARATOR ", ") as category_names');
                       

                if (authUserPlanType() == 'premium') {
                    $personalized->selectRaw('0 as is_expiry');
                }else{
                    $personalized->selectRaw('CASE WHEN orders.expiry_date > NOW() THEN 0 ELSE 1 END as is_expiry');
                }
                $personalized = $personalized->groupBy('orders.id')
                                    ->limit(4)
                                    ->get();

            $banners = Banner::where('status',1)->orderByDesc('created_at')->get();
            
            $user = User::find(authId());
            $day_count = $user->day_count;
            
            // if($user->scratched_date == date('Y-m-d')){
            //     $day_count = $day_count-1;
            // }

            $data = [
                'popular_categories'        => ($categories->count() != 0 ) ? $categories :Category::where('status',1)->orderBy('id','desc')->limit(5)->select('id','path','name')->get(),
                'orders'                    => $orders,
                'categories'                => Category::where('status',1)->orderBy('id','desc')->limit(8)->select('id','path','name')->get(),
                'banners'                   => $banners,
                'personalized'              => $personalized,
                'total_personalized_board'  => Order::where('user_id',authId())->whereNotNull('payment_id')->where('board_type','personalized')->count(),
                'total_categorized_board'   => Order::where('user_id',authId())->whereNotNull('payment_id')->where('board_type','customized')->count(),
                'day_count'                 => $day_count
            ];

            return $this->apiResponse('success',200,'Home detail '.config('constants.SUCCESS.FETCH_DONE'),$data);
        }catch(\Exception $e){
            return $this->apiResponse('error',400,$e->getMessage());
        }
    }
    /*end method home */

    /**
     * functionName : contentPages
     * createdDate  : 12-07-2024
     * purpose      : get the content pages data with slug
    */
    public function contentPages($slug){
        try{
            if($slug != 'f-a-q')
                $data = ContentPage::where('slug',$slug)->select('id','title','slug','content')->first();
            else
                $data = ManagefAQ::where('status',1)->select('id','question','answer')->get();

            return $this->apiResponse('success',200,'Content detail '.config('constants.SUCCESS.FETCH_DONE'),$data);
        }catch(\Exception $e){
            return $this->apiResponse('error',400,$e->getMessage());
        }
    }
    /*end method contentPages */

     /**
     * functionName : storeContact
     * createdDate  : 10-04-2025
     * purpose      : Save contacts
    */

    
 /*end method storeContact */
}
