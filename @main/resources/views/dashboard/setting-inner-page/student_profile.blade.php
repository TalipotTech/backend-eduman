@extends('layouts.master')

@php
$page_title = __("Site Setting");
@endphp

@section('title') {{ $page_title }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Setting") => route("dashboard.event.list"),
        $page_title => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ "$page_title " . __("Settings") }}</h4>
</div>
<form method="POST" action="{{ route('dashboard.inner_page_settings.student_profile') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("site_student_profile_title"),
                    "name" => "site_student_profile_title",
                    "type" => "text",
                    "value" => $options["site_student_profile_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_student_profile_sub_title"),
                    "name" => "site_student_profile_sub_title",
                    "type" => "text",
                    "value" => $options["site_student_profile_sub_title"] ?? "",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("site_student_profile_description"),
                    "name" => "site_student_profile_description",
                    "type" => "html",
                    "value" => $options["site_student_profile_description"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_student_profile_keywords"),
                    "name" => "site_student_profile_keywords",
                    "type" => "text",
                    "value" => $options["site_student_profile_keywords"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_student_profile_tab_dashboard_text"),
                    "name" => "site_student_profile_tab_dashboard_text",
                    "type" => "text",
                    "value" => $options["site_student_profile_tab_dashboard_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_student_profile_tab_profile_text"),
                    "name" => "site_student_profile_tab_profile_text",
                    "type" => "text",
                    "value" => $options["site_student_profile_tab_profile_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_student_profile_tab_enroll_course_text"),
                    "name" => "site_student_profile_tab_enroll_course_text",
                    "type" => "text",
                    "value" => $options["site_student_profile_tab_enroll_course_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_student_profile_tab_wishlist_text"),
                    "name" => "site_student_profile_tab_wishlist_text",
                    "type" => "text",
                    "value" => $options["site_student_profile_tab_wishlist_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_student_profile_tab_review_text"),
                    "name" => "site_student_profile_tab_review_text",
                    "type" => "text",
                    "value" => $options["site_student_profile_tab_review_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_student_profile_tab_quiz_text"),
                    "name" => "site_student_profile_tab_quiz_text",
                    "type" => "text",
                    "value" => $options["site_student_profile_tab_quiz_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_student_profile_tab_order_history_text"),
                    "name" => "site_student_profile_tab_order_history_text",
                    "type" => "text",
                    "value" => $options["site_student_profile_tab_order_history_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_student_profile_tab_setting_text"),
                    "name" => "site_student_profile_tab_setting_text",
                    "type" => "text",
                    "value" => $options["site_student_profile_tab_setting_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_student_profile_tab_logout_text"),
                    "name" => "site_student_profile_tab_logout_text",
                    "type" => "text",
                    "value" => $options["site_student_profile_tab_logout_text"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_student_profile_banner_image"),
                    "name" => "site_student_profile_banner_image",
                    "value" => $options["site_student_profile_banner_image"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_student_profile_img"),
                    "name" => "site_student_profile_img",
                    "value" => $options["site_student_profile_img"] ?? "",
                ])
                @include("partials.inputs.save-btn", [
                    "label" => __("Save Settings")
                ])
            </div>
        </div>
    </div>
</form>
@endsection