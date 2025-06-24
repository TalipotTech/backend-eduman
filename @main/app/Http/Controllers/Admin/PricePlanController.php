<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseMessage;
use App\Enums\PricePlanEnum;
use App\Models\PricePlan;
use Illuminate\Http\Request;

class PricePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:price_plan-list', ['only' => ['index','show']]);
        $this->middleware('permission:price_plan-create', ['only' => ['create','store']]);
        $this->middleware('permission:price_plan-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:price_plan-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $price_plans = PricePlan::all();
        return view("dashboard.price-plan.all", compact("price_plans"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "type" => "nullable|string",
            "title" => "required|string",
            "money_sign" => "required|string",
            "amount" => "required|string",
            "duration" => "required|string",
            "details" => "nullable|string",
            "features" => "nullable|string",
            "badge_text" => "nullable|string",
            "status" => "nullable|string",
        ]);

        $price_plan = PricePlan::create([
            "type" => $request->type,
            "title" => $request->title,
            "money_sign" => $request->money_sign,
            "amount" => $request->amount,
            "duration" => $request->duration,
            "details" => $request->details,
            "features" => $request->features,
            "badge_text" => $request->badge_text,
            "is_highlighted" => !empty($request->is_highlighted) ? $request->is_highlighted : 0,
            "category" => PricePlanEnum::SUBSCRIPTION,
            "status" => $request->status,
        ]);

        if ($price_plan) {
            return back()->with(ResponseMessage::createSucceed(__("Price plan")));
        }
        return back()->with(ResponseMessage::createFailed(__("Price plan")));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PricePlan $pricePlan)
    {
        $request->validate([
            "type" => "nullable|string",
            "title" => "required|string",
            "money_sign" => "required|string",
            "amount" => "required|string",
            "duration" => "required|string",
            "details" => "nullable|string",
            "features" => "nullable|string",
            "badge_text" => "nullable|string",
            "status" => "required|string",
        ]);

        $updated = $pricePlan->update([
            "type" => $request->type,
            "title" => $request->title,
            "money_sign" => $request->money_sign,
            "amount" => $request->amount,
            "duration" => $request->duration,
            "details" => $request->details,
            "features" => $request->features,
            "badge_text" => $request->badge_text,
            "is_highlighted" => !empty($request->is_highlighted) ? $request->is_highlighted : 0,
            "status" => $request->status,
        ]);

        if ($updated) {
            return back()->with(ResponseMessage::updateSucceed(__("Price plan")));
        }
        return back()->with(ResponseMessage::updateFailed(__("Price plan")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PricePlan $pricePlan)
    {
        $deleted = $pricePlan->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Price Plan")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Price Plan")));
    }
}
