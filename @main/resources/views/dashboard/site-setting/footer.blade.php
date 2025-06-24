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
        __("Setting") => "",
        $page_title => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ "$page_title " . __("Settings") }}</h4>
</div>
@php
$site_footer_social_links = !empty($options["site_footer_social_links"]) ? json_decode($options["site_footer_social_links"]) : [];
$site_footer_social_icons = !empty($options["site_footer_social_icons"]) ? json_decode($options["site_footer_social_icons"]) : [];
@endphp
<form method="POST" action="{{ route('dashboard.site_settings.footer') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("site_footer_menu_1_title"),
                    "name" => "site_footer_menu_1_title",
                    "type" => "text",
                    "value" => $options["site_footer_menu_1_title"] ?? "",
                ])
                @include("partials.inputs.select", [
                    "label" => __("Select Menu"),
                    "name" => "site_footer_menu_1",
                    "options" => $menuNames,
                    "selected" => $options["site_footer_menu_1"] ?? "",
                    "option_value" => "id",
                    "option_display" => "title",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_footer_menu_2_title"),
                    "name" => "site_footer_menu_2_title",
                    "type" => "text",
                    "value" => $options["site_footer_menu_2_title"] ?? "",
                ])
                @include("partials.inputs.select", [
                    "label" => __("Select Menu"),
                    "name" => "site_footer_menu_2",
                    "options" => $menuNames,
                    "selected" => $options["site_footer_menu_2"] ?? "",
                    "option_value" => "id",
                    "option_display" => "title",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_footer_newsletter_title"),
                    "name" => "site_footer_newsletter_title",
                    "type" => "text",
                    "value" => $options["site_footer_newsletter_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_footer_newsletter_message"),
                    "name" => "site_footer_newsletter_message",
                    "type" => "text",
                    "value" => $options["site_footer_newsletter_message"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_footer_newsletter_email"),
                    "name" => "site_footer_newsletter_email",
                    "type" => "text",
                    "value" => $options["site_footer_newsletter_email"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_footer_app_download_title"),
                    "name" => "site_footer_app_download_title",
                    "type" => "text",
                    "value" => $options["site_footer_app_download_title"] ?? "",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("site_footer_about_company"),
                    "name" => "site_footer_about_company",
                    "type" => "html",
                    "value" => $options["site_footer_about_company"] ?? "",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("site_footer_copyright"),
                    "name" => "site_footer_copyright",
                    "type" => "html",
                    "value" => $options["site_footer_copyright"] ?? "",
                ])
                @include("partials.inputs.select", [
                    "label" => __("Select Menu"),
                    "name" => "site_footer_copyright_menu",
                    "options" => $menuNames,
                    "selected" => $options["site_footer_copyright_menu"] ?? "",
                    "option_value" => "id",
                    "option_display" => "title",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_footer_logo"),
                    "name" => "site_footer_logo",
                    "value" => $options["site_footer_logo"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_footer_android_app_logo"),
                    "name" => "site_footer_android_app_logo",
                    "value" => $options["site_footer_android_app_logo"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_footer_apple_app_logo"),
                    "name" => "site_footer_apple_app_logo",
                    "value" => $options["site_footer_apple_app_logo"] ?? "",
                ])
                {{-- ========== repeater - start ========== --}}
                <div class="item-container">
                    @forelse ($site_footer_social_links ?? [] as $key => $item)
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("site_footer_social_links"),
                                "name" => "site_footer_social_links[]",
                                "type" => "text",
                                "value" => $item ?? "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("site_footer_social_icons"),
                                "name" => "site_footer_social_icons[]",
                                "type" => "text",
                                "value" => $site_footer_social_icons[$key] ?? "",
                            ])

                            
                        </div>
                    @empty
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("site_footer_social_links"),
                                "name" => "site_footer_social_links[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("site_footer_social_icons"),
                                "name" => "site_footer_social_icons[]",
                                "type" => "text",
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
                $(document).on("click", ".add_item", function () {
                    $(this).closest(".item-container").append(`
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("site_footer_social_links"),
                                "name" => "site_footer_social_links[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("site_footer_social_icons"),
                                "name" => "site_footer_social_icons[]",
                                "type" => "text",
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