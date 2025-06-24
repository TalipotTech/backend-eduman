<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Question;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * @OA\Get(
     *    path="/result",
     *    operationId="getResult",
     *    tags={"Quiz Result"},
     *    summary="Get quiz results",
     *    description="Get quiz results",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getResult(Request $request)
    {
        $data = QuizResult::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/result/{result}/details",
     *    operationId="getResultDetails",
     *    tags={"Quiz Result"},
     *    summary="Get a quiz result details",
     *    description="Get a quiz result details",
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
     *    path="/result/user-exam",
     *    operationId="getResultDetailsFromSlug",
     *    tags={"Quiz Result"},
     *    summary="Get quiz result details",
     *    description="Get quiz result details", 
     *    @OA\Parameter(name="user_id", in="query", description="user_id", example="1", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Parameter(name="qid", in="query", description="qid", example="1", required=true,
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
    public function getResultDetailsFromSlug(Request $request)
    {
        $result = QuizResult::orderBy("id", "DESC")
            ->with('course')
            ->where('quiz_id', $request->qid)
            ->where('user_id', $request->user_id)
            ->first();

        $totalTimes = QuizResult::where('quiz_id', $request->qid)
            ->where('user_id', $request->user_id)
            ->count();

        $quiz = Quiz::find($result->quiz_id);
        $quizSetting = !empty($quiz->settings_data) ? json_decode($quiz->settings_data) : '';
        $quizContentData = !empty($quiz->content_data) ? json_decode($quiz->content_data) : [];
        $quizQuestions = array();

        if( !empty($quizContentData->questions) ) 
        {
            foreach($quizContentData->questions as $qId)
            {
                $qq = Question::Find($qId);
                if( $qq->category != 'Header' )
                {
                    array_push($quizQuestions, $qId);
                }
            }
        }

        $contentData = !empty($result->content_data) ? json_decode($result->content_data) : [];
        $questions = array();
        $questionIds = array();
        $correctAnswersCount = 0;
        $wrongAnswersCount = 0;
        $notAnswersCount = 0;
        $negativePoint = 0;
        if( !empty($contentData->questions) ) 
        {
            foreach($contentData->questions as $question)
            {
                $qResult = Question::Find($question->q);
                $qqContentData = !empty($qResult->content_data) ? json_decode($qResult->content_data) : '';
                $qResult['user_correct'] = !empty($question->correct) ? $question->correct : 0;
                $qResult['user_answer'] = !empty($question->answer) ? $question->answer : "";
                array_push($questions, $qResult);
                array_push($questionIds, $question->q);

                if( empty($question->answer) )
                {
                    $notAnswersCount++;
                }
                elseif( !empty($question->answer) && $question->correct == 1 )
                {
                    $correctAnswersCount++;
                }
                elseif( !empty($question->answer) && $question->correct == 0 )
                {
                    $wrongAnswersCount++;
                    $negativePoint = $negativePoint + intval($qqContentData->points);
                }

            }
        }

        $notAnswerQIds = array_diff($quizQuestions, $questionIds);
        if( !empty($notAnswerQIds) ) 
        {
            foreach($notAnswerQIds as $qId)
            {
                $qResult = Question::Find($qId);
                $qqContentData = !empty($qResult->content_data) ? json_decode($qResult->content_data) : '';
                $qResult['user_correct'] = 0;
                $qResult['user_answer'] = !empty($question->answer) ? $question->answer : "";
                array_push($questions, $qResult);
            }
        }
        // calculate negative marks
        $totalNegativeScore = 0;
        if( $quizSetting->flat == 0 )
        {
            $totalNegativeScore = round((intval($quizSetting->negative_percentage)/100)*$negativePoint, 2);
        }
        else 
        {
            $totalNegativeScore = $negativePoint;
        }

        $earned_score = $contentData->earned_score - $totalNegativeScore;
        $score_percentage =  ceil(($earned_score*100)/$contentData->total_score);
        
        $result['negative_points'] = $negativePoint;
        $result['total_negative_score'] = $totalNegativeScore;
        $result['score_percentage'] = $score_percentage;
        $result['earned_score'] = $earned_score;
        $result['correct_number'] = $correctAnswersCount;
        $result['wrong_number'] = $wrongAnswersCount;
        $result['not_answers_number'] = count($notAnswerQIds);
        $result['take_time'] = ( (int)$quizSetting->timer_time*60 - (int)$contentData->examTime);
        $result['questions'] = $questions;
        
        return response()->json([
            'data' => $result,
            'total_taken' => $totalTimes,
        ]);
    }

    /**
     * @OA\Post(
     * path="/result/quiz-submit",
     * summary="Quiz Result",
     * description="Quiz Result",
     * operationId="saveQuizResult",
     * tags={"Quiz Result"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Order and Register user",
     *    @OA\JsonContent(
     *       required={"quiz_id","mcq_question"},
     *       @OA\Property(property="user_id", type="integer", example="1"),
     *       @OA\Property(property="course_id", type="integer", example="1"),
     *       @OA\Property(property="quiz_id", type="integer", example="1"),
     *       @OA\Property(property="mcq_question", type="string", example="9~=~B. Anticipate… ensure~,~9~=~C. Sustain… question~,~7~=~C. 10~,~10~=~A. "),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Error response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="No quiz")
     *        )
     *     )
     * )
     */
    public function saveQuizResult(Request $request)
    {
        if( $request->user_id )
        {
            $user = User::find($request->user_id);
            // mcq questions answers
            if( !empty($request->mcq_question) ) {
                $mcqs = json_decode($request->mcq_question);
                $mcqs = $this->getMcqResult($mcqs);
            }
            
            $mcqResults = !empty($mcqs['mcqResults']) ? $mcqs['mcqResults'] : [];
            $mcqEarned = !empty($mcqs['mcqEarned']) ? $mcqs['mcqEarned'] : 0;

            $earnedPoints = $mcqEarned;
            $questionResult = array_merge($mcqResults);

            // Calculate results
            $quiz = Quiz::find($request->quiz_id);
            $questionData = json_decode($quiz->content_data);

            $totalPoints = 1;
            if( !empty($questionData->questions) )
            {
                foreach($questionData->questions as $qQId)
                {
                    $question = Question::find($qQId);
                    $qData = json_decode($question->content_data);
                    $totalPoints = $totalPoints + intval($qData->points);
                }
                $totalPoints = $totalPoints - 1;
            }

            $score_percentage = round( ($earnedPoints*100)/$totalPoints );

            $contentData = [
                'examTime' => $request->exam_time,
                'userId' => $request->user_id,
                'courseId' => $request->course_id,
                'quizId' => $request->quiz_id,
                'questions' => $questionResult,
                'passed' => ($score_percentage >= 60) ? 1 : 0,
                'score_percentage' => $score_percentage,
                'earned_score' => $earnedPoints,
                'total_score' => $totalPoints
            ];
         
            $result = QuizResult::create([
                "user_id" => $request->user_id,
                'course_id' => $request->course_id,
                'quiz_id' => $request->quiz_id,
                'content_data' => json_encode($contentData),
                'settings_data' => ""
            ]);
    
            return response()->json([
                'data' => [
                    'result' => $result,
                    'quiz' => $quiz,
                    'user' => $user,
                ],
            ]);
        }
        else 
        {
            return response()->json([
                "success" => false,
            ]);
        }
    }

    // Get mcq results
    private function getMcqResult($mcqAnswers)
    {
        $questionResult = array();
        $earnedPoints = 0;
        
        if($mcqAnswers) 
        {
            $studentAnswers = array();
            if( !empty($mcqAnswers) )
            {
                foreach( $mcqAnswers as $answerArray)
                {
                    $qNoAns = explode('~=~', $answerArray);
                    $qId = !empty($qNoAns[0]) ? $qNoAns[0] : 0;
                    $answer = !empty($qNoAns[1]) ? $qNoAns[1] : "";
                    $studentAnswers[$qId] = $answer;
                }
            }

            foreach($studentAnswers as $qId => $sAnswer)
            {
                $correct = 0;
                $question = Question::find($qId);
                $qData = json_decode($question->content_data);
                if($qData->correct == $sAnswer)
                {
                    $earnedPoints = $earnedPoints + $qData->points;
                    $correct = 1;
                }

                $resultQ = array(
                    "q" => $qId,
                    "correct" => $correct,
                    "answer" => $sAnswer,
                );
                array_push($questionResult, $resultQ);
            }
        }
        
        return [
            'mcqResults' => $questionResult,
            'mcqEarned' => $earnedPoints,
        ];
    }
}
