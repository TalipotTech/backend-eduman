<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseReview;

class CourseReviewController extends Controller
{
    /**
     * @OA\Get(
     *    path="/courses/reviews",
     *    operationId="getReviewFromCourse",
     *    tags={"Review"},
     *    summary="Get reviews from course",
     *    description="Get reviews from course",
     *    @OA\Parameter(name="courseId", in="query", description="courseId", example="1", required=true,
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
    public function getReviewFromCourse(Request $request)
    {
        $reviews = CourseReview::where('course_id', $request->courseId)
            ->with('student')
            ->get();
        return response()->json([
            'data' => $reviews,
        ]);
    }

    /**
     * @OA\Post(
     * path="/course/review/create",
     * summary="Create course review",
     * description="Create course review",
     * operationId="createReview",
     * tags={"Review"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Course review",
     *    @OA\JsonContent(
     *       required={"courseId","rating","message"},
     *       @OA\Property(property="courseId", type="string", example="1"),
     *       @OA\Property(property="rating", type="string", example="5"),
     *       @OA\Property(property="message", type="string", example="Good Course"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Error response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, Can't create")
     *        )
     *     )
     * )
     */
    public function createReview(Request $request)
    {
        if( !empty($request->user()->id) )
        {
            CourseReview::create([
                'rating' => $request->rating,
                'message' => $request->message,
                'course_id' => $request->courseId,
                'user_id' => $request->user()->id,
            ]);

            return response()->json([
                'success' => true,
            ]);
        }
        else 
        {
            return response()->json([
                "success" => false,
            ]);
        }
    }

}
