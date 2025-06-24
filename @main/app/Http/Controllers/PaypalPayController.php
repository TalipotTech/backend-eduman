<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalPayController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view("paypal.index");
    }
    
    public function handlePayment(Request $request)
    {
        $amt = !empty($_GET['amt']) ? $_GET['amt'] : "10.00";
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amt
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()->away(config('app.frontend_url') .'/failed-payment?message=Something went wrong');
        } 
        else {
            return redirect()->away(config('app.frontend_url') .'/failed-payment?message=Something went wrong');
        }
    }

    public function paymentCancel()
    {
        return redirect()->away(config('app.frontend_url') .'/failed-payment?message=You have canceled the transaction');
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()->away(config('app.frontend_url') .'/thankyou?message=Transaction complete');
        } else {
            return redirect()->away(config('app.frontend_url') .'/failed-payment?message=Something went wrong');
        }
    }
}
