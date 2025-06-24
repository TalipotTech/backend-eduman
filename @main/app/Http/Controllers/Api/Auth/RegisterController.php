<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Cashier\Order\Order;
use App\Models\PricePlan;
use App\Models\Student;
use App\Models\OrderBilling;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

final class RegisterController extends Controller
{
    /**
     * @OA\Post(
     * path="/users/register",
     * summary="Sign in",
     * description="Register by email, name, etc",
     * operationId="saveUser",
     * tags={"User"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Register user",
     *    @OA\JsonContent(
     *       required={"first_name","last_name","phone","email","role","password"},
     *       @OA\Property(property="email", type="string", format="email", example="nasir.chalo@gmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="password"),
     *       @OA\Property(property="first_name", type="string", example="first name"),
     *       @OA\Property(property="last_name", type="string", example="last name"),
     *       @OA\Property(property="phone", type="string", example="phone"),
     *       @OA\Property(property="role", type="string", example="role"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Error response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, Already exists your email")
     *        )
     *     )
     * )
     */
    public function saveUser(Request $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'status' => StatusEnum::PENDING,
        ]);

        $lastName = !empty($request->last_name) ? ' '. $request->last_name .'-'. $user->id: '';
        $slug = str()->slug($request->first_name . $lastName);

        $studentData = [
            "user_id" => $user->id,
            "titel_name" => "",
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "slug" => $slug,
            "street_address" => "",
            "city" => "",
            "zip" => "",
            "country" => "",
            "teaser" => "",
            "description" => "",
            "fb_url" => "",
            "website_url" => "",
            "instagram_url" => "",
            "status" => StatusEnum::PENDING,
        ];

        $student = Student::create($studentData);

        return response()->json([
            'data' => [
                'user' => $user,
                'student' => $student,
            ],
        ]);
    }

    /**
     * @OA\Post(
     * path="/users/order-with-register",
     * summary="Order",
     * description="Order",
     * operationId="saveUserAndOrder",
     * tags={"User"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Order and Register user",
     *    @OA\JsonContent(
     *       required={"price_plan_id","first_name","last_name","street_address","city","country","zip","phone","email","alt_first_name","alt_last_name","alt_street_address","alt_city","alt_country","alt_zip","alt_phone","alt_email"},
     *       @OA\Property(property="price_plan_id", type="integer", example="1"),
     *       @OA\Property(property="first_name", type="string", example="first name"),
     *       @OA\Property(property="last_name", type="string", example="last name"),
     *       @OA\Property(property="city", type="string", example="berlin"),
     *       @OA\Property(property="zip", type="string", example="10235"),
     *       @OA\Property(property="country", type="string", example="germany"),
     *       @OA\Property(property="email", type="string", format="email", example="nasir.chalo@gmail.com"),
     *       @OA\Property(property="phone", type="string", example="448775656"),
     *       @OA\Property(property="alt_first_name", type="string", example="first name"),
     *       @OA\Property(property="alt_last_name", type="string", example="last name"),
     *       @OA\Property(property="alt_city", type="string", example="berlin"),
     *       @OA\Property(property="alt_zip", type="string", example="10235"),
     *       @OA\Property(property="alt_country", type="string", example="germany"),
     *       @OA\Property(property="alt_email", type="string", format="email", example="nasir.chalo@gmail.com"),
     *       @OA\Property(property="alt_phone", type="string", example="448775656"),
     *       @OA\Property(property="payment_method", type="string", example="paypal"),
     * 
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Error response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, Already exists your email")
     *        )
     *     )
     * )
     */
    public function saveUserAndOrder(Request $request)
    {
        $user_id = trim($request->user_id);
        if( !empty($user_id) )
        {
            $user = User::find($user_id);
            $student = Student::where('user_id', $user_id)->first();
            $package = PricePlan::find(intval($request->price_plan_id));
            $amt = !empty($package->amount) ? $package->amount : 0.00;
            $start_at = \Carbon\Carbon::now()->toDateString();
            $end_at = \Carbon\Carbon::now()->addMonths($package->duration)->toDateString();
        
            $order = OrderBilling::create([
                "user_id" => $user_id,
                'price_plan_id' => $request->price_plan_id,
                'qty' => 1,
                'total_price' => $amt,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'country' => $request->country,
                'zip' => $request->zip,
                'phone' => $request->phone,
                'email' => $request->email,
                'alt_first_name' => !empty($request->alt_first_name) ? $request->alt_first_name : $request->first_name,
                'alt_last_name' => !empty($request->alt_last_name) ? $request->alt_last_name : $request->last_name,
                'alt_street_address' => !empty($request->alt_street_address) ? $request->alt_street_address : $request->street_address,
                'alt_city' => !empty($request->alt_city) ? $request->alt_city : $request->city,
                'alt_country' => !empty($request->alt_country) ? $request->alt_country : $request->country,
                'alt_zip' => !empty($request->alt_zip) ? $request->alt_zip : $request->zip,
                'alt_phone' => !empty($request->alt_phone) ? $request->alt_phone : $request->phone,
                'alt_email' => !empty($request->alt_email) ? $request->alt_email : $request->email,
                'start_at' => $start_at,
                'end_at' => $end_at,
                'payment_method' => $request->payment_method,
                'status' => StatusEnum::PENDING,
            ]);

            return response()->json([
                'data' => [
                    'order' => $order,
                    'user' => $user,
                    'student' => $student,
                    'package' => $package,
                ],
            ]);
        }
        else 
        {
            return response()->json([
                'success' => false,
            ]);
        }
    }
}
