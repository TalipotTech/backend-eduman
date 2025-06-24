<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends Controller
{
    /**
     * @OA\Get(
     *    path="/topics",
     *    operationId="getTopics",
     *    tags={"Topic"},
     *    summary="Get Topics",
     *    description="Get Topics",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getTopics(Request $request)
    {
        $data = Topic::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/topics/by-course",
     *    operationId="getTopicsFromCourse",
     *    tags={"Topic"},
     *    summary="Get Topics from course",
     *    description="Get Topics from course",
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
    public function getTopicsFromCourse(Request $request)
    {
        if( $request->courseId != null )
        {
            $data = Topic::where('course_id', $request->courseId)->get();
            return response()->json([
                'data' => $data,
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
     * @OA\Get(
     *    path="/topics/by-classroom",
     *    operationId="getTopicsFromClassroom",
     *    tags={"Topic"},
     *    summary="Get Topics from course",
     *    description="Get Topics from course",
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
    public function getTopicsFromClassroom(Request $request)
    {
        $data = Topic::where('course_id', $request->courseId)->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/topics/{topic}/details",
     *    operationId="getTopicDetails",
     *    tags={"Topic"},
     *    summary="Get a Topic details",
     *    description="Get a Topic details",
     *    @OA\Parameter(name="Topic", in="path", description="Topic", example="1", required=true,
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
    public function getTopicDetails(Topic $topic, Request $request)
    {
        return response()->json([
            'data' => $topic,
        ]);
    }
}
