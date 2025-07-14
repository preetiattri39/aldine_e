<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CryptoSubscription;
use App\Models\Payment;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * functionName : getList
     * createdDate  : 14-06-2024
     * purpose      : Get the list for all transactions
    */
    public function getList(Request $request){
        try{
            $fromDate = null;
            $toDate = null;
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date);
                $toDate = Carbon::parse($request->to_date);
                if ($fromDate->gt($toDate)) {
                    $temp = $fromDate;
                    $fromDate = $toDate;
                    $toDate = $temp;
                }
            }

            $transactions = Payment::when($fromDate && $toDate, function($query) use ($fromDate, $toDate) {
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            })->when($request->filled('search_keyword'), function($query) use ($request) {
                $keyword = $request->search_keyword;
                $query->where(function($query) use ($keyword) {
                    $query->where('payment_id', 'like', "%$keyword%")
                        ->orWhere('amount', 'like', "%$keyword%")
                        ->orWhere('payment_type', 'like', "%$keyword%")
                        ->orWhereHas('user', function($query) use ($keyword) {
                            $query->where(function($query) use ($keyword) {
                                $query->where('first_name', 'like', "%$keyword%")
                                    ->orWhere('last_name', 'like', "%$keyword%")
                                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$keyword%"]);
                            });
                        })
                        ->orWhereHas('order', function($query) use ($keyword) {
                            $query->where('uuid', 'like', "%$keyword%");
                        });
                });
            })->orderBy('id', 'desc')->paginate(10);
            return view("admin.transaction.list",compact("transactions"));
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method getList**/

    /**
     * functionName : cryptosubscriptionList
     * createdDate  : 07-01-2025
     * purpose      : Get the list of crypto subscription
    */
    public function cryptosubscriptionList(Request $request){
        try{
            $fromDate = null;
            $toDate = null;
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date);
                $toDate = Carbon::parse($request->to_date);
                if ($fromDate->gt($toDate)) {
                    $temp = $fromDate;
                    $fromDate = $toDate;
                    $toDate = $temp;
                }
            }

            $transactions = CryptoSubscription::when($fromDate && $toDate, function($query) use ($fromDate, $toDate) {
                $query->whereBetween('created_at', [$fromDate->startOfDay(), $toDate->endOfDay()]);
            })->when($request->filled('search_keyword'), function($query) use ($request) {
                $keyword = $request->search_keyword;
                $query->where(function($query) use ($keyword) {
                    $query->Where('amount', 'like', "%$keyword%")
                        ->orWhere('method', 'like', "%$keyword%")
                        ->orWhere('status', 'like', "%$keyword%")
                        ->orWhereHas('user', function($query) use ($keyword) {
                            $query->where(function($query) use ($keyword) {
                                $query->where('first_name', 'like', "%$keyword%")
                                    ->orWhere('last_name', 'like', "%$keyword%")
                                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$keyword%"]);
                            });
                        });
                });
            })->orderBy('id', 'desc')->paginate(10);
            return view("admin.transaction.cryptoSubscriptionlist",compact("transactions"));
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method getList**/

    /**
     * functionName : view
     * createdDate  : 14-06-2024
     * purpose      : Get the detail of the specific transaction
    */
    public function view($id){
        try{
            $transaction = Payment::findOrFail($id);
            return view("admin.transaction.view",compact("transaction"));
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method view**/


     /**
     * functionName : subscriptionList
     * createdDate  : 14-10-2024
     * purpose      : Get the list for all subscription user list
    */
    public function subscriptionList(Request $request){
        try{
            $fromDate = null;
            $toDate = null;
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date);
                $toDate = Carbon::parse($request->to_date);
                if ($fromDate->gt($toDate)) {
                    $temp = $fromDate;
                    $fromDate = $toDate;
                    $toDate = $temp;
                }
            }

            $subscriptions = Subscription::when($fromDate && $toDate, function($query) use ($fromDate, $toDate) {
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            })->when($request->filled('search_keyword'), function($query) use ($request) {
                $keyword = $request->search_keyword;
                $query->where(function($query) use ($keyword) {
                    $query->where('transaction_id', 'like', "%$keyword%")
                        ->orWhereHas('user', function($query) use ($keyword) {
                            $query->where(function($query) use ($keyword) {
                                $query->where('first_name', 'like', "%$keyword%")
                                    ->orWhere('last_name', 'like', "%$keyword%")
                                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$keyword%"]);
                            });
                        });
                });
            })->orderBy('id', 'desc')->paginate(10);
            return view("admin.subscription.list",compact("subscriptions"));
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method subscriptionList**/
}
