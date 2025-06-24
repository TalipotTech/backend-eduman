@extends('layouts.master')

@section('title') {{ __("All Events") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Events") => ""
    ]])
@endsection

@section('content')
    <div class="dashboard-edit">
        <div class="mb-10">
            <h4 class="dashboard-edit-title mb-6">{{ __("All Events") }}</h4>
            <x-common.top-btn :text="__('New Event')" href="{{ route('dashboard.event.new') }}" />
        </div>
        <table id="datatable-org" class="table hover stripe table-auto" style="width:100%">
            <thead>
                <tr>
                    <th>{{ __("ID") }}</th>
                    <th>{{ __("Image") }}</th>
                    <th>{{ __("Title") }}</th>
                    <th>{{ __("Available Seat") }}</th>
                    <th>{{ __("Type") }}</th>
                    <th>{{ __("Status") }}</th>
                    <th>{{ __("Action") }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td><img src="{{ uploaded_asset($event->image_url) }}" alt="image" width="100" height="80" /></td>
                    <td>{{ str()->limit($event->title, 25) }}</td>
                    <td>{{ str()->limit($event->available_seat, 15) }}</td>
                    <td>{{ str()->limit(optional($event->Category)->title, 25) }}</td>
                    <td>
                        <x-common.table.status :status="$event->status" />
                    </td>
                    <td>
                        <x-common.table.btn-dropdown :title=" __('Action') ">
                            <x-common.table.btn-dropdown-option :type="__('edit')" class="edit-item" href="{{ route('dashboard.event.edit', $event->id) }}" />
                            <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item" data-url="{{ route('dashboard.event.delete', $event->id) " />
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
                        title: '{{ __("Do you want to delete this Event?") }}',
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
                        title: '{{ __("Do you want to delete this Event?") }}',
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
