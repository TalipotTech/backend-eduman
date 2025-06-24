@extends('layouts.master')

@section('title') {{ __("Create Page") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Page") => route("dashboard.pages.list"),
        __("Create Page") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Create Page") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Pages')" class="mb-0" href="{{ route('dashboard.pages.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.pages.new') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Title") }}</h5>
                    <div class="eduman-input-field-style">
                        <div class="single-input-field w-full">
                            <x-text-input id="title" name="title" class="block mt-1 w-full" type="text" required autofocus />
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="col-span-12">
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Content") }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-tinymce.editor :id="'content'" :name="'content'" :type="'html'" />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-12">
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Meta Title") }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-text-input id="meta_title" name="meta_title" class="block mt-1 w-full" type="text" required />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-12">
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Meta Description") }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <textarea name="meta_description" id="meta_description" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                    </div>
                </div>
                <div class="eduman-select-field mb-8">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">
                        {{ __("Meta Image") }}
                    </h5>
                    <div class="custom-file">
                        <input type="file" name="meta_image" class="custom-file-input"
                            id="meta_image" />
                        <label class="custom-file-label" for="meta_image">{{ __("Select Image") }}</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit">
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Status") }}</h5>
                    <div class="eduman-radio-field-style">
                        <div class="single-input-field w-full">
                            <label for="opt-1" class="mr-4">
                                <input class="mr-1" type="radio" name="status" id="opt-1" value="Active" />
                                {{ __("Published") }}
                            </label>
                            <label for="opt-2" class="mr-4">
                                <input class="mr-1" type="radio" name="status" id="opt-2" value="Pending" />
                                {{ __("Pending") }}
                            </label>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
                <div class="col-span-12 mt-12">
                    <div class="eduman-managesale-top-btn default-light-theme">
                        <button class="btn-primary" type="submit">{{ __("Create Page") }}</button>
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
