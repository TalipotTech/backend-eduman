@extends('layouts.master')

@section('title') {{ __("Create Category") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Category") => route("dashboard.pages.list"),
        __("Create Category") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Create Category") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Categories')" class="mb-0" href="{{ route('dashboard.category.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.category.new') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Category Title") }}</h5>
                    <div class="eduman-input-field-style">
                        <div class="single-input-field w-full">
                            <x-text-input id="title" name="title" class="block mt-1 w-full" type="text" required autofocus />
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="col-span-12">
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Description") }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-tinymce.editor :id="'description'" :name="'description'" :type="'html'" />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit">
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Type") }}</h5>
                    <div class="eduman-radio-field-style">
                        <div class="single-input-field w-full">
                            <select class="block" id="ctype" name="ctype">
                                <option value="">{{ __("Select One") }}</option>
                                <option {{ old('ctype') == 'Course' ? 'selected' : '' }} value="Course">{{ __("Course") }}</option>
                                <option {{ old('ctype') == 'Event' ? 'selected' : '' }} value="Event">{{ __("Event") }}</option>
                                <option {{ old('ctype') == 'Blog' ? 'selected' : '' }} value="Blog">{{ __("Blog") }}</option>
                            </select>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('ctype')" class="mt-2" />
                </div>
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Parent Category") }}</h5>
                    <div class="eduman-radio-field-style">
                        <div class="single-input-field w-full">
                            <select class="block" id="parent_id" name="parent_id">
                                <option selected value="">{{ __("Select One") }}</option>
                                @if (count($catParents) > 0)
                                    @foreach ($catParents as $cat)
                                        <option {{ (old('parent_id') == $cat->id) ? 'selected' : '' }} value="{{ $cat->id }}">
                                            {{ $cat->title }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
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
