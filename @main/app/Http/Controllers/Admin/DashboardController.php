<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\Order\Order;
use App\Models\Student;
use App\Models\Author;
use App\Models\Course;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::where('category', 'Instructor')
            ->limit(10)
            ->get();
        $courses = Course::limit(5)
            ->get();
        $students = Student::limit(4)
            ->get();
        $orders = Order::join("order_items","order_items.order_id","=","orders.id")
            ->orderBy("orders.id", "DESC")
            ->select('orders.currency', 'orders.total', 'orders.mollie_payment_status', 'order_items.description_extra_lines', 'order_items.description', 'order_items.quantity')
            ->limit(3)
            ->get();
        $totalIncome = Order::sum('total');
        $totalCourses = Course::count();
        $totalAuthors = Author::where('category', 'Instructor')
            ->count();
        $totalStudents = Student::count();

        $moneySignObj = Order::orderBy('id', 'DESC')
            ->limit(1)
            ->select('currency')
            ->first();

        $totalIncome = round($totalIncome/100, 2);
        $moneySign = (!empty($moneySignObj->currency) && $moneySignObj->currency == 'EUR') ? '€' : '$';

        return view("dashboard", 
            compact("authors", "students", "courses", "orders", "totalCourses", "totalAuthors", "totalStudents", "totalIncome", "moneySign")
        );
    }


}
