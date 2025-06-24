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
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Authors')" class="mb-0" href="{{ route('dashboard.courseAuthor.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.courseAuthor.edit', $ca->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.select", [
                    "label" => __("Select Course"),
                    "name" => "course_id",
                    "options" => $courses,
                    "selected" => $ca->course_id,
                    "option_value" => "id",
                    "option_display" => "title",
                ])
                @include("partials.inputs.select", [
                    "label" => __("Select Author"),
                    "name" => "author_id",
                    "options" => $authors,
                    "selected" => $ca->author_id,
                    "option_value" => "id",
                    "option_display" => "title",
                ])
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.save-btn", [
                    "label" => __("Update")
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
