<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizResult;
use App\Models\Quiz;
use App\Models\Question;
use App\Enums\QuizCategoryEnum;
use App\Helpers\ResponseMessage;
use Illuminate\Http\Request;

class QuizResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:blog-list', ['only' => ['index','show']]);
        $this->middleware('permission:blog-create', ['only' => ['create','store']]);
        $this->middleware('permission:blog-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = QuizResult::with("course")
            ->get();
        return view("dashboard.quiz_result.list", ["results" => $results]);
    }

   
}
