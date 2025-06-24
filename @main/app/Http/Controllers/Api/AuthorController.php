<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\CourseAuthor;
use App\Enums\AuthorCategoryEnum;
use App\Enums\StatusEnum;

class AuthorController extends Controller
{
    /**
     * @OA\Get(
     *    path="/author/instructors",
     *    operationId="getAuthors",
     *    tags={"Instructor"},
     *    summary="Get list of instructors",
     *    description="Get list of instructors",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getAuthors(Request $request)
    {
        $authors = Author::with('courses')
            ->where('category', AuthorCategoryEnum::INSTRUCTOR)
            ->where('status', StatusEnum::ACTIVE)
            ->get();
        
        return response()->json([
            'data' => $authors,
        ]); 
    }
    
    /**
     * @OA\Get(
     *    path="/author/{author}/courses",
     *    operationId="getCoursesFromAuthor",
     *    tags={"Instructor"},
     *    summary="Get list of Author Courses",
     *    description="Get list of Author Courses",
     *    @OA\Parameter(name="author", in="path", description="author", required=true,
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
    public function getCourses(Author $author, Request $request)
    {
        return response()->json([
            'data' => $author->courses,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/author/details",
     *    operationId="getInstructorFromSlug",
     *    tags={"Instructor"},
     *    summary="Get instructor details",
     *    description="Get instructor details", 
     *    @OA\Parameter(name="slug", in="query", description="slug", example="mahfuz-anam", required=true,
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
    public function getInstructorFromSlug(Request $request)
    {
        $author = Author::where('slug', [$request->slug])
            ->with([
                'courses' => [
                    'categories',
                    'authors',
                    'lessons',
                    'enrolUsers'
                ],
            ])
            ->first();

        return response()->json([
            'data' => $author,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/author/{author}/details",
     *    operationId="getAuthorDetails",
     *    tags={"Instructor"},
     *    summary="Get Author details",
     *    description="Get Author details",
     *    @OA\Parameter(name="author", in="path", description="author", required=true,
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
    public function getAuthorDetails($authorId, Request $request)
    {
        $authorData = Author::where("id", $authorId)
            ->with([
                'courses' => [
                    'categories',
                    'authors',
                    'lessons',
                    'enrolUsers'
                ],
            ])
                ->first();

        $authorData['totalEnrolled'] = CourseAuthor::where('author_id', $authorId)
            ->join('course_users','course_users.course_id','=','course_authors.course_id')
            ->count();
        
        return response()->json([
            'data' => $authorData,
            "id" => $authorId
        ]);
    }
}
