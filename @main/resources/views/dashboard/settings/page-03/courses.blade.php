@extends('layouts.master')

@php
$page_title = __("Homepage-03 Courses");
@endphp

@section('title') {{ $page_title }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        $page_title => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ "$page_title " . __("Settings") }}</h4>
</div>

<form method="POST" action="{{ route('dashboard.settings.page.home-03.course') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("home_03_course_section_title"),
                    "name" => "home_03_course_section_title",
                    "type" => "text",
                    "value" => !empty($options["home_03_course_section_title"])
                                ? str_replace("<br/>", "[br]", $options["home_03_course_section_title"])
                                : "",
                    "hint" => __("Use") . " <kbd>" . "[br]" . "</kbd> " . __("to break line")
                ])
                @include("partials.inputs.input", [
                    "label" => __("home_03_course_btn_text"),
                    "name" => "home_03_course_btn_text",
                    "type" => "text",
                    "value" => $options["home_03_course_btn_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("home_03_course_btn_url"),
                    "name" => "home_03_course_btn_url",
                    "type" => "text",
                    "value" => $options["home_03_course_btn_url"] ?? "",
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
    <x-utils.swal-js />
    <x-utils.datatable.js />
    <x-tinymce.init />
@endsection
