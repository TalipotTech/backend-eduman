<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * @OA\Get(
     *    path="/blogs/list",
     *    operationId="getBlogs",
     *    tags={"Blog"},
     *    summary="Get Blogs",
     *    description="Get Blogs",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getBlogs(Request $request)
    {
        $data = Blog::with('category')
            ->with('author')
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/blogs/by-category",
     *    operationId="getBlogsByCategory",
     *    tags={"Blog"},
     *    summary="Get Blogs & cats ids",
     *    description="Get Blogs & cats ids",
     *    @OA\Parameter(name="catId", in="query", description="catId", example="1", required=true,
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
    public function getBlogsByCategory(Request $request)
    {
        $data = Blog::with('category')
            ->with('author')
            ->where('category_id', [$request->catId])
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/blogs/{blog}/details",
     *    operationId="getBlogDetails",
     *    tags={"Blog"},
     *    summary="Get blog details",
     *    description="Get blog details",
     *    @OA\Parameter(name="blog", in="path", description="blog", example="1", required=true,
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
    public function getBlogDetails($blog, Request $request)
    {
        $singleBlog = Blog::where('id', $blog)
            ->with('category')
            ->with('author')
            ->first();
        
        return response()->json([
            'data' => $singleBlog,
            "id" => $blog
        ]);
    }

    /**
     * @OA\Get(
     *    path="/blogs/details",
     *    operationId="getBlogDetailsFromSlug",
     *    tags={"Blog"},
     *    summary="Get blog details",
     *    description="Get blog details", 
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
    public function getBlogDetailsFromSlug(Request $request)
    {
        $blog = Blog::with('category')
            ->with('author')
            ->where('slug', $request->slug)
            ->first();
        
        return response()->json([
            'data' => $blog,
        ]);
    }
}
