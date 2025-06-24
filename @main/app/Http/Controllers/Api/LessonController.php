<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonController extends Controller
{
    /**
     * @OA\Get(
     *    path="/lessons",
     *    operationId="getLessons",
     *    tags={"Lesson"},
     *    summary="Get lesson",
     *    description="Get lesson",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getLessons(Request $request)
    {
        $data = Lesson::where('status', 'Active')
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/lessons/by-course",
     *    operationId="getLessonsFromCourse",
     *    tags={"Lesson"},
     *    summary="Get lesson from course",
     *    description="Get lesson from course",
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
    public function getLessonsFromCourse(Request $request)
    {
        $data = Lesson::where('course_id', $request->courseId)
            ->where('status', 'Active')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/lessons/by-classroom",
     *    operationId="getLessonsFromClassroom",
     *    tags={"Lesson"},
     *    summary="Get lesson from course",
     *    description="Get lesson from course",
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
    public function getLessonsFromClassroom(Request $request)
    {
        $data = Lesson::where('course_id', $request->courseId)
            ->where('status', 'Active')
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/lessons/{lesson}/details",
     *    operationId="getLessonDetails",
     *    tags={"Lesson"},
     *    summary="Get a lesson details",
     *    description="Get a lesson details",
     *    @OA\Parameter(name="lesson", in="path", description="lesson", example="1", required=true,
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
    public function getLessonDetails(Lesson $lesson, Request $request)
    {
        return response()->json([
            'data' => $lesson,
        ]);
    }
}
