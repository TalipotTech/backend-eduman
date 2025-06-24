@extends('layouts.master')

@section('title')
    {{ __('All Sliders') }}
@endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', [
        'path_array' => [
            __('Dashboard') => route('dashboard'),
            __('Slider') => '',
        ],
    ])
@endsection

@section('content')
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit">
                <div class="mb-10">
                    <h4 class="dashboard-edit-title mb-6">{{ __('All Sliders') }}</h4>
                </div>
                <table id="datatable-org" class="table hover stripe table-auto" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Display Name') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $slider)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ str()->limit($slider->name, 25) ?? '' }}</td>
                                <td>{{ str()->limit($slider->display_name, 25) ?? '' }}</td>
                                <td>
                                    <x-common.table.btn-dropdown :title=" __('Action') ">
                                        <x-common.table.btn-dropdown-option :type="__('edit')" class="edit-item"
                                            data-href="{{ route('dashboard.slider.edit', $slider->id) }}"
                                            data-name="{{ $slider->name }}"
                                            data-display-name="{{ $slider->display_name }}"
                                        />
                                        <x-common.table.btn-dropdown-option :type="__('edit')" :btnText="'Edit Items'"
                                            href="{{ route('dashboard.slider.items.list', $slider->id) }}" />
                                        <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item"
                                            data-url="{{ route('dashboard.slider.delete', $slider->id) }}" />
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
                    <h4 class="dashboard-edit-title mb-6">{{ __('Add Slider') }}</h4>
                </div>
                <form action="{{ route('dashboard.slider.new') }}" method="POST">
                    @csrf
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Name') }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-text-input id="name" name="name" class="block mt-1 w-full" type="text"
                                    required autofocus />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Display Name') }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-text-input id="display_name" name="display_name" class="block mt-1 w-full" type="text"
                                    required autofocus />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('display_name')" class="mt-2" />
                    </div>
                    <div class="eduman-managesale-top-btn default-light-theme justify-center mt-8">
                        <button class="btn-primary" type="submit">{{ __('Create Slider') }}</button>
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
                                <h4 class="text-[20px] text-heading font-bold category-modal-title">{{ __('Edit Slider') }}
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
                            <div class="eduman-select-field mb-5">
                                <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Name') }}</h5>
                                <div class="eduman-input-field-style">
                                    <div class="single-input-field w-full">
                                        <x-text-input id="edit_name" name="name" class="block mt-1 w-full" type="text"
                                            required autofocus />
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="eduman-select-field mb-5">
                                <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Display Name') }}</h5>
                                <div class="eduman-input-field-style">
                                    <div class="single-input-field w-full">
                                        <x-text-input id="edit_display_name" name="display_name" class="block mt-1 w-full" type="text"
                                            required autofocus />
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('display_name')" class="mt-2" />
                            </div>
                            <div class="col-span-12">
                                <div class="eduman-popup-btn default-light-theme pt-1.5">
                                    <button type="submit" id="btn-modal-submit"
                                        class="btn-primary justify-center">{{ __('Save Now') }}</button>
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
                    let name = $(this).data("name");
                    let displayName = $(this).data("displayName");
     
                    edit_name.value = name;
                    edit_display_name.value = displayName;

                    $(".pop-outer form").attr("action", href);
                    $(".pop-outer").fadeIn("slow");
                });

                $('#datatable-org tbody').on( 'click', 'a.edit-item', function () {
                    let href = $(this).data("href");
                    let name = $(this).data("name");
                    let displayName = $(this).data("displayName");
                    edit_name.value = name;
                    edit_display_name.value = displayName;

                    $(".pop-outer form").attr("action", href);
                    $(".pop-outer").fadeIn("slow");

                    return false;
                });

                $('.delete-item').on('click', function(e) {
                    e.preventDefault();

                    let url = $(this).data('url');

                    Swal.fire({
                        title: '{{ __("Do you want to delete this Item?") }}',
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
                        title: '{{ __("Do you want to delete this Item?") }}',
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
