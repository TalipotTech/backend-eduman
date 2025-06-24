@extends('layouts.master')

@section('title')
    {{ __('All FAQs') }}
@endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', [
        'path_array' => [
            __('Dashboard') => route('dashboard'),
            __('FAQ') => '',
        ],
    ])
@endsection

@section('content')
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit">
                <div class="mb-10">
                    <h4 class="dashboard-edit-title mb-6">{{ __('All FAQs') }}</h4>
                </div>
                <table id="datatable-org" class="table hover stripe table-auto" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('State') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faqs as $faq)
                            <tr>
                                <td>{{ $faq->id }}</td>
                                <td>{{ str()->limit($faq->title, 25) ?? '' }}</td>
                                <td>{!! str()->limit($faq->description, 50) ?? '' !!}</td>
                                <td>
                                    @if ($faq->status)
                                        <span class="status-tag text-[12px] font-semibold leading-5 text-white px-2.5 h-5 rounded-[3px] inline-block bg-themeGreen">
                                            {{ __("Published") }}
                                        </span>
                                    @else
                                        <span class="status-tag text-[12px] font-semibold leading-5 text-white px-2.5 h-5 rounded-[3px] inline-block bg-themeWarn">
                                            {{ __("Pending") }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($faq->is_open)
                                        <span class="status-tag text-[12px] font-semibold leading-5 text-white px-2.5 h-5 rounded-[3px] inline-block bg-themeGreen">
                                            {{ __("Open") }}
                                        </span>
                                    @else
                                        <span class="status-tag text-[12px] font-semibold leading-5 text-white px-2.5 h-5 rounded-[3px] inline-block bg-themeWarn">
                                            {{ __("Closed") }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <x-common.table.btn-dropdown :title=" __('Action') ">
                                        <x-common.table.btn-dropdown-option :type="__('edit')" class="edit-item"
                                            data-href="{{ route('dashboard.faqs.edit', $faq->id) }}"
                                            data-title="{{ $faq->title }}"
                                            data-description="{{ $faq->description }}"
                                            data-status="{{ $faq->status }}"
                                            data-is-open="{{ $faq->is_open }}"
                                        />
                                        <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item"
                                            data-url="{{ route('dashboard.faqs.delete', $faq->id) }}" />
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
                    <h4 class="dashboard-edit-title mb-6">{{ __('Add FAQ') }}</h4>
                </div>
                <form action="{{ route('dashboard.faqs.new') }}" method="POST">
                    @csrf
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Title') }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-text-input id="title" name="title" class="block mt-1 w-full" type="text"
                                    required autofocus />
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
                    <div class="grid grid-cols-12 sm:gap-x-5">  
                        <div class="col-span-12">
                            <div class="eduman-select-field mb-5">
                                <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Select Category') }}</h5>
                                <div class="eduman-select-field-style">
                                    <select class="block" id="category" name="category">
                                        <option selected value="">{{ __('Select One') }}</option>
                                        @foreach($categories as $cat)
                                        <option value="{{$cat->value}}">
                                            {{ $cat->value }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('category'))
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                @endif
                            </div>
                        </div>
                        <div class="col-span-12">
                            <div class="eduman-select-field mb-5">
                                <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Select Status') }}</h5>
                                <div class="eduman-select-field-style">
                                    <select class="block" id="status" name="status">
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
                        <div class="col-span-12">
                            <div class="eduman-select-field mb-5">
                                <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Open State') }}</h5>
                                <div class="eduman-select-field-style">
                                    <select class="block" id="is_open" name="is_open">
                                        <option selected value="">{{ __('Select One') }}</option>
                                        <option value="1">{{ __("Open") }}</option>
                                        <option value="0">{{ __("Close") }}</option>
                                    </select>
                                </div>
                                <small class="text-gray-400">{{ __("Select if the FAQ item should be open initially") }}</small>
                                @if ($errors->has('is_open'))
                                    <x-input-error :messages="$errors->get('is_open')" class="mt-2" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="eduman-managesale-top-btn default-light-theme justify-center mt-8">
                        <button class="btn-primary" type="submit">{{ __('Create FAQ') }}</button>
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
                            <div class="grid grid-cols-12 gap-x-7 maxSm:gap-x-0">
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
                                        <div class="lg:col-span-6 col-span-12">
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
                                        <div class="lg:col-span-6 col-span-12">
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
                                                @if ($errors->has('is_open'))
                                                    <x-input-error :messages="$errors->get('is_open')" class="mt-2" />
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
                    let title = $(this).data("title");
                    let description = $(this).data("description");
        
                    let status = $(this).data("status");
                    let isOpen = $(this).data("isOpen");

                    edit_title.value = title;
                    tinymce.get("edit_description").setContent(description)
           
                    edit_status.value = status;
                    edit_is_open.value = isOpen;

                    $("#edit_status").niceSelect('update');
                    $("#edit_is_open").niceSelect('update');

                    $(".pop-outer form").attr("action", href);

                    $(".pop-outer").fadeIn("slow");
                });

                $('#datatable-org tbody').on( 'click', 'a.edit-item', function () {
                    let href = $(this).data("href");
                    let title = $(this).data("title");
                    let description = $(this).data("description");
        
                    let status = $(this).data("status");
                    let isOpen = $(this).data("isOpen");

                    edit_title.value = title;
                    tinymce.get("edit_description").setContent(description)
           
                    edit_status.value = status;
                    edit_is_open.value = isOpen;

                    $("#edit_status").niceSelect('update');
                    $("#edit_is_open").niceSelect('update');

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

                $('#datatable-org tbody').on( 'click', 'a.delete-item', function () {
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
                    return false;
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
    <script>
    // datatable activation
    var table = $('#datatable-org').DataTable( {
        responsive: true
    });
    </script>
@endsection
