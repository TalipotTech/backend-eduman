@extends('layouts.master')

@section('title') {{ __("Edit Author") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Author") => route("dashboard.authors.list"),
        __("Edit Author") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Edit Author") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Authors')" class="mb-0" href="{{ route('dashboard.authors.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.authors.edit', $author->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("First Name"),
                    "name" => "first_name",
                    "type" => "text",
                    "value" => $author->first_name ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Last Name"),
                    "name" => "last_name",
                    "type" => "text",
                    "value" => $author->last_name ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Title Name"),
                    "name" => "titel_name",
                    "type" => "text",
                    "value" => $author->titel_name ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Salute Name"),
                    "name" => "salute_name",
                    "type" => "text",
                    "value" => $author->salute_name ?? ""
                ])
                @include("partials.inputs.select", [
                    "label" => __("Select Category"),
                    "name" => "category",
                    "options" => $categories,
                    "selected" => $author->category,
                    "option_value" => "id",
                    "option_display" => "title",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Designation"),
                    "name" => "designation",
                    "type" => "text",
                    "value" => $author->designation ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Institute"),
                    "name" => "institute",
                    "type" => "text",
                    "value" => $author->institute ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Street Address"),
                    "name" => "street_address",
                    "type" => "text",
                    "value" => $author->street_address ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("City"),
                    "name" => "city",
                    "type" => "text",
                    "value" => $author->city ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Zip code"),
                    "name" => "zip",
                    "type" => "text",
                    "value" => $author->zip ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Country"),
                    "name" => "country",
                    "type" => "text",
                    "value" => $author->country ?? ""
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Teaser"),
                    "name" => "teaser",
                    "type" => "text",
                    "value" => $author->teaser
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Description"),
                    "name" => "description",
                    "type" => "text",
                    "value" => $author->description
                ])
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("Email"),
                    "name" => "email",
                    "type" => "email",
                    "value" => $author->email ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Phone"),
                    "name" => "phone",
                    "type" => "tel",
                    "value" => $author->phone ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Website URL"),
                    "name" => "website_url",
                    "type" => "text",
                    "value" => $author->website_url ?? ""
                ])
               
                @include("partials.inputs.input", [
                    "label" => __("Facebook URL"),
                    "name" => "fb_url",
                    "type" => "text",
                    "value" => $author->fb_url ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Instagram URL"),
                    "name" => "instagram_url",
                    "type" => "text",
                    "value" => $author->instagram_url ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Twitter URL"),
                    "name" => "twitter_url",
                    "type" => "text",
                    "value" => $author->twitter_url ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Linkedin URL"),
                    "name" => "linkedin_url",
                    "type" => "text",
                    "value" => $author->linkedin_url ?? ""
                ])

                @include("partials.inputs.file", [
                    "label" => __("promo_video_url"),
                    "name" => "promo_video_url",
                    "value" => $author->promo_video_url ? $author->promo_video_url : ""
                ])
                @include("partials.inputs.file", [
                    "label" => __("logo_url"),
                    "name" => "logo_url",
                    "value" => $author->logo_url ? $author->logo_url : ""
                ])
                @include("partials.inputs.file", [
                    "label" => __("banner_url"),
                    "name" => "banner_url",
                    "value" => $author->banner_url ? $author->banner_url : ""
                ])
                @include("partials.inputs.status", [
                    "label" => __("Status"),
                    "name" => "status",
                    "value" => $author->status
                ])
                @include("partials.inputs.save-btn", [
                    "label" => __("Update Author")
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
