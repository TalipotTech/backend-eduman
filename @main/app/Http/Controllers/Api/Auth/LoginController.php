<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OrderBilling;
use Laravel\Cashier\Order\Order;
use App\Models\Student;
use App\Models\ProfileUser;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Mpdf\Tag\Em;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     * path="/users/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="store",
     * tags={"User"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="nasir.chalo@gmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="password"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->tokens()->first();
            if (!empty($token)) {
                $newToken = Str::random(40);
                $token->token = hash('sha256', $newToken);
                $token->save();
                $user['bearer_token'] = $newToken;
            } 
            else {
                $user['bearer_token'] = $user->createToken('storefront')->plainTextToken;
            }

            $orderArray = array(
                'email' => $request->email,
                'total_price' => '0',
                'start_at' => '',
                'end_at' => '',
            );
  
            $order = Order::join("order_items","order_items.order_id","=","orders.id")
                ->where('orders.owner_id', $user->id)
                ->orderBy("orders.id", "DESC")
                ->select('orders.currency', 'orders.total', 'orders.mollie_payment_status', 'order_items.description_extra_lines', 'order_items.quantity')
                ->first();
        if( !empty($order->description_extra_lines) )
            $startEndDate = json_decode($order->description_extra_lines);
            if( !empty($startEndDate[0]) )
            {
                $startEndDateArray = explode(' ', $startEndDate[0]);
                $orderArray['currency'] = $order->currency;
                $orderArray['total_price'] = $order->total;
                $orderArray['status'] = $order->mollie_payment_status;
                $orderArray['quantity'] = $order->quantity;
                $orderArray['start_at'] = !empty($startEndDateArray[1]) ? $startEndDateArray[1] : date('Y-m-d');
                $orderArray['end_at'] = !empty($startEndDateArray[3]) ? $startEndDateArray[3] : date('Y-m-d');
            }

            if( !empty($orderArray['end_at']) ) {
                $user['order'] = (object)$orderArray;
            }
            else {
                $order = OrderBilling::where('user_id', $user->id)
                ->orderBy("id", "DESC")
                ->select('total_price', 'qty', 'end_at', 'start_at', 'status')
                ->first();
                if( !empty($order) ) {
                $orderArray['currency'] = 'Dollar';
                $orderArray['total_price'] = $order->total_price;
                $orderArray['status'] = $order->status;
                $orderArray['quantity'] = $order->qty;
                $orderArray['start_at'] = !empty($order->start_at) ? $order->start_at : date('Y-m-d');
                $orderArray['end_at'] = !empty($order->end_at) ? $order->end_at : date('Y-m-d');

                $user['order'] = (object)$orderArray;
                }
            }

            $user['student_profile'] = Student::where('user_id', $user->id)
                ->orderBy("id", "DESC")
                ->select('street_address', 'city', 'zip', 'country')
                ->first();

            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        }

        return response()->json([
            'success' => false,
            'data' => $user,
            'message' => __('Invalid E-Mail or Password!'),
        ], 401);
    }
}