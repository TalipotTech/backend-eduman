@extends('layouts.master')

@section('title') {{ __("All Events") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Order") => ""
    ]])
@endsection

@section('content')
    <div class="dashboard-edit">
        <div class="mb-10">
            <h4 class="dashboard-edit-title mb-6">{{ __("All Orders") }}</h4>
        </div>
        <table id="datatable-org" class="table hover stripe table-auto" style="width:100%">
            <thead>
                <tr>
                    <th>{{ __("ID") }}</th>
                    <th>{{ __("Title") }}</th>
                    <th>{{ __("Amount") }}</th>
                    <th>{{ __("First Name") }}</th>
                    <th>{{ __("Last Name") }}</th>
                    <th>{{ __("Email") }}</th>
                    <th>{{ __("Phone") }}</th>
                    <th>{{ __("Payment ID") }}</th>
                    <th>{{ __("Status") }}</th>
                    <th>{{ __("Action") }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->description ?? ""}}</td>
                    <td>{{ round($order->total/100, 2)}} {{ $order->currency }}</td>
                    <td>{{ $order->first_name }}</td>
                    <td>{{ $order->last_name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->mollie_payment_id ?? "" }}</td>
                    <td>
                        <x-common.table.status :status="$order->mollie_payment_status" />
                    </td>
                    <td>
                        <x-common.table.btn-dropdown :title=" __('Action') ">
                            <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item" data-url="{{ route('dashboard.order.delete', $order->id) }}" />
                        </x-common.table.btn-dropdown >
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
                $('.update-status-item').on('click', function (e) {
                    e.preventDefault();
                    let url = $(this).data('url');
                    Swal.fire({
                        title: '{{ __("Do you want to approve this Order?") }}',
                        showCancelButton: true,
                        confirmButtonText: 'Approve',
                        confirmButtonColor: '#000',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            approveStatusItem(url);
                        }
                    });
                });

                $('#datatable-org tbody').on( 'click', 'a.update-status-item', function () {
                    let url = $(this).data('url');
                    Swal.fire({
                        title: '{{ __("Do you want to approve this Order?") }}',
                        showCancelButton: true,
                        confirmButtonText: 'Approve',
                        confirmButtonColor: '#000',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            approveStatusItem(url);
                        }
                    });
                    return false;
                });

                function approveStatusItem(url) {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            if (data.status == 'success') {
                                Swal.fire('Approved!', data.message, 'success')
                                return setTimeout(() => {
                                    return location.reload();
                                }, 1000);
                            }

                            return Swal.fire('Error!', '{{ __("Got Approved") }}', 'error')
                        },
                        error: function (err) {
                            return Swal.fire('Error!', '{{ __("An error occurred!") }}', 'error')
                        }
                    });
                }

                $('.delete-item').on('click', function (e) {
                    e.preventDefault();
                    let url = $(this).data('url');
                    Swal.fire({
                        title: '{{ __("Do you want to delete this Order?") }}',
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
                        title: '{{ __("Do you want to delete this Order?") }}',
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
