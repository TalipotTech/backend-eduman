<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Enums\StatusEnum;
use App\Models\Lesson;

class CourseController extends Controller
{
    /**
     * @OA\Get(
     *    path="/courses/all",
     *    operationId="getCourses",
     *    tags={"Course"},
     *    summary="Get courses",
     *    description="Get courses",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getCourses(Request $request)
    {
        $courses = Course::with([
            'categories', 
            'authors', 
            'lessons', 
            'wishlist' => function($query) {
                $query->select(['user_id', 'course_id']);
            }
        ])
            ->where('status', StatusEnum::ACTIVE)
            ->get();

        $wishArray = array();
        foreach($courses as $course)
        {   
            if( !empty($course->wishlist) )
            {
                foreach($course->wishlist as $wishlist)
                {
                    $wishArray[$wishlist->course_id][] = $wishlist->user_id;
                }
            }
        }

        return response()->json([
            'data' => $courses,
            'wishlistArray' => $wishArray,
        ]);
    }


/**
     * @OA\Get(
     *    path="/courses/top6",
     *    operationId="getCourses",
     *    tags={"Course"},
     *    summary="Get Top 6 courses",
     *    description="Get Top 6 courses",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getTop6Courses(Request $request)
    {
        $courses = Course::with([
            'categories', 
            'authors', 
            'lessons', 
            'wishlist' => function($query) {
                $query->select(['user_id', 'course_id']);
            }
        ])
            ->where('status', StatusEnum::ACTIVE)
            ->take(8)
            ->get();

        $wishArray = array();
        foreach($courses as $course)
        {   
            if( !empty($course->wishlist) )
            {
                foreach($course->wishlist as $wishlist)
                {
                    $wishArray[$wishlist->course_id][] = $wishlist->user_id;
                }
            }
        }

        return response()->json([
            'data' => $courses,
            'wishlistArray' => $wishArray,
        ]);
    }


    /**
     * @OA\Get(
     *    path="/courses/tabs-courses-and-categories",
     *    operationId="getTabsCourses",
     *    tags={"Course"},
     *    summary="Get courses",
     *    description="Get courses",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getTabsCourses(Request $request)
    {
        $queryCourses = Course::with(['categories', 'authors', 'lessons'])
            ->where('status', StatusEnum::ACTIVE)
            ->get();

        $categories = array();
        $courses = array();

        foreach($queryCourses as $course) 
        {
            if( !empty($course->categories) ) 
            {
                foreach($course->categories as $cat) 
                {
                    if( !in_array($cat->title, $categories) )
                    {
                        $categories[$cat->id] = $cat->title;
                    }
                    $courses[$cat->title][] = $course;
                }
            }
        }

        sort($categories);

        $lessonsCount = Lesson::count();
        
        return response()->json([
            'data' => [
                'courses' => $courses,
                'cats' => $categories,
                'lessons' => $lessonsCount,
            ] 
        ]);
    }

    /**
     * @OA\Get(
     *    path="/courses/{course}/categories",
     *    operationId="getCategory",
     *    tags={"Course"},
     *    summary="Get course categories",
     *    description="Get course categories",
     *    @OA\Parameter(name="course", in="path", description="course", example="1", required=true,
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
    public function getCategory(Request $request, Course $course)
    {
        return response()->json([
            'data' => $course->categories,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/courses/{course}/students",
     *    operationId="getCourseStudents",
     *    tags={"Course"},
     *    summary="Get course students",
     *    description="Get course students",
     *    @OA\Parameter(name="course", in="path", description="course", example="1", required=true,
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
    public function getCourseStudents(Course $course, Request $request)
    {
        return response()->json([
            'data' => $course->users,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/courses/{course}/instructors",
     *    operationId="getInstructors",
     *    tags={"Course"},
     *    summary="Get course students",
     *    description="Get course students",
     *    @OA\Parameter(name="course", in="path", description="course", example="1", required=true,
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
    public function getInstructors(Course $course, Request $request)
    {
        return response()->json([
            'data' => $course->authors,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/courses/{course}/classroom",
     *    operationId="getClassroom",
     *    tags={"Course"},
     *    summary="Get classroom of course",
     *    description="Get classroom of course",
     *    @OA\Parameter(name="course", in="path", description="course", example="1", required=true,
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
    public function getClassroom(Request $request, Course $course)
    {
        return response()->json([
            'data' => $course->classrooms,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/courses/details",
     *    operationId="getCourseDetailsFromSlug",
     *    tags={"Course"},
     *    summary="Get course details",
     *    description="Get course details", 
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
    public function getCourseDetailsFromSlug(Request $request)
    {
        $course = Course::with('categories')
            ->with('authors')
            ->with('lessons')
            ->with('enrolUsers')
            ->with('classrooms')
            ->where('slug', $request->slug)
            ->first();
        
        return response()->json([
            'data' => $course,
        ]);
    }

    /**
     * @OA\Post(
     * path="/courses/search",
     * summary="Get courses from search",
     * description="Get courses from search",
     * operationId="getSearchCourses",
     * tags={"Course"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Get courses from search",
     *    @OA\JsonContent(
     *       required={""},
     *       @OA\Property(property="keyword", type="string", example="Hello"),
     *       @OA\Property(property="rating", type="string", example="5"),
     *       @OA\Property(property="price", type="string", example="free"),
     *       @OA\Property(property="cats", type="string", example="10235"),
     * 
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Error response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, no results")
     *        )
     *     )
     * )
     */
    public function getSearchCourses(Request $request)
    {
        $search = $request->input('search');
        $rating = $request->input('rating');
        $cats = json_decode($request->input('cats'));
        $price = $request->input('price');

        $courses = Course::with(['review_rating', 'search_category', 'categories', 'authors', 'lessons', 'wishlist'])
            ->where(function ( $query ) use( $search, $rating, $cats, $price ) {
                if( $search != NULL )
                    $query->where('title', 'like', "%{$search}%");
                if( $rating != NULL )
                    $query->whereHas('review_rating', function($q) use($rating) {
                        $q->where('rating', '>=', $rating);
                    });
                if( $price != NULL && $price != 'free' )
                    $query->whereNotNull('price');
                if( $cats != NULL )
                    $query->whereHas('search_category', function($sQuery) use($cats) {
                        $sQuery->whereIn('category_id', $cats);
                    });
            })
            ->where('status', StatusEnum::ACTIVE)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'data' => $courses,
            'search' => $search,
            'rating' => $rating,
            'cats' => $cats,
            'price' => $price
        ]);
    }

    
}
