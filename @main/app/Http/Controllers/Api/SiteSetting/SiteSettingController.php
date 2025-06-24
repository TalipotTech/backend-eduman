<?php

namespace App\Http\Controllers\Api\SiteSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class SiteSettingController extends Controller
{
    /**
     * @OA\Get(
     *    path="/site-setting/header",
     *    operationId="getSiteHeader",
     *    tags={"Site Setting"},
     *    summary="Get site header settting",
     *    description="GGet site header settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getSiteHeader(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_header_promo_message",
            "site_header_name",
            "site_header_category_title",
            "site_header_category_icon",
            "site_header_slogan",
            "site_header_logo",
            "site_header_white_logo",
            "site_header_phone",
            "site_header_email",
            "site_header_address",
            "site_header_login_text",
            "site_header_login_url",
            "site_header_signup_text",
            "site_header_signup_url",
        ]);

        $reapeter_header_info = getKeyValueArray([
            "site_header_social_links",
            "site_header_social_icons"
        ]);

        $format_from_to = [
            "site_header_social_links" => "link",
            "site_header_social_icons" => "icon",
        ];

        $formatted_data = $this->formatRepeater($reapeter_header_info, $format_from_to);
        $header_info["social_links"] = $formatted_data;

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/site-setting/footer",
     *    operationId="getSiteFooter",
     *    tags={"Site Setting"},
     *    summary="Get site footer settting",
     *    description="GGet site footer settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getSiteFooter(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_footer_app_download_title",
            "site_footer_menu_1_title",
            "site_footer_menu_1",
            "site_footer_menu_2_title",
            "site_footer_menu_2",
            "site_footer_newsletter_title",
            "site_footer_newsletter_message",
            "site_footer_newsletter_email",
            "site_footer_about_company",
            "site_footer_copyright",
            "site_footer_copyright_menu",
            "site_footer_logo",
            "site_footer_android_app_logo",
            "site_footer_apple_app_logo",
        ]);

        $header_info['site_footer_menu_1'];
        $header_info['site_footer_menu_2'];
        $header_info['site_footer_copyright_menu'];

        $reapeter_header_info = getKeyValueArray([
            "site_footer_social_links",
            "site_footer_social_icons",
        ]);

        $header_info["menu_c1"] = Menu::where('category', $header_info['site_footer_menu_1'])
            ->get();

        $header_info["menu_c2"] = Menu::where('category', $header_info['site_footer_menu_2'])
            ->get();

        $header_info["menu_copyright"] = Menu::where('category', $header_info['site_footer_copyright_menu'])
            ->get();

        $format_from_to = [
            "site_footer_social_links" => "link",
            "site_footer_social_icons" => "icon",
        ];

        $formatted_data = $this->formatRepeater($reapeter_header_info, $format_from_to);
        $header_info["social_links"] = $formatted_data;

        return response()->json([
            "data" => $header_info,
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
