@extends('layouts.master')

@section('title') {{ __("Create Question") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Question") => route("dashboard.questions.list"),
        __("Create Question") => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Create Question") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Questions')" class="mb-0" href="{{ route('dashboard.questions.list') }}" />
</div>
<form method="POST" action="{{ route('dashboard.questions.new') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit p-10">
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Question") }}</h5>
                    <div class="eduman-input-field-style">
                        <div class="single-input-field w-full">
                            <x-text-input id="title" name="title" class="block mt-1 w-full" type="text" required autofocus />
                        </div>
                    </div>
                    @if ($errors->has("title"))
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    @endif
                </div>
                {{-- ========== repeater start ========== --}}
                <div class="item-container">
                    <div class="repeater border-spacing-1 border-gray-300">
                        <div class="flex flex-row-reverse gap-x-1">
                            <button type="button" class="add_item rounded-full bg-green-600 text-white w-8 h-8">+</button>
                            <button type="button" class="remove_item rounded-full bg-red-600 text-white w-8 h-8">x</button>
                        </div>
                        @include("partials.inputs.input", [
                            "label" => __("Options"),
                            "name" => "answers[]",
                            "type" => "text",
                            "value" => "",
                        ])
                    </div>
                </div>
                {{-- ========== repeater - end ========== --}}
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Correct Answer") }}</h5>
                    <div class="eduman-input-field-style">
                        <div class="single-input-field w-full">
                            <x-text-input id="correct_answer" name="correct_answer" class="block mt-1 w-full" type="text" autofocus />
                        </div>
                    </div>
                    @if ($errors->has("correct_answer"))
                        <x-input-error :messages="$errors->get('correct_answer')" class="mt-2" />
                    @endif
                </div>
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Question Points") }}</h5>
                    <div class="eduman-input-field-style">
                        <div class="single-input-field w-full">
                            <x-text-input id="points" name="points" class="block mt-1 w-full" type="text" autofocus />
                        </div>
                    </div>
                    @if ($errors->has("points"))
                        <x-input-error :messages="$errors->get('points')" class="mt-2" />
                    @endif
                </div>
                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Explanation") }}</h5>
                    <div class="eduman-input-field-style">
                        <div class="single-input-field w-full">
                            <textarea name="explanation" id="explanation" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    @if ($errors->has("explanation"))
                    <x-input-error :messages="$errors->get('explanation')" class="mt-2" />
                    @endif
                </div>
            </div>
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit p-10"> 

                <div class="eduman-select-field mb-5">
                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Question Type") }}</h5>
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
                <div class="col-span-12 mt-12">
                    <div class="eduman-managesale-top-btn default-light-theme justify-center">
                        <button class="btn-primary" type="submit">{{ __("Create Question") }}</button>
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
                            @include("partials.inputs.input", [
                                "label" => __("Options"),
                                "name" => "answers[]",
                                "type" => "text",
                                "value" => "",
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