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
@php
$site_contact_phone_numbers = !empty($options["site_contact_phone_numbers"]) ? json_decode($options["site_contact_phone_numbers"]) : [];
$site_contact_emails = !empty($options["site_contact_emails"]) ? json_decode($options["site_contact_emails"]) : [];
@endphp
<form method="POST" action="{{ route('dashboard.inner_page_settings.contact') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("site_contact_title"),
                    "name" => "site_contact_title",
                    "type" => "text",
                    "value" => $options["site_contact_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_contact_sub_title"),
                    "name" => "site_contact_sub_title",
                    "type" => "text",
                    "value" => $options["site_contact_sub_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_contact_description"),
                    "name" => "site_contact_description",
                    "type" => "text",
                    "value" => $options["site_contact_description"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_contact_keywords"),
                    "name" => "site_contact_keywords",
                    "type" => "text",
                    "value" => $options["site_contact_keywords"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_contact_info_title"),
                    "name" => "site_contact_info_title",
                    "type" => "text",
                    "value" => $options["site_contact_info_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_contact_btn_text"),
                    "name" => "site_contact_btn_text",
                    "type" => "text",
                    "value" => $options["site_contact_btn_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_contact_phone_title"),
                    "name" => "site_contact_phone_title",
                    "type" => "text",
                    "value" => $options["site_contact_phone_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_contact_email_title"),
                    "name" => "site_contact_email_title",
                    "type" => "text",
                    "value" => $options["site_contact_email_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_contact_location_title"),
                    "name" => "site_contact_location_title",
                    "type" => "text",
                    "value" => $options["site_contact_location_title"] ?? "",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("site_contact_location_address"),
                    "name" => "site_contact_location_address",
                    "type" => "html",
                    "value" => $options["site_contact_location_address"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_contact_banner_image"),
                    "name" => "site_contact_banner_image",
                    "value" => $options["site_contact_banner_image"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_contact_phone_icon"),
                    "name" => "site_contact_phone_icon",
                    "value" => $options["site_contact_phone_icon"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_contact_email_icon"),
                    "name" => "site_contact_email_icon",
                    "value" => $options["site_contact_email_icon"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_contact_location_icon"),
                    "name" => "site_contact_location_icon",
                    "value" => $options["site_contact_location_icon"] ?? "",
                ])
                {{-- ========== repeater - phone start ========== --}}
                <div class="item-container">
                    @forelse ($site_contact_phone_numbers ?? [] as $key => $item)
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("site_contact_phone_numbers"),
                                "name" => "site_contact_phone_numbers[]",
                                "type" => "text",
                                "value" => $item ?? "",
                            ])
                        </div>
                    @empty
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("site_contact_phone_numbers"),
                                "name" => "site_contact_phone_numbers[]",
                                "type" => "text",
                                "value" => "",
                            ])
                        </div>
                    @endforelse
                </div>
                {{-- ========== repeater - phone end ========== --}}

                {{-- ========== repeater - email start ========== --}}
                <div class="item-container">
                    @forelse ($site_contact_emails ?? [] as $key => $item)
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse">
                                <button type="button" class="add_email_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_email_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("site_contact_emails"),
                                "name" => "site_contact_emails[]",
                                "type" => "text",
                                "value" => $item ?? "",
                            ])
                        </div>
                    @empty
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("site_contact_emails"),
                                "name" => "site_contact_emails[]",
                                "type" => "text",
                                "value" => "",
                            ])
                        </div>
                    @endforelse
                </div>
                {{-- ========== repeater - email end ========== --}}
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
                // Add phone
                $(document).on("click", ".add_item", function () {
                    $(this).closest(".item-container").append(`
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("site_contact_phone_numbers"),
                                "name" => "site_contact_phone_numbers[]",
                                "type" => "text",
                                "value" => "",
                            ])
                        </div>
                    `)
                });
                // Remove phone
                $(document).on("click", ".remove_item", function (e) {
                    let repeater = $(this).closest(".repeater");
                    $(repeater).slideUp("slow", function () {
                        $(repeater).remove();
                    })
                });
                // Add email
                $(document).on("click", ".add_email_item", function () {
                    $(this).closest(".item-container").append(`
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("site_contact_emails"),
                                "name" => "site_contact_emails[]",
                                "type" => "text",
                                "value" => "",
                            ])
                        </div>
                    `)
                });
                // Remove email
                $(document).on("click", ".remove_email_item", function (e) {
                    let repeater = $(this).closest(".repeater");
                    $(repeater).slideUp("slow", function () {
                        $(repeater).remove();
                    })
                });
            })
        })(jQuery)
    </script>
@endsection