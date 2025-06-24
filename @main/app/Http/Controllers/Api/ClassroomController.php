<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Topic;

class ClassroomController extends Controller
{
    /**
     * @OA\Get(
     *    path="/class",
     *    operationId="getClassrooms",
     *    tags={"Classroom"},
     *    summary="Get classrooms",
     *    description="Get classrooms",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getClassrooms(Request $request)
    {
        $data = Classroom::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/class/by-course",
     *    operationId="getClassroomFromCourse",
     *    tags={"Classroom"},
     *    summary="Get classroom from course",
     *    description="Get classroom from course",
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
    public function getClassroomFromCourse(Request $request)
    {
        $data = Classroom::where('course_id', $request->courseId)->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/class/{class}/details",
     *    operationId="getClassroomDetails",
     *    tags={"Classroom"},
     *    summary="Get a classroom details",
     *    description="Get a classroom details",
     *    @OA\Parameter(name="classroom", in="path", description="classroom", example="1", required=true,
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
    public function getClassroomDetails(Classroom $classroom, Request $request)
    {
        return response()->json([
            'data' => $classroom,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/class/details",
     *    operationId="getClassDetailsFromSlug",
     *    tags={"Classroom"},
     *    summary="Get class details",
     *    description="Get class details", 
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
    public function getClassDetailsFromSlug(Request $request)
    {
        $class = Classroom::where('slug', [$request->slug])
            ->first();

        $contentData = !empty($class->content_data) ? json_decode($class->content_data) : [];
        $lessons = array();
        if( !empty($contentData->lessons) ) 
        {
            foreach($contentData->lessons as $lessonId)
            {
                $lessonResult = Lesson::Find($lessonId);
                $topics = array();
                $lessonClassTest = "";
                $lessonContentData = !empty($lessonResult->content_data) ? json_decode($lessonResult->content_data) : [];
                // lesson content data json format
                if( !empty($lessonContentData->topics) ) 
                {
                    
                    foreach($lessonContentData->topics as $topicId)
                    {
                        $topicResult = Topic::Find($topicId);
                        array_push($topics, $topicResult);
                    }
                }
                // class test quiz
                if( !empty($lessonContentData->quiz) ) 
                {
                    $lessonClassTest = Quiz::Find($lessonContentData->quiz);
                }

                $lessonResult['topics'] = $topics;
                $lessonResult['class_test'] = $lessonClassTest;
                array_push($lessons, $lessonResult);
            }
        }

        $quizResult = "";
        if( !empty($contentData->quiz) ) 
        {
            $quizResult = Quiz::Find($contentData->quiz);
        }

        $class['lessons'] = $lessons;
        $class['quiz'] = $quizResult;
        
        return response()->json([
            'data' => $class,
        ]);
    }
}
