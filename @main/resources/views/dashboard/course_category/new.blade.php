@extends('layouts.master')

@section('title') {{ __("Create Category") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Category") => route("dashboard.authors.list"),
        __("Create Category") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Create Category") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Categories')" class="mb-0" href="{{ route('dashboard.courseCategory.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.courseCategory.new') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.select", [
                    "label" => __("Select Course"),
                    "name" => "course_id",
                    "options" => $courses,
                    "option_value" => "id",
                    "option_display" => "title",
                ])
                @include("partials.inputs.select", [
                    "label" => __("Select Category"),
                    "name" => "category_id",
                    "options" => $cats,
                    "option_value" => "id",
                    "option_display" => "title",
                ])
            </div>
        </div>
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
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
