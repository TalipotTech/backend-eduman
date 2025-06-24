@extends('layouts.master')

@php
$page_title = __("Homepage-03 Categories");
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
    $home_03_categories_title = !empty($options["home_03_categories_title"]) ? json_decode($options["home_03_categories_title"], true) : [];
    $home_03_categories_subtitle = !empty($options["home_03_categories_subtitle"]) ? json_decode($options["home_03_categories_subtitle"], true) : [];
    $home_03_categories_url = !empty($options["home_03_categories_url"]) ? json_decode($options["home_03_categories_url"], true) : [];
    $home_03_categories_image = !empty($options["home_03_categories_image"]) ? json_decode($options["home_03_categories_image"], true) : [];
@endphp
<form method="POST" action="{{ route('dashboard.settings.page.home-03.categories') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("home_03_categories_section_title"),
                    "name" => "home_03_categories_section_title",
                    "type" => "text",
                    "value" => $options["home_03_categories_section_title"] ?? "",
                ])
                <div class="item-container">
                    @forelse ($home_03_categories_title ?? [] as $key => $title)
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("home_03_categories_title"),
                                "name" => "home_03_categories_title[]",
                                "type" => "text",
                                "value" => $home_03_categories_title[$key] ?? "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_03_categories_subtitle"),
                                "name" => "home_03_categories_subtitle[]",
                                "type" => "text",
                                "value" => $home_03_categories_subtitle[$key] ?? "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_03_categories_url"),
                                "name" => "home_03_categories_url[]",
                                "type" => "text",
                                "value" => $home_03_categories_url[$key] ?? "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_03_categories_image"),
                                "name" => "home_03_categories_image[]",
                                "value" => $home_03_categories_image[$key] ?? "",
                            ])
                        </div>
                    @empty
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("home_03_categories_title"),
                                "name" => "home_03_categories_title[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_03_categories_subtitle"),
                                "name" => "home_03_categories_subtitle[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_03_categories_url"),
                                "name" => "home_03_categories_url[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_03_categories_image"),
                                "name" => "home_03_categories_image[]",
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
                                "label" => __("home_03_categories_title"),
                                "name" => "home_03_categories_title[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_03_categories_subtitle"),
                                "name" => "home_03_categories_subtitle[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_03_categories_url"),
                                "name" => "home_03_categories_url[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_03_categories_image"),
                                "name" => "home_03_categories_image[]",
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
