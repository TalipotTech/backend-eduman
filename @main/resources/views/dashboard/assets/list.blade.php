@extends('layouts.master')

@section('title')
    {{ __('All Assets') }}
@endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', [
        'path_array' => [
            __('Dashboard') => route('dashboard'),
            __('Asset') => '',
        ],
    ])
@endsection

@section('content')
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="xl:col-span-8 col-span-12">
            <div class="dashboard-edit">
                <div class="mb-10">
                    <h4 class="dashboard-edit-title mb-6">{{ __('All Assets') }}</h4>
                </div>
                <table id="datatable-org" class="table hover stripe table-auto" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Media 1') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bd-media-image-list-wrap">
                        @foreach ($assets as $asset)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img width="100" src="{{ uploaded_asset($asset->path) }}" alt="{{ __('image') }}" />
                                    <span class="bd-media-image-list-img"><b>{{ __('AssetUrl:') }}</b> {{ uploaded_asset($asset->path) }}</span>
                                </td>
                                <td>{{ $asset->title }}</td>
                                <td>{{ $asset->category }}</td>
                                <td>
                                    <x-common.table.btn-dropdown :title=" __('Action') ">
                                        <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item"
                                            data-url="{{ route('dashboard.assets.delete', $asset->id) }}" />
                                    </x-common.table.btn-dropdown>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="xl:col-span-4 col-span-12">
            <div class="dashboard-edit">
                <div class="mb-10">
                    <h4 class="dashboard-edit-title mb-6">{{ __('Add Asset') }}</h4>
                </div>
                <form action="{{ route('dashboard.assets.new') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="eduman-select-field mb-8">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">
                            {{ __('Upload Feature Image') }}
                        </h5>
                        <div class="custom-file">
                            <input type="file" name="image_url" class="custom-file-input"
                                id="image_url" />
                            <label class="custom-file-label" for="image_url">{{ __('Select Image') }}</label>
                        </div>
                    </div>

                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Category Page') }}</h5>
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-text-input id="category" name="category" class="block mt-1 w-full" type="text"
                                    required autofocus />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>
                
                    <div class="eduman-managesale-top-btn default-light-theme justify-center mt-8">
                        <button class="btn-primary" type="submit">{{ __('Create FAQ') }}</button>
                    </div>
                </form>
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
                } );

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
