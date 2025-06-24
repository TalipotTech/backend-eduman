<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use App\Enums\QuizCategoryEnum;
use App\Helpers\ResponseMessage;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:quiz-list', ['only' => ['index','show']]);
        $this->middleware('permission:quiz-create', ['only' => ['create','store']]);
        $this->middleware('permission:quiz-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:quiz-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::all();
        return view("dashboard.quiz.list", ["quizzes" => $quizzes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = QuizCategoryEnum::cases();
        $questions = Question::all();

        return view("dashboard.quiz.new", [
            "types" => $types,
            "questions" => $questions,
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
            "category" => "required|string",
            "questions" => "required|array",
            "status" => "required|string",
        ]);

        try {   
            $settingData = [
                'quiz_attempt' => !empty($request->quiz_attempt) ? intval($request->quiz_attempt) : 3,
                'active_timer' => !empty($request->active_timer) ? $request->active_timer : 0,
                'timer_time' => !empty($request->timer_time) ? $request->timer_time : 0,
                'allow_negative_mark' => !empty($request->allow_negative_mark) ? $request->allow_negative_mark : 0,
                'flat' => !empty($request->flat) ? $request->flat : 0,
                'negative_percentage' => !empty($request->negative_percentage) ? $request->negative_percentage : 0,
            ];

            $contentData = [
                'questions' => $request->questions,
            ];

            Quiz::create([
                "title" => $request->title,
                "slug" => str()->slug($request->title),
                "description" => $request->description,
                "settings_data" => json_encode($settingData),
                "content_data" => json_encode($contentData),
                "category" => $request->category,
                "status" => $request->status,
            ]);

            return redirect()->route("dashboard.quiz.list")->with(ResponseMessage::createSucceed(__("Quiz")));

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(ResponseMessage::createFailed(__("Quiz")));
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
    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        $types = QuizCategoryEnum::cases();
        $questions = Question::all();

        return view("dashboard.quiz.edit", [
            "quiz" => $quiz,
            "types" => $types,
            "questions" => $questions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            "title" => "required|string",
            "category" => "required|string",
            "questions" => "required|array",
            "status" => "required|string",
        ]);

        $contentData = [
            'questions' => $request->questions,
        ];

        $settingData = [
            'quiz_attempt' => !empty($request->quiz_attempt) ? intval($request->quiz_attempt) : 3,
            'active_timer' => !empty($request->active_timer) ? $request->active_timer : 0,
            'timer_time' => !empty($request->timer_time) ? $request->timer_time : 0,
            'allow_negative_mark' => !empty($request->allow_negative_mark) ? $request->allow_negative_mark : 0,
            'flat' => !empty($request->flat) ? $request->flat : 0,
            'negative_percentage' => !empty($request->negative_percentage) ? $request->negative_percentage : 0,
        ];

        $data = [
            "title" => $request->title,
            "slug" => str()->slug($request->title),
            "description" => $request->description,
            "settings_data" => json_encode($settingData),
            "content_data" => json_encode($contentData),
            "category" => $request->category,
            "status" => $request->status
        ];

        try {
            $updated = $quiz->update($data);
            if ($updated) {
                return redirect()->route("dashboard.quiz.list")->with(ResponseMessage::updateSucceed(__("Quiz")));
            }
            
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(ResponseMessage::updateFailed(__("Quiz")));
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
        $quiz = Quiz::findOrFail($id);
        $deleted = $quiz->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Quiz")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Quiz")));
    }
}