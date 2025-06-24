@extends('layouts.master')

@section('title') {{ __("Edit Student") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Studen") => route("dashboard.students.list"),
        __("Edit Student") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Edit Student") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Students')" class="mb-0" href="{{ route('dashboard.students.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.students.edit', $student->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("First Name"),
                    "name" => "first_name",
                    "type" => "text",
                    "value" => $student->first_name ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Last Name"),
                    "name" => "last_name",
                    "type" => "text",
                    "value" => $student->last_name ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Title Name"),
                    "name" => "titel_name",
                    "type" => "text",
                    "value" => $student->titel_name ?? ""
                ])
                @include("partials.inputs.select", [
                    "label" => __("Select User"),
                    "name" => "user_id",
                    "options" => $users,
                    "selected" => $student->user_id,
                    "option_value" => "id",
                    "option_display" => "title",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Street Address"),
                    "name" => "street_address",
                    "type" => "text",
                    "value" => $student->street_address ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("City"),
                    "name" => "city",
                    "type" => "text",
                    "value" => $student->city ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Zip"),
                    "name" => "zip",
                    "type" => "text",
                    "value" => $student->zip ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Country"),
                    "name" => "country",
                    "type" => "text",
                    "value" => $student->country ?? ""
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Teaser"),
                    "name" => "teaser",
                    "type" => "text",
                    "value" => $student->teaser
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Description"),
                    "name" => "description",
                    "type" => "text",
                    "value" => $student->description
                ])
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("Facebook URL"),
                    "name" => "fb_url",
                    "type" => "text",
                    "value" => $student->fb_url ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Website URL"),
                    "name" => "website_url",
                    "type" => "text",
                    "value" => $student->website_url ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Instagram URL"),
                    "name" => "instagram_url",
                    "type" => "text",
                    "value" => $student->instagram_url ?? ""
                ])
                @include("partials.inputs.file", [
                    "label" => __("image_url"),
                    "name" => "image_url",
                    "value" => $student->image_url ? $student->image_url : ""
                ])
                @include("partials.inputs.file", [
                    "label" => __("banner_url"),
                    "name" => "banner_url",
                    "value" => $student->banner_url ? $student->banner_url : ""
                ])
                @include("partials.inputs.status", [
                    "label" => __("Status"),
                    "name" => "status",
                    "value" => $student->status
                ])
                @include("partials.inputs.save-btn", [
                    "label" => __("Update Student")
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
