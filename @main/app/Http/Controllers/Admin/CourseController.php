<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;

class CourseController extends Controller
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
        $courses = Course::all();
        return view('dashboard.course.list')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Category::where('type', 'Course')
            ->where('status', 'Active')
            ->where('parent_id', 0)
            ->get();
        return view('dashboard.course.add')
            ->with('categories', $cats);
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
            'title' => ['required', 'string'],
            'teaser' => ['required', 'string'],
            'more_info' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'string'],
        ]);

        $upload = new UploadFileController();

        $image_url = '';
        $file_url = '';
        $video_url = '';

        if (!empty($request->file('image_url'))) {
            $image_url = $upload->uploadImage($request, 'image_url');
        }

        if (!empty($request->file('document_url'))) {
            $file_url = $upload->uploadFile($request, 'document_url');
        }

        if (!empty($request->file('video_url'))) {
            $video_url = $upload->uploadVideo($request, 'video_url');
        }

        $course = Course::create([
            'title' => $request->title,
            'slug' => str()->slug($request->title),
            'price' => $request->price,
            'discount' => $request->discount,
            'teaser' => $request->teaser,
            'more_info' => $request->more_info,
            'description' => $request->description,
            'image_url' => $image_url,
            'video_url' => $video_url,
            'document_url' => $file_url,
            'status' => $request->status,
            'language' => $request->language,
            'level' => $request->level,
            'credit' => $request->credit,
            'duration' => $request->duration,
        ]);

        return  redirect()->route('dashboard.courses.list')->with('message', 'Save Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $categories = Category::where('type', 'Course')
            ->where('status', 'Active')
            ->where('parent_id', 0)
            ->get();
        return view('dashboard.course.edit', compact("course", "categories"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            "title" => "required|string",
            "price" => "required|numeric",
            "teaser" => "required|string",
            "more_info" => "required|string",
            "description" => "required|string",
            "status" => "required|string",
        ]);

        $course->title = $request->title;
        $course->slug = str()->slug($request->title);
        $course->price = $request->price;
        $course->discount = $request->discount;
        $course->teaser = $request->teaser;
        $course->more_info = $request->more_info;
        $course->description = $request->description;
        $course->status = $request->status;
        $course->language = $request->language;
        $course->level = $request->level;
        $course->credit = $request->credit;
        $course->duration = $request->duration;

        //upload image
        $upload = new UploadFileController();

        if (!empty($request->file('image_url')) && $request->hasFile('image_url')) {
            $image_url = $upload->uploadImage($request, 'image_url');
            $course->image_url = $image_url;
        }

        if (!empty($request->file('document_url')) && $request->hasFile('document_url')) {
            $document_url= $upload->uploadFile($request, 'document_url');
            $course->document_url = $document_url;
        }

        if (!empty($request->file('video_url')) && $request->hasFile('video_url')) {
            $video_url = $upload->uploadVideo($request, 'video_url');
            $course->video_url = $video_url;
        }

        $course = $course->save();
        if ($course) {
            return redirect()->route('dashboard.courses.list')->with('message', 'Course update success');
        }

        return redirect()->back()->with('message', 'Course update failed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $deleted = $course->delete();
        if ($deleted) {
            return response()->json([
                'status' => 200,
                'message' => 'Course delete success'
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Course delete failed'
        ]);
    }
}
