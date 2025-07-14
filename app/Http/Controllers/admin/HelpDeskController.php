<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{HelpDesk, NotificationPreference, NotificationPreferencePermission, QueryResponse};
use App\Models\ConfigSetting;
use App\Models\CryptoSubscription;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use App\Notifications\PaymentNotification;
use App\Traits\SendResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class HelpDeskController extends Controller
{
    use SendResponseTrait;
    /**
     * functionName : getList
     * createdDate  : 03-06-2024
     * purpose      : Get the list for all the help desk
     */
    public function getList($type)
    {
        try {
            $tickets = new HelpDesk;
            $data = $tickets->clone()->when(($type == 'open'), function ($query) {
                $query->where('status', '!=', 'Done');
            })->when(($type == 'close'), function ($query) {
                $query->where('status', 'Done');
            })->orderBy("id", "desc")->paginate(10);
            $openCount = $tickets->clone()->where('status', '!=', 'Done')->count();
            $closeCount = $tickets->clone()->where('status', 'Done')->count();
            return view("admin.helpDesk.list", compact("data", "openCount", "closeCount", 'type'));
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method getList**/

    /**
     * functionName : add
     * createdDate  : 03-06-2024
     * purpose      : add the query
     */
    public function add(Request $request)
    {
        try {
            if ($request->isMethod('get')) {
                return view("admin.helpDesk.add");
            } elseif ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'user_name'         => 'required|string|max:255',
                    'email'             => 'required|email:rfc,dns',
                    'description'       => 'required',
                ], [
                    'description.required' => 'Query is required',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                HelpDesk::Create([
                    'user_id'           => authId(),
                    'user_name'         => $request->user_name,
                    'email'             => $request->email,
                    'phone_number'      => $request->phone_number ? $request->phone_number : '',
                    'query'             => $request->description,
                ]);

                return redirect()->route('admin.helpDesk.list', ['type' => 'open'])->with('success', 'Query ' . config('constants.SUCCESS.ADD_DONE'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End Method Add */

    /**
     * functionName : response
     * createdDate  : 03-06-2024
     * purpose      : Add the response
     */
    public function response(Request $request, $id)
    {
        try {
            // Status Expired of link after 60 minutes
            $subscriptions = CryptoSubscription::where('status', 'Pending')->get();
            foreach ($subscriptions as $key => $value) {
                $startTime = Carbon::parse($value->updated_at);
                $finishTime = Carbon::parse(now());
                $differnce = $startTime->diffInMinutes($finishTime);

                if ($differnce > 60) {
                    CryptoSubscription::where('id', $value->id)->update([
                        'status'    => 'Expired'
                    ]);
                }
            }
            // End of Expiration link
            if ($request->isMethod('get')) {
                $response = HelpDesk::find($id);
                return view("admin.helpDesk.response", compact('response'));
            } elseif ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'response'        => 'required'
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                HelpDesk::where('id', $id)->update(['status' => 'In Progress']);
                $query_response = QueryResponse::create(['help_id' => $id, 'user_id' => authId(), 'response' => $request->response]);

                /**send notification from firebase to users */
                $notificationId = NotificationPreference::where('name', NotificationPreference::MESSAGE_ARRIVED)->first()->id;
                $helpDesk =  HelpDesk::find($id);

                $user = NotificationPreferencePermission::where('notification_preference_id', $notificationId)->where('user_id', $helpDesk->user_id)->where('status', 1)->first();
                if ($user) {
                    $notificationData = [
                        'title' => 'New Message Arrived',
                        'body' => 'Message Recieved from admin in ' . $helpDesk->title,
                        'helpdesk',
                        $helpDesk->user_id,
                        $query_response->toArray(),
                        'type' => 'helpDesk',
                    ];


                    $this->sendPushNotification($notificationData['title'], $notificationData['body'], $notificationData['type'], $notificationData['shipment_id'], $user->id);
                }
                /**End to send notifcation */

                return redirect()->route('admin.helpDesk.response', ['id' => $id])->with('success', 'Reply ' . config('constants.SUCCESS.ADD_DONE'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    /**End method response**/


    /**
     * functionName : changeStatus
     * createdDate  : 04-05-2024
     * purpose      : Update the ticket status done mark as complete
     */
    public function changeStatus(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'id'        => 'required',
            ]);
            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(["status" => "error", "message" => $validator->errors()->first()], 422);
                }
            }

            HelpDesk::where('id', $request->id)->update(['status' => 'Done']);

            return response()->json(["status" => "success", "message" => "Ticket status " . config('constants.SUCCESS.CHANGED_DONE')], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", $e->getMessage()], 500);
        }
    }
    /**End method changeStatus**/


    /**
     * functionName : generatePaymentLink
     * createdDate  : 06-01-2025
     * purpose      : Generate the payment link for purchasing subscription
     */
    public function generatePaymentLink(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'amount'            => 'required',
                'payment_method'    => 'required|in:paypal,ETH,USDTERC20',
                'user_id'           => 'required|exists:users,id',
                'ticket_id'         => 'required|exists:help_desks,id'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $payment_url = '';

            $crypto_subscription = CryptoSubscription::create([
                'user_id'       => $request->user_id,
                'status'        => 'Pending',
                'amount'        => $request->amount,
                'method'        => $request->payment_method,
            ]);

            switch ($request->payment_method) {
                case "paypal":
                    $provider = paypalObjectCreation();

                    $response = $provider->createOrder([
                        'intent' => 'CAPTURE',
                        'purchase_units' => [
                            [
                                'amount' => [
                                    'currency_code' => 'USD',
                                    'value' => $request->amount,
                                ],
                            ],
                        ],
                        'application_context' => [
                            'return_url' => route('admin.paypal.success', ['crypto_id' => $crypto_subscription->id]),
                            'cancel_url' => route('admin.paypal.cancel', ['crypto_id' => $crypto_subscription->id]),
                        ],
                    ]);


                    $parsedUrl = parse_url($response['links'][1]['href']);
                    parse_str($parsedUrl['query'], $queryParams);

                    $payment_url  = 'https://' . $parsedUrl['host'] . '/checkoutweb/signup?token=' . $queryParams['token'];

                    // $payment_url = $response['links'][1]['href'];
                    break;
                case "ETH":
                case "USDTERC20":
                    // $apiKey       = env('NOW_PAYMENT_SANDBOX_API_KEY');
                    // $publicKey    = env('NOW_PAYMENT_SANDBOX_PUBLIC_KEY');
                    // $baseUrl      = env('NOW_PAYMENT_SANDBOX_BASE_URL');

                    $apiKey    = env('NOW_PAYMENT_LIVE_API_KEY');
                    $publicKey = env('NOW_PAYMENT_LIVE_PUBLIC_KEY');
                    $baseUrl   = env('NOW_PAYMENT_LIVE_BASE_URL');

                    $headers = [
                        'x-api-key' => $apiKey,
                    ];
                    $coins = Http::withHeaders($headers)
                        ->contentType('application/json')
                        ->get("{$baseUrl}/v1/merchant/coins");

                    if ($coins && $coins["selectedCurrencies"]) {

                        if (is_array($coins["selectedCurrencies"]) && ! in_array($request->payment_method, $coins["selectedCurrencies"])) {
                            return redirect()->back()->with('error', 'Selected currency is not supportd at yet.');
                        }
                    }

                    $order_request = array(
                        "price_amount"      => $request->amount,
                        "price_currency"    => 'usd',
                        "pay_currency"      => $request->payment_method,
                        "order_id"          =>  $crypto_subscription->id,
                        "order_description" => "Purchased  for subscription.",
                        "success_url"       => route('admin.nowpayment.success', ['crypto_id' => $crypto_subscription->id]),
                        "cancel_url"        => route('admin.nowpayment.cancel', ['crypto_id' => $crypto_subscription->id])
                    );


                    $response = Http::withHeaders($headers)
                        ->contentType('application/json')
                        ->post("{$baseUrl}/v1/invoice", $order_request);

                    if ($response) {
                        $payment_url = $response['invoice_url'];
                    } else {
                        return redirect()->back()->with('error', 'Payment creation failed.');
                    }
                    break;
            }

            HelpDesk::where('id', $request->ticket_id)->update(['status' => 'In Progress']);


            $crypto_subscription->link = $payment_url;
            $crypto_subscription->save();

            $query_response = QueryResponse::create([
                'help_id'               => $request->ticket_id,
                'user_id'               => authId(),
                'response'              => $payment_url,
                'type'                  => 2,
                'crypto_subscription_id' => $crypto_subscription->id,
            ]);

            /**send notification from firebase to users */
            $notificationId = NotificationPreference::where('name', NotificationPreference::MESSAGE_ARRIVED)->first()->id;
            $helpDesk =  HelpDesk::find($request->ticket_id);

            $user = NotificationPreferencePermission::where('notification_preference_id', $notificationId)->where('user_id', $helpDesk->user_id)->where('status', 1)->first();
            if ($user) {
                $notificationData = [
                    'title' => 'New Message Arrived',
                    'body' => 'Message Recieved from admin in ' . $helpDesk->title,
                    'helpdesk',
                    $helpDesk->user_id,
                    $query_response->toArray(),
                    'type' => 'helpDesk',
                ];


                $this->sendPushNotification($notificationData['title'], $notificationData['body'], $notificationData['type'], $notificationData['shipment_id'], $user->id);
            }
            /**End to send notifcation */


            return redirect()->back()->with('success', 'Payment link has been generated sucessfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    /**End method generatePaymentLink**/


    public function paypalPaymentExecute(Request $request)
    {
        try {
            $request->validate([
                'token'         => 'required',
                'crypto_id'     => 'required|exists:crypto_subscriptions,id',
            ]);

            $token = $request->input('token');

            $provider = paypalObjectCreation();

            $response = $provider->capturePaymentOrder($token);

            \Log::info($response);

            $crypto_payment =  CryptoSubscription::find($request->crypto_id);

            $help_desk_id = QueryResponse::firstWhere('crypto_subscription_id', $crypto_payment->id)->help_id;

            $helpdesk = HelpDesk::find($help_desk_id);

            if ($response['status'] === 'COMPLETED') {
                $crypto_payment->status = 'Paid';
                $crypto_payment->save();

                QueryResponse::create([
                    'response'  => '$' . $crypto_payment->amount . ' Payment successfully done using method : ' . $crypto_payment->method . '  with transaction id :' . $response['id'],
                    'user_id'   => $crypto_payment->user_id,
                    'help_id'   => $help_desk_id,
                    'type'      => 2
                ]);

                HelpDesk::where('id', $help_desk_id)->update(['status' => 'Done']);

                User::find(getAdmimId())->notify(new NewMessageNotification(userNameById($crypto_payment->user_id), $helpdesk->title));

                return $this->apiResponse('success', 200, 'Payment completed.');
            }
            $crypto_payment->status = 'Failed';
            $crypto_payment->save();

            HelpDesk::create([
                'user_id'  => $crypto_payment->user_id,
                'response' => 'Payment Failed!!',
                'help_id'  => $help_desk_id
            ]);

            User::find(getAdmimId())->notify(new NewMessageNotification(userNameById($crypto_payment->user_id), $helpdesk->title));

            return $this->apiResponse('error', 400, 'Payment capture failed.');
        } catch (\Exception $e) {
            return $this->apiResponse('error', 400, $e->getMessage());
        }
    }

    public function paypalPaymentCancel(Request $request)
    {
        try {
            $request->validate([
                'crypto_id'     => 'required|exists:crypto_subscriptions,id',
            ]);

            $crypto_payment =  CryptoSubscription::find($request->crypto_id);

            $help_desk_id = QueryResponse::firstWhere('crypto_subscription_id', $crypto_payment->id)?->help_id;

            $helpdesk = HelpDesk::find($help_desk_id);

            $crypto_payment->status = 'Failed';
            $crypto_payment->save();

            QueryResponse::create([
                'user_id'  => $crypto_payment->user_id,
                'response' => 'Payment Failed!!',
                'help_id'  => $help_desk_id
            ]);

            User::find(getAdmimId())->notify(new NewMessageNotification(userNameById($crypto_payment->user_id), $helpdesk->title));

            return $this->apiResponse('error', 400, 'Payment capture failed.');
        } catch (\Exception $e) {
            return $this->apiResponse('error', 400, $e->getMessage());
        }
    }

    public function nowPaymentExecute(Request $request)
    {
        try {
            $request->validate([
                'NP_id'         => 'required',
                'crypto_id'     => 'required|exists:crypto_subscriptions,id',
            ]);

            // $apiKey       = env('NOW_PAYMENT_SANDBOX_API_KEY');
            // $publicKey    = env('NOW_PAYMENT_SANDBOX_PUBLIC_KEY');
            // $baseUrl      = env('NOW_PAYMENT_SANDBOX_BASE_URL');

            $apiKey    = env('NOW_PAYMENT_LIVE_API_KEY');
            $publicKey = env('NOW_PAYMENT_LIVE_PUBLIC_KEY');
            $baseUrl   = env('NOW_PAYMENT_LIVE_BASE_URL');

            $headers = [
                'x-api-key' => $apiKey,
            ];
            $response = Http::withHeaders($headers)
                ->contentType('application/json')
                ->get("{$baseUrl}/v1/payment/{$request->NP_id}");

            $crypto_payment =  CryptoSubscription::find($request->crypto_id);

            $help_desk_id = QueryResponse::firstWhere('crypto_subscription_id', $crypto_payment->id)->help_id;

            $helpdesk = HelpDesk::find($help_desk_id);

            if ($response && $response["payment_status"]  === 'finished') {
                $crypto_payment->status = 'Paid';
                $crypto_payment->save();

                QueryResponse::create([
                    'response'  => '$' . $crypto_payment->amount . ' Payment successfully done using method : ' . $crypto_payment->method . '  with transaction id :' . $request->NP_id,
                    'user_id'   => $crypto_payment->user_id,
                    'help_id'   => $help_desk_id,
                    'type'      => 2
                ]);

                HelpDesk::where('id', $help_desk_id)->update(['status' => 'Done']);

                User::find(getAdmimId())->notify(new NewMessageNotification(userNameById($crypto_payment->user_id), $helpdesk->title));

                return $this->apiResponse('success', 200, 'Payment completed.');
            }
            $crypto_payment->status = 'Failed';
            $crypto_payment->save();

            HelpDesk::create([
                'user_id'  => $crypto_payment->user_id,
                'response' => 'Payment Failed!!',
                'help_id'  => $help_desk_id
            ]);

            User::find(getAdmimId())->notify(new NewMessageNotification(userNameById($crypto_payment->user_id), $helpdesk->title));

            return $this->apiResponse('error', 400, 'Payment capture failed.');
        } catch (\Exception $e) {
            return $this->apiResponse('error', 400, $e->getMessage());
        }
    }

    public function nowPaymentCancel(Request $request)
    {
        try {
            $request->validate([
                'crypto_id'     => 'required|exists:crypto_subscriptions,id',
            ]);

            $crypto_payment =  CryptoSubscription::find($request->crypto_id);

            $help_desk_id = QueryResponse::firstWhere('crypto_subscription_id', $crypto_payment->id)?->help_id;

            $crypto_payment->status = 'Failed';
            $crypto_payment->save();

            $helpdesk = HelpDesk::find($help_desk_id);

            QueryResponse::create([
                'user_id'  => $crypto_payment->user_id,
                'response' => 'Payment Failed!!',
                'help_id'  => $help_desk_id
            ]);

            User::find(getAdmimId())->notify(new NewMessageNotification(userNameById($crypto_payment->user_id), $helpdesk->title));

            return $this->apiResponse('error', 400, 'Payment capture failed.');
        } catch (\Exception $e) {
            return $this->apiResponse('error', 400, $e->getMessage());
        }
    }
}
