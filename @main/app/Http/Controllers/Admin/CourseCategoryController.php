<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Models\Course;
use App\Models\Category;
use App\Enums\StatusEnum;

class CourseCategoryController extends Controller
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
        $cats = CourseCategory::with('course')
        ->with('category')
        ->get();
        return view('dashboard.course_category.list', [
            'cats' => $cats,
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
        $cats = Category::all();
        return view("dashboard.course_category.new", compact("cats", "courses"));
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
            'category_id' => 'required|integer',
            'course_id' => 'required|integer',
        ]);

        $insertData = [
            'course_id' => $request->course_id,
            'category_id' => $request->category_id,
        ];

        $authors = CourseCategory::create($insertData);
        if ($authors) {
            return redirect()->route("dashboard.courseCategory.list")->with(ResponseMessage::createSucceed(__("Category")));
        }
        return redirect()->route("dashboard.courseCategory.list")->with(ResponseMessage::createFailed(__("Category")));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseCategory $cc)
    {
        $courses = Course::where("status", StatusEnum::ACTIVE)->get();
        $cats = Category::all();
        return view("dashboard.course_category.edit", compact("cc", "cats", "courses"));
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
        $validated = $request->validate([
            'category_id' => 'required|integer',
            'course_id' => 'required|integer',
        ]);

        $data = [
            'course_id' => $request->course_id,
            'category_id' => $request->category_id,
        ];

        $ca = CourseCategory::findOrFail($id)->update($data);
        if ($ca) {
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
        $cat = CourseCategory::findOrFail($id);
        $deleted = $cat->delete();
        if ($deleted) {
            return response()->json([
                'status' => 200,
                'message' => 'Category deleted'
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Category deleted'
        ]);
    }
}
