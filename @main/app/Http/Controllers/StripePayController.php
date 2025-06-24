<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OrderBilling;
use Session;
use Stripe;

class StripePayController extends Controller
{
    /**
     * Display the view.
     *
     * @return \Illuminate\View\View
     */
    public function stripePayment(Request $request)
    {
        return view("stripe.index", [
            'user' => User::find($request->get('user_id')),
            'order_id' => $request->get('order_id'),
            'amt' => $request->get('amt'),
        ]);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePaymentPost(Request $request)
    {
        $user = User::find($request->post('user_id'));
        $order = OrderBilling::find($request->post('order_id'));
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $customer = Stripe\Customer::create(array(
            "address" => [
                "line1" => $order->street_address,
                "postal_code" => $order->zip,
                "city" => $order->city,
                "state" => $order->city,
                "country" => $order->country,
            ],
            "email" => $order->email,
            "name" => $order->first_name .' '. $order->last_name,
            "source" => $request->stripeToken
        ));

        Stripe\Charge::create([
            "amount" => !empty($order->total_price) ? round($order->total_price*100)  : 2000,
            "currency" => "usd",
            "customer" => $customer->id,
            "description" => __("Course Subscription Fee"),
            "shipping" => [
                "name" => $order->first_name .' '. $order->last_name,
                "address" => [
                    "line1" => $order->street_address,
                    "postal_code" => $order->zip,
                    "city" => $order->city,
                    "state" => $order->city,
                    "country" => $order->country,
                ],
            ]
        ]);

        return redirect()->away(config('app.frontend_url') .'/thankyou?message=Stripe Transaction complete');
    }
}
