@extends('layouts.master')
@section('title') {{ __("Create Author") }} @endsection
@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Reviews") => route("dashboard.courseReview.list"),
        __("Create Review") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Create Course review") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Reviews')" class="mb-0" href="{{ route('dashboard.courseReview.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.courseReview.new') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.select", [
                    "label" => __("Select rating"),
                    "name" => "rating",
                    "options" => $rating,
                    "option_value" => "value",
                    "option_display" => "title",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Message"),
                    "name" => "message",
                    "type" => "text",
                ])
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.select", [
                    "label" => __("Select Course"),
                    "name" => "course_id",
                    "options" => $courses,
                    "option_value" => "id",
                    "option_display" => "title",
                ])
                @include("partials.inputs.select", [
                    "label" => __("Select Student"),
                    "name" => "user_id",
                    "options" => $students,
                    "option_value" => "id",
                    "option_display" => "title",
                ])
                @include("partials.inputs.status", [
                    "label" => __("Status"),
                    "name" => "status"
                ])
                @include("partials.inputs.save-btn", [
                    "label" => __("Create Review")
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
