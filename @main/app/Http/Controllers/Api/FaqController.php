<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\FaqCategoryEnum;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * @OA\Get(
     *    path="/faqs",
     *    operationId="getFaqs",
     *    tags={"FAQ"},
     *    summary="Get faq",
     *    description="Get faq",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getFaqs(Request $request)
    {
        $studentFaqs = Faq::where('category', FaqCategoryEnum::STUDENT)
            ->get();
        $instructorFaqs = Faq::where('category', FaqCategoryEnum::INSTRUCTOR)
            ->get();
        return response()->json([
            'data' => $studentFaqs,
            'dataInstructor' => $instructorFaqs,
        ]);
    }

   

    /**
     * @OA\Get(
     *    path="/faqs/{faq}/details",
     *    operationId="getFaqDetails",
     *    tags={"FAQ"},
     *    summary="Get a faq details",
     *    description="Get a faq details",
     *    @OA\Parameter(name="faq", in="path", description="faq", example="1", required=true,
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
    public function getFaqDetails(Faq $faq, Request $request)
    {
        return response()->json([
            'data' => $faq,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/faqs/details",
     *    operationId="getFaqDetailsFromSlug",
     *    tags={"FAQ"},
     *    summary="Get faq details",
     *    description="Get faq details", 
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
    public function getFaqDetailsFromSlug(Request $request)
    {
        $faqs = Faq::where('slug', [$request->slug])
            ->where('category', FaqCategoryEnum::STUDENT)
            ->first();
        
        return response()->json([
            'data' => $faqs,
        ]);
    }
}
