<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * @OA\Get(
     *    path="/questions",
     *    operationId="getQuestions",
     *    tags={"Question"},
     *    summary="Get Questions",
     *    description="Get Questions",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getQuestions(Request $request)
    {
        $data = Question::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/questions/{question}/details",
     *    operationId="getQuestionDetails",
     *    tags={"Question"},
     *    summary="Get a Question details",
     *    description="Get a Question details",
     *    @OA\Parameter(name="question", in="path", description="question", example="1", required=true,
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
    public function getQuestionDetails(Question $Question, Request $request)
    {
        return response()->json([
            'data' => $Question,
        ]);
    }
}
