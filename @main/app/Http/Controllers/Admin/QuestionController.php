<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Question;
use App\Enums\QuestionCategoryEnum;
use App\Helpers\ResponseMessage;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:question-list', ['only' => ['index','show']]);
        $this->middleware('permission:question-create', ['only' => ['create','store']]);
        $this->middleware('permission:question-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:question-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();
        return view("dashboard.questions.list", ["questions" => $questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = QuestionCategoryEnum::cases();
        return view("dashboard.questions.new", [
            "types" => $types,
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
            "answers" => "required|array",
            "correct_answer" => "required|string",
            "points" => "nullable|integer",
            "status" => "required|string",
        ]);

        try {
            $options = [
                "options" => $request->answers,
                "correct" => $request->correct_answer,
                "points" => $request->points,
            ];
    
            $question = Question::create([
                "title" => $request->title,
                "settings_data" => "",
                "content_data" => json_encode($options),
                "explanation" => $request->explanation,
                "category" => $request->category,
                "status" => $request->status,
            ]);

            return redirect()->route("dashboard.questions.list")->with(ResponseMessage::createSucceed(__("Question")));

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(ResponseMessage::createFailed(__("Question")));
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
        $question = Question::findOrFail($id);
        $types = QuestionCategoryEnum::cases();

        return view("dashboard.questions.edit", [
            "question" => $question,
            "types" => $types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            "title" => "required|string",
            "category" => "required|string",
            "answers" => "required|array",
            "correct_answer" => "required|string",
            "points" => "nullable|integer",
            "status" => "required|string",
        ]);

        $options = [
            "options" => $request->answers,
            "correct" => $request->correct_answer,
            "points" => $request->points,
        ];

        $data = [
            "title" => $request->title,
            "settings_data" => "",
            "content_data" => json_encode($options),
            "explanation" => $request->explanation,
            "category" => $request->category,
            "status" => $request->status,
        ];

        try {
            $updated = $question->update($data);
            if ($updated) {
                return redirect()->route("dashboard.questions.list")->with(ResponseMessage::updateSucceed(__("Question")));
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(ResponseMessage::updateFailed(__("Question")));
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
        $Question = Question::findOrFail($id);
        $deleted = $Question->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Question")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Question")));
    }
}
