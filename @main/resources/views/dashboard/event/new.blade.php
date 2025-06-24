@extends('layouts.master')

@section('title') {{ __("Create Event") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Events") => route("dashboard.event.list"),
        __("Create Event") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Create Event") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Events')" class="mb-0" href="{{ route('dashboard.event.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.event.new') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("Title"),
                    "name" => "title",
                    "type" => "text",
                ])
                @include("partials.inputs.select", [
                    "label" => __("Event Category"),
                    "name" => "category_id",
                    "options" => $event_types,
                    "option_value" => "id",
                    "option_display" => "title",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Teaser"),
                    "name" => "teaser",
                    "type" => "html",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Description"),
                    "name" => "description",
                    "type" => "html",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Location"),
                    "name" => "location",
                    "type" => "text",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Join Url"),
                    "name" => "join_url",
                    "type" => "text",
                ])
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("Available Seat"),
                    "name" => "available_seat",
                    "type" => "number",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Start Datetime"),
                    "name" => "start_datetime",
                    "type" => "datetime-local",
                ])
                @include("partials.inputs.input", [
                    "label" => __("End Datetime"),
                    "name" => "end_datetime",
                    "type" => "datetime-local",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Visible From Date"),
                    "name" => "visible_from",
                    "type" => "datetime-local",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Visible To Date"),
                    "name" => "visible_to",
                    "type" => "datetime-local",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Registration Start Date"),
                    "name" => "registration_start_at",
                    "type" => "datetime-local",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Registration End Date"),
                    "name" => "registration_end_at",
                    "type" => "datetime-local",
                ])
                @include("partials.inputs.file", [
                    "label" => __("Select Image"),
                    "name" => "image_url",
                ])
                @include("partials.inputs.file", [
                    "label" => __("Video URL"),
                    "name" => "video_url",
                ])
                @include("partials.inputs.file", [
                    "label" => __("Document URL"),
                    "name" => "document_url",
                ])
                @include("partials.inputs.status", [
                    "label" => __("Status"),
                    "name" => "status"
                ])
                <div class="col-span-12 mt-12">
                    <div class="eduman-managesale-top-btn default-light-theme justify-center">
                        <button class="btn-primary" type="submit">{{ __("Create Event") }}</button>
                    </div>
                </div>
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
