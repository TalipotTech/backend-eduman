@extends('layouts.master')

@section('title')
    {{ __('All Menus') }}
@endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', [
        'path_array' => [
            __("Dashboard") => route('dashboard'),
            __("Menu") => '',
        ],
    ])
@endsection

@section('content')
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            @foreach ($menusList as $mkey => $menuName)
            <div class="dashboard-edit">
                <div class="mb-10">
                    <h4 class="dashboard-edit-title mb-6">{{ __('All Menus of ') }} {{ $menuName }}</h4>
                </div>
                <table id="menus-{{$mkey}}" class="table hover stripe table-auto" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Icon') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('URL') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus[$menuName] as $menu)
                            <tr>
                                <td>{{ $menu->id }}</td>
                                <td>
                                    <i class="{{ $menu->icon }}"></i>
                                </td>
                                <td>{{ str()->limit($menu->title, 25) ?? '' }}</td>
                                <td>{!! str()->limit($menu->url, 25) ?? '' !!}</td>
                                <td>{{ $menu->category }}</td>
                                <td>
                                    <x-common.table.btn-dropdown :title=" __('Action') ">
                                        <x-common.table.btn-dropdown-option :type="__('edit')" class="edit-item"
                                            data-href="{{ route('dashboard.settings.menus.edit', $menu->id) }}"
                                            data-title="{{ $menu->title }}" data-category="{{ $menu->category }}"
                                            data-icon="{{ $menu->icon }}" data-title="{{ $menu->title }}"
                                            data-url="{{ $menu->url }}"
                                            data-parent-id="{{ $menu->parent_id }}"
                                        />
                                        <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item"
                                            data-url="{{ route('dashboard.settings.menus.delete', $menu->id) }}" />
                                    </x-common.table.btn-dropdown>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
        <div class="lg:col-span-4 col-span-12">
            <div class="dashboard-edit">
                <div class="mb-10">
                    <h4 class="dashboard-edit-title mb-6">{{ __('Add Menu') }}</h4>
                </div>
                <form action="{{ route('dashboard.settings.menus.new') }}" method="POST">
                    @csrf
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Select Parent Menu') }}</h5>
                        <div class="eduman-select-field-style">
                            <select class="block" id="parent_id" name="parent_id">
                                <option selected value="">{{ __('No Parent') }}</option>
                                @foreach ($parentMenus as $menu)
                                    <option value="{{ $menu->id }}">
                                        {{ $menu->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('parent_id'))
                            <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                        @endif
                    </div>

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
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('URL') }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-text-input id="url" name="url" class="block mt-1 w-full" type="text"
                                    required autofocus />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('url')" class="mt-2" />
                    </div>
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Category') }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-text-input id="category" name="category" class="block mt-1 w-full" type="text"
                                    required autofocus />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>
                    {{-- icon picker - start --}}
                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Icon') }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-text-input id="icon" name="icon" class="block mt-1 w-full" type="text"
                                    required autofocus />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                        <span class="text-gray-400 block mt-1 mx-2">{{ __('Insert any fontawesome icon here') }}</span>
                    </div>
                    {{-- icon picker - end --}}
                    <div class="eduman-managesale-top-btn default-light-theme justify-center mt-8">
                        <button class="btn-primary" type="submit">{{ __('Create Topic') }}</button>
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
                                <h4 class="text-[20px] text-heading font-bold category-modal-title">{{ __('Edit Menu') }}
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
                        <form method="POST" action="{{ route('dashboard.settings.menus.new') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-12 gap-x-7 maxSm:gap-x-0">
                                <div class="col-span-12">
                                    <div class="eduman-select-field mb-5">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">
                                            {{ __('Select Parent Menu') }}</h5>
                                        <div class="eduman-select-field-style">
                                            <select class="block" id="edit_parent_id" name="parent_id">
                                                <option value="0">{{ __('No Parent') }}</option>
                                                @foreach ($parentMenus as $menu)
                                                    <option value="{{ $menu->id }}">
                                                        {{ $menu->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('parent_id'))
                                            <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                                        @endif
                                    </div>
                                </div>
                                <div class="col-span-12">
                                    <div class="eduman-select-field mb-6">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Title') }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <input id="edit_title" name="title" type="text" placeholder="{{ __('Title') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12">
                                    <div class="eduman-select-field mb-6">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('URL') }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <input id="edit_url" name="url" type="text" placeholder="{{ __('URL') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:col-span-6 col-span-12">
                                    <div class="eduman-select-field mb-6">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Category') }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <input type="text" id="edit_category" name="category"
                                                    placeholder="{{ __('Category') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:col-span-6 col-span-12">
                                    <div class="eduman-select-field mb-6">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Icon') }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <input type="text" id="edit_icon" name="icon"
                                                    placeholder="{{ __('Icon') }}" />
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
    <script>
        (function() {
            $(document).ready(function() {
                $(".modal-close").on("click", function(e) {
                    e.preventDefault();
                    $(this).closest(".pop-outer").fadeOut("slow");
                });

                $(".edit-item").on("click", function() {
                    let parentId = $(this).data("parent-id");
                    let href = $(this).data("href");
                    let title = $(this).data("title");
                    let category = $(this).data("category");
                    let icon = $(this).data("icon");
                    let url = $(this).data("url");
                    edit_parent_id.value = parentId;
                    edit_title.value = title;
                    edit_url.value = url;
                    edit_category.value = category;
                    edit_icon.value = icon;
    
                    $("#edit_parent_id").niceSelect('update');

                    $(".pop-outer form").attr("action", href);

                    $(".pop-outer").fadeIn("slow");
                });

                @foreach ($menusList as $mkey => $menuName)
                $('#menus-{{$mkey}}').on( 'click', 'a.edit-item', function () {
                    let parentId = $(this).data("parent-id");
                    let href = $(this).data("href");
                    let title = $(this).data("title");
                    let category = $(this).data("category");
                    let icon = $(this).data("icon");
                    let url = $(this).data("url");
                    edit_parent_id.value = parentId;
                    edit_title.value = title;
                    edit_url.value = url;
                    edit_category.value = category;
                    edit_icon.value = icon;
    
                    $("#edit_parent_id").niceSelect('update');

                    $(".pop-outer form").attr("action", href);

                    $(".pop-outer").fadeIn("slow");
                    return false;
                });
                @endforeach

                $('.delete-item').on('click', function(e) {
                    e.preventDefault();

                    let url = $(this).data('url');

                    Swal.fire({
                        title: '{{ __("Do you want to delete this Item?") }}',
                        showCancelButton: true,
                        confirmButtonText: '{{ __("Delete") }}',
                        confirmButtonColor: '#d33',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteItem(url);
                        }
                    });
                });

                @foreach ($menusList as $mkey => $menuName)
                $('#menus-{{$mkey}}').on( 'click', 'a.delete-item', function () {
                    let url = $(this).data('url');
                    Swal.fire({
                        title: '{{ __("Do you want to delete this Item?") }}',
                        showCancelButton: true,
                        confirmButtonText: '{{ __("Delete") }}',
                        confirmButtonColor: '#d33',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteItem(url);
                        }
                    });
                    return false;
                });
                @endforeach

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

                            return Swal.fire('Error!', '{{ __("An error occurred!") }}', 'error')
                        },
                        error: function(err) {
                            return Swal.fire('Error!', '{{ __("An error occurred!") }}', 'error')
                        }
                    });
                }
            });
        })()
    </script>
    @foreach ($menusList as $mkey => $menuName)
    <script>
    var table = $('#menus-{{$mkey}}').DataTable( {
        responsive: true
    });
    </script>
    @endforeach
@endsection
