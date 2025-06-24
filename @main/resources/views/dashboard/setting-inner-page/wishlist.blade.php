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
<form method="POST" action="{{ route('dashboard.inner_page_settings.wishlist') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("site_wishlist_title"),
                    "name" => "site_wishlist_title",
                    "type" => "text",
                    "value" => $options["site_wishlist_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_wishlis_sub_title"),
                    "name" => "site_wishlis_sub_title",
                    "type" => "text",
                    "value" => $options["site_wishlis_sub_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_wishlis_description"),
                    "name" => "site_wishlis_description",
                    "type" => "text",
                    "value" => $options["site_wishlis_description"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_wishlis_keywords"),
                    "name" => "site_wishlis_keywords",
                    "type" => "text",
                    "value" => $options["site_wishlis_keywords"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_wishlis_banner_image"),
                    "name" => "site_wishlis_banner_image",
                    "value" => $options["site_wishlis_banner_image"] ?? "",
                ])
                @include("partials.inputs.save-btn", [
                    "label" => __("Save Settings")
                ])
            </div>
        </div>
    </div>
</form>
@endsection