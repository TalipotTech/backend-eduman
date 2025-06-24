<?php

namespace App\Http\Controllers\Api\PageSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomepageThreeInfoController extends Controller
{
    /**
     * @OA\Get(
     *    path="/setting/home-03/header",
     *    operationId="getHomeThreeHeader",
     *    tags={"Page Setting - HomeThree"},
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
    public function getHomeThreeHeader(Request $request)
    {
        $header_info = getKeyValueArray([
            "home_03_header_sub_title",
            "home_03_header_title",
            "home_03_header_image",
            "home_03_header_button_text",
            "home_03_header_button_url",
        ]);

        return response()->json([
            "data" => $header_info
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-03/course-overview",
     *    operationId="getHomeThreeCourseOverview",
     *    tags={"Page Setting - HomeThree"},
     *    summary="Get course overview settting",
     *    description="Get course overview settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeThreeCourseOverview(Request $request)
    {
        $header_info = getKeyValueArray([
            "home_03_course_overview_sub_title",
            "home_03_course_overview_title",
            "home_03_course_overview_button_text",
            "home_03_course_overview_button_url",
        ]);

        $reapeter_header_info = getKeyValueArray([
            "home_03_course_overview_features",
            "home_03_course_overview_image",
            "home_03_course_overview_description",
        ]);

        $format_from_to = [
            "home_03_course_overview_features" => "title",
            "home_03_course_overview_image" => "image",
            "home_03_course_overview_description" => "description",
        ];

        $formatted_data = $this->formatRepeater($reapeter_header_info, $format_from_to);
        $header_info["items"] = $formatted_data;

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-03/stats",
     *    operationId="getHomeThreeStats",
     *    tags={"Page Setting - HomeThree"},
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
    public function getHomeThreeStats(Request $request)
    {
        $header_info = getKeyValueArray([
            "home_03_stats_images",
            "home_03_stats_counts",
            "home_03_stats_texts",
        ]);

        $format_from_to = [
            "home_03_stats_images" => "image",
            "home_03_stats_counts" => "title",
            "home_03_stats_texts" => "subtitle",
        ];

        $formatted_data = $this->formatRepeater($header_info, $format_from_to);

        return response()->json([
            "data" => $formatted_data
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-03/welcome-message",
     *    operationId="getHomeThreeWelcomeMessage",
     *    tags={"Page Setting - HomeThree"},
     *    summary="Get welcome message settting",
     *    description="Get welcome message settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeThreeWelcomeMessage(Request $request)
    {
        $header_info = getKeyValueArray([
            "home_03_welcome_message_since",
            "home_03_welcome_message_title",
            "home_03_welcome_message_image",
            "home_03_welcome_message_profile_image",
            "home_03_welcome_message_description",
            "home_03_welcome_message_url",
        ]);

        return response()->json([
            "data" => $header_info
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-03/course",
     *    operationId="getHomeThreeCourse",
     *    tags={"Page Setting - HomeThree"},
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
    public function getHomeThreeCourse(Request $request)
    {
        $all_course = getKeyValueArray([
            "home_03_course_section_title",
            "home_03_course_btn_text",
            "home_03_course_btn_url",
        ]);

        return response()->json([
            "data" => $all_course
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-03/about",
     *    operationId="getHomeThreeAboutInfo",
     *    tags={"Page Setting - HomeThree"},
     *    summary="Get about settting",
     *    description="Get about settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeThreeAboutInfo(Request $request)
    {
        $info = getKeyValueArray([
            "home_03_about_badge_title",
            "home_03_about_title",
            "home_03_about_image",
            "home_03_about_badge_image",
            "home_03_about_description",
        ]);

        return response()->json([
            "data" => $info
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/home-03/insta-images-more-titles",
     *    operationId="getHomeThreeInstaImagesTitles",
     *    tags={"Page Setting - HomeThree"},
     *    summary="Get Images & more titles settting",
     *    description="Get Images & more titles settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getHomeThreeInstaImagesTitles(Request $request)
    {
        $header_info = getKeyValueArray([
            "home_03_insta_images_titles_title",
            "home_03_insta_images_titles_feedback_title",
            "home_03_insta_images_titles_news_title",
            "home_03_insta_images_titles_url",
        ]);

        $reapeter_header_info = getKeyValueArray([
            "home_03_insta_images_titles_images",
        ]);

        $format_from_to = [
            "home_03_insta_images_titles_images" => "image",
        ];

        $formatted_data = $this->formatRepeater($reapeter_header_info, $format_from_to);
        $header_info["items"] = $formatted_data;

        return response()->json([
            "data" => $header_info
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
