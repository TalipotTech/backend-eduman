@extends('layouts.master')

@section('title') {{ __("All Event Types") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Events") => route("dashboard.event.list"),
        __("Event Type") => ""
    ]])
@endsection

@section('content')
<div class="grid grid-cols-12 sm:gap-x-5">
    <div class="lg:col-span-8 col-span-12">
        <div class="dashboard-edit">
            <div class="mb-10">
                <h4 class="dashboard-edit-title mb-6">{{ __('All Event Types') }}</h4>
            </div>
            <table id="datatable-org" class="table hover stripe table-auto" style="width:100%">
                <thead>
                    <tr>
                        <th>{{ __("ID") }}</th>
                        <th>{{ __("Title") }}</th>
                        <th>{{ __("Action") }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($event_types as $event_type)
                    <tr>
                        <td>{{ $event_type->id }}</td>
                        <td>{{ $event_type->title }}</td>
                        <td>
                            <x-common.table.btn-dropdown :title=" __('Action') ">
                                <x-common.table.btn-dropdown-option :type="__('edit')" class="edit-item"
                                    data-href="{{ route('dashboard.event.type.edit', $event_type->id) }}"
                                    data-title="{{ $event_type->title }}"
                                    data-description="{{ $event_type->description }}"
                                />
                                <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item" data-url="{{ route('dashboard.event.type.delete', $event_type->id) }}" />
                            </x-common.table.btn-dropdown>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="lg:col-span-4 col-span-12">
        <div class="dashboard-edit">
            <div class="mb-10">
                <h4 class="dashboard-edit-title mb-6">{{ __('Add Event Type') }}</h4>
            </div>
            <form action="{{ route('dashboard.event.type.new') }}" method="POST">
                @csrf
                @include("partials.inputs.input", [
                    "label" => __("Name"),
                    "name" => "title",
                    "type" => "text",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("Description"),
                    "name" => "description",
                    "type" => "html",
                ])
                <div class="eduman-managesale-top-btn default-light-theme justify-center mt-8">
                    <button class="btn-primary" type="submit">{{ __('Create Event Type') }}</button>
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
                            <h4 class="text-[20px] text-heading font-bold category-modal-title">{{ __('Edit FAQ') }}
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
                        @include("partials.inputs.input", [
                            "label" => __("Name"),
                            "name" => "title",
                            "id" => "edit_title",
                            "type" => "text",
                        ])
                        @include("partials.inputs.textarea", [
                            "label" => __("Description"),
                            "name" => "description",
                            "id" => "edit_description",
                            "type" => "html",
                        ])
                        <div class="eduman-managesale-top-btn default-light-theme justify-center mt-8">
                            <button class="btn-primary" type="submit">{{ __('Create Event Type') }}</button>
                        </div>
                        {{-- <div class="grid grid-cols-12 gap-x-7 maxSm:gap-x-0">
                            <div class="col-span-12">
                                <div class="eduman-select-field mb-6">
                                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Title') }}</h5>
                                    <div class="eduman-input-field-style">
                                        <div class="single-input-field w-full">
                                            <input id="edit_title" name="title" type="text" placeholder="Title" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12">
                                <div class="eduman-select-field mb-5">
                                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Description") }}</h5>
                                    <div class="eduman-input-field-style">
                                        <div class="single-input-field w-full">
                                            <x-tinymce.editor :id="'edit_description'" :name="'description'" :type="'html'" />
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-span-12">
                                <div class="grid grid-cols-12 sm:gap-x-5">
                                    <div class="col-span-6">
                                        <div class="eduman-select-field mb-5">
                                            <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Select Status') }}</h5>
                                            <div class="eduman-select-field-style">
                                                <select class="block" id="edit_status" name="status">
                                                    <option selected value="">{{ __('Select One') }}</option>
                                                    <option value="Active">{{ __("Published") }}</option>
                                                    <option value="Pending">{{ __("Pending") }}</option>
                                                </select>
                                            </div>
                                            @if ($errors->has('status'))
                                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-span-6">
                                        <div class="eduman-select-field mb-5">
                                            <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Open State') }}</h5>
                                            <div class="eduman-select-field-style">
                                                <select class="block" id="edit_is_open" name="is_open">
                                                    <option selected value="">{{ __('Select One') }}</option>
                                                    <option value="1">{{ __("Open") }}</option>
                                                    <option value="0">{{ __("Close") }}</option>
                                                </select>
                                            </div>
                                            <span class="text-gray-400">{{ __("Select if the FAQ item should be open initially") }}</span>
                                            @if ($errors->has('status'))
                                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12">
                                <div class="eduman-popup-btn default-light-theme pt-1.5">
                                    <button type="submit" id="btn-modal-submit"
                                        class="btn-primary justify-center">{{ __('Save Now') }}</button>
                                </div>
                            </div>
                        </div> --}}
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
        (function () {
            $(document).ready(function () {
                $(".modal-close").on("click", function(e) {
                    e.preventDefault();
                    $(this).closest(".pop-outer").fadeOut("slow");
                    $("#edit_image_preview").hide()
                });

                $(".edit-item").on("click", function(e) {
                    e.preventDefault();

                    let href = $(this).data("href");

                    let title = $(this).data("title");
                    let description = $(this).data("description");
   

                    edit_title.value = title;
                    tinymce.get("edit_description").setContent(description)
               

                    $(".pop-outer form").attr("action", href);

                    $(".pop-outer").fadeIn("slow");
                });

                $('#datatable-org tbody').on( 'click', 'a.edit-item', function () {
                    let href = $(this).data("href");
                    let title = $(this).data("title");
                    let description = $(this).data("description");
                    edit_title.value = title;
                    tinymce.get("edit_description").setContent(description)
                    $(".pop-outer form").attr("action", href);
                    $(".pop-outer").fadeIn("slow");
                    return false;
                });

                $('.delete-item').on('click', function (e) {
                    e.preventDefault();

                    let url = $(this).data('url');

                    Swal.fire({
                        title: '{{ __("Do you want to delete this Event Type?") }}',
                        showCancelButton: true,
                        confirmButtonText: 'Delete',
                        confirmButtonColor: '#d33',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteItem(url);
                        }
                    });
                });

                $('#datatable-org tbody').on( 'click', 'a.delete-item', function () {
                    let url = $(this).data('url');
                    Swal.fire({
                        title: '{{ __("Do you want to delete this Event Type?") }}',
                        showCancelButton: true,
                        confirmButtonText: 'Delete',
                        confirmButtonColor: '#d33',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteItem(url);
                        }
                    });
                    return false;
                });

                function deleteItem(url) {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            if (data.status == 'success') {
                                Swal.fire('Deleted!', data.message, 'error')
                                return setTimeout(() => {
                                    return location.reload();
                                }, 1000);
                            }

                            return Swal.fire('Error!', '{{ __("An error occurred!") }}', 'error')
                        },
                        error: function (err) {
                            return Swal.fire('Error!', '{{ __("An error occurred!") }}', 'error')
                        }
                    });
                }
            });
        })()
    </script>
    <script>
    // datatable activation
    var table = $('#datatable-org').DataTable( {
        responsive: true
    });
    </script>
@endsection
