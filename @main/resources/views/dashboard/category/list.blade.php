@extends('layouts.master')

@section('title')
    {{ __('All Categories') }}
@endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', [
        'path_array' => [
            'Dashboard' => route('dashboard'),
            'Category' => '',
        ],
    ])
@endsection

@section('content')
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="col-span-12">
            <div class="dashboard-edit">
                <div class="mb-10">
                    <h4 class="dashboard-edit-title mb-6">{{ __('All Categories') }}</h4>
                    <x-common.top-btn :text="__('New Category')" class="add-item" href="{{ route('dashboard.category.new') }}" />
                </div>
                <table id="datatable-org" class="table hover stripe table-auto" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Parent') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->type }}</td>
                                <td>{{ $category->title }}</td>
                                <td>{{ $category->parentCategory?->title ?? '-' }}</td>
                                <td>
                                    <x-common.table.btn-dropdown :title=" __('Action') ">
                                        <x-common.table.btn-dropdown-option :type="__('edit')" class="edit-item"
                                            href="{{ route('dashboard.category.edit', $category->id) }}"
                                        />
                                        <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item"
                                            data-url="{{ route('dashboard.category.delete', $category->id) }}" />
                                    </x-common.table.btn-dropdown>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
