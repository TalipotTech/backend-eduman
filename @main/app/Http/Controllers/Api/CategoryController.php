<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseCategory;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *    path="/categories/type",
     *    operationId="getCategoryByTypes",
     *    tags={"Category"},
     *    summary="Get list of Categories",
     *    description="Get list of Categories",
     *    @OA\Parameter(name="type", in="query", description="type", required=true,
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
    public function getCategoryByTypes(Request $request)
    {
        $data = Category::where('type', $request->type)->select("id", "slug", "title")->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/categories/{category}/chields",
     *    operationId="getCategoryChields",
     *    tags={"Category"},
     *    summary="Get a category",
     *    description="Get a category",
     *    @OA\Parameter(name="category", in="path", description="category", example="1", required=true,
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
    public function getCategoryChields(Category $category, Request $request)
    {
        return response()->json([
            'data' => $category->CategoryChields,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/categories/courses",
     *    operationId="getCoursesFromCategory",
     *    tags={"Category"},
     *    summary="Get courses from Cat",
     *    description="Get courses from Cat",
     *    @OA\Parameter(name="slug", in="query", description="slug", example="development", required=true,
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
    public function getCoursesFromCategory(Request $request)
    {
        $cat = Category::where('slug', $request->slug)
            ->where('type', 'Course')
            ->first();
        $catId = $cat->id;
        $courses = Course::whereHas('categories', function($q) use($catId) {
            $q->where('category_id', $catId);
        })
            ->get();
        
        return response()->json([
            'data' => $courses,
            'category_id' => $catId
        ]);
    }
}
