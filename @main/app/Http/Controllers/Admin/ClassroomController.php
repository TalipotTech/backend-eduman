<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Enums\QuizCategoryEnum;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Classroom;
use App\Enums\ClassroomCategoryEnum;
use App\Helpers\ResponseMessage;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:classroom-list', ['only' => ['index','show']]);
        $this->middleware('permission:classroom-create', ['only' => ['create','store']]);
        $this->middleware('permission:classroom-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:classroom-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classroom::all();
        
        return view("dashboard.classrooms.list", ["classes" => $classes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = ClassroomCategoryEnum::cases();
        $courses = Course::all();
        $lessons = Lesson::all();
        $quizzes = Quiz::where('category', QuizCategoryEnum::FINAL_EXAM)
            ->get();

        return view("dashboard.classrooms.new", [
            "types" => $types,
            "lessons" => $lessons,
            "courses" => $courses,
            "quizzes" => $quizzes,
        ]);
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
            "title" => "required|string",
            "lessons" => "required|array",
            "course_id" => "required|integer",
            "quiz_id" => "required|integer",
            "category" => "required|string",
            "status" => "required|string",
        ]);

        try {   
            $contentData = [
                'lessons' => $request->lessons,
                'quiz' => $request->quiz_id,
                'course_id' => $request->course_id,
            ];

            Classroom::create([
                "course_id" => $request->course_id,
                "title" => $request->title,
                "slug" => str()->slug($request->title),
                "settings_data" => "",
                "content_data" => json_encode($contentData),
                "category" => $request->category,
                "status" => $request->status,
            ]);

            return redirect()->route("dashboard.classrooms.list")->with(ResponseMessage::createSucceed(__("Classroom")));

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(ResponseMessage::createFailed(__("Classroom")));
        }
    }

    /**
     * @todo check if dropdown menu value is set or not
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {
        $types = ClassroomCategoryEnum::cases();
        $courses = Course::all();
        $lessons = Lesson::all();
        $quizzes = Quiz::all();

        return view("dashboard.classrooms.edit", [
            "classroom" => $classroom,
            "types" => $types,
            "lessons" => $lessons,
            "courses" => $courses,
            "quizzes" => $quizzes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom $Classroom)
    {
        $request->validate([
            "title" => "required|string",
            "lessons" => "required|array",
            "course_id" => "required|integer",
            "quiz_id" => "required|integer",
            "category" => "required|string",
            "status" => "required|string",
        ]);

        $contentData = [
            'lessons' => $request->lessons,
            'quiz' => $request->quiz_id,
            'course_id' => $request->course_id,
        ];

        $data = [
            "course_id" => $request->course_id,
            "title" => $request->title,
            "slug" => str()->slug($request->title),
            "settings_data" => "",
            "content_data" => json_encode($contentData),
            "category" => $request->category,
            "status" => $request->status
        ];

        try {
            $updated = $Classroom->update($data);
            if ($updated) {
                return redirect()->route("dashboard.classrooms.list")->with(ResponseMessage::updateSucceed(__("Classroom")));
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(ResponseMessage::updateFailed(__("Classroom")));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Classroom = Classroom::findOrFail($id);
        $deleted = $Classroom->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Classroom")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Classroom")));
    }
}
