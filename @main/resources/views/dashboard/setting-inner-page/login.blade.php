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
<form method="POST" action="{{ route('dashboard.inner_page_settings.login') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("site_login_title"),
                    "name" => "site_login_title",
                    "type" => "text",
                    "value" => $options["site_login_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_login_sub_title"),
                    "name" => "site_login_sub_title",
                    "type" => "text",
                    "value" => $options["site_login_sub_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_login_description"),
                    "name" => "site_login_description",
                    "type" => "text",
                    "value" => $options["site_login_description"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_login_keywords"),
                    "name" => "site_login_keywords",
                    "type" => "text",
                    "value" => $options["site_login_keywords"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_login_check_text"),
                    "name" => "site_login_check_text",
                    "type" => "text",
                    "value" => $options["site_login_check_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_login_signin_text"),
                    "name" => "site_login_signin_text",
                    "type" => "text",
                    "value" => $options["site_login_signin_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_login_signup_text"),
                    "name" => "site_login_signup_text",
                    "type" => "text",
                    "value" => $options["site_login_signup_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_login_register_text"),
                    "name" => "site_login_register_text",
                    "type" => "text",
                    "value" => $options["site_login_register_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_login_forget_text"),
                    "name" => "site_login_forget_text",
                    "type" => "text",
                    "value" => $options["site_login_forget_text"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_login_img"),
                    "name" => "site_login_img",
                    "value" => $options["site_login_img"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_login_banner_image"),
                    "name" => "site_login_banner_image",
                    "value" => $options["site_login_banner_image"] ?? "",
                ])
                @include("partials.inputs.save-btn", [
                    "label" => __("Save Settings")
                ])
            </div>
        </div>
    </div>
</form>
@endsection