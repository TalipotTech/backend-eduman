<?php

namespace App\Http\Controllers\Api\PageSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomepageTwoInfoController extends Controller
{
    /**
     * @OA\Get(
     *    path="/setting/home-02/header",
     *    operationId="getHomeTwoHeader",
     *    tags={"Page Setting - HomeTwo"},
     *    summary="Get header settting",
     *    description="Get header settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeTwoHeader(Request $request)
    {
        $header_info = getKeyValueArray([
            "home_02_header_title",
            "home_02_header_search_placeholder",
            "home_02_header_left_image",
            "home_02_header_left_badge_image",
            "home_02_header_left_badge_text",
            "home_02_header_right_floating_image",
            "home_02_header_right_floating_text",
            "home_02_header_features",
        ]);

        return response()->json([
            "data" => $header_info
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-02/stats",
     *    operationId="getHomeTwoStats",
     *    tags={"Page Setting - HomeTwo"},
     *    summary="Get stats settting",
     *    description="Get stats settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeTwoStats(Request $request)
    {
        $header_info = getKeyValueArray([
            "home_02_stats_images",
            "home_02_stats_counts",
            "home_02_stats_texts",
        ]);

        $format_from_to = [
            "home_02_stats_images" => "image",
            "home_02_stats_counts" => "title",
            "home_02_stats_texts" => "subtitle",
        ];

        $formatted_data = $this->formatRepeater($header_info, $format_from_to);

        return response()->json([
            "data" => $formatted_data
        ]);
    }

        /**
     * @OA\Get(
     *    path="/setting/home-02/partners",
     *    operationId="getHomeTwoPartners",
     *    tags={"Page Setting - HomeTwo"},
     *    summary="Get partners settting",
     *    description="Get partners settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeTwoPartners(Request $request)
    {
        $header_info = getKeyValueArray([
            "home_02_partner_section_title",
            "home_02_partner_section_description",
            "home_02_partner_section_desc_more",
            "home_02_partner_section_img",
        ]);
        
        $repeated_header_info = getKeyValueArray([
            "home_02_partner_logo_images",
        ]);

        $format_from_to = [
            "home_02_partner_logo_images" => "image",
        ];

        $formatted_data = $this->formatRepeater($repeated_header_info, $format_from_to);
        $header_info["partners"] = $formatted_data;

        return response()->json([
            "data" => $header_info
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-02/cta-01",
     *    operationId="getHomeTwoCtaOne",
     *    tags={"Page Setting - HomeTwo"},
     *    summary="Get cta-01 settting",
     *    description="Get cta-01 settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeTwoCtaOne(Request $request)
    {
        $ctaOne = getKeyValueArray([
            "home_02_cta_01_title",
            "home_02_cta_01_description",
            "home_02_cta_01_image",
            "home_02_cta_01_features",
            "home_02_cta_01_btn_text",
            "home_02_cta_01_btn_url",
        ]);
        
        return response()->json([
            "data" => $ctaOne
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-02/categories",
     *    operationId="getHomeTwoCategories",
     *    tags={"Page Setting - HomeTwo"},
     *    summary="Get categories settting",
     *    description="Get categories settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeTwoCategories(Request $request)
    {
        $categories = getKeyValueArray([
            "home_02_categories_section_title",
            "home_02_categories_title",
            "home_02_categories_subtitle",
            "home_02_categories_url",
            "home_02_categories_image",
        ]);

        $format_from_to = [
            "home_02_categories_title" => "title",
            "home_02_categories_subtitle" => "subtitle",
            "home_02_categories_url" => "url",
            "home_02_categories_image" => "image",
        ];

        $formatted_data = [
            "title" => $categories["home_02_categories_section_title"],
            "items" => $this->formatRepeater($categories, $format_from_to)
        ];

        return response()->json([
            "data" => $formatted_data
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-02/course",
     *    operationId="getHomeTwoCourse",
     *    tags={"Page Setting - HomeTwo"},
     *    summary="Get course settting",
     *    description="Get course settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeTwoCourse(Request $request)
    {
        $all_course = getKeyValueArray([
            "home_02_course_section_title",
        ]);

        return response()->json([
            "data" => $all_course
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-02/features",
     *    operationId="getHomeTwoFeatures",
     *    tags={"Page Setting - HomeTwo"},
     *    summary="Get features settting",
     *    description="Get features settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeTwoFeatures(Request $request)
    {
        $all_features = getKeyValueArray([
            "home_02_feature_items_title",
            "home_02_feature_items_image",
        ]);

        $format_from_to = [
            "home_02_feature_items_title" => "title",
            "home_02_feature_items_image" => "image",
        ];

        $formatted_data = $this->formatRepeater($all_features, $format_from_to);

        return response()->json([
            "data" => $formatted_data
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-02/cta-02",
     *    operationId="getHomeTwoCtaTwo",
     *    tags={"Page Setting - HomeTwo"},
     *    summary="Get cta-02 settting",
     *    description="Get cta-02 settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeTwoCtaTwo(Request $request)
    {
        $ctaTwo = getKeyValueArray([
            "home_02_cta_02_title",
            "home_02_cta_02_subtitle",
            "home_02_cta_02_btn_text",
            "home_02_cta_02_btn_url",
            "home_02_cta_02_img_01",
            "home_02_cta_02_img_02",
        ]);

        return response()->json([
            "data" => $ctaTwo
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-02/cta-03",
     *    operationId="getHomeTwoCtaThree",
     *    tags={"Page Setting - HomeTwo"},
     *    summary="Get cta-03 settting",
     *    description="Get cta-03 settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeTwoCtaThree(Request $request)
    {
        $ctaThree = getKeyValueArray([
            "home_02_cta_03_title",
            "home_02_cta_03_subtitle",
            "home_02_cta_03_btn_text",
            "home_02_cta_03_btn_url",
            "home_02_cta_03_img_01",
            "home_02_cta_03_img_02",
        ]);

        return response()->json([
            "data" => $ctaThree
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-02/cta-04",
     *    operationId="getHomeTwoCtaFour",
     *    tags={"Page Setting - HomeTwo"},
     *    summary="Get cta-04 settting",
     *    description="Get cta-04 settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeTwoCtaFour(Request $request)
    {
        $ctaThree = getKeyValueArray([
            "home_02_cta_04_subtitle",
            "home_02_cta_04_title",
            "home_02_cta_04_btn_text",
            "home_02_cta_04_btn_url",
            "home_02_cta_04_img",
            "home_02_cta_04_badge_text",
        ]);

        return response()->json([
            "data" => $ctaThree
        ]);
    }

    /**
     * format repeater data based on the given format
     * @param array $raw_data Key-value array
     * @param array $format_from_to Array of format to take `from` $raw_data and store `to` returning array
     * @return array Formatted array of repeater data
     */
    private function formatRepeater($raw_data, $format_from_to)
    {
        // extract data
        $extracted_data = [];
        foreach ($format_from_to as $key => $save_key) {
            $extracted_data[$save_key] = !empty($raw_data[$key]) ? json_decode($raw_data[$key]) : [];
        }

        // format data
        $formatted_data = [];
        foreach ($extracted_data as $item_key => $values_array) {
            foreach ($values_array as $index => $value) {
                $formatted_data[$index][$item_key] = $value;
            }
        }

        return $formatted_data;
    }
}
