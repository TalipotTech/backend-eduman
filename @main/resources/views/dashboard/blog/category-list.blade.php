@extends('layouts.master')

@section('title')
    {{ __('All Blog Categories') }}
@endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', [
        'path_array' => [
            __('Dashboard') => route('dashboard'),
            __('Blog Category') => '',
        ],
    ])
@endsection

@section('content')
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit">
                <div class="mb-10">
                    <h4 class="dashboard-edit-title mb-6">{{ __('All Blog Categories') }}</h4>
                </div>
                <table class="table hover stripe table-auto">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Slug') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blog_categories as $blog_category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ str()->limit($blog_category->name, 25) ?? '' }}</td>
                                <td>{{ str()->limit($blog_category->slug, 15) ?? '' }}</td>
                                <td>
                                    <img src="{{ uploaded_asset($blog_category->image) }}" alt="">
                                </td>
                                <td>
                                    @if ($blog_category->status)
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
                                    <x-common.table.btn-dropdown :title=" __('Action') ">
                                        <x-common.table.btn-dropdown-option :type="__('edit')" class="edit-item"
                                            data-href="{{ route('dashboard.blogs.category.edit', $blog_category->id) }}"
                                            data-name="{{ $blog_category->name }}"
                                            data-image="{{ uploaded_asset($blog_category->image) }}"
                                            data-status="{{ $blog_category->status }}"
                                        />
                                        <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item"
                                            data-url="{{ route('dashboard.blogs.category.delete', $blog_category->id) }}" />
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
                    <h4 class="dashboard-edit-title mb-6">{{ __('Add Blog Category') }}</h4>
                </div>
                <form action="{{ route('dashboard.blogs.category.new') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="md:col-span-6 col-span-12">
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

                    <div class="grid grid-cols-12 sm:gap-x-5">
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
                    </div>
                    <div class="eduman-managesale-top-btn default-light-theme justify-center mt-8">
                        <button class="btn-primary" type="submit">{{ __('Create Blog Category') }}</button>
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
                                <h4 class="text-[20px] text-heading font-bold category-modal-title">{{ __('Edit Blog Category') }}
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
                        <form id="edit_form" method="POST" enctype="multipart/form-data">
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
                            <div class="md:col-span-6 col-span-12">
                                <div class="eduman-select-field mb-8">
                                    <h5 class="text-[15px] text-heading font-semibold mb-3">
                                        {{ __("Upload Image") }}
                                    </h5>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input"
                                            id="edit_image" />
                                        <label class="custom-file-label" for="image">{{ __("Select Image") }}</label>
                                    </div>
                                    <div id="edit_image_preview" style="display: none">
                                        <img src="" alt="">
                                    </div>
                                </div>
                            </div>
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
                            </div>
                            <div class="eduman-managesale-top-btn default-light-theme justify-center mt-8">
                                <button class="btn-primary" type="submit">{{ __('Update Blog Category') }}</button>
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
                    $("#edit_image_preview").hide()
                });

                $(".edit-item").on("click", function() {
                    let href = $(this).data("href");
                    let name = $(this).data("name");
                    let image = $(this).data("image");
                    let status = $(this).data("status");
          
                    edit_form.action = href;
                    edit_name.value = name;
                    edit_image.src = image;
                    edit_status.value = status;
   
                    $(edit_image_preview).find("img").attr("src", image);

                    $("#edit_image_preview").show()
                    $("#edit_status").niceSelect('update');
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
