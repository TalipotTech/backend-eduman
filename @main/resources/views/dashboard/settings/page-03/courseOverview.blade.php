@extends('layouts.master')

@php
$page_title = __("Homepage-03 Header");
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
@php
    $home_03_course_overview_features = !empty($options["home_03_course_overview_features"]) ? json_decode($options["home_03_course_overview_features"]) : [];
    $home_03_course_overview_description = !empty($options["home_03_course_overview_description"]) ? json_decode($options["home_03_course_overview_description"]) : [];
    $home_03_course_overview_image = !empty($options["home_03_course_overview_image"]) ? json_decode($options["home_03_course_overview_image"]) : [];
@endphp
<form method="POST" action="{{ route('dashboard.settings.page.home-03.course-overview') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("home_03_course_overview_sub_title"),
                    "name" => "home_03_course_overview_sub_title",
                    "type" => "text",
                    "value" => $options["home_03_course_overview_sub_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("home_03_course_overview_title"),
                    "name" => "home_03_course_overview_title",
                    "type" => "text",
                    "value" => $options["home_03_course_overview_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("home_03_course_overview_button_text"),
                    "name" => "home_03_course_overview_button_text",
                    "type" => "text",
                    "value" => $options["home_03_course_overview_button_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("home_03_course_overview_button_url"),
                    "name" => "home_03_course_overview_button_url",
                    "type" => "text",
                    "value" => $options["home_03_course_overview_button_url"] ?? "",
                ])
                <div class="item-container">
                    @forelse ($home_03_course_overview_features ?? [] as $key => $item)
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("home_03_course_overview_features"),
                                "name" => "home_03_course_overview_features[]",
                                "type" => "text",
                                "value" => $item ?? "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_03_course_overview_description"),
                                "name" => "home_03_course_overview_description[]",
                                "type" => "text",
                                "value" => $home_03_course_overview_description[$key] ?? "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_03_course_overview_image"),
                                "name" => "home_03_course_overview_image[]",
                                "value" => $home_03_course_overview_image[$key] ?? "",
                            ])
                        </div>
                    @empty
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("home_03_course_overview_features"),
                                "name" => "home_03_course_overview_features[]",
                                "type" => "text",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_03_course_overview_description"),
                                "name" => "home_03_course_overview_description[]",
                                "type" => "text",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_03_course_overview_image"),
                                "name" => "home_03_course_overview_image[]",
                            ])
                        </div>
                    @endforelse
                </div>
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
    <script>
        (function ($) {
            "use strict"

            $(document).ready(function () {
                $(document).on("click", ".add_item", function () {
                    $(this).closest(".item-container").append(`
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("home_03_course_overview_features"),
                                "name" => "home_03_course_overview_features[]",
                                "type" => "text",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_03_course_overview_description"),
                                "name" => "home_03_course_overview_description",
                                "type" => "text",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_03_course_overview_image"),
                                "name" => "home_03_course_overview_image[]",
                            ])
                        </div>
                    `)
                });

                $(document).on("click", ".remove_item", function (e) {
                    let repeater = $(this).closest(".repeater");
                    $(repeater).slideUp("slow", function () {
                        $(repeater).remove();
                    })
                });
            })
        })(jQuery)
    </script>
@endsection
