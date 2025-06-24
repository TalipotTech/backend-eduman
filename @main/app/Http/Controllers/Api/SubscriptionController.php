<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseMessage;
use App\Models\PricePlan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * @OA\Get(
     *    path="/subscription/packages",
     *    operationId="getPlansAll",
     *    tags={"Subscription"},
     *    summary="Get subscriptions",
     *    description="Get subscriptions",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getPlansAll(Request $request)
    {
        $data = PricePlan::where('status', 'Active')
            ->get();
        return response()->json([
            'data' =>$data,
        ]);
    }

   
}
