<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Country;
use App\Models\InterestedCountriesUser;
use App\Models\User;
use Laravel\Cashier\Order\Order;
use App\Models\Wishlist;
use App\Mail\UserFeedback;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    
    /**
     * @OA\Get(
     *    path="/users/me",
     *    operationId="me",
     *    tags={"User"},
     *    summary="Get auth user details",
     *    description="Get auth user details",
     *    security={ {"sanctum": {} }},
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    ),
     *    @OA\Response(
     *          response=401,
     *          description="Returns when user is not authenticated",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Not authorized"),
     *          )
     *      )
     * )
     */
    public function me(Request $request)
    {
        if($request->user()->id)
        {
            $user = User::find($request->user()->id);
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
            $user['order'] = (object)$orderArray;

            return response()->json( array('success' => true, 'user' => $user), 200);
        }
        else 
        {
            return response()->json( array('success' => false), 200);
        }
        
    }
    
    /**
     * @OA\Get(
     *    path="/users/courses",
     *    operationId="getAuthUserCourses",
     *    tags={"User"},
     *    summary="Get auth user courses",
     *    description="Get auth user courses",
     *    security={ {"sanctum": {} }},
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getAuthUserCourses(User $user, Request $request)
    {
        if( !empty($request->user()->id) )
        {
            $user = User::find($request->user()->id);
            return response()->json([
                'data' => $user->courses,
                'user_id' => $request->user()->id,
            ]);
        }
        else 
        {
            return response()->json([
                "success" => false,
            ]);
        }
    }

    /**
     * @OA\Get(
     *    path="/users/wishlist",
     *    operationId="getAuthUserWishlist",
     *    tags={"User"},
     *    summary="Get auth user wishlist",
     *    description="Get auth user wishlist",
     *    security={ {"sanctum": {} }},
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getAuthUserWishlist(User $user, Request $request)
    {
        if( !empty($request->user()->id) )
        {
            $user = User::where('id', $request->user()->id)
                ->with([
                    'wishlist' => [
                        'categories',
                    ],
                ])
                ->first();

            return response()->json([
                'data' => !empty($user->wishlist) ? $user->wishlist : [],
                'user_id' => $request->user()->id,
            ]);
        }
        else 
        {
            return response()->json([
                "success" => false,
            ]);
        }
    }

    /**
     * @OA\Get(
     *    path="/users/wishlist-save",
     *    operationId="saveAuthUserWishlist",
     *    tags={"User"},
     *    summary="Save auth user wishlist",
     *    description="Save auth user wishlist",
     *    security={ {"sanctum": {} }},
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function saveAuthUserWishlist(User $user, Request $request)
    {
        if( !empty($request->user()->id) )
        {
            if( Wishlist::where('user_id', $request->user()->id)->where('course_id', $request->cid)->count() > 0 )
            {
                $wishlist = Wishlist::where('user_id', $request->user()->id)
                    ->where('course_id', $request->cid)
                    ->first();
                
                $wish = Wishlist::findOrFail($wishlist->id);
                $wish->delete();
                $follow_bolooen = true;
            }
            else 
            {
                $data = [
                    "user_id" => $request->user()->id,
                    "course_id" => $request->cid ?? "", 
                ];
                $wishlist = Wishlist::create($data);
                $follow_bolooen = false;
            }

            return response()->json([
                'data' => $wishlist,
                'user_id' => $request->user()->id,
                'course_id' => $request->cid,
                'unfollow' => $follow_bolooen,
            ]);
        }
        else 
        {
            return response()->json([
                "success" => false,
            ]);
        }
    }
}
