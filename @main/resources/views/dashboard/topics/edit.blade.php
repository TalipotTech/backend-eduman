@extends('layouts.master')

@section('title') {{ __("Edit Topic") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Topic") => route("dashboard.topics.list"),
        __("Edit Topic") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Edit Topic") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Topics')" class="mb-0" href="{{ route('dashboard.topics.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.topics.edit', $topic->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="col-span-12">
            <div class="dashboard-edit p-10">
                <div class="grid grid-cols-12 sm:gap-x-5">
                    <div class="lg:col-span-8 col-span-12">
                        <div class="eduman-select-field mb-5">
                            <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Title") }}</h5>
                            <div class="eduman-input-field-style">
                                <div class="single-input-field w-full">
                                    <x-text-input id="title" name="title" class="block mt-1 w-full" type="text" :value="$topic->title" required autofocus />
                                </div>
                            </div>
                            @if ($errors->has("title"))
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-span-12">
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Teaser") }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-tinymce.editor :id="'teaser'" :name="'teaser'" :type="'html'" :value="$topic->teaser" />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('teaser')" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-12">
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Description") }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-tinymce.editor :id="'description'" :name="'description'" :type="'html'" :value="$topic->description" />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-12">
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Settings Data") }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <textarea
                                    name="settings_data"
                                    id="settings_data"
                                    cols="30"
                                    rows="10"
                                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >{{ $topic->settings_data }}</textarea>
                            </div>
                        </div>
                        @if ($errors->has("settings_data"))
                            <x-input-error :messages="$errors->get('settings_data')" class="mt-2" />
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-12 sm:gap-x-5">
                    <div class="lg:col-span-4 col-span-12">
                        <div class="eduman-select-field mb-8">
                            <h5 class="text-[15px] text-heading font-semibold mb-3">
                                {{ __("Image") }}
                            </h5>
                            <div class="custom-file">
                                <input type="file" name="image_url" class="custom-file-input"
                                    id="image_url" />
                                <label class="custom-file-label" for="image_url">{{ __("Select Video") }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-4 col-span-12">
                        <div class="eduman-select-field mb-8">
                            <h5 class="text-[15px] text-heading font-semibold mb-3">
                                {{ __("Video") }}
                            </h5>
                            <div class="custom-file">
                                <input type="file" name="video_url" class="custom-file-input"
                                    id="video_url" />
                                <label class="custom-file-label" for="video_url">{{ __("Select Video") }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-4 col-span-12">
                        <div class="eduman-select-field mb-8">
                            <h5 class="text-[15px] text-heading font-semibold mb-3">
                                {{ __("Document") }}
                            </h5>
                            <div class="custom-file">
                                <input type="file" name="document_url" class="custom-file-input"
                                    id="document_url" />
                                <label class="custom-file-label" for="document_url">{{ __("Select Video") }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Status") }}</h5>
                    <div class="eduman-radio-field-style">
                        <div class="single-input-field w-full">
                            <label for="opt-1" class="mr-4">
                                <input class="mr-1" type="radio" name="status" id="opt-1" value="Active" @checked($topic->status->value == 'Active') />
                                {{ __("Published") }}
                            </label>
                            <label for="opt-2" class="mr-4">
                                <input class="mr-1" type="radio" name="status" id="opt-2" value="Pending" @checked(!$topic->status->value == 'Pending') />
                                {{ __("Pending") }}
                            </label>
                        </div>
                    </div>
                    @if ($errors->has("status"))
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    @endif
                </div>
                <div class="col-span-12 mt-12">
                    <div class="eduman-managesale-top-btn default-light-theme justify-center">
                        <button class="btn-primary" type="submit">{{ __("Update Topic") }}</button>
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
