<?php
namespace App\Http\Controllers;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class SubscriptionPlanController extends Controller
{
    /**
     * @param string $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $uid, string $plan)
    {
        $user = User::find($uid);

        if(!$user->subscribed($plan)) {

            $result = $user->newSubscription('main', $plan)->create();

            if(is_a($result, RedirectResponse::class)) {
                return $result; // Redirect to Mollie checkout
            }

            // $result is a \Laravel\Cashier\Subscription model
            return back()->with('status', 'Welcome to the ' . $plan . ' plan');
        }

        return back()->with('status', 'You are already on the ' . $plan . ' plan');
    }
}
