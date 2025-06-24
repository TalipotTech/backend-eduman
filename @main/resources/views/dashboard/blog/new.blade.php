@extends('layouts.master')

@section('title') {{ __("Create Blog") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Blog") => route("dashboard.blogs.list"),
        __("Create Blog") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Create Blog") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Blogs')" class="mb-0" href="{{ route('dashboard.blogs.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.blogs.new') }}" enctype="multipart/form-data">
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
                    @if ($errors->has("title"))
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    @endif
                </div>
                <div class="col-span-12">
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Teaser") }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-tinymce.editor :id="'teaser'" :name="'teaser'" :type="'html'" />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('teaser')" class="mt-2" />
                    </div>
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
                <hr class="my-8">
                <div class="grid grid-cols-12 sm:gap-x-5">
                    <div class="col-span-12">
                        <div class="eduman-select-field mb-5">
                            <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Meta Title") }}</h5>
                            <div class="eduman-input-field-style">
                                <div class="single-input-field w-full">
                                    <x-text-input id="meta_title" name="meta_title" class="block mt-1 w-full" type="text" required autofocus />
                                </div>
                            </div>
                            @if ($errors->has("meta_title"))
                                <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                            @endif
                        </div>
                    </div>
                    <div class="col-span-12">
                        <div class="eduman-select-field mb-5">
                            <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Meta Description") }}</h5>
                            <div class="eduman-input-field-style">
                                <div class="single-input-field w-full">
                                    <textarea
                                        name="meta_description"
                                        id="meta_description"
                                        cols="30"
                                        rows="10"
                                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    ></textarea>
                                </div>
                            </div>
                            @if ($errors->has("meta_description"))
                                <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                            @endif
                        </div>
                    </div>
                    <div class="col-span-12">
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
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10">
                <div class="md:col-span-12 col-span-12">
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Author") }}</h5>
                        <div class="eduman-select-field-style">
                            <select class="block" id="author_id" name="author_id">
                                <option selected value="">{{ __("Select One") }}</option>
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}">
                                        {{ $author->first_name .' '. $author->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has("author_id"))
                            <x-input-error :messages="$errors->get('author_id')" class="mt-2" />
                        @endif
                    </div>
                </div>
                <div class="md:col-span-12 col-span-12">
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Category") }}</h5>
                        <div class="eduman-select-field-style">
                            <select class="block" id="category_id" name="category_id">
                                <option selected value="">{{ __("Select One") }}</option>
                                @foreach ($blog_categories as $blog_category)
                                    <option value="{{ $blog_category->id }}">
                                        {{ $blog_category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has("category_id"))
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        @endif
                    </div>
                </div>
                <div class="md:col-span-12 col-span-12">
                    <div class="eduman-select-field mb-8">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">
                            {{ __("Upload Image") }}
                        </h5>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input"
                                id="image" />
                            <label class="custom-file-label" for="image">{{ __("Select Image") }}</label>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-12 col-span-12">
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
                        @if ($errors->has("status"))
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        @endif
                    </div>
                </div>
                <hr class="my-8">
                <div class="col-span-12 mt-12">
                    <div class="eduman-managesale-top-btn default-light-theme justify-center">
                        <button class="btn-primary" type="submit">{{ __("Create Blog") }}</button>
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
