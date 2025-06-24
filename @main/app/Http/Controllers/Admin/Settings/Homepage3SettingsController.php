<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Admin\UploadFileController;
use App\Http\Controllers\AdminBaseController;
use App\Models\KeyValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;

class Homepage3SettingsController extends AdminBaseController
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

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function homeThreeHeaderPage()
    {
        $options = getKeyValueArray([
            "home_03_header_sub_title",
            "home_03_header_title",
            "home_03_header_image",
            "home_03_header_button_text",
            "home_03_header_button_url",
        ]);

        return view("dashboard.settings.page-03.header", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function homeThreeHeaderPageSave()
    {
        $field_rules = [
            "home_03_header_sub_title" => "nullable|string",
            "home_03_header_title" => "nullable|string",
            "home_03_header_image" => "nullable|file",
            "home_03_header_button_text" => "nullable|string",
            "home_03_header_button_url" => "nullable|string",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "home_03_header_image",
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function homeThreeCourseOverview()
    {
        $options = getKeyValueArray([
            "home_03_course_overview_sub_title",
            "home_03_course_overview_title",
            "home_03_course_overview_button_text",
            "home_03_course_overview_button_url",
            "home_03_course_overview_features",
            "home_03_course_overview_description",
            "home_03_course_overview_image",
        ]);

        return view("dashboard.settings.page-03.courseOverview", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function homeThreeCourseOverviewSave()
    {
        $field_rules = [
            "home_03_course_overview_title" => "nullable|string",
            "home_03_course_overview_sub_title" => "nullable|string",
            "home_03_course_overview_button_text" => "nullable|string",
            "home_03_course_overview_button_url" => "nullable|string",
            "home_03_course_overview_features.*" => "nullable|string",
        ];

        request()->validate($field_rules);

        // save repeater field data
        $images = request()->file("home_03_course_overview_image");
        $upload_location_arr = [];

        // loop over item title to get proper indexing
        if (is_array($images)) {
            foreach ($images as $key => $image) {
                $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
            }
        }

        $repeater_save_data = [
            "home_03_course_overview_features" => json_encode(request()->get("home_03_course_overview_features")),
            "home_03_course_overview_description" => json_encode(request()->get("home_03_course_overview_description")),
            "home_03_course_overview_image" => json_encode($upload_location_arr),
        ];

        $saved = setKeyValueArray($repeater_save_data, true);

        unset($field_rules["home_03_course_overview_features"]);

        // set image fields
        $image_fields = [];

        return $this->saveItems($field_rules, $image_fields);
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function homeThreeStatsPage()
    {
        $options = getKeyValueArray([
            "home_03_stats_images",
            "home_03_stats_counts",
            "home_03_stats_texts",
        ]);

        return view("dashboard.settings.page-03.stats", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function homeThreeStatsPageSave()
    {
        $field_rules = [
            "home_03_stats_images.*" => "nullable|file",
            "home_03_stats_counts.*" => "nullable|string",
            "home_03_stats_texts.*" => "nullable|string",
        ];

        request()->validate($field_rules);

        $images = request()->file("home_03_stats_images");
        $upload_location_arr = [];

        // loop over item title to get proper indexing
        if (is_array($images)) {
            foreach ($images as $key => $image) {
                $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
            }
        }

        $save_data = [
            "home_03_stats_images" => json_encode($upload_location_arr),
            "home_03_stats_counts" => json_encode(request()->get("home_03_stats_counts")),
            "home_03_stats_texts" => json_encode(request()->get("home_03_stats_texts")),
        ];

        $saved = setKeyValueArray($save_data, true);

        if ($saved) {
            return back()->with(ResponseMessage::customSuccess(__("Settings save success")));
        }
        return back()->withErrors(ResponseMessage::customFail(__("Attempt to save settings is failed")));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function homeThreeWelcomeMessagePage()
    {
        $options = getKeyValueArray([
            "home_03_welcome_message_since",
            "home_03_welcome_message_title",
            "home_03_welcome_message_image",
            "home_03_welcome_message_profile_image",
            "home_03_welcome_message_url",
            "home_03_welcome_message_description",
        ]);

        return view("dashboard.settings.page-03.welcomeMessage", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function homeThreeWelcomeMessagePageSave()
    {
        $field_rules = [
            "home_03_welcome_message_since" => "nullable|string",
            "home_03_welcome_message_title" => "nullable|string",
            "home_03_welcome_message_image" => "nullable|file",
            "home_03_welcome_message_profile_image" => "nullable|file",
            "home_03_welcome_message_description" => "nullable|string",
            "home_03_welcome_message_url" => "nullable|string",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "home_03_welcome_message_image",
            "home_03_welcome_message_profile_image",
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function homeThreeCoursePage()
    {
        $options = getKeyValueArray([
            "home_03_course_section_title",
            "home_03_course_btn_text",
            "home_03_course_btn_url",
        ]);

        return view("dashboard.settings.page-03.courses", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function homeThreeCoursePageSave()
    {
        $field_rules = [
            "home_03_course_section_title" => "nullable|string",
            "home_03_course_btn_text" => "nullable|string",
            "home_03_course_btn_url" => "nullable|string",
        ];

        request()->validate($field_rules);

        return $this->saveItems($field_rules, [], ["[br]" => "<br/>"]);
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function homeThreeAboutPage()
    {
        $options = getKeyValueArray([
            "home_03_about_badge_title",
            "home_03_about_title",
            "home_03_about_image",
            "home_03_about_badge_image",
            "home_03_about_description",
        ]);

        return view("dashboard.settings.page-03.about", compact("options"));
    }

    /*  
    * Welcome Message save
    */
    public function homeThreeAboutPageSave()
    {
        $field_rules = [
            "home_03_about_badge_title" => "nullable|string",
            "home_03_about_title" => "nullable|string",
            "home_03_about_image" => "nullable|file",
            "home_03_about_badge_image" => "nullable|file",
            "home_03_about_description" => "nullable|string",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "home_03_about_image",
            "home_03_about_badge_image",
        ];

        return $this->saveItems($field_rules, $image_fields);
    }


    /*
    * insta images
    */
    public function homeThreeInstaImagesTitlesPage()
    {
        $options = getKeyValueArray([
            "home_03_insta_images_titles_title",
            "home_03_insta_images_titles_feedback_title",
            "home_03_insta_images_titles_news_title",
            "home_03_insta_images_titles_url",
            "home_03_insta_images_titles_images",
        ]);

        return view("dashboard.settings.page-03.instaImagesTitles", compact("options"));
    }

    public function homeThreeInstaImagesTitlesPageSave()
    {
        $field_rules = [
            "home_03_insta_images_titles_title" => "nullable|string",
            "home_03_insta_images_titles_feedback_title" => "nullable|string",
            "home_03_insta_images_titles_news_title" => "nullable|string",
            "home_03_insta_images_titles_url" => "nullable|string",
            "home_03_insta_images_titles_images.*" => "nullable|file",
        ];

        request()->validate($field_rules);

        // save repeater field data
        if ( request()->hasFile('home_03_insta_images_titles_images') ) {
            $images = request()->file("home_03_insta_images_titles_images");
            $upload_location_arr = [];
            // loop over item title to get proper indexing
            if (is_array($images)) {
                foreach ($images as $key => $image) {
                    $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
                }
            }
            $repeater_save_data = [
                "home_03_insta_images_titles_images" => json_encode($upload_location_arr),
            ];
        }
        else {
            $category_images = getKeyValueArray([
                "home_03_insta_images_titles_images",
            ]);
            $repeater_save_data = [
                "home_03_insta_images_titles_images" => $category_images['home_03_insta_images_titles_images'],
            ];
        }

        $saved = setKeyValueArray($repeater_save_data, true);

        unset($field_rules["home_03_insta_images_titles_images"]);

        // set image fields
        $image_fields = [];

        $this->saveItems($field_rules, $image_fields);

        if ($saved) {
            return back()->with(ResponseMessage::customSuccess(__("Settings save success")));
        }
        return back()->withErrors(ResponseMessage::customFail(__("Attempt to save settings is failed")));
    }

}
