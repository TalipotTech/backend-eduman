@extends('layouts.master')

@section('title') {{ __("Create Author") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Author") => route("dashboard.authors.list"),
        __("Create Author") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Create Author") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Authors')" class="mb-0" href="{{ route('dashboard.authors.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.authors.new') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("First Name"),
                    "name" => "first_name",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Last Name"),
                    "name" => "last_name",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Title Name"),
                    "name" => "titel_name",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Salute Name"),
                    "name" => "salute_name",
                    "type" => "text",
                ])
                
                @include("partials.inputs.select", [
                    "label" => __("Select Category"),
                    "name" => "category",
                    "options" => $categories,
                    "option_value" => "id",
                    "option_display" => "title",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Designation"),
                    "name" => "designation",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Institute"),
                    "name" => "institute",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Street Address"),
                    "name" => "street_address",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("City"),
                    "name" => "city",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Zip code"),
                    "name" => "zip",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Country"),
                    "name" => "country",
                    "type" => "text",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Teaser"),
                    "name" => "teaser",
                    "type" => "text",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Description"),
                    "name" => "description",
                    "type" => "text",
                ])
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("Email"),
                    "name" => "email",
                    "type" => "email",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Phone"),
                    "name" => "phone",
                    "type" => "tel",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Website URL"),
                    "name" => "website_url",
                    "type" => "text",
                ])

                @include("partials.inputs.input", [
                    "label" => __("Facebook URL"),
                    "name" => "fb_url",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Instagram URL"),
                    "name" => "instagram_url",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Twitter URL"),
                    "name" => "twitter_url",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Linkedin URL"),
                    "name" => "linkedin_url",
                    "type" => "text",
                ])

                @include("partials.inputs.file", [
                    "label" => __("promo_video_url"),
                    "name" => "promo_video_url",
                ])
                @include("partials.inputs.file", [
                    "label" => __("logo_url"),
                    "name" => "logo_url",
                ])
                @include("partials.inputs.file", [
                    "label" => __("banner_url"),
                    "name" => "banner_url",
                ])
                @include("partials.inputs.status", [
                    "label" => __("Status"),
                    "name" => "status"
                ])
                @include("partials.inputs.save-btn", [
                    "label" => __("Create Author")
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
