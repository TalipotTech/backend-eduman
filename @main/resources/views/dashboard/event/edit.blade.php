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

<form method="POST" action="{{ route('dashboard.event.edit', $event->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("Title"),
                    "name" => "title",
                    "type" => "text",
                    "value" => $event->title,
                ])
                @include("partials.inputs.select", [
                    "label" => __("Event Category"),
                    "name" => "category_id",
                    "options" => $event_types,
                    "selected" => $event->category_id,
                    "option_value" => "id",
                    "option_display" => "title",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Teaser"),
                    "name" => "teaser",
                    "type" => "html",
                    "value" => $event->teaser,
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Description"),
                    "name" => "description",
                    "type" => "html",
                    "value" => $event->description,
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Location"),
                    "name" => "location",
                    "type" => "text",
                    "value" => $event->location,
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Join Url"),
                    "name" => "join_url",
                    "type" => "text",
                    "value" => $event->join_url,
                ])
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("Available Seat"),
                    "name" => "available_seat",
                    "type" => "number",
                    "value" => $event->available_seat
                ])
                @include("partials.inputs.input", [
                    "label" => __("Start Datetime"),
                    "name" => "start_datetime",
                    "type" => "datetime-local",
                    "value" => $event->start_datetime
                ])
                @include("partials.inputs.input", [
                    "label" => __("End Datetime"),
                    "name" => "end_datetime",
                    "type" => "datetime-local",
                    "value" => $event->end_datetime
                ])
                @include("partials.inputs.input", [
                    "label" => __("Visible From Date"),
                    "name" => "visible_from",
                    "type" => "datetime-local",
                    "value" => $event->visible_from
                ])
                @include("partials.inputs.input", [
                    "label" => __("Visible To Date"),
                    "name" => "visible_to",
                    "type" => "datetime-local",
                    "value" => $event->visible_to
                ])
                @include("partials.inputs.input", [
                    "label" => __("Registration Start Date"),
                    "name" => "registration_start_at",
                    "type" => "datetime-local",
                    "value" => $event->registration_start_at
                ])
                @include("partials.inputs.input", [
                    "label" => __("Registration End Date"),
                    "name" => "registration_end_at",
                    "type" => "datetime-local",
                    "value" => $event->registration_end_at
                ])
                @include("partials.inputs.file", [
                    "label" => __("Select Image"),
                    "name" => "image_url",
                    "value" => $event->image_url ? $event->image_url : "",
                    "file_type" => "image"
                ])
                @include("partials.inputs.file", [
                    "label" => __("Video URL"),
                    "name" => "video_url",
                    "value" => $event->video_url ? $event->video_url : "",
                    "file_type" => "video"
                ])
                @include("partials.inputs.file", [
                    "label" => __("Document URL"),
                    "name" => "document_url",
                    "value" => $event->document_url ? $event->document_url : "",
                    "file_type" => "docs"
                ])
                @include("partials.inputs.status", [
                    "label" => __("Status"),
                    "name" => "status",
                    "value" => $event->status
                ])
                <div class="col-span-12 mt-12">
                    <div class="eduman-managesale-top-btn default-light-theme justify-center">
                        <button class="btn-primary" type="submit">{{ __("Update Event") }}</button>
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
