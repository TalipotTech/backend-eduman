@extends('layouts.master')

@php
$page_title = __("Page Setting");
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
<form method="POST" action="{{ route('dashboard.inner_page_settings.thankyou') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("site_thankyou_title"),
                    "name" => "site_thankyou_title",
                    "type" => "text",
                    "value" => $options["site_thankyou_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_thankyou_sub_title"),
                    "name" => "site_thankyou_sub_title",
                    "type" => "text",
                    "value" => $options["site_thankyou_sub_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_thankyou_description"),
                    "name" => "site_thankyou_description",
                    "type" => "text",
                    "value" => $options["site_thankyou_description"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_thankyou_keywords"),
                    "name" => "site_thankyou_keywords",
                    "type" => "text",
                    "value" => $options["site_thankyou_keywords"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_thankyou_message"),
                    "name" => "site_thankyou_message",
                    "type" => "text",
                    "value" => $options["site_thankyou_message"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_thankyou_btn_text"),
                    "name" => "site_thankyou_btn_text",
                    "type" => "text",
                    "value" => $options["site_thankyou_btn_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_thankyou_btn_url"),
                    "name" => "site_thankyou_btn_url",
                    "type" => "text",
                    "value" => $options["site_thankyou_btn_url"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_thankyou_banner_image"),
                    "name" => "site_thankyou_banner_image",
                    "value" => $options["site_thankyou_banner_image"] ?? "",
                ])
                @include("partials.inputs.save-btn", [
                    "label" => __("Save Settings")
                ])
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
    <x-tinymce.init />
@endsection