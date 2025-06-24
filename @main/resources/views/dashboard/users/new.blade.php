@extends('layouts.master')

@section('title') {{ __("Create user") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Users") => route("dashboard.users.list"),
        __("Create user") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Create user") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All users')" class="mb-0" href="{{ route('dashboard.users.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.users.new') }}" enctype="multipart/form-data">
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
                    "label" => __("Phone"),
                    "name" => "phone",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Email"),
                    "name" => "email",
                    "type" => "text",
                ])
                @include("partials.inputs.input", [
                    "label" => __("Password"),
                    "name" => "password",
                    "type" => "password",
                ])
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.status", [
                    "label" => __("Status"),
                    "name" => "status"
                ])
                @include("partials.inputs.save-btn", [
                    "label" => __("Create user")
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
