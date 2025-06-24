<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use App\Enums\QuizCategoryEnum;
use App\Helpers\ResponseMessage;
use Illuminate\Http\Request;

class QuizImportController extends Controller
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
     * form layout
     *
     * @return Response
    */
    public function quizForm() {
		$types = QuizCategoryEnum::cases();
        return view("dashboard.import.quiz_form", [
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
            'questions_file' => 'required',
            "status" => "required|string",
        ]);

		if ( $request->has('questions_file') ) 
		{
			$upload = new UploadFileController();
			$file_url = '';
			if (!empty($request->file('questions_file'))) {
				$file_url = $upload->uploadFile($request, 'questions_file');
			}

			if (($handle = fopen ( '@main/storage/app/public/'. $file_url , 'r' )) !== FALSE) {
				$questionIds = array();
				while ( ($data = fgetcsv ( $handle, 1000, ',' )) !== FALSE ) {
					//Create question 
					$q = new Question();
					if( Question::where('title', $data[0])->where('category', $data[4])->count() ) {
						$existQ = Question::where('title', $data[0])->where('category', $data[4])->first();
						if( !empty($existQ->id) ) {
							$q = Question::find($existQ->id);
						}
					}

					$options = explode(",, ", $data[1]);
					$qContentData = [
						"options" => $options,
						"correct" => $data[2],
						"points" => $data[3],
					];
		
					$q->title = $data[0];
					$q->content_data = json_encode($qContentData);
					$q->settings_data = "";
					$q->category = !empty($data[4]) ? $data[4] : "MCQ";
					$q->explanation = !empty($data[5]) ? $data[5] : "";
					$q->created_at = \Carbon\Carbon::now();
					$q->updated_at = \Carbon\Carbon::now();
					$q->status = 'Active';
					$q->save();

					array_push($questionIds, $q->id);
				}

				fclose ( $handle );
			}

			$contentData = [
				'questions' => $questionIds,
			];
			$settingData = [
				'quiz_attempt' => !empty($request->quiz_attempt) ? intval($request->quiz_attempt) : 3,
				'active_timer' => !empty($request->active_timer) ? $request->active_timer : 0,
				'timer_time' => !empty($request->timer_time) ? $request->timer_time : 0,
				'allow_negative_mark' => !empty($request->allow_negative_mark) ? $request->allow_negative_mark : 0,
				'flat' => !empty($request->flat) ? $request->flat : 0,
				'negative_percentage' => !empty($request->negative_percentage) ? $request->negative_percentage : 0,
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
		}
		else 
		{
			return redirect()->back()->withErrors(ResponseMessage::createFailed(__("Quiz")));
		}
    }

}



