<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Question;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * @OA\Get(
     *    path="/quiz",
     *    operationId="getQuizzes",
     *    tags={"Quiz"},
     *    summary="Get quizzes",
     *    description="Get quizzes",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getQuizzes(Request $request)
    {
        $data = Quiz::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/quiz/{quiz}/details",
     *    operationId="getQuizDetails",
     *    tags={"Quiz"},
     *    summary="Get a quiz details",
     *    description="Get a quiz details",
     *    @OA\Parameter(name="quiz", in="path", description="quiz", example="1", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getQuizDetails(Quiz $quiz, Request $request)
    {
        return response()->json([
            'data' => $quiz,
        ]);
    }

       /**
     * @OA\Get(
     *    path="/quiz/details",
     *    operationId="getQuizDetailsFromSlug",
     *    tags={"Quiz"},
     *    summary="Get quiz details",
     *    description="Get quiz details", 
     *    @OA\Parameter(name="slug", in="query", description="slug", example="hello-world", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getQuizDetailsFromSlug(Request $request)
    {
        $quiz = Quiz::where('slug', [$request->slug])
            ->first();

        $contentData = !empty($quiz->content_data) ? json_decode($quiz->content_data) : [];
        $questions = array();
        if( !empty($contentData->questions) ) 
        {
            foreach($contentData->questions as $qId)
            {
                $qResult = Question::Find($qId);
                array_push($questions, $qResult);
            }
        }

        $settingData = !empty($quiz->settings_data) ? json_decode($quiz->settings_data) : '';
    
        $quiz['questions'] = $questions;
        $quiz['setting_data'] = $settingData;

        $resultCount = QuizResult::orderBy("id", "DESC")
            ->where('quiz_id', $quiz->id)
            ->count();
        $quiz['taken_quiz'] = $resultCount;
        
        return response()->json([
            'data' => $quiz,
        ]);
    }
}
