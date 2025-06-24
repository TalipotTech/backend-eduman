@extends('layouts.master')

@php
$page_title = __("Homepage-01 Testimonials");
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
    $home_01_testimonial_title = !empty($options["home_01_testimonial_title"]) ? json_decode($options["home_01_testimonial_title"], true) : [];
    $home_01_testimonial_name = !empty($options["home_01_testimonial_name"]) ? json_decode($options["home_01_testimonial_name"], true) : [];
    $home_01_testimonial_message = !empty($options["home_01_testimonial_message"]) ? json_decode($options["home_01_testimonial_message"], true) : [];
    $home_01_testimonial_rating = !empty($options["home_01_testimonial_rating"]) ? json_decode($options["home_01_testimonial_rating"], true) : [];
    $home_01_testimonial_designation = !empty($options["home_01_testimonial_designation"]) ? json_decode($options["home_01_testimonial_designation"], true) : [];
    $home_01_testimonial_profile_img = !empty($options["home_01_testimonial_profile_img"]) ? json_decode($options["home_01_testimonial_profile_img"], true) : [];
@endphp

<form method="POST" action="{{ route('dashboard.settings.page.home-01.testimonial') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("home_01_section_title"),
                    "name" => "home_01_section_title",
                    "type" => "text",
                    "value" => $options["home_01_section_title"] ?? "",
                ])
                <div class="item-container">
                    @forelse ($home_01_testimonial_title ?? [] as $key => $title)
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("home_01_testimonial_title"),
                                "name" => "home_01_testimonial_title[]",
                                "type" => "text",
                                "value" => $home_01_testimonial_title[$key] ?? "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_testimonial_name"),
                                "name" => "home_01_testimonial_name[]",
                                "type" => "text",
                                "value" => $home_01_testimonial_name[$key] ?? "",
                            ])
                            @include("partials.inputs.textarea", [
                                "label" => __("home_01_testimonial_message"),
                                "name" => "home_01_testimonial_message[]",
                                "type" => "html",
                                "value" => $home_01_testimonial_message[$key] ?? "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_testimonial_rating"),
                                "name" => "home_01_testimonial_rating[]",
                                "type" => "text",
                                "value" => $home_01_testimonial_rating[$key] ?? "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_testimonial_designation"),
                                "name" => "home_01_testimonial_designation[]",
                                "type" => "text",
                                "value" => $home_01_testimonial_designation[$key] ?? "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_01_testimonial_profile_img"),
                                "name" => "home_01_testimonial_profile_img[]",
                                "value" => $home_01_testimonial_profile_img[$key] ?? "",
                            ])
                        </div>
                    @empty
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("home_01_testimonial_title"),
                                "name" => "home_01_testimonial_title[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_testimonial_name"),
                                "name" => "home_01_testimonial_name[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.textarea", [
                                "label" => __("home_01_testimonial_message"),
                                "name" => "home_01_testimonial_message[]",
                                "type" => "html",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_testimonial_rating"),
                                "name" => "home_01_testimonial_rating[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_testimonial_designation"),
                                "name" => "home_01_testimonial_designation[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_01_testimonial_profile_img"),
                                "name" => "home_01_testimonial_profile_img[]",
                                "value" => "",
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
                                "label" => __("home_01_testimonial_title"),
                                "name" => "home_01_testimonial_title[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_testimonial_name"),
                                "name" => "home_01_testimonial_name[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.textarea", [
                                "label" => __("home_01_testimonial_message"),
                                "name" => "home_01_testimonial_message[]",
                                "type" => "html",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_testimonial_rating"),
                                "name" => "home_01_testimonial_rating[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_testimonial_designation"),
                                "name" => "home_01_testimonial_designation[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_01_testimonial_profile_img"),
                                "name" => "home_01_testimonial_profile_img[]",
                                "value" => "",
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