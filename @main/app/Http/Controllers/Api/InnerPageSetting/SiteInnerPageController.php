<?php

namespace App\Http\Controllers\Api\InnerPageSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteInnerPageController extends Controller
{
    /**
     * @OA\Get(
     *    path="/setting/inner-page/login",
     *    operationId="getLoginPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get inner login page settting",
     *    description="Get inner login page settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getLoginPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_login_title",
            "site_login_sub_title",
            "site_login_description",
            "site_login_keywords",
            "site_login_img",
            "site_login_check_text",
            "site_login_signin_text",
            "site_login_signup_text",
            "site_login_register_text",
            "site_login_forget_text",
            "site_login_banner_img",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/forget-password",
     *    operationId="getForgetPasswordPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get inner forget password settting",
     *    description="Get inner forget password settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getForgetPasswordPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_forget_pass_title",
            "site_forget_pass_sub_title",
            "site_forget_pass_description",
            "site_forget_pass_keywords",
            "site_forget_pass_banner_img",
            "site_forget_pass_img",
            "site_forget_pass_text",
            "site_forget_pass_signin_btn_text",
            "site_forget_pass_back_text",
            "site_forget_pass_email_text",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/signup",
     *    operationId="getSignUpPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get inner signup page settting",
     *    description="Get inner signup page settting",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getSignUpPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_signup_title",
            "site_signup_sub_title",
            "site_signup_description",
            "site_signup_keywords",
            "site_signup_banner_img",
            "site_signup_img",
            "site_signup_policy_text",
            "site_signup_back_text", 
            "site_signup_btn_text", 
            "site_signup_btn_url",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/contact",
     *    operationId="getContactPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner contact page",
     *    description="Get settting of inner contact page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getContactPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_contact_title",
            "site_contact_sub_title",
            "site_contact_description",
            "site_contact_keywords",
            "site_contact_banner_image",
            "site_contact_info_title",
            "site_contact_btn_text",
            "site_contact_phone_title",
            "site_contact_phone_icon",
            "site_contact_email_title",
            "site_contact_email_icon",
            "site_contact_location_title",
            "site_contact_location_icon",
            "site_contact_location_address",
            "site_contact_phone_numbers.*",
            "site_contact_emails.*",
        ]);

        $reapeter_phone_header_info = getKeyValueArray([
            "site_contact_phone_numbers",
        ]);
        $format_phone_from_to = [
            "site_contact_phone_numbers" => "number",
        ];
        $formatted_phone_data = $this->formatRepeater($reapeter_phone_header_info, $format_phone_from_to);
        $header_info["numbers"] = $formatted_phone_data;

        $reapeter_email_header_info = getKeyValueArray([
            "site_contact_emails",
        ]);
        $format_email_from_to = [
            "site_contact_emails" => "email",
        ];
        $formatted_email_data = $this->formatRepeater($reapeter_email_header_info, $format_email_from_to);
        $header_info["emails"] = $formatted_email_data;

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/course",
     *    operationId="getCoursePage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner course page",
     *    description="Get settting of inner course page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getCoursePage(Request $request)
    {
        $header_info = getKeyValueArray([
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

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/course-details",
     *    operationId="getCourseDetailsPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner course details page",
     *    description="Get settting of inner course details page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getCourseDetailsPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_course_details_title",
            "site_course_details_sub_title",
            "site_course_details_description",
            "site_course_details_keywords",
            "site_course_details_banner_image",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/checkout",
     *    operationId="getCheckoutPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner checkout page",
     *    description="Get settting of inner checkout page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getCheckoutPage(Request $request)
    {
        $header_info = getKeyValueArray([
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

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/cart",
     *    operationId="getCartPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner cart page",
     *    description="Get settting of inner cart page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getCartPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_cart_title",
            "site_cart_sub_title",
            "site_cart_description",
            "site_cart_keywords",
            "site_cart_banner_image",
            "site_cart_btn_text",
            "site_cart_btn_url",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/about",
     *    operationId="getAboutPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner about page",
     *    description="Get settting of inner about page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getAboutPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_about_title",
            "site_about_sub_title",
            "site_about_description",
            "site_about_keywords",
            "site_about_banner_image",
            "site_about_feature_title",
            "site_about_intro_video",
            "site_about_intro_btn_text",
            "site_about_intro_promo_text",
            "site_about_intro_promo_text2",
            "site_about_blog_category",
            "site_about_blog_title",
            "site_about_blog_description",
            "site_about_instructor_title",
            "site_about_instructor_description",
            "site_about_instructor_btn_text",
            "site_about_instructor_btn_url",
            "site_about_intro_video_image",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/instructors",
     *    operationId="getInstructorsListPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner webinar details page",
     *    description="Get settting of inner webinar details page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getInstructorsListPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_instructors_title",
            "site_instructors_sub_title",
            "site_instructors_description",
            "site_instructors_keywords",
            "site_instructors_banner_image",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/instructor-details",
     *    operationId="getInnerInstructorPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner webinar details page",
     *    description="Get settting of inner webinar details page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getInnerInstructorPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_instructor_details_title",
            "site_instructor_details_sub_title",
            "site_instructor_details_description",
            "site_instructor_details_keywords",
            "site_instructor_details_banner_image",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/student-profile",
     *    operationId="getStudentProfilePage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner webinar details page",
     *    description="Get settting of inner webinar details page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getStudentProfilePage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_student_profile_title",
            "site_student_profile_sub_title",
            "site_student_profile_description",
            "site_student_profile_keywords",
            "site_student_profile_banner_image",
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

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/become-instructor",
     *    operationId="getBecomeInstructorPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner become instructor page",
     *    description="Get settting of inner become instructor page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getBecomeInstructorPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_become_instructor_title",
            "site_become_instructor_sub_title",
            "site_become_instructor_description",
            "site_become_instructor_keywords",
            "site_become_instructor_banner_image",
            "site_become_instructor_section_title",
        ]);

        $reapeter_phone_header_info = getKeyValueArray([
            "site_become_instructor_tab_titles",
            "site_become_instructor_tab_contents",
            "site_become_instructor_tab_images",
        ]);
        $format_from_to = [
            "site_become_instructor_tab_titles" => "title",
            "site_become_instructor_tab_contents" => "content",
            "site_become_instructor_tab_images" => "image",
        ];

        $formatted_data = $this->formatRepeater($reapeter_phone_header_info, $format_from_to);
        $header_info["tab_items"] = $formatted_data;

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/blogs",
     *    operationId="getBlogsListPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner blogs page",
     *    description="Get settting of inner blogs page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getBlogsListPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_blogs_title",
            "site_blogs_sub_title",
            "site_blogs_banner_image",
            "site_blogs_description",
            "site_blogs_keywords",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/blog-details",
     *    operationId="getBlogDetailsPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner blog details page",
     *    description="Get settting of inner blog details page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getBlogDetailsPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_blog_details_title",
            "site_blog_details_sub_title",
            "site_blog_details_banner_image",
            "site_blog_details_description",
            "site_blog_details_keywords",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/events",
     *    operationId="getEventsListPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner events page",
     *    description="Get settting of inner events page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getEventsListPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_events_title",
            "site_events_sub_title",
            "site_events_description",
            "site_events_keywords",
            "site_events_banner_image",
            "site_events_form_title",
            "site_events_form_btn_title",
            "site_events_form_btn_url",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/event-details",
     *    operationId="getEventDetailsPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner event details page",
     *    description="Get settting of inner event details page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getEventDetailsPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_event_details_title",
            "site_event_details_sub_title",
            "site_event_details_banner_image",
            "site_event_details_description",
            "site_event_details_keywords",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/faqs",
     *    operationId="getFaqsListPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner faqs page",
     *    description="Get settting of inner faqs page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getFaqsListPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_faq_title",
            "site_faq_sub_title",
            "site_faq_description",
            "site_faq_keywords",
            "site_faq_banner_image",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/faq-details",
     *    operationId="getFaqDetailsPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner faq details page",
     *    description="Get settting of inner faq details page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getFaqDetailsPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_faq_details_title",
            "site_faq_details_sub_title",
            "site_faq_details_description",
            "site_faq_details_keywords",
            "site_faq_details_banner_image",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }
    
    /**
     * @OA\Get(
     *    path="/setting/inner-page/membership",
     *    operationId="getMembershipPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner membership page",
     *    description="Get settting of inner membership page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getMembershipPage(Request $request)
    {
        $header_info = getKeyValueArray([
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

        return response()->json([
            "data" => $header_info,
        ]);
    }
    
    /**
     * @OA\Get(
     *    path="/setting/inner-page/404-page",
     *    operationId="get404Page",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner 404 page",
     *    description="Get settting of inner 404 page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function get404Page(Request $request)
    {
        $header_info = getKeyValueArray([
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

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/failed-payment",
     *    operationId="getFailedPaymentPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of failed payment page",
     *    description="Get settting of failed payment page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getFailedPaymentPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_failed_title",
            "site_failed_sub_title",
            "site_failed_description",
            "site_failed_keywords",
            "site_failed_message",
            "site_failed_btn_text",
            "site_failed_btn_url",
            "site_failed_banner_image",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/thankyou",
     *    operationId="getThankyouPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of thank you page",
     *    description="Get settting of inner thank you page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getThankyouPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_thankyou_title",
            "site_thankyou_sub_title",
            "site_thankyou_description",
            "site_thankyou_keywords",
            "site_thankyou_message",
            "site_thankyou_btn_text",
            "site_thankyou_btn_url",
            "site_thankyou_banner_image",
        ]);

        return response()->json([
            "data" => $header_info,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/setting/inner-page/wishlist",
     *    operationId="getWishlistPage",
     *    tags={"Inner Page Setting"},
     *    summary="Get settting of inner wishlist page",
     *    description="Get settting of inner wishlist page",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getWishlistPage(Request $request)
    {
        $header_info = getKeyValueArray([
            "site_wishlist_title",
            "site_wishlis_sub_title",
            "site_wishlis_description",
            "site_wishlis_keywords",
            "site_wishlis_banner_image",
        ]);

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
