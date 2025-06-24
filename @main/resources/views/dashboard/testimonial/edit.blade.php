@extends('layouts.master')

@section('title') {{ __("Edit Testimonial") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Testimonial") => route("dashboard.testimonial.list"),
        __("Edit Testimonial") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Edit Testimonial") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Testimonials')" class="mb-0" href="{{ route('dashboard.testimonial.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.testimonial.edit', $testimonial->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                @php
                    $name_label = __("Reviewer Name");
                    $designation_label = __("Reviewer Designation");
                    $image_label = __("Reviewer Image");
                    $title_label = __("Title");
                    $body_label = __("Body");
                    $rating_label = __("Rating");
                    $rating_options = [
                        ["value" => 1, "display" => __("1 Star")],
                        ["value" => 2, "display" => __("2 Star")],
                        ["value" => 3, "display" => __("3 Star")],
                        ["value" => 4, "display" => __("4 Star")],
                        ["value" => 5, "display" => __("5 Star")],
                    ];

                    $title = $testimonial->title;
                    $body = $testimonial->body;
                    $rating = $testimonial->rating;
                    $name = $testimonial->name;
                    $designation = $testimonial->designation;
                    $image = $testimonial->image;
                @endphp

                <x-form.input :name="'title'" :label="$title_label" :value="$title" />
                <x-form.textarea :name="'body'" :label="$body_label" :value="$body" />

                <div class="grid grid-cols-12 sm:gap-x-5">
                    <div class="sm:col-span-6 col-span-12">
                        <x-form.select
                            :name="'rating'"
                            :label="$rating_label"
                            :value="$rating"
                            :options="$rating_options"
                            :option_value="'value'"
                            :option_display="'display'"
                            :selected="$rating"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10">
                <x-form.input :name="'name'" :label="$name_label" :value="$name" />
                <x-form.input :name="'designation'" :label="$designation_label" :value="$designation" />
                <x-form.file :name="'image'" :label="$image_label" :value="$image" />
                <div class="col-span-12 mt-12">
                    <div class="eduman-managesale-top-btn default-light-theme justify-center">
                        <button class="btn-primary" type="submit">{{ __("Update Testimonial") }}</button>
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
