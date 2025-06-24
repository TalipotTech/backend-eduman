<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseReview;
use App\Models\Course;
use App\Models\User;
use App\Enums\StatusEnum;

class CourseReviewController extends Controller
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
        $reviews = CourseReview::all();
        return view('dashboard.course_review.list', [
            'reviews' => $reviews,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::where("status", StatusEnum::ACTIVE)->get();
        $studentsData = User::where('role', 'Student')
            ->get();
        $students = array();
        if($studentsData)
        {
            foreach($studentsData as $student)
            {
                $singleStudent = array(
                    'id' => $student->id,
                    'title' => $student->first_name .' '. $student->last_name,
                );
                array_push($students, $singleStudent);
            }
        }
        $rating = [
            ["value" => 1, "title" => 1],
            ["value" => 2, "title" => 2],
            ["value" => 3, "title" => 3],
            ["value" => 4, "title" => 4],
            ["value" => 5, "title" => 5],
        ];

        return view("dashboard.course_review.new", compact("students", "rating", "courses"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer',
            'message' => 'required|string|max:65535',
        ]);

        $insertData = [
            'course_id' => $request->course_id,
            'user_id' => $request->user_id,
            'rating' => $request->rating,
            'message' => !empty($request->message) ? $request->message : "",
            'status' => "Active",
        ];

        $reviews = CourseReview::create($insertData);
        if ($reviews) {
            return redirect()->route("dashboard.courseReview.list")->with(ResponseMessage::createSucceed(__("Review")));
        }
        return redirect()->route("dashboard.courseReview.list")->with(ResponseMessage::createFailed(__("Review")));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseReview $review)
    {
        $studentsData = User::where('role', 'Student')
            ->get();
        $courses = Course::where("status", StatusEnum::ACTIVE)->get();
        $students = array();
        if($studentsData)
        {
            foreach($studentsData as $student)
            {
                $singleStudent = array(
                    'id' => $student->id,
                    'title' => $student->first_name .' '. $student->last_name,
                );
                array_push($students, $singleStudent);
            }
        }
        $rating = [
            ["value" => 1, "title" => 1],
            ["value" => 2, "title" => 2],
            ["value" => 3, "title" => 3],
            ["value" => 4, "title" => 4],
            ["value" => 5, "title" => 5],
        ];

        return view("dashboard.course_review.edit", compact("review", "students", "rating", "courses"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "rating" => "required|integer",
            "message" => "required|string|max:65535",
        ]);

        $course = CourseReview::findOrFail($id)->update([
            'course_id' => $request->course_id,
            'user_id' => $request->user_id,
            'rating' => $request->rating,
            'message' => !empty($request->message) ? $request->message : "",
            'status' => "Active",
        ]);

        if ($course) {
            return redirect()->back()->with('message', 'Save Successfully!');
        }
        return redirect()->back()->with('message', 'Save Failed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = CourseReview::findOrFail($id);
        $deleted = $review->delete();
        if ($deleted) {
            return response()->json([
                'status' => 200,
                'message' => 'Review deleted'
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Review deleted'
        ]);
    }
}
