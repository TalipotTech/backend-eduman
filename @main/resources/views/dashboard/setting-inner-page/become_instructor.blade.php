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
@php
$site_become_instructor_tab_titles = !empty($options["site_become_instructor_tab_titles"]) ? json_decode($options["site_become_instructor_tab_titles"]) : [];
$site_become_instructor_tab_contents = !empty($options["site_become_instructor_tab_contents"]) ? json_decode($options["site_become_instructor_tab_contents"]) : [];
$site_become_instructor_tab_images = !empty($options["site_become_instructor_tab_images"]) ? (array)json_decode($options["site_become_instructor_tab_images"]) : [];
@endphp
<form method="POST" action="{{ route('dashboard.inner_page_settings.become_instructor') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("site_become_instructor_title"),
                    "name" => "site_become_instructor_title",
                    "type" => "text",
                    "value" => $options["site_become_instructor_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_become_instructor_sub_title"),
                    "name" => "site_become_instructor_sub_title",
                    "type" => "text",
                    "value" => $options["site_become_instructor_sub_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_become_instructor_description"),
                    "name" => "site_become_instructor_description",
                    "type" => "text",
                    "value" => $options["site_become_instructor_description"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_become_instructor_keywords"),
                    "name" => "site_become_instructor_keywords",
                    "type" => "text",
                    "value" => $options["site_become_instructor_keywords"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_become_instructor_section_title"),
                    "name" => "site_become_instructor_section_title",
                    "type" => "text",
                    "value" => $options["site_become_instructor_section_title"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_become_instructor_banner_image"),
                    "name" => "site_become_instructor_banner_image",
                    "value" => $options["site_become_instructor_banner_image"] ?? "",
                ])
            
                {{-- ========== repeater start ========== --}}
                <div class="item-container">
                    @forelse ($site_become_instructor_tab_titles ?? [] as $key => $item)
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("site_become_instructor_tab_titles"),
                                "name" => "site_become_instructor_tab_titles[]",
                                "type" => "text",
                                "value" => $item ?? "",
                            ])
                            @include("partials.inputs.textarea", [
                                "label" => __("site_become_instructor_tab_contents"),
                                "name" => "site_become_instructor_tab_contents[]",
                                "type" => "html",
                                "value" => $site_become_instructor_tab_contents[$key] ?? "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("site_become_instructor_tab_images"),
                                "name" => "site_become_instructor_tab_images[]",
                                "value" => $site_become_instructor_tab_images[$key] ?? "",
                            ])
                        </div>
                    @empty
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("site_become_instructor_tab_titles"),
                                "name" => "site_become_instructor_tab_titles[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.textarea", [
                                "label" => __("site_become_instructor_tab_contents"),
                                "name" => "site_become_instructor_tab_contents[]",
                                "type" => "html",
                                "value" => "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("site_become_instructor_tab_images"),
                                "name" => "site_become_instructor_tab_images[]",
                                "value" => "",
                            ])
                        </div>
                    @endforelse
                </div>
                {{-- ========== repeater - end ========== --}}
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
                // Add
                $(document).on("click", ".add_item", function () {
                    $(this).closest(".item-container").append(`
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("site_become_instructor_tab_titles"),
                                "name" => "site_become_instructor_tab_titles[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.textarea", [
                                "label" => __("site_become_instructor_tab_contents"),
                                "name" => "site_become_instructor_tab_contents[]",
                                "type" => "html",
                                "value" => "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("site_become_instructor_tab_images"),
                                "name" => "site_become_instructor_tab_images[]",
                                "value" => "",
                            ])
                        </div>
                    `)
                });
                // Remove
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