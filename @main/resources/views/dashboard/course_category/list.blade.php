@extends('layouts.master')

@section('title') {{ __("All Authors") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        "Dashboard" => route("dashboard"),
        "Category" => ""
    ]])
@endsection

@section('content')
    <div class="dashboard-edit">
        <div class="mb-10">
            <h4 class="dashboard-edit-title mb-6">{{ __("All Categories") }}</h4>
            <x-common.top-btn :text="__('New Category')" href="{{ route('dashboard.courseCategory.new') }}" />
        </div>
        <table id="datatable-org" class="table hover stripe table-auto" style="width:100%">
            <thead>
                <tr>
                    <th>{{ __("ID") }}</th>
                    <th>{{ __("Course") }}</th>
                    <th>{{ __("Category") }}</th>
                    <th>{{ __("Action") }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cats as $cat)
                <tr>
                    <td>{{ $cat->id }}</td>
                    <td>{{ $cat->course->title }}</td>
                    <td>{{ $cat->category->title }}</td>
                    <td>
                        <x-common.table.btn-dropdown :title=" __('Action') ">
                            <x-common.table.btn-dropdown-option :type="__('edit')" href="{{ route('dashboard.courseCategory.edit', $cat->id) }}" />
                            <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item" data-url="{{ route('dashboard.courseCategory.delete', $cat->id) }}" />
                        </x-common.table.btn-dropdown>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('js')
    <x-utils.swal-js />
    <x-utils.datatable.js />
    <script>
        (function () {
            $(document).ready(function () {
                $('.delete-item').on('click', function (e) {
                    e.preventDefault();

                    let url = $(this).data('url');

                    Swal.fire({
                        title: '{{ __("Do you want to delete this Category?") }}',
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
                        title: '{{ __("Do you want to delete this Category?") }}',
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
                            if (data.status == '200') {
                                Swal.fire('Deleted!', data.message, 'success')
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
