@extends('layouts.master')

@section('title') {{ __("Create Quiz") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Quiz") => route("dashboard.quiz.list"),
        __("Create Quiz") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Create Quiz") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Quizs')" class="mb-0" href="{{ route('dashboard.quiz.list') }}" />
</div>
<form method="POST" action="{{ route('dashboard.quiz.new') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Quiz Title") }}</h5>
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
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Description") }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-tinymce.editor :id="'description'" :name="'description'" :type="'html'" />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>
                {{-- ========== repeater start ========== --}}
                <div class="item-container">
                    <div class="repeater border-spacing-1 border-gray-300">
                        <div class="flex flex-row-reverse gap-x-1">
                            <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                            <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                        </div>
                        @include("partials.inputs.select", [
                            "label" => __("Question"),
                            "name" => "questions[]",
                            "options" => $questions,
                           // "selected" => $event->category_id,
                            "option_value" => "id",
                            "option_display" => "title",
                        ])
                    </div>
                </div>
                {{-- ========== repeater - end ========== --}}
   
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10"> 
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Quiz Type") }}</h5>
                    <div class="eduman-select-field-style">
                        <select class="block" id="category" name="category">
                            <option selected value="">{{ __("Select One") }}</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->value }}">
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
                <hr />

                <div class="eduman-select-field mt-5 mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Quiz attempt ") }}</h5>
                    <div class="eduman-input-field-style">
                        <div class="single-input-field w-full">
                            <x-text-input id="quiz_attempt" name="quiz_attempt" class="block mt-1 w-full" type="text" :value="3" required autofocus />
                        </div>
                    </div>
                    @if ($errors->has("quiz_attempt"))
                        <x-input-error :messages="$errors->get('quiz_attempt')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-12 mt-5 mb-5">
                    <label for="active_timer" class="mr-4">
                        <input class="mr-1" type="checkbox" name="active_timer" id="active_timer" value="1" />
                        {{ __("Active Timer") }}
                    </label>
                </div>

                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Set Time in min") }}</h5>
                    <div class="eduman-input-field-style">
                        <div class="single-input-field w-full">
                            <x-text-input id="timer_time" name="timer_time" class="block mt-1 w-full" type="text" :value="30" required autofocus />
                        </div>
                    </div>
                    @if ($errors->has("timer_time"))
                        <x-input-error :messages="$errors->get('timer_time')" class="mt-2" />
                    @endif
                </div>

                <div class="col-span-12 mt-5 mb-5">
                    <label for="allow_negative_mark" class="mr-4">
                        <input class="mr-1" type="checkbox" name="allow_negative_mark" id="allow_negative_mark" value="1" />
                        {{ __("Allow negative marks") }}
                    </label>
                </div>
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Mark Type") }}</h5>
                    <div class="eduman-radio-field-style">
                        <div class="single-input-field w-full">
                            <label for="opt-3" class="mr-4">
                                <input class="mr-1" type="radio" name="flat" id="opt-3" value="1" />
                                {{ __("Flat") }}
                            </label>
                            <label for="opt-4" class="mr-4">
                                <input class="mr-1" type="radio" name="flat" id="opt-4" value="0" />
                                {{ __("Percentage") }}
                            </label>
                        </div>
                    </div>
                    @if ($errors->has("flat"))
                        <x-input-error :messages="$errors->get('flat')" class="mt-2" />
                    @endif
                </div>

                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Mark Percentage") }}</h5>
                    <div class="eduman-select-field-style">
                        <select class="block" id="negative_percentage" name="negative_percentage">
                            <option selected value="0">{{ __("Select One") }}</option>
                            <option selected value="100">{{ __("100%") }}</option>
                            <option selected value="50">{{ __("50%") }}</option>
                            <option selected value="25">{{ __("25%") }}</option>
                            <option selected value="0">{{ __("0%") }}</option>
                        </select>
                    </div>
                    @if ($errors->has("negative_percentage"))
                        <x-input-error :messages="$errors->get('negative_percentage')" class="mt-2" />
                    @endif
                </div>
                <div class="col-span-12 mt-12">
                    <div class="eduman-managesale-top-btn default-light-theme justify-center">
                        <button class="btn-primary" type="submit">{{ __("Create Quiz") }}</button>
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
                                "label" => __("Question"),
                                "name" => "questions[]",
                                "options" => $questions,
                            // "selected" => $event->category_id,
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