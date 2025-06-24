<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PageController extends Controller
{
    /**
     * @OA\Get(
     *    path="/page",
     *    operationId="getPages",
     *    tags={"Page"},
     *    summary="Get pages",
     *    description="Get pages",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getPages(Request $request)
    {
        $data = Page::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/page/details",
     *    operationId="getPageDetailsFromSlug",
     *    tags={"Page"},
     *    summary="Get page details",
     *    description="Get page details", 
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
    public function getPageDetailsFromSlug(Request $request)
    {
        $event = Page::where('slug', [$request->slug])
            ->first();
        return response()->json([
            'data' => $event,
        ]);
    }
}
