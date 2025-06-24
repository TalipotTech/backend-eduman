<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Enums\CategoryTypeEnum;
use Laravel\Cashier\Order\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:course-list', ['only' => ['index','show']]);
        $this->middleware('permission:course-create', ['only' => ['create','store']]);
        $this->middleware('permission:course-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:course-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $user['order'] = Order::join("order_items","order_items.order_id","=","orders.id")
            ->join("users","users.id","=","orders.owner_id")
            ->orderBy("orders.id", "DESC")
            ->select('orders.*', 'order_items.description_extra_lines', 'order_items.quantity', 'order_items.description', 'users.first_name', 'users.last_name', 'users.email', 'users.phone')
            ->get();
        return view("dashboard.order.list", compact("orders"));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate(Order $order)
    {
        $data = [
            "status" => 'Active',
        ];

        $updated = $order->update($data);
        if ($updated) {
            return response()->json(ResponseMessage::deleteSucceed(__("Order")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Order")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $deleted = $order->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Order")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Order")));
    }
}
