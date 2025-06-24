@extends('layouts.master')

@php
$page_title = __("Homepage-01 Header");
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
$subtitles = !empty($options["home_01_cta_01_subtitle"]) ? json_decode($options["home_01_cta_01_subtitle"]) : [];
$titles = !empty($options["home_01_cta_01_title"]) ? json_decode($options["home_01_cta_01_title"]) : [];
$images = !empty($options["home_01_cta_01_image"]) ? json_decode($options["home_01_cta_01_image"]) : [];
$btn_texts = !empty($options["home_01_cta_01_btn_text"]) ? json_decode($options["home_01_cta_01_btn_text"]) : [];
$btn_urls = !empty($options["home_01_cta_01_btn_url"]) ? json_decode($options["home_01_cta_01_btn_url"]) : [];
@endphp

<form method="POST" action="{{ route('dashboard.settings.page.home-01.cta-01') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                <div class="item-container">
                    @forelse ($subtitles as $key => $subtitle)
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("home_01_cta_01_subtitle"),
                                "name" => "home_01_cta_01_subtitle[]",
                                "type" => "text",
                                "value" => $subtitle ?? "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_cta_01_title"),
                                "name" => "home_01_cta_01_title[]",
                                "type" => "text",
                                "value" => $titles[$key] ?? "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_01_cta_01_image"),
                                "name" => "home_01_cta_01_image[]",
                                "value" => $images[$key] ?? "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_cta_01_btn_text"),
                                "name" => "home_01_cta_01_btn_text[]",
                                "type" => "text",
                                "value" => $btn_texts[$key] ?? "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_cta_01_btn_url"),
                                "name" => "home_01_cta_01_btn_url[]",
                                "type" => "text",
                                "value" => $btn_urls[$key] ?? "",
                            ])
                        </div>
                    @empty
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("home_01_cta_01_subtitle"),
                                "name" => "home_01_cta_01_subtitle[]",
                                "type" => "text",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_cta_01_title"),
                                "name" => "home_01_cta_01_title[]",
                                "type" => "text",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_01_cta_01_image"),
                                "name" => "home_01_cta_01_image[]",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_cta_01_btn_text"),
                                "name" => "home_01_cta_01_btn_text[]",
                                "type" => "text",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_cta_01_btn_url"),
                                "name" => "home_01_cta_01_btn_url[]",
                                "type" => "text",
                            ])
                        </div>
                    @endforelse
                </div>

                {{-- <div class="grid grid-cols-12 sm:gap-x-5">
                    <div class="lg:col-span-6 md:col-span-6 col-span-12">
                        @include("partials.inputs.input", [
                            "label" => __("home_01_cta_01_left_subtitle"),
                            "name" => "home_01_cta_01_left_subtitle",
                            "type" => "text",
                            "value" => $options["home_01_cta_01_left_subtitle"] ?? "",
                        ])
                        @include("partials.inputs.input", [
                            "label" => __("home_01_cta_01_left_title"),
                            "name" => "home_01_cta_01_left_title",
                            "type" => "text",
                            "value" => $options["home_01_cta_01_left_title"] ?? "",
                        ])
                        @include("partials.inputs.file", [
                            "label" => __("home_01_cta_01_left_image"),
                            "name" => "home_01_cta_01_left_image",
                            "value" => $options["home_01_cta_01_left_image"] ?? "",
                        ])
                        @include("partials.inputs.input", [
                            "label" => __("home_01_cta_01_left_btn_text"),
                            "name" => "home_01_cta_01_left_btn_text",
                            "type" => "text",
                            "value" => $options["home_01_cta_01_left_btn_text"] ?? "",
                        ])
                        @include("partials.inputs.input", [
                            "label" => __("home_01_cta_01_left_btn_url"),
                            "name" => "home_01_cta_01_left_btn_url",
                            "type" => "text",
                            "value" => $options["home_01_cta_01_left_btn_url"] ?? "",
                        ])
                    </div>
                    <div class="lg:col-span-6 md:col-span-6 col-span-12">
                        @include("partials.inputs.input", [
                            "label" => __("home_01_cta_01_right_subtitle"),
                            "name" => "home_01_cta_01_right_subtitle",
                            "type" => "text",
                            "value" => $options["home_01_cta_01_right_subtitle"] ?? "",
                        ])
                        @include("partials.inputs.input", [
                            "label" => __("home_01_cta_01_right_title"),
                            "name" => "home_01_cta_01_right_title",
                            "type" => "text",
                            "value" => $options["home_01_cta_01_right_title"] ?? "",
                        ])
                        @include("partials.inputs.file", [
                            "label" => __("home_01_cta_01_right_image"),
                            "name" => "home_01_cta_01_right_image",
                            "value" => $options["home_01_cta_01_right_image"] ?? "",
                        ])
                        @include("partials.inputs.input", [
                            "label" => __("home_01_cta_01_right_btn_text"),
                            "name" => "home_01_cta_01_right_btn_text",
                            "type" => "text",
                            "value" => $options["home_01_cta_01_right_btn_text"] ?? "",
                        ])
                        @include("partials.inputs.input", [
                            "label" => __("home_01_cta_01_right_btn_url"),
                            "name" => "home_01_cta_01_right_btn_url",
                            "type" => "text",
                            "value" => $options["home_01_cta_01_right_btn_url"] ?? "",
                        ])
                    </div>
                </div> --}}



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
                                "label" => __("home_01_cta_01_subtitle"),
                                "name" => "home_01_cta_01_subtitle[]",
                                "type" => "text",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_cta_01_title"),
                                "name" => "home_01_cta_01_title[]",
                                "type" => "text",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_01_cta_01_image"),
                                "name" => "home_01_cta_01_image[]",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_cta_01_btn_text"),
                                "name" => "home_01_cta_01_btn_text[]",
                                "type" => "text",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_cta_01_btn_url"),
                                "name" => "home_01_cta_01_btn_url[]",
                                "type" => "text",
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
