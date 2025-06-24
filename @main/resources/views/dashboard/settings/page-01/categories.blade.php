@extends('layouts.master')

@php
$page_title = __("Homepage-01 Category");
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

<form method="POST" action="{{ route('dashboard.settings.page.home-01.categories') }}" enctype="multipart/form-data">
    @csrf
    @php
    $item_images = !empty($options["home_01_category_items_img"]) ? json_decode($options["home_01_category_items_img"]) : [];
    $item_title = !empty($options["home_01_category_items_title"]) ? json_decode($options["home_01_category_items_title"]) : [];
    $item_description = !empty($options["home_01_category_items_description"]) ? json_decode($options["home_01_category_items_description"]) : [];
    $item_slug = !empty($options["home_01_category_items_slug"]) ? json_decode($options["home_01_category_items_slug"]) : [];

    
    @endphp
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("home_01_category_section_title"),
                    "name" => "home_01_category_section_title",
                    "type" => "text",
                    "value" => $options["home_01_category_section_title"] ?? "",
                ])
                <div class="item-container">
                    @forelse ($item_title ?? [] as $key => $category_img)
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("home_01_category_items_title"),
                                "name" => "home_01_category_items_title[]",
                                "type" => "text",
                                "value" => $item_title[$key] ?? "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_category_items_slug"),
                                "name" => "home_01_category_items_slug[]",
                                "type" => "text",
                                "value" => $item_slug[$key] ?? "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_category_items_description"),
                                "name" => "home_01_category_items_description[]",
                                "type" => "text",
                                "value" => $item_description[$key] ?? "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_01_category_items_img"),
                                "name" => "home_01_category_items_img[]",
                                "value" => $item_images[$key] ?? "",
                            ])
                        </div>
                    @empty
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.input", [
                                "label" => __("home_01_category_items_title"),
                                "name" => "home_01_category_items_title[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_category_items_slug"),
                                "name" => "home_01_category_items_slug[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_category_items_description"),
                                "name" => "home_01_category_items_description[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_01_category_items_img"),
                                "name" => "home_01_category_items_img[]",
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
                                "label" => __("home_01_category_items_title"),
                                "name" => "home_01_category_items_title[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_category_items_slug"),
                                "name" => "home_01_category_items_slug[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.input", [
                                "label" => __("home_01_category_items_description"),
                                "name" => "home_01_category_items_description[]",
                                "type" => "text",
                                "value" => "",
                            ])
                            @include("partials.inputs.file", [
                                "label" => __("home_01_category_items_img"),
                                "name" => "home_01_category_items_img[]",
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
