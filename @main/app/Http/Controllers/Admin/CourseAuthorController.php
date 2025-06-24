<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseAuthor;
use App\Models\Course;
use App\Models\Author;
use App\Enums\StatusEnum;

class CourseAuthorController extends Controller
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
        $authors = CourseAuthor::with('course')
            ->with('author')
            ->get();

        return view('dashboard.course_author.list', [
            'authors' => $authors,
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
        $authorsData = Author::all();
        $authors = array();
        if($authorsData)
        {
            foreach($authorsData as $author)
            {
                $singleAuthor = array(
                    'id' => $author->id,
                    'title' => $author->first_name .' '. $author->last_name,
                );
                array_push($authors, $singleAuthor);
            }
        }
        return view("dashboard.course_author.new", compact("authors", "courses"));
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
            'author_id' => 'required|integer',
            'course_id' => 'required|integer',
        ]);

        $insertData = [
            'course_id' => $request->course_id,
            'author_id' => $request->author_id,
        ];

        $authors = CourseAuthor::create($insertData);

        if ($authors) {
            return redirect()->route("dashboard.courseAuthor.list")->with(ResponseMessage::createSucceed(__("Author")));
        }
        return redirect()->route("dashboard.courseAuthor.list")->with(ResponseMessage::createFailed(__("Author")));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(courseAuthor $ca)
    {
        $courses = Course::where("status", StatusEnum::ACTIVE)->get();
        $authorsData = Author::all();
        $authors = array();
        if($authorsData)
        {
            foreach($authorsData as $author)
            {
                $singleAuthor = array(
                    'id' => $author->id,
                    'title' => $author->first_name .' '. $author->last_name,
                );
                array_push($authors, $singleAuthor);
            }
        }
        return view("dashboard.course_author.edit", compact("ca", "authors", "courses"));
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
            'author_id' => 'required|integer',
            'course_id' => 'required|integer',
        ]);

        $data = [
            'course_id' => $request->course_id,
            'author_id' => $request->author_id,
        ];

        $ca = courseAuthor::findOrFail($id)->update($data);
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
        $author = courseAuthor::findOrFail($id);
        $deleted = $author->delete();
        if ($deleted) {
            return response()->json([
                'status' => 200,
                'message' => 'Author deleted'
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Author deleted'
        ]);
    }
}
