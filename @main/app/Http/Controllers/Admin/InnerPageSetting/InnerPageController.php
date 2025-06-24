<?php

namespace App\Http\Controllers\Admin\InnerPageSetting;

use App\Http\Controllers\AdminBaseController;

class InnerPageController extends AdminBaseController
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
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function getLoginPage()
    {
        $options = getKeyValueArray([
            "site_login_title",
            "site_login_sub_title",
            "site_login_description",
            "site_login_keywords",
            "site_login_img",
            "site_login_banner_image",
            "site_login_check_text",
            "site_login_signin_text",
            "site_login_signup_text",
            "site_login_register_text",
            "site_login_forget_text",
        ]);

        return view("dashboard.setting-inner-page.login", compact("options"));
    }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function saveLoginPage()
    {
        $field_rules = [
            "site_login_title" => "nullable|string",
            "site_login_sub_title" => "nullable|string",
            "site_login_description" => "nullable|string",
            "site_login_keywords" => "nullable|string",
            "site_login_check_text" => "nullable|string",
            "site_login_img" => "nullable|file",
            "site_login_banner_image" => "nullable|file",
            "site_login_signin_text" => "nullable|string",
            "site_login_signup_text" => "nullable|string",
            "site_login_register_text" => "nullable|string",
            "site_login_forget_text" => "nullable|string",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_login_img",
            "site_login_banner_image",
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function getForgetPassPage()
    {
        $options = getKeyValueArray([
            "site_forget_pass_title",
            "site_forget_pass_sub_title",
            "site_forget_pass_description",
            "site_forget_pass_keywords",
            "site_forget_pass_banner_image",
            "site_forget_pass_img",
            "site_forget_pass_text",
            "site_forget_pass_signin_btn_text",
            "site_forget_pass_back_text",
            "site_forget_pass_email_text",
        ]);

        return view("dashboard.setting-inner-page.forget_password", compact("options"));
    }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function saveForgetPassPage()
    {
        $field_rules = [
            "site_forget_pass_title" => "nullable|string",
            "site_forget_pass_sub_title" => "nullable|string",
            "site_forget_pass_description" => "nullable|string",
            "site_forget_pass_keywords" => "nullable|string",
            "site_forget_pass_text" => "nullable|string",
            "site_forget_pass_banner_image" => "nullable|file",
            "site_forget_pass_img" => "nullable|file",
            "site_forget_pass_signin_btn_text" => "nullable|string",
            "site_forget_pass_back_text" => "nullable|string",
            "site_forget_pass_email_text" => "nullable|string",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_forget_pass_banner_image",
            "site_forget_pass_img",
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
    public function getStudentProfilePage()
    {
        $options = getKeyValueArray([
            "site_student_profile_title",
            "site_student_profile_sub_title",
            "site_student_profile_description",
            "site_student_profile_keywords",
            "site_student_profile_banner_image",
            "site_student_profile_img",
            "site_student_profile_tab_dashboard_text",
            "site_student_profile_tab_profile_text",
            "site_student_profile_tab_enroll_course_text", 
            "site_student_profile_tab_wishlist_text", 
            "site_student_profile_tab_review_text", 
            "site_student_profile_tab_quiz_text", 
            "site_student_profile_tab_order_history_text", 
            "site_student_profile_tab_setting_text", 
            "site_student_profile_tab_logout_text", 
        ]);

        return view("dashboard.setting-inner-page.student_profile", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveStudentProfilePage()
    {
        $field_rules = [
            "site_student_profile_title" => "nullable|string",
            "site_student_profile_sub_title" => "nullable|string",
            "site_student_profile_description" => "nullable|string",
            "site_student_profile_keywords" => "nullable|string",
            "site_student_profile_banner_image" => "nullable|file",
            "site_student_profile_tab_dashboard_text" => "nullable|string",
            "site_student_profile_tab_profile_text" => "nullable|string",
            "site_student_profile_tab_enroll_course_text" => "nullable|string", 
            "site_student_profile_tab_wishlist_text" => "nullable|string", 
            "site_student_profile_tab_review_text" => "nullable|string", 
            "site_student_profile_tab_quiz_text" => "nullable|string", 
            "site_student_profile_tab_order_history_text" => "nullable|string", 
            "site_student_profile_tab_setting_text" => "nullable|string", 
            "site_student_profile_tab_logout_text" => "nullable|string", 
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_student_profile_banner_image",
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
    public function getSignUpPage()
    {
        $options = getKeyValueArray([
            "site_signup_title",
            "site_signup_sub_title",
            "site_signup_description",
            "site_signup_keywords",
            "site_signup_banner_image",
            "site_signup_img",
            "site_signup_policy_text",
            "site_signup_back_text", 
            "site_signup_btn_text", 
            "site_signup_btn_url",
        ]);

        return view("dashboard.setting-inner-page.signup", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveSignUpPage()
    {
        $field_rules = [
            "site_signup_title" => "nullable|string",
            "site_signup_sub_title" => "nullable|string",
            "site_signup_description" => "nullable|string",
            "site_signup_keywords" => "nullable|string",
            "site_signup_banner_image" => "nullable|file",
            "site_signup_img" => "nullable|file",
            "site_signup_btn_text" => "nullable|string",
            "site_signup_btn_url" => "nullable|string",
            "site_signup_back_text" => "nullable|string",
            "site_signup_policy_text" => "nullable|string",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_signup_banner_image",
            "site_signup_img",
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
    public function getAboutPage()
    {
        $options = getKeyValueArray([
            "site_about_blog_category",
            "site_about_title",
            "site_about_sub_title",
            "site_about_description",
            "site_about_keywords",
            "site_about_banner_image",
            "site_about_feature_title",
            "site_about_intro_video",
            "site_about_intro_video_image",
            "site_about_intro_btn_text",
            "site_about_intro_promo_text",
            "site_about_intro_promo_text2",
            "site_about_blog_title",
            "site_about_blog_description",
            "site_about_instructor_title",
            "site_about_instructor_description",
            "site_about_instructor_btn_text",
            "site_about_instructor_btn_url",
        ]);

        return view("dashboard.setting-inner-page.about", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveAboutPage()
    {
        $field_rules = [
            "site_about_blog_category" => "nullable|string",
            "site_about_title" => "nullable|string",
            "site_about_sub_title" => "nullable|string",
            "site_about_description" => "nullable|string",
            "site_about_keywords" => "nullable|string",
            "site_about_banner_image" => "nullable|file",
            "site_about_feature_title" => "nullable|string",
            "site_about_intro_video" => "nullable|string",
            "site_about_intro_btn_text" => "nullable|string",
            "site_about_intro_promo_text" => "nullable|string",
            "site_about_intro_promo_text2" => "nullable|string",
            "site_about_blog_title" => "nullable|string",
            "site_about_blog_description" => "nullable|string",
            "site_about_instructor_title" => "nullable|string",
            "site_about_instructor_description" => "nullable|string",
            "site_about_instructor_btn_text" => "nullable|string",
            "site_about_instructor_btn_url" => "nullable|string",
            "site_about_intro_video_image" => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_about_intro_video_image",
            "site_about_banner_image",
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
    public function getBecomeInstructorPage()
    {
        $options = getKeyValueArray([
            "site_become_instructor_title",
            "site_become_instructor_sub_title",
            "site_become_instructor_description",
            "site_become_instructor_keywords",
            "site_become_instructor_banner_image",
            "site_become_instructor_section_title",
            "site_become_instructor_tab_titles",
            "site_become_instructor_tab_contents",
            "site_become_instructor_tab_images",
        ]);

        return view("dashboard.setting-inner-page.become_instructor", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveBecomeInstructorPage()
    {
        $field_rules = [
            "site_become_instructor_title" => "nullable|string",
            "site_become_instructor_sub_title" => "nullable|string",
            "site_become_instructor_keywords" => "nullable|string",
            "site_become_instructor_banner_image" => "nullable|file",
            "site_become_instructor_description" => "nullable|string",
            "site_become_instructor_section_title" => "nullable|string",
            "site_become_instructor_tab_images.*" => "nullable|file",
            "site_become_instructor_tab_titles.*" => "nullable|string",
            "site_become_instructor_tab_contents.*" => "nullable|string",
        ];

        request()->validate($field_rules);

        if ( request()->hasFile('site_become_instructor_tab_images') ) {
            $images = request()->file("site_become_instructor_tab_images");
            $upload_location_arr = [];

            // loop over item title to get proper indexing
            if (is_array($images)) {
                foreach ($images as $key => $image) {
                    $upload_location_arr[$key] = $image ? uploadFileInDirectory($image, config("upload.directories.owner_image") . auth()->id()) ?? "" : "";
                }
            }

            $upload_location_json = json_encode($upload_location_arr);
        }
        else {
            $upload_images = getKeyValueArray([
                "site_become_instructor_tab_images",
            ]);

            $upload_location_json = $upload_images['site_become_instructor_tab_images'];
        }

        $repeated_save_data = [
            "site_become_instructor_tab_titles" => json_encode(request()->get("site_become_instructor_tab_titles")),
            "site_become_instructor_tab_contents" => json_encode(request()->get("site_become_instructor_tab_contents")),
            "site_become_instructor_tab_images" => $upload_location_json,
        ];

        $saved = setKeyValueArray($repeated_save_data, true);

        // set image fields
        $image_fields = [
            "site_become_instructor_banner_image",
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
    public function getCheckoutPage()
    {
        $options = getKeyValueArray([
            "site_checkout_title",
            "site_checkout_sub_title",
            "site_checkout_description",
            "site_checkout_keywords",
            "site_checkout_banner_image",
            "site_checkout_billing_title",
            "site_checkout_payment_title",
            "site_checkout_payment_default_title",
            "site_checkout_payment_default_description",
            "site_checkout_btn_text",
            "site_checkout_btn_url",
            "site_checkout_account_title",
            "site_checkout_account_description",
            "site_checkout_shipping_title",
            "site_checkout_payment_url",
            "site_checkout_paypal_payment_url",
            "site_checkout_stripe_payment_url",
            "site_checkout_pay_later_url",
        ]);

        return view("dashboard.setting-inner-page.checkout", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveCheckoutPage()
    {
        $field_rules = [
            "site_checkout_title" => "nullable|string",
            "site_checkout_sub_title" => "nullable|string",
            "site_checkout_description" => "nullable|string",
            "site_checkout_keywords" => "nullable|string",
            "site_checkout_banner_image" => "nullable|file",
            "site_checkout_billing_title" => "nullable|string",
            "site_checkout_payment_title" => "nullable|string",
            "site_checkout_payment_default_title" => "nullable|string",
            "site_checkout_payment_default_description" => "nullable|string",
            "site_checkout_btn_text" => "nullable|string",
            "site_checkout_btn_url" => "nullable|string",
            "site_checkout_account_title" => "nullable|string",
            "site_checkout_account_description" => "nullable|string",
            "site_checkout_shipping_title" => "nullable|string",
            "site_checkout_payment_url" => "nullable|string",
            "site_checkout_paypal_payment_url" => "nullable|string",
            "site_checkout_stripe_payment_url" => "nullable|string",
            "site_checkout_pay_later_url" => "nullable|string",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_checkout_banner_image",
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
    public function getCartPage()
    {
        $options = getKeyValueArray([
            "site_cart_title",
            "site_cart_sub_title",
            "site_cart_description",
            "site_cart_keywords",
            "site_cart_banner_image",
            "site_cart_btn_text",
            "site_cart_btn_url",
        ]);

        return view("dashboard.setting-inner-page.cart", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveCartPage()
    {
        $field_rules = [
            "site_cart_title" => "nullable|string",
            "site_cart_sub_title" => "nullable|string",
            "site_cart_description" => "nullable|string",
            "site_cart_keywords" => "nullable|string",
            "site_cart_banner_image" => "nullable|file",
            "site_cart_btn_text" => "nullable|string",
            "site_cart_btn_url" => "nullable|string",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_cart_banner_image",
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
    public function getCoursesListPage()
    {
        $options = getKeyValueArray([
            "site_courses_title",
            "site_courses_sub_title",
            "site_courses_description",
            "site_courses_keywords",
            "site_courses_banner_image",
            "site_courses_filter_title",
            "site_courses_filter_category_title",
            "site_courses_filter_rating_title",
            "site_courses_filter_price_title",
            "site_courses_filter_level_title",
        ]);

        return view("dashboard.setting-inner-page.courses", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveCoursesListPage()
    {
        $field_rules = [
            "site_courses_title" => "nullable|string",
            "site_courses_sub_title" => "nullable|string",
            "site_courses_description" => "nullable|string",
            "site_courses_keywords" => "nullable|string",
            "site_courses_banner_image"  => "nullable|file",
            "site_courses_filter_title" => "nullable|string",
            "site_courses_filter_category_title" => "nullable|string",
            "site_courses_filter_rating_title" => "nullable|string",
            "site_courses_filter_price_title" => "nullable|string",
            "site_courses_filter_level_title" => "nullable|string",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_courses_banner_image",
        ];

        return $this->saveItems($field_rules, $image_fields);
    }

    /**
     * Course details meta form
     *
     * @return Application|Factory|View
     */
    public function getCourseDetailsPage()
    {
        $options = getKeyValueArray([
            "site_course_details_title",
            "site_course_details_sub_title",
            "site_course_details_description",
            "site_course_details_keywords",
            "site_course_details_banner_image",
        ]);

        return view("dashboard.setting-inner-page.course_details", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveCourseDetailsPage()
    {
        $field_rules = [
            "site_course_details_title" => "nullable|string",
            "site_course_details_sub_title" => "nullable|string",
            "site_course_details_description" => "nullable|string",
            "site_course_details_keywords" => "nullable|string",
            "site_course_details_banner_image"  => "nullable|file",
        ];
        request()->validate($field_rules);
        // set image fields
        $image_fields = [
            "site_course_details_banner_image",
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
    public function getEventsListPage()
    {
        $options = getKeyValueArray([
            "site_events_title",
            "site_events_sub_title",
            "site_events_description",
            "site_events_keywords",
            "site_events_form_title",
            "site_events_form_btn_title",
            "site_events_form_btn_url",
            "site_events_banner_image",
        ]);

        return view("dashboard.setting-inner-page.events", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveEventsListPage()
    {
        $field_rules = [
            "site_events_title" => "nullable|string",
            "site_events_sub_title" => "nullable|string",
            "site_events_description" => "nullable|string",
            "site_events_keywords" => "nullable|string",
            "site_events_keywords" => "nullable|string",
            "site_events_form_title" => "nullable|string",
            "site_events_form_btn_title" => "nullable|string",
            "site_events_form_btn_url" => "nullable|string",
            "site_events_banner_image"  => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_events_banner_image",
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
    public function getFailedPaymentPage()
    {
        $options = getKeyValueArray([
            "site_failed_title",
            "site_failed_sub_title",
            "site_failed_description",
            "site_failed_keywords",
            "site_failed_message",
            "site_failed_btn_text",
            "site_failed_btn_url",
            "site_failed_banner_image",
        ]);

        return view("dashboard.setting-inner-page.failed_payment", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveFailedPaymentPage()
    {
        $field_rules = [
            "site_failed_title" => "nullable|string",
            "site_failed_sub_title" => "nullable|string",
            "site_failed_description" => "nullable|string",
            "site_failed_keywords" => "nullable|string",
            "site_failed_message" => "nullable|string",
            "site_failed_btn_text" => "nullable|string",
            "site_failed_btn_url" => "nullable|string",
            "site_failed_banner_image"  => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_failed_banner_image",
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
    public function getThankyouPage()
    {
        $options = getKeyValueArray([
            "site_thankyou_title",
            "site_thankyou_sub_title",
            "site_thankyou_description",
            "site_thankyou_keywords",
            "site_thankyou_message",
            "site_thankyou_btn_text",
            "site_thankyou_btn_url",
            "site_thankyou_banner_image",
        ]);

        return view("dashboard.setting-inner-page.thankyou", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveThankyouPage()
    {
        $field_rules = [
            "site_thankyou_title" => "nullable|string",
            "site_thankyou_sub_title" => "nullable|string",
            "site_thankyou_description" => "nullable|string",
            "site_thankyou_keywords" => "nullable|string",
            "site_thankyou_message" => "nullable|string",
            "site_thankyou_btn_text" => "nullable|string",
            "site_thankyou_btn_url" => "nullable|string",
            "site_thankyou_banner_image"  => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_thankyou_banner_image",
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
    public function getBlogsPage()
    {
        $options = getKeyValueArray([
            "site_blogs_title",
            "site_blogs_sub_title",
            "site_blogs_banner_image",
            "site_blogs_description",
            "site_blogs_keywords",
        ]);

        return view("dashboard.setting-inner-page.blogs", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveBlogsPage()
    {
        $field_rules = [
            "site_blogs_title" => "nullable|string",
            "site_blogs_sub_title" => "nullable|string",
            "site_blogs_description" => "nullable|string",
            "site_blogs_keywords" => "nullable|string",
            "site_blogs_banner_image"  => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_blogs_banner_image",
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
    public function getBlogDetailsPage()
    {
        $options = getKeyValueArray([
            "site_blog_details_title",
            "site_blog_details_sub_title",
            "site_blog_details_banner_image",
            "site_blog_details_description",
            "site_blog_details_keywords",
        ]);

        return view("dashboard.setting-inner-page.blog_details", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveBlogDetailsPage()
    {
        $field_rules = [
            "site_blog_details_title" => "nullable|string",
            "site_blog_details_sub_title" => "nullable|string",
            "site_blog_details_description" => "nullable|string",
            "site_blog_details_keywords" => "nullable|string",
            "site_blog_details_banner_image"  => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_blog_details_banner_image",
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
    public function getEventDetailsPage()
    {
        $options = getKeyValueArray([
            "site_event_details_title",
            "site_event_details_sub_title",
            "site_event_details_banner_image",
            "site_event_details_description",
            "site_event_details_keywords",
        ]);

        return view("dashboard.setting-inner-page.event_details", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveEventDetailsPage()
    {
        $field_rules = [
            "site_event_details_title" => "nullable|string",
            "site_event_details_sub_title" => "nullable|string",
            "site_event_details_description" => "nullable|string",
            "site_event_details_keywords" => "nullable|string",
            "site_event_details_banner_image"  => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_event_details_banner_image",
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
    public function getFaqListPage()
    {
        $options = getKeyValueArray([
            "site_faq_title",
            "site_faq_sub_title",
            "site_faq_description",
            "site_faq_keywords",
            "site_faq_banner_image",
        ]);

        return view("dashboard.setting-inner-page.faqs", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveFaqListPage()
    {
        $field_rules = [
            "site_faq_title" => "nullable|string",
            "site_faq_sub_title" => "nullable|string",
            "site_faq_description" => "nullable|string",
            "site_faq_keywords" => "nullable|string",
            "site_faq_banner_image"  => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_faq_banner_image",
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
    public function getMembershipPage()
    {
        $options = getKeyValueArray([
            "site_membership_title",
            "site_membership_sub_title",
            "site_membership_banner_image",
            "site_membership_description",
            "site_membership_keywords",
            "site_membership_package_title",
            "site_membership_btn_text",
            "site_membership_btn_url",
            "site_membership_package_description",
        ]);

        return view("dashboard.setting-inner-page.membership", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveMembershipPage()
    {
        $field_rules = [
            "site_membership_title" => "nullable|string",
            "site_membership_sub_title" => "nullable|string",
            "site_membership_description" => "nullable|string",
            "site_membership_keywords" => "nullable|string",
            "site_membership_package_title" => "nullable|string",
            "site_membership_package_description" => "nullable|string",
            "site_membership_btn_text" => "nullable|string",
            "site_membership_btn_url" => "nullable|string",
            "site_membership_banner_image"  => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_membership_banner_image",
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
    public function getFaqDetailsPage()
    {
        $options = getKeyValueArray([
            "site_faq_details_title",
            "site_faq_details_sub_title",
            "site_faq_details_description",
            "site_faq_details_keywords",
            "site_faq_details_banner_image",
        ]);

        return view("dashboard.setting-inner-page.faq_details", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveFaqDetailsPage()
    {
        $field_rules = [
            "site_faq_details_title" => "nullable|string",
            "site_faq_details_sub_title" => "nullable|string",
            "site_faq_details_description" => "nullable|string",
            "site_faq_details_keywords" => "nullable|string",
            "site_faq_details_banner_image"  => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_faq_details_banner_image",
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
    public function getInstructorsListPage()
    {
        $options = getKeyValueArray([
            "site_instructors_title",
            "site_instructors_sub_title",
            "site_instructors_description",
            "site_instructors_keywords",
            "site_instructors_banner_image",
        ]);

        return view("dashboard.setting-inner-page.instructors_list", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveInstructorsListPage()
    {
        $field_rules = [
            "site_instructors_title" => "nullable|string",
            "site_instructors_sub_title" => "nullable|string",
            "site_instructors_description" => "nullable|string",
            "site_instructors_keywords" => "nullable|string",
            "site_instructors_banner_image"  => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_instructors_banner_image",
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
    public function getInstructorDetailsPage()
    {
        $options = getKeyValueArray([
            "site_instructor_details_title",
            "site_instructor_details_sub_title",
            "site_instructor_details_description",
            "site_instructor_details_keywords",
            "site_instructor_details_banner_image",
        ]);

        return view("dashboard.setting-inner-page.instructor_details", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveInstructorDetailsPage()
    {
        $field_rules = [
            "site_instructor_details_title" => "nullable|string",
            "site_instructor_details_sub_title" => "nullable|string",
            "site_instructor_details_description" => "nullable|string",
            "site_instructor_details_keywords" => "nullable|string",
            "site_instructor_details_banner_image"  => "nullable|file",
        ];

        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_instructor_details_banner_image",
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
    public function getContactPage()
    {
        $options = getKeyValueArray([
            "site_contact_title",
            "site_contact_sub_title",
            "site_contact_description",
            "site_contact_keywords",
            "site_contact_banner_image",
            "site_contact_info_title",
            "site_contact_btn_text",
            "site_contact_phone_title",
            "site_contact_email_title",
            "site_contact_phone_icon",
            "site_contact_email_icon",
            "site_contact_location_icon", 
            "site_contact_location_title", 
            "site_contact_location_address",
            "site_contact_phone_numbers",
            "site_contact_emails",
        ]);

        return view("dashboard.setting-inner-page.contact", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveContactPage()
    {
        $field_rules = [
            "site_contact_title" => "nullable|string",
            "site_contact_sub_title" => "nullable|string",
            "site_contact_description" => "nullable|string",
            "site_contact_keywords" => "nullable|string",
            "site_contact_info_title" => "nullable|string",
            "site_contact_btn_text" => "nullable|string",
            "site_contact_phone_title" => "nullable|string",
            "site_contact_email_title" => "nullable|string",
            "site_contact_phone_icon" => "nullable|file",
            "site_contact_email_icon" => "nullable|file",
            "site_contact_location_icon" => "nullable|file",
            "site_contact_banner_image" => "nullable|file",
            "site_contact_location_title" => "nullable|string",
            "site_contact_location_address" => "nullable|string",
        ];

        request()->validate($field_rules);

        // save phone repeater field data
        $repeater_save_data = [
            "site_contact_phone_numbers" => json_encode(request()->get("site_contact_phone_numbers")),
        ];

        $saved = setKeyValueArray($repeater_save_data, true);

        // save email repeater field data
        $repeater_email_save_data = [
            "site_contact_emails" => json_encode(request()->get("site_contact_emails")),
        ];

        $saved = setKeyValueArray($repeater_email_save_data, true);

        // set image fields
        $image_fields = [
            "site_contact_phone_icon",
            "site_contact_email_icon",
            "site_contact_location_icon",
            "site_contact_banner_image",
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
    public function getWishlistPage()
    {
        $options = getKeyValueArray([
            "site_wishlist_title",
            "site_wishlis_sub_title",
            "site_wishlis_description",
            "site_wishlis_keywords",
            "site_wishlis_banner_image",
        ]);

        return view("dashboard.setting-inner-page.wishlist", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function saveWishlistPage()
    {
        $field_rules = [
            "site_wishlist_title" => "nullable|string",
            "site_wishlis_sub_title" => "nullable|string",
            "site_wishlis_description" => "nullable|string",
            "site_wishlis_keywords" => "nullable|string",
            "site_wishlis_banner_image" => "nullable|file",
        ];
        
        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_wishlis_banner_image",
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
    public function get404Page()
    {
        $options = getKeyValueArray([
            "site_404_title",
            "site_404_sub_title",
            "site_404_description",
            "site_404_keywords",
            "site_404_banner_image",
            "site_404_logo",
            "site_404_details",
            "site_404_btn_text",
            "site_404_btn_url",
        ]);

        return view("dashboard.setting-inner-page.404_page", compact("options"));
    }

    /**
     * @param $customerId
     * @param $customerUniqId
     * @param $orderId
     * @param $orderUniqId
     *
     * @return Application|Factory|View
     */
    public function save404Page()
    {
        $field_rules = [
            "site_404_title" => "nullable|string",
            "site_404_sub_title" => "nullable|string",
            "site_404_description" => "nullable|string",
            "site_404_keywords" => "nullable|string",
            "site_404_details" => "nullable|string",
            "site_404_btn_text" => "nullable|string",
            "site_404_btn_url" => "nullable|string",
            "site_404_banner_image" => "nullable|file",
            "site_404_logo" => "nullable|file",
        ];
        
        request()->validate($field_rules);

        // set image fields
        $image_fields = [
            "site_404_banner_image",
            "site_404_logo",
        ];
        return $this->saveItems($field_rules, $image_fields);
    }
}
