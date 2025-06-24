<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Admin\UploadFileController;
use App\Http\Controllers\AdminBaseController;
use App\Models\KeyValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;

class HomepageSettingsController extends AdminBaseController
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
    
    /** ==========================================
     *      Homepage - 01
     * ========================================== */
    public function homeOneHeader()
    {
        $options = getKeyValueArray([
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

        return view("dashboard.settings.page-01.header", compact("options"));
    }

    public function homeOneHeaderSave()
    {
        $field_rules = [
            "home_01_header_title" => "nullable|string",
            "home_01_header_subtitle" => "nullable|string",
            "home_01_header_description" => "nullable|string",
            "home_01_header_btn_text" => "nullable|string",
            "home_01_header_btn_url" => "nullable|string",
            "home_01_header_hero_img" => "nullable|file",
            "home_01_header_card_1_text" => "nullable|string",
            "home_01_header_card_2_img" => "nullable|file",
            "home_01_header_card_2_text" => "nullable|string",
        ];

        request()->validate($field_rules);

        // upload image fields
        $image_fields = [
            "home_01_header_hero_img",
            "home_01_header_card_2_img",
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    /** ==========================================
     *      Category Section
     * ========================================== */
    public function homeOneCategoriesPage()
    {
        $options = getKeyValueArray([
            "home_01_category_section_title",
            "home_01_category_section_slug",
            "home_01_category_items_img",
            "home_01_category_items_title",
            "home_01_category_items_description",
        ]);

        return view("dashboard.settings.page-01.categories", compact("options"));
    }

    public function homeOneCategoriesPageSave()
    {
        $field_rules = [
            "home_01_category_section_title" => "nullable|string",
            "home_01_category_items_img.*" => "nullable|file",
            "home_01_category_items_title.*" => "nullable|string",
            "home_01_category_items_slug.*" => "nullable|string",
            "home_01_category_items_description.*" => "nullable|string",
        ];

        request()->validate($field_rules);

        if ( request()->hasFile('home_01_category_items_img') ) {
            $images = request()->file("home_01_category_items_img");
            $upload_location_arr = [];
            // loop over item title to get proper indexing
            if (is_array(request()->get("home_01_category_items_title"))) {
                foreach (request()->get("home_01_category_items_title") as $key => $title) {
                    $image = $images[$key] ?? null;
                    $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
                }
            }

            $category_items_images_json = json_encode($upload_location_arr);
        }
        else {
            $category_images = getKeyValueArray([
                "home_01_category_items_img",
            ]);

            $category_items_images_json = $category_images['home_01_category_items_img'];
        }

        $save_data = [
            "home_01_category_section_title" => request()->input("home_01_category_section_title"),
            "home_01_category_items_img" => $category_items_images_json,
            "home_01_category_items_title" => json_encode(request()->input("home_01_category_items_title")),
            "home_01_category_items_slug" => json_encode(request()->input("home_01_category_items_slug")),
            "home_01_category_items_description" => json_encode(request()->input("home_01_category_items_description")),
        ];

        $saved = setKeyValueArray($save_data, true);

        if ($saved) {
            return back()->with(ResponseMessage::customSuccess(__("Settings save success")));
        }
        return back()->withErrors(ResponseMessage::customFail(__("Attempt to save settings is failed")));
    }

    public function homeOneCoursePage()
    {
        $options = getKeyValueArray([
            "home_01_course_section_title",
        ]);
        return view("dashboard.settings.page-01.courses", compact("options"));
    }

    public function homeOneCoursePageSave()
    {
        $field_rules = [
            "home_01_course_section_title" => "nullable|string",
        ];

        request()->validate($field_rules);

        return $this->saveItems($field_rules, [], ["[br]" => "<br/>"]);
    }

    public function homeOneFeaturesPage()
    {
        $options = getKeyValueArray([
            "home_01_feature_items_title",
            "home_01_feature_items_image",
            "home_01_feature_items_details",
        ]);

        return view("dashboard.settings.page-01.features", compact("options"));
    }

    public function homeOneFeaturesPageSave()
    {
        $field_rules = [
            "home_01_feature_items_title.*" => "nullable|string",
            "home_01_feature_items_details.*" => "nullable|string",
            "home_01_feature_items_image.*" => "nullable|file",
        ];

        request()->validate($field_rules);

        $images = request()->file("home_01_feature_items_image");
        $upload_location_arr = [];

        // loop over item title to get proper indexing
        if (is_array($images)) {
            foreach ($images as $key => $image) {
                $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
            }
        }

        $save_data = [
            "home_01_feature_items_image" => json_encode($upload_location_arr),
            "home_01_feature_items_title" => json_encode(request()->get("home_01_feature_items_title") ?? []),
            "home_01_feature_items_details" => json_encode(request()->get("home_01_feature_items_details") ?? [])
        ];

        $saved = setKeyValueArray($save_data, true);

        if ($saved) {
            return back()->with(ResponseMessage::customSuccess(__("Settings save success")));
        }
        return back()->withErrors(ResponseMessage::customFail(__("Attempt to save settings is failed")));
    }

    public function homeOneAboutPage()
    {
        $options = getKeyValueArray([
            "home_01_about_us_title",
            "home_01_about_us_description",
            "home_01_about_us_items",
            "home_01_about_us_btn_text",
            "home_01_about_us_btn_url",
            "home_01_about_us_section_image",
        ]);

        return view("dashboard.settings.page-01.about-us", compact("options"));
    }

    public function homeOneAboutPageSave()
    {
        $field_rules = [
            "home_01_about_us_title" => "nullable|string",
            "home_01_about_us_description" => "nullable|string",
            "home_01_about_us_items.*" => "nullable|string",
            "home_01_about_us_btn_text" => "nullable|string",
            "home_01_about_us_btn_url" => "nullable|string",
            "home_01_about_us_section_image" => "nullable|file",
        ];

        request()->validate($field_rules);

        // save repeater field data
        $repeater_save_data = [
            "home_01_about_us_items" => json_encode(request()->input("home_01_about_us_items")),
        ];

        $saved = setKeyValueArray($repeater_save_data, true);

        // image
        $image_fields = [
            "home_01_about_us_section_image"
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    public function homeOneTestimonialPage()
    {
        $options = getKeyValueArray([
            "home_01_section_title",
            "home_01_testimonial_title",
            "home_01_testimonial_message",
            "home_01_testimonial_rating",
            "home_01_testimonial_name",
            "home_01_testimonial_designation",
            "home_01_testimonial_profile_img",
        ]);

        return view("dashboard.settings.page-01.testimonial", compact("options"));
    }

    public function homeOneTestimonialPageSave()
    {
        $field_rules = [
            "home_01_section_title" => "nullable|string",
            "home_01_testimonial_title.*" => "nullable|string",
            "home_01_testimonial_message.*" => "nullable|string",
            "home_01_testimonial_rating.*" => "nullable|string",
            "home_01_testimonial_name.*" => "nullable|string",
            "home_01_testimonial_designation.*" => "nullable|string",
            "home_01_testimonial_profile_img.*" => "nullable|file",
        ];

        request()->validate($field_rules);

       

        $images = request()->file("home_01_testimonial_profile_img");
        $upload_location_arr = [];

        // loop over item title to get proper indexing
        if (is_array($images)) {
            foreach ($images as $key => $image) {
                $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
            }
        }

        // save repeater field data
        $repeater_save_data = [
            "home_01_testimonial_title" => json_encode(request()->get("home_01_testimonial_title")),
            "home_01_testimonial_message" => json_encode(request()->get("home_01_testimonial_message")),
            "home_01_testimonial_profile_img" => json_encode($upload_location_arr),
            "home_01_testimonial_rating" => json_encode(request()->get("home_01_testimonial_rating")),
            "home_01_testimonial_name" => json_encode(request()->get("home_01_testimonial_name")),
            "home_01_testimonial_designation" => json_encode(request()->get("home_01_testimonial_designation")),
        ];

        $saved = setKeyValueArray($repeater_save_data, true);

        unset($field_rules["home_01_testimonial_title"]);
        unset($field_rules["home_01_testimonial_message"]);
        unset($field_rules["home_01_testimonial_profile_img"]);
        unset($field_rules["home_01_testimonial_rating"]);
        unset($field_rules["home_01_testimonial_name"]);
        unset($field_rules["home_01_testimonial_designation"]);

        // set image fields
        $image_fields = [
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    public function homeOneCTAOnePage()
    {
        /** @todo delete from key-val store where id = (35..44) */
        $options = getKeyValueArray([
            "home_01_cta_01_subtitle",
            "home_01_cta_01_title",
            "home_01_cta_01_image",
            "home_01_cta_01_btn_text",
            "home_01_cta_01_btn_url",
        ]);

        return view("dashboard.settings.page-01.cta-one", compact("options"));
    }

    public function homeOneCTAOnePageSave()
    {
        $field_rules = [
            "home_01_cta_01_subtitle.*" => "nullable|string",
            "home_01_cta_01_title.*" => "nullable|string",
            "home_01_cta_01_image.*" => "nullable|file",
            "home_01_cta_01_btn_text.*" => "nullable|string",
            "home_01_cta_01_btn_url.*" => "nullable|string",
        ];

        request()->validate($field_rules);

        $images = request()->file("home_01_cta_01_image");
        $upload_location_arr = [];

        // loop over item title to get proper indexing
        if (is_array($images)) {
            foreach ($images as $key => $image) {
                $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
            }
        }

        // save repeater field data
        $repeater_save_data = [
            "home_01_cta_01_subtitle" => json_encode(request()->get("home_01_cta_01_subtitle")),
            "home_01_cta_01_title" => json_encode(request()->get("home_01_cta_01_title")),
            "home_01_cta_01_image" => json_encode($upload_location_arr),
            "home_01_cta_01_btn_text" => json_encode(request()->get("home_01_cta_01_btn_text")),
            "home_01_cta_01_btn_url" => json_encode(request()->get("home_01_cta_01_btn_url")),
        ];

        $saved = setKeyValueArray($repeater_save_data, true);


        if ($saved) {
            return back()->with(ResponseMessage::customSuccess(__("Settings save success")));
        }
        return back()->withErrors(ResponseMessage::customFail(__("Attempt to save settings is failed")));
    }

    public function homeOneCTATwoPage()
    {
        $options = getKeyValueArray([
            "home_01_cta_02_title",
            "home_01_cta_02_description",
            "home_01_cta_02_image",
            "home_01_cta_02_btn_text",
            "home_01_cta_02_btn_url",
        ]);

        return view("dashboard.settings.page-01.cta-two", compact("options"));
    }

    public function homeOneCTATwoPageSave()
    {
        $field_rules = [
            "home_01_cta_02_title" => "nullable|string",
            "home_01_cta_02_description" => "nullable|string",
            "home_01_cta_02_image" => "nullable|file",
            "home_01_cta_02_btn_text" => "nullable|string",
            "home_01_cta_02_btn_url" => "nullable|string",
        ];

        request()->validate($field_rules);

        $image_fields = [
            "home_01_cta_02_image",
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    public function homeOneBrandPage()
    {
        $options = getKeyValueArray([
            "home_01_brand_images",
        ]);

        return view("dashboard.settings.page-01.brand", compact("options"));
    }

    public function homeOneBrandPageSave()
    {
        $field_rules = [
            "home_01_brand_images.*" => "nullable|file",
        ];

        request()->validate($field_rules);

        $images = request()->file("home_01_brand_images");
        $upload_location_arr = [];

        // loop over item title to get proper indexing
        if (is_array($images)) {
            foreach ($images as $key => $image) {
                $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
            }
        }

        $save_data = [
            "home_01_brand_images" => json_encode($upload_location_arr),
        ];

        $saved = setKeyValueArray($save_data, true);

        if ($saved) {
            return back()->with(ResponseMessage::customSuccess(__("Settings save success")));
        }
        return back()->withErrors(ResponseMessage::customFail(__("Attempt to save settings is failed")));
    }

    public function homeOneSettingsPage()
    {
        return;
    }

    public function homeOneSettingsStore()
    {
        return "";
    }

    /** ==========================================
     *      Homepage - 02
     * ========================================== */
    public function homeTwoHeaderPage()
    {
        $options = getKeyValueArray([
            "home_02_header_title",
            "home_02_header_search_placeholder",
            "home_02_header_left_image",
            "home_02_header_left_badge_image",
            "home_02_header_left_badge_text",
            "home_02_header_right_floating_image",
            "home_02_header_right_floating_text",
            "home_02_header_features",
        ]);

        return view("dashboard.settings.page-02.header", compact("options"));
    }

    public function homeTwoHeaderPageSave()
    {
        $field_rules = [
            "home_02_header_title" => "nullable|string",
            "home_02_header_search_placeholder" => "nullable|string",
            "home_02_header_left_image" => "nullable|file",
            "home_02_header_left_badge_image" => "nullable|file",
            "home_02_header_left_badge_text" => "nullable|string",
            "home_02_header_right_floating_image" => "nullable|file",
            "home_02_header_right_floating_text" => "nullable|string",
            "home_02_header_features.*" => "nullable|string",
        ];

        request()->validate($field_rules);

        // save repeater field data
        $repeater_save_data = [
            "home_02_header_features" => json_encode(request()->get("home_02_header_features")),
        ];

        $saved = setKeyValueArray($repeater_save_data, true);

        unset($field_rules["home_02_header_features"]);

        // set image fields
        $image_fields = [
            "home_02_header_left_image",
            "home_02_header_left_badge_image",
            "home_02_header_right_floating_image",
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    public function homeTwoStatsPage()
    {
        $options = getKeyValueArray([
            "home_02_stats_images",
            "home_02_stats_counts",
            "home_02_stats_texts",
        ]);

        return view("dashboard.settings.page-02.stats", compact("options"));
    }

    public function homeTwoStatsPageSave()
    {
        $field_rules = [
            "home_02_stats_images.*" => "nullable|file",
            "home_02_stats_counts.*" => "nullable|string",
            "home_02_stats_texts.*" => "nullable|string",
        ];

        request()->validate($field_rules);

        $images = request()->file("home_02_stats_images");
        $upload_location_arr = [];

        // loop over item title to get proper indexing
        if (is_array($images)) {
            foreach ($images as $key => $image) {
                $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
            }
        }

        $save_data = [
            "home_02_stats_images" => json_encode($upload_location_arr),
            "home_02_stats_counts" => json_encode(request()->get("home_02_stats_counts")),
            "home_02_stats_texts" => json_encode(request()->get("home_02_stats_texts")),
        ];

        $saved = setKeyValueArray($save_data, true);

        if ($saved) {
            return back()->with(ResponseMessage::customSuccess(__("Settings save success")));
        }
        return back()->withErrors(ResponseMessage::customFail(__("Attempt to save settings is failed")));
    }

    public function homeTwoCtaOnePage()
    {
        $options = getKeyValueArray([
            "home_02_cta_01_title",
            "home_02_cta_01_description",
            "home_02_cta_01_image",
            "home_02_cta_01_features",
            "home_02_cta_01_btn_text",
            "home_02_cta_01_btn_url",
        ]);

        return view("dashboard.settings.page-02.ctaOne", compact("options"));
    }

    public function homeTwoCtaOnePageSave()
    {
        $field_rules = [
            "home_02_cta_01_title" => "nullable|string",
            "home_02_cta_01_description" => "nullable|string",
            "home_02_cta_01_image" => "nullable|file",
            "home_02_cta_01_features.*" => "nullable|string",
            "home_02_cta_01_btn_text" => "nullable|string",
            "home_02_cta_01_btn_url" => "nullable|string",
        ];

        request()->validate($field_rules);

        // upload and save repeater image
        $save_data = [
            "home_02_cta_01_features" => json_encode(request()->get("home_02_cta_01_features")),
        ];

        $saved = setKeyValueArray($save_data, true);

        unset($field_rules["home_02_cta_01_features"]);

        // save image and other data
        $image_fields = [
            "home_02_cta_01_image"
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    public function homeTwoCategoriesPage()
    {
        $options = getKeyValueArray([
            "home_02_categories_section_title",
            "home_02_categories_title",
            "home_02_categories_subtitle",
            "home_02_categories_url",
            "home_02_categories_image",
        ]);

        return view("dashboard.settings.page-02.categories", compact("options"));
    }

    public function homeTwoCategoriesPageSave()
    {
        $field_rules = [
            "home_02_categories_section_title" => "nullable|string",
            "home_02_categories_title.*" => "nullable|string",
            "home_02_categories_subtitle.*" => "nullable|string",
            "home_02_categories_url.*" => "nullable|string",
            "home_02_categories_image.*" => "nullable|image",
        ];

        request()->validate($field_rules);


        
        $images = request()->file("home_02_categories_image");
        $upload_location_arr = [];

        // loop over item title to get proper indexing
        if (is_array($images)) {
            foreach ($images as $key => $image) {
                $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
            }
        }

        $save_data = [
            "home_02_categories_section_title" => request()->get("home_02_categories_section_title"),
            "home_02_categories_title" => json_encode(request()->get("home_02_categories_title")),
            "home_02_categories_subtitle" => json_encode(request()->get("home_02_categories_subtitle")),
            "home_02_categories_url" => json_encode(request()->get("home_02_categories_url")),
            "home_02_categories_image" => json_encode($upload_location_arr),
        ];

        $saved = setKeyValueArray($save_data, true);

        if ($saved) {
            return back()->with(ResponseMessage::customSuccess(__("Settings save success")));
        }
        return back()->withErrors(ResponseMessage::customFail(__("Attempt to save settings is failed")));
    }

    public function homeTwoCoursePage()
    {
        $options = getKeyValueArray([
            "home_02_course_section_title",
        ]);

        return view("dashboard.settings.page-02.courses", compact("options"));
    }

    public function homeTwoCoursePageSave()
    {
        $field_rules = [
            "home_02_course_section_title" => "nullable|string",
        ];

        request()->validate($field_rules);

        return $this->saveItems($field_rules, [], ["[br]" => "<br/>"]);
    }

    public function homeTwoFeaturesPage()
    {
        $options = getKeyValueArray([
            "home_02_feature_items_title",
            "home_02_feature_items_image",
        ]);

        return view("dashboard.settings.page-02.features", compact("options"));
    }

    public function homeTwoFeaturesPageSave()
    {
        $field_rules = [
            "home_02_feature_items_title.*" => "nullable|string",
            "home_02_feature_items_image.*" => "nullable|file",
        ];

        request()->validate($field_rules);

        $images = request()->file("home_02_feature_items_image");
        $upload_location_arr = [];

        // loop over item title to get proper indexing
        if (is_array($images)) {
            foreach ($images as $key => $image) {
                $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
            }
        }

        $save_data = [
            "home_02_feature_items_image" => json_encode($upload_location_arr),
            "home_02_feature_items_title" => json_encode(request()->get("home_02_feature_items_title") ?? [])
        ];

        $saved = setKeyValueArray($save_data, true);

        if ($saved) {
            return back()->with(ResponseMessage::customSuccess(__("Settings save success")));
        }
        return back()->withErrors(ResponseMessage::customFail(__("Attempt to save settings is failed")));
    }

    public function homeTwoCtaTwoPage()
    {
        $options = getKeyValueArray([
            "home_02_cta_02_title",
            "home_02_cta_02_subtitle",
            "home_02_cta_02_btn_text",
            "home_02_cta_02_btn_url",
            "home_02_cta_02_img_01",
            "home_02_cta_02_img_02",
        ]);
        return view("dashboard.settings.page-02.ctaTwo", compact("options"));
    }

    public function homeTwoCtaTwoPageSave()
    {
        $field_rules = [
            "home_02_cta_02_title" => "nullable|string",
            "home_02_cta_02_subtitle" => "nullable|string",
            "home_02_cta_02_btn_text" => "nullable|string",
            "home_02_cta_02_btn_url" => "nullable|string",
            "home_02_cta_02_img_01" => "nullable|file",
            "home_02_cta_02_img_02" => "nullable|file",
        ];

        request()->validate($field_rules);

        // save image and other data
        $image_fields = [
            "home_02_cta_02_img_01",
            "home_02_cta_02_img_02",
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    public function homeTwoCtaThreePage()
    {
        $options = getKeyValueArray([
            "home_02_cta_03_title",
            "home_02_cta_03_subtitle",
            "home_02_cta_03_btn_text",
            "home_02_cta_03_btn_url",
            "home_02_cta_03_img_01",
            "home_02_cta_03_img_02",
        ]);
        return view("dashboard.settings.page-02.ctaThree", compact("options"));
    }

    public function homeTwoCtaThreePageSave()
    {
        $field_rules = [
            "home_02_cta_03_title" => "nullable|string",
            "home_02_cta_03_subtitle" => "nullable|string",
            "home_02_cta_03_btn_text" => "nullable|string",
            "home_02_cta_03_btn_url" => "nullable|string",
            "home_02_cta_03_img_01" => "nullable|file",
            "home_02_cta_03_img_02" => "nullable|file",
        ];

        request()->validate($field_rules);

        // save image and other data
        $image_fields = [
            "home_02_cta_03_img_01",
            "home_02_cta_03_img_02",
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    public function homeTwoCtaFourPage()
    {
        $options = getKeyValueArray([
            "home_02_cta_04_subtitle",
            "home_02_cta_04_title",
            "home_02_cta_04_btn_text",
            "home_02_cta_04_btn_url",
            "home_02_cta_04_img",
            "home_02_cta_04_badge_text",
        ]);
        return view("dashboard.settings.page-02.ctaFour", compact("options"));
    }

    public function homeTwoCtaFourPageSave()
    {
        $field_rules = [
            "home_02_cta_04_subtitle" => "nullable|string",
            "home_02_cta_04_title" => "nullable|string",
            "home_02_cta_04_btn_text" => "nullable|string",
            "home_02_cta_04_btn_url" => "nullable|string",
            "home_02_cta_04_img" => "nullable|file",
            "home_02_cta_04_badge_text" => "nullable|string",
        ];

        request()->validate($field_rules);

        // save image and other data
        $image_fields = [
            "home_02_cta_04_img",
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    public function homeTwoBlogPage()
    {
        $options = null;
        return view("dashboard.settings.page-02.blog", compact("options"));
    }

    public function homeTwoBlogPageSave()
    {
        $all_blogPageSave = null;
        return response()->json([
            "blogPageSave" => $all_blogPageSave
        ]);
    }

    /*
    * insta images
    */
    public function getHomeTwoPartners()
    {
        $options = getKeyValueArray([
            "home_02_partner_section_title",
            "home_02_partner_section_description",
            "home_02_partner_section_desc_more",
            "home_02_partner_section_img",
            "home_02_partner_logo_images",
        ]);

        return view("dashboard.settings.page-02.partners", compact("options"));
    }

    public function saveHomeTwoPartners()
    {
        $field_rules = [
            "home_02_partner_section_title" => "nullable|string",
            "home_02_partner_section_description" => "nullable|string",
            "home_02_partner_section_desc_more" => "nullable|string",
            "home_02_partner_section_img" => "nullable|file",
            "home_02_partner_logo_images.*" => "nullable|file",
        ];

        request()->validate($field_rules);

        // save repeater field data
        $images = request()->file("home_02_partner_logo_images");
        $upload_location_arr = [];

        // loop over item title to get proper indexing
        if (is_array($images)) {
            foreach ($images as $key => $image) {
                $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
            }
        }

        $repeater_save_data = [
            "home_02_partner_logo_images" => json_encode($upload_location_arr),
        ];

        $saved = setKeyValueArray($repeater_save_data, true);

        unset($field_rules["home_02_partner_logo_images"]);

        // set image fields
        $image_fields = [
            "home_02_partner_section_img",
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    public function homeTwoHeader()
    {
        return null;
    }
}
