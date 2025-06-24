@extends('layouts.master')

@section('title')
    {{ __('All Featured Items') }}
@endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', [
        'path_array' => [
            __('Dashboard') => route('dashboard'),
            __('Featured Item') => '',
        ],
    ])
@endsection

@section('content')
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="col-span-8">
            <div class="dashboard-edit">
                <div class="mb-10">
                    <h4 class="dashboard-edit-title mb-6">{{ __('All Featured Items') }}</h4>
                </div>
                <table class="table hover stripe table-auto">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Start Date') }}</th>
                            <th>{{ __('End Date') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($featured_courses as $featured_course)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ str()->limit(optional($featured_course->course)->title, 25) ?? "" }}</td>
                                <td>{{ date("F jS, Y", strtotime($featured_course->from_date)) }}</td>
                                <td>{{ date("F jS, Y", strtotime($featured_course->end_date)) }}</td>
                                <td>
                                    <x-common.table.btn-dropdown :title=" __('Action') ">
                                        <x-common.table.btn-dropdown-option :type="__('edit')" class="edit-item"
                                            data-href="{{ route('dashboard.featured_courses.edit', $featured_course->id) }}"
                                            data-course_id="{{ $featured_course->course_id }}"
                                            data-from_date="{{ $featured_course->from_date }}"
                                            data-end_date="{{ $featured_course->end_date }}"
                                        />
                                        <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item"
                                            data-url="{{ route('dashboard.featured_courses.delete', $featured_course->id) }}" />
                                    </x-common.table.btn-dropdown>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-span-4">
            <div class="dashboard-edit">
                <div class="mb-10">
                    <h4 class="dashboard-edit-title mb-6">{{ __('Add Featured Item') }}</h4>
                </div>
                <form action="{{ route('dashboard.featured_courses.new') }}" method="POST">
                    @csrf
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Select Course') }}</h5>
                        <div class="eduman-select-field-style">
                            <select class="block" id="course_id" name="course_id">
                                <option selected value="">{{ __('Select One') }}</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('course_id'))
                            <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                        @endif
                    </div>
                    <div class="col-span-12">
                        <div class="eduman-select-field mb-5">
                            <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Start Date") }}</h5>
                            <div class="eduman-input-field-style">
                                <div class="single-input-field w-full">
                                    <input type="datetime-local" name="from_date" id="from_date" >
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('from_date')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-span-12">
                        <div class="eduman-select-field mb-5">
                            <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("End Date") }}</h5>
                            <div class="eduman-input-field-style">
                                <div class="single-input-field w-full">
                                    <input type="datetime-local" name="end_date" id="end_date" >
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>
                    <div class="eduman-managesale-top-btn default-light-theme justify-center mt-8">
                        <button class="btn-primary" type="submit">{{ __('Create Featured Item') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div style="display: none;" class="pop-outer edit-modal">
        <div class="relative md:h-auto">
            <div class="eduman-dialog-content">
                <div class="popup-body">
                    <div class="eduman-popup-inner">
                        <div class="eduman-popup-header relative mb-11">
                            <div class="eduman-popup-header-title">
                                <h4 class="text-[20px] text-heading font-bold category-modal-title">{{ __('Edit Featured Item') }}
                                </h4>
                            </div>
                            <div class="eduman-popup-header-close absolute -top-0 right-0">
                                <div class="default-light-theme">
                                    <a class="modal-close cursor-pointer">
                                        <i class="fa-light fa-xmark"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-12 gap-x-7 maxSm:gap-x-0">
                                <div class="eduman-select-field mb-5">
                                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Select Course') }}</h5>
                                    <div class="eduman-select-field-style">
                                        <select class="block" id="edit_course_id" name="course_id">
                                            <option selected value="">{{ __('Select One') }}</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">
                                                    {{ $course->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('course_id'))
                                        <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                                    @endif
                                </div>
                                <div class="col-span-12">
                                    <div class="eduman-select-field mb-5">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Start Date") }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <input type="datetime-local" name="from_date" id="edit_from_date" >
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('from_date')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-span-12">
                                    <div class="eduman-select-field mb-5">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("End Date") }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <input type="datetime-local" name="end_date" id="edit_end_date" >
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-span-12">
                                    <div class="eduman-popup-btn default-light-theme pt-1.5">
                                        <button type="submit" id="btn-modal-submit"
                                            class="btn-primary justify-center">{{ __('Save Now') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <x-utils.swal-js />
    <x-utils.datatable.js />
    <x-tinymce.init />
    <script>
        (function() {
            $(document).ready(function() {
                $(".modal-close").on("click", function(e) {
                    e.preventDefault();
                    $(this).closest(".pop-outer").fadeOut("slow");
                });

                $(".edit-item").on("click", function() {
                    let href = $(this).data("href");
                    let course_id = $(this).data("course_id");
                    let from_date = $(this).data("from_date");
                    let end_date = $(this).data("end_date");

                    edit_course_id.value = course_id;
                    $("#edit_course_id").niceSelect('update');
                    edit_from_date.value = from_date;
                    edit_end_date.value = end_date;

                    $(".pop-outer form").attr("action", href);

                    $(".pop-outer").fadeIn("slow");
                });

                $('.delete-item').on('click', function(e) {
                    e.preventDefault();

                    let url = $(this).data('url');

                    Swal.fire({
                        title: "{{ __('Do you want to delete this Item?') }}",
                        showCancelButton: true,
                        confirmButtonText: "{{ __('Delete') }}",
                        confirmButtonColor: '#d33',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteItem(url);
                        }
                    });
                });

                function deleteItem(url) {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                Swal.fire('Deleted!', data.message, 'error')
                                return setTimeout(() => {
                                    return location.reload();
                                }, 1000);
                            }

                            return Swal.fire('Error!', "{{ __('An error occurred!') }}", 'error')
                        },
                        error: function(err) {
                            return Swal.fire('Error!', "{{ __('An error occurred!') }}", 'error')
                        }
                    });
                }
            });
        })()
    </script>
@endsection
