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
<form method="POST" action="{{ route('dashboard.inner_page_settings.about') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("site_about_blog_category"),
                    "name" => "site_about_blog_category",
                    "type" => "text",
                    "value" => $options["site_about_blog_category"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_title"),
                    "name" => "site_about_title",
                    "type" => "text",
                    "value" => $options["site_about_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_sub_title"),
                    "name" => "site_about_sub_title",
                    "type" => "text",
                    "value" => $options["site_about_sub_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_description"),
                    "name" => "site_about_description",
                    "type" => "text",
                    "value" => $options["site_about_description"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_keywords"),
                    "name" => "site_about_keywords",
                    "type" => "text",
                    "value" => $options["site_about_keywords"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_feature_title"),
                    "name" => "site_about_feature_title",
                    "type" => "text",
                    "value" => $options["site_about_feature_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_intro_video"),
                    "name" => "site_about_intro_video",
                    "type" => "text",
                    "value" => $options["site_about_intro_video"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_intro_btn_text"),
                    "name" => "site_about_intro_btn_text",
                    "type" => "text",
                    "value" => $options["site_about_intro_btn_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_intro_promo_text"),
                    "name" => "site_about_intro_promo_text",
                    "type" => "text",
                    "value" => $options["site_about_intro_promo_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_intro_promo_text2"),
                    "name" => "site_about_intro_promo_text2",
                    "type" => "text",
                    "value" => $options["site_about_intro_promo_text2"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_blog_title"),
                    "name" => "site_about_blog_title",
                    "type" => "text",
                    "value" => $options["site_about_blog_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_blog_description"),
                    "name" => "site_about_blog_description",
                    "type" => "text",
                    "value" => $options["site_about_blog_description"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_instructor_title"),
                    "name" => "site_about_instructor_title",
                    "type" => "text",
                    "value" => $options["site_about_instructor_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_instructor_description"),
                    "name" => "site_about_instructor_description",
                    "type" => "text",
                    "value" => $options["site_about_instructor_description"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_instructor_btn_text"),
                    "name" => "site_about_instructor_btn_text",
                    "type" => "text",
                    "value" => $options["site_about_instructor_btn_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_about_instructor_btn_url"),
                    "name" => "site_about_instructor_btn_url",
                    "type" => "text",
                    "value" => $options["site_about_instructor_btn_url"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_about_banner_image"),
                    "name" => "site_about_banner_image",
                    "value" => $options["site_about_banner_image"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_about_intro_video_image"),
                    "name" => "site_about_intro_video_image",
                    "value" => $options["site_about_intro_video_image"] ?? "",
                ])
                @include("partials.inputs.save-btn", [
                    "label" => __("Save Settings")
                ])
            </div>
        </div>
    </div>
</form>
@endsection