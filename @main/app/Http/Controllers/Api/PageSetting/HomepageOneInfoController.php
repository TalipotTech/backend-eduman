<?php

namespace App\Http\Controllers\Api\PageSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomepageOneInfoController extends Controller
{
    /**
     * @OA\Get(
     *    path="/setting/home-01/header",
     *    operationId="getHomeOneHeader",
     *    tags={"Page Setting - HomeOne"},
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
    public function getHomeOneHeader(Request $request)
    {
        $all_header = getKeyValueArray([
            "home_01_header_title",
            "home_01_header_subtitle",
            "home_01_header_description",
            "home_01_header_btn_text",
            "home_01_header_btn_url",
            "home_01_header_hero_img",
            "home_01_header_card_1_text",
            "home_01_header_card_2_img",
            "home_01_header_card_2_text",
        ]);

        return response()->json([
            "data" => $all_header
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-01/categories",
     *    operationId="getHomeOneCategories",
     *    tags={"Page Setting - HomeOne"},
     *    summary="Get category settting",
     *    description="Get category settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeOneCategories(Request $request)
    {
        $all_categories = getKeyValueArray([
            "home_01_category_section_title", 
            "home_01_category_items_title",
            "home_01_category_items_slug",
            "home_01_category_items_description",
            "home_01_category_items_img",
        ]);

        $format_from_to = [
            "home_01_category_items_title" => "title",
            "home_01_category_items_slug" => "slug",
            "home_01_category_items_description" => "description",
            "home_01_category_items_img" => "image",
        ];

        $formatted_data = [
            "title" => $all_categories["home_01_category_section_title"] ?? "",
            "items" => $this->formatRepeater($all_categories, $format_from_to)
        ];

        return response()->json([
            "data" => $formatted_data
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-01/course",
     *    operationId="getHomeOneCourse",
     *    tags={"Page Setting - HomeOne"},
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
    public function getHomeOneCourse(Request $request)
    {
        $all_course = getKeyValueArray([
            "home_01_course_section_title",
        ]);

        return response()->json([
            "data" => $all_course
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-01/features",
     *    operationId="getHomeOneFeatures",
     *    tags={"Page Setting - HomeOne"},
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
    public function getHomeOneFeatures(Request $request)
    {
        $all_features = getKeyValueArray([
            "home_01_feature_items_title",
            "home_01_feature_items_image",
            "home_01_feature_items_details",
        ]);

        $format_from_to = [
            "home_01_feature_items_title" => "title",
            "home_01_feature_items_image" => "image",
            "home_01_feature_items_details" => "description",
        ];

        $formatted_data = $this->formatRepeater($all_features, $format_from_to);
        return response()->json([
            "data" => $formatted_data
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-01/about-us",
     *    operationId="getHomeOneAbout",
     *    tags={"Page Setting - HomeOne"},
     *    summary="Get about-us settting",
     *    description="Get about-us settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeOneAbout(Request $request)
    {
        $all_about = getKeyValueArray([
            "home_01_about_us_title",
            "home_01_about_us_description",
            "home_01_about_us_items",
            "home_01_about_us_btn_text",
            "home_01_about_us_btn_url",
            "home_01_about_us_section_image",
        ]);

        return response()->json([
            "data" => $all_about
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-01/testimonial",
     *    operationId="getHomeOneTestimonial",
     *    tags={"Page Setting - HomeOne"},
     *    summary="Get testimonial settting",
     *    description="Get testimonial settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeOneTestimonial(Request $request)
    {
        $all_testimonial = getKeyValueArray([
            "home_01_section_title",
        ]);

        $reapeter_testimonial_info = getKeyValueArray([
            "home_01_testimonial_title",
            "home_01_testimonial_message",
            "home_01_testimonial_rating",
            "home_01_testimonial_name",
            "home_01_testimonial_designation",
            "home_01_testimonial_profile_img",
        ]);
        $format_from_to = [
            "home_01_testimonial_title" => "title",
            "home_01_testimonial_message" => "message",
            "home_01_testimonial_rating" => "rating",
            "home_01_testimonial_name" => "name",
            "home_01_testimonial_designation" => "designation",
            "home_01_testimonial_profile_img" => "profile_img",
        ];
        $formatted_data = $this->formatRepeater($reapeter_testimonial_info, $format_from_to);
        $all_testimonial["testimonials"] = $formatted_data;
        return response()->json([
            "data" => $all_testimonial
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-01/cta-01",
     *    operationId="getHomeOneCtaOne",
     *    tags={"Page Setting - HomeOne"},
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
    public function getHomeOneCtaOne(Request $request)
    {
        $all_cta_one = getKeyValueArray([
            "home_01_cta_01_subtitle",
            "home_01_cta_01_title",
            "home_01_cta_01_image",
            "home_01_cta_01_btn_text",
            "home_01_cta_01_btn_url",
        ]);

        $format_from_to = [
            "home_01_cta_01_subtitle" => "subtitle",
            "home_01_cta_01_title" => "title",
            "home_01_cta_01_image" => "image",
            "home_01_cta_01_btn_text" => "btn_text",
            "home_01_cta_01_btn_url" => "btn_url",
        ];

        $formatted_data = $this->formatRepeater($all_cta_one, $format_from_to);
        return response()->json([
            "data" => $formatted_data
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-01/cta-02",
     *    operationId="getHomeOneCtaTwo",
     *    tags={"Page Setting - HomeOne"},
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
    public function getHomeOneCtaTwo(Request $request)
    {
        $all_cta_two = getKeyValueArray([
            "home_01_cta_02_title",
            "home_01_cta_02_description",
            "home_01_cta_02_image",
            "home_01_cta_02_btn_text",
            "home_01_cta_02_btn_url",
        ]);

        return response()->json([
            "data" => $all_cta_two
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-01/brand",
     *    operationId="getHomeOneBrand",
     *    tags={"Page Setting - HomeOne"},
     *    summary="Get brand settting",
     *    description="Get brand settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeOneBrand(Request $request)
    {
        $all_brand = getKeyValueArray([
            "home_01_brand_images",
        ]);

        return response()->json([
            "data" => $all_brand
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
