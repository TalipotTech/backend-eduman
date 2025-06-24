@extends('layouts.master')

@section('title') {{ __("Edit User") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("User") => route("dashboard.users.list"),
        __("Edit user") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Edit User") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Users')" class="mb-0" href="{{ route('dashboard.users.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.users.edit', $user->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("First Name"),
                    "name" => "first_name",
                    "type" => "text",
                    "value" => $user->first_name ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Last Name"),
                    "name" => "last_name",
                    "type" => "text",
                    "value" => $user->last_name ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Phone"),
                    "name" => "phone",
                    "type" => "text",
                    "value" => $user->phone ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Email"),
                    "name" => "email",
                    "type" => "text",
                    "value" => $user->email ?? ""
                ])
                @include("partials.inputs.input", [
                    "label" => __("Password"),
                    "name" => "password",
                    "type" => "password",
                    "value" => $user->password ?? ""
                ])
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.status", [
                    "label" => __("Status"),
                    "name" => "status",
                    "value" => $user->status
                ])
                @include("partials.inputs.save-btn", [
                    "label" => __("Update user")
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
