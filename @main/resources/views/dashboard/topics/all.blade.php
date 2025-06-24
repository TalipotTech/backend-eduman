@extends('layouts.master')

@section('title') {{ __("All Topics") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Topics") => ""
    ]])
@endsection

@section('content')
    <div class="dashboard-edit">
        <div class="mb-10">
            <h4 class="dashboard-edit-title mb-6">{{ __("All Topics") }}</h4>
            <x-common.top-btn :text="__('New Topic')" href="{{ route('dashboard.topics.new') }}" />
        </div>
        <table id="datatable-org" class="table hover stripe table-auto" style="width:100%">
            <thead>
                <tr>
                    <th>{{ __("#") }}</th>
                    <th>{{ __("Title") }}</th>
                    <th>{{ __("Description") }}</th>
                    <th>{{ __("Status") }}</th>
                    <th>{{ __("Action") }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topics as $topic)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ str()->limit($topic->title, 30) }}</td>
                    <td>{!! str()->limit($topic->description, 25) ?? "" !!}</td>
                    <td>
                        @if ($topic->status)
                            <span class="status-tag text-[12px] font-semibold leading-5 text-white px-2.5 h-5 rounded-[3px] inline-block bg-themeGreen">
                                {{ __("Publised") }}
                            </span>
                        @else
                            <span class="status-tag text-[12px] font-semibold leading-5 text-white px-2.5 h-5 rounded-[3px] inline-block bg-themeWarn">
                                {{ __("Pending") }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <x-common.table.btn-dropdown :title=" __('Action') ">
                            <x-common.table.btn-dropdown-option :type="__('edit')" href="{{ route('dashboard.topics.edit', $topic->id) }}" />
                            <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item" data-url="{{ route('dashboard.topics.delete', $topic->id) }}" />
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
                        title: '{{ __("Do you want to delete this Topic?") }}',
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
                        title: '{{ __("Do you want to delete this Topic?") }}',
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
                            if (data.status == "success") {
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
