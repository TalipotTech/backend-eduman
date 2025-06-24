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

<form method="POST" action="{{ route('dashboard.settings.page.home-01.cta-02') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("home_01_cta_02_title"),
                    "name" => "home_01_cta_02_title",
                    "type" => "text",
                    "value" => $options["home_01_cta_02_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("home_01_cta_02_description"),
                    "name" => "home_01_cta_02_description",
                    "type" => "text",
                    "value" => $options["home_01_cta_02_description"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("home_01_cta_02_image"),
                    "name" => "home_01_cta_02_image",
                    "value" => $options["home_01_cta_02_image"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("home_01_cta_02_btn_text"),
                    "name" => "home_01_cta_02_btn_text",
                    "type" => "text",
                    "value" => $options["home_01_cta_02_btn_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("home_01_cta_02_btn_url"),
                    "name" => "home_01_cta_02_btn_url",
                    "type" => "text",
                    "value" => $options["home_01_cta_02_btn_url"] ?? "",
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
@endsection
