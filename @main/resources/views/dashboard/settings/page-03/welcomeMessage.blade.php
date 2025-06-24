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
<form method="POST" action="{{ route('dashboard.settings.page.home-03.welcome-message') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("home_03_welcome_message_title"),
                    "name" => "home_03_welcome_message_title",
                    "type" => "text",
                    "value" => $options["home_03_welcome_message_title"] ?? "",
                ])
                
                @include("partials.inputs.file", [
                    "label" => __("home_03_welcome_message_image"),
                    "name" => "home_03_welcome_message_image",
                    "value" => $options["home_03_welcome_message_image"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("home_03_welcome_message_profile_image"),
                    "name" => "home_03_welcome_message_profile_image",
                    "value" => $options["home_03_welcome_message_profile_image"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("home_03_welcome_message_url"),
                    "name" => "home_03_welcome_message_url",
                    "type" => "text",
                    "value" => $options["home_03_welcome_message_url"] ?? "",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("home_03_welcome_message_since"),
                    "name" => "home_03_welcome_message_since",
                    "type" => "html",
                    "value" => $options["home_03_welcome_message_since"] ?? "",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("home_03_welcome_message_description"),
                    "name" => "home_03_welcome_message_description",
                    "type" => "html",
                    "value" => $options["home_03_welcome_message_description"] ?? "",
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
                                "label" => __("home_03_header_features"),
                                "name" => "home_03_header_features[]",
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
