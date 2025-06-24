<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRoles;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnrollController extends Controller
{
    /**
     * @OA\Post(
     * path="/course/enroll/student",
     * summary="Post Student Course enroll",
     * description="Post Student Course enroll",
     * operationId="studentEnroll",
     * tags={"User"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"course_id"},
     *       @OA\Property(property="course_id", type="string", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function studentEnroll(Request $request)
    {
        if( !empty($request->user()->id) )
        {
            $courseId = $request->course_id;
            $course = Course::find($courseId);
            $user = $request->user();
      
            Invoice::create([
                'total_price' => $course->price,
                'course_id' => $course->id,
                'title' => $course->title,
                'qty' => $course->qty ?? 1,
                'unit_price' => $course->price,
            ]);

            CourseUser::create([
                'course_id' => $courseId,
                'user_id' => $user->id,
                'role' => UserRoles::STUDENT,
            ]);
        }
        else 
        {
            return response()->json([
                "success" => false,
            ]);
        }
    }
    
    /**
     * @OA\Post(
     * path="/course/enroll/instructor",
     * summary="Post Student Course enroll",
     * description="Post Student Course enroll",
     * operationId="instructorEnroll",
     * tags={"User"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"course_id"},
     *       @OA\Property(property="course_id", type="string", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function instructorEnroll(Request $request)
    {
        if( !empty($request->user()->id) )
        {
            $courseId = $request->course_id;
            $course = Course::find($courseId);
            $user = $request->user();

            CourseUser::create([
                'course_id' => $courseId,
                'user_id' => $user->id,
                'role' => UserRoles::INSTRUCTOR,
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
