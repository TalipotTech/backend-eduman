@extends('layouts.master')

@section('title') {{ __("Edit Class") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Classes") => route("dashboard.classrooms.list"),
        __("Edit Class") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Edit Class") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Classes')" class="mb-0" href="{{ route('dashboard.classrooms.list') }}" />
</div>
@php
$options = !empty($classroom->content_data) ? json_decode($classroom->content_data) : [];
@endphp

<form method="POST" action="{{ route('dashboard.classrooms.edit', $classroom->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Class") }}</h5>
                    <div class="eduman-input-field-style">
                        <div class="single-input-field w-full">
                            <x-text-input id="title" name="title" class="block mt-1 w-full" type="text" :value="$classroom->title" required autofocus />
                        </div>
                    </div>
                    @if ($errors->has("title"))
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    @endif
                </div>

                {{-- ========== repeater start ========== --}}
                <div class="item-container">
                    @forelse ($options->lessons ?? [] as $key => $item)
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.select", [
                                "label" => __("Lesson"),
                                "name" => "lessons[]",
                                "options" => $lessons,
                                "selected" => $item,
                                "option_value" => "id",
                                "option_display" => "title",
                            ])
                        </div>
                    @empty
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.select", [
                                "label" => __("Lesson"),
                                "name" => "lessons[]",
                                "options" => $lessons,
                                "option_value" => "id",
                                "option_display" => "title",
                            ])
                        </div>
                    @endforelse
                </div>
                {{-- ========== repeater - end ========== --}}
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10"> 
            <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Course") }}</h5>
                    <div class="eduman-select-field-style">
                        <select class="block" id="course_id" name="course_id">
                            <option value="">{{ __("Select One") }}</option>
                            @foreach ($courses as $course)
                                <option {{ ($classroom->course_id == $course->id) ? 'selected="selected"' : ''}} value="{{ $course->id }}">
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has("course_id"))
                        <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                    @endif
                </div>
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Quiz") }}</h5>
                    <div class="eduman-select-field-style">
                        <select class="block" id="quiz_id" name="quiz_id">
                            <option value="">{{ __("Select One") }}</option>
                            @foreach ($quizzes as $quiz)
                                <option {{ ($options->quiz == $quiz->id) ? 'selected="selected"' : ''}} value="{{ $quiz->id }}">
                                    {{ $quiz->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has("quiz_id"))
                        <x-input-error :messages="$errors->get('quiz_id')" class="mt-2" />
                    @endif
                </div>
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Class Type") }}</h5>
                    <div class="eduman-select-field-style">
                        <select class="block" id="category" name="category">
                            <option selected value="">{{ __("Select One") }}</option>
                            @foreach ($types as $type)
                                <option {{ ($classroom->category == $type->value) ? 'selected' : ''}} value="{{ $type->value }}">
                                    {{ $type->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has("category"))
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    @endif
                </div>
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Status") }}</h5>
                    <div class="eduman-radio-field-style">
                        <div class="single-input-field w-full">
                            <label for="opt-1" class="mr-4">
                                <input {{ ($classroom->status->value == 'Active') ? 'checked' : ''}} class="mr-1" type="radio" name="status" id="opt-1" value="Active" />
                                {{ __("Published") }}
                            </label>
                            <label for="opt-2" class="mr-4">
                                <input class="mr-1" {{ ($classroom->status->value == 'Pending') ? 'checked' : ''}} type="radio" name="status" id="opt-2" value="Pending" />
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
                        <button class="btn-primary" type="submit">{{ __("Update Classroom") }}</button>
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
    <script>
        (function ($) {
            "use strict"
            $(document).ready(function () {
                // Add
                $(document).on("click", ".add_item", function () {
                    $(this).closest(".item-container").append(`
                        <div class="repeater border-spacing-1 border-gray-300">
                            <div class="flex flex-row-reverse gap-x-1">
                                <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                                <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                            </div>
                            @include("partials.inputs.select", [
                                "label" => __("Lesson"),
                                "name" => "lessons[]",
                                "options" => $lessons,
                                "option_value" => "id",
                                "option_display" => "title",
                            ])
                        </div>
                    `)
                });
                // Remove
                $(document).on("click", ".remove_item", function (e) {
                    let repeater = $(this).closest(".repeater");
                    $(repeater).slideUp("slow", function () {
                        $(repeater).remove();
                    })
                });
            })
        })(jQuery)
    </script>
@endsection