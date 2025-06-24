<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Admin\UploadFileController;
use App\Http\Controllers\Controller;
use App\Models\KeyValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Enums\MenuTypeEnum;

class SiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:page-list', ['only' => ['index','show']]);
        $this->middleware('permission:page-create', ['only' => ['create','store']]);
        $this->middleware('permission:page-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:page-delete', ['only' => ['destroy']]);
    }
    
    public function siteSettingHeader()
    {
        $options = getKeyValueArray([
            "site_header_name",
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
            "site_header_social_links",
            "site_header_social_icons"
        ]);

        return view("dashboard.site-setting.header", compact("options"));
    }

    public function siteSettingHeaderSave()
    {
        $field_rules = [
            "site_header_name" => "nullable|string",
            "site_header_slogan" => "nullable|string",
            "site_header_logo" => "nullable|file",
            "site_header_white_logo" => "nullable|file",
            "site_header_phone" => "nullable|string",
            "site_header_email" => "nullable|string",
            "site_header_address" => "nullable|string",
            "site_header_login_text" => "nullable|string",
            "site_header_login_url" => "nullable|string",
            "site_header_signup_text" => "nullable|string",
            "site_header_signup_url" => "nullable|string",
            "site_header_social_links.*" => "nullable|string",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_header_logo",
            "site_header_white_logo",
        ];

        // save repeater field data
        $repeater_save_data = [
            "site_header_social_links" => json_encode(request()->get("site_header_social_links") ?? []),
            "site_header_social_icons" => json_encode(request()->get("site_header_social_icons") ?? [])
        ];
        $saved = setKeyValueArray($repeater_save_data, true);

        unset($field_rules["site_header_social_links"]);
        unset($field_rules["site_header_social_icons"]);

        return $this->saveItems($field_rules, $image_fields);
    }

    public function siteSettingFooter()
    {
        $options = getKeyValueArray([
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
            "site_footer_social_links",
            "site_footer_social_icons",
        ]);

        $menus = MenuTypeEnum::cases();
        $menuNames = array();
        foreach($menus as $key => $menu)
        {
            $menuNames[] = array(
                'id' => $menu->value,
                'title' => $menu->value,
            );
        }

        return view("dashboard.site-setting.footer", compact("options", "menuNames"));
    }

    public function siteSettingFooterSave()
    {
        $field_rules = [
            "site_footer_app_download_title" => "nullable|string",
            "site_footer_menu_1_title" => "nullable|string",
            "site_footer_menu_1" => "nullable|string",
            "site_footer_menu_2_title" => "nullable|string",
            "site_footer_menu_2" => "nullable|string",
            "site_footer_newsletter_title" => "nullable|string",
            "site_footer_newsletter_message" => "nullable|string",
            "site_footer_newsletter_email" => "nullable|string",
            "site_footer_about_company" => "nullable|string",
            "site_footer_copyright" => "nullable|string",
            "site_footer_copyright_menu" => "nullable|string",
            "site_footer_logo" => "nullable|file",
            "site_footer_android_app_logo" => "nullable|file",
            "site_footer_apple_app_logo" => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_footer_logo",
            "site_footer_android_app_logo",
            "site_footer_apple_app_logo",
        ];

        // save repeater field data
        $repeater_save_data = [
            "site_footer_social_links" => json_encode(request()->get("site_footer_social_links") ?? []),
            "site_footer_social_icons" => json_encode(request()->get("site_footer_social_icons") ?? [])
        ];
        $saved = setKeyValueArray($repeater_save_data, true);

        return $this->saveItems($field_rules, $image_fields);
    }

    public function saveItems($field_rules = [], $image_fields = [], $format = [])
    {
        try {
            DB::beginTransaction();

            if (is_array($image_fields) || is_iterable($image_fields)) {
                foreach ($image_fields as $key) {
                    $upload_location = uploadMedia($key);

                    // remove uploaded image from the normal input array
                    unset($field_rules[$key]);

                    if ($upload_location) {
                        setKeyValue($key, $upload_location);
                    }
                }
            }

            // save input
            $saved = setKeyValueArray($field_rules, false, $format);

            DB::commit();

            return back()->with(ResponseMessage::customSuccess(__("Settings save success")));

        } 
        catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(ResponseMessage::customFail(__("Attempt to save settings is failed")));
        }
    }
}
