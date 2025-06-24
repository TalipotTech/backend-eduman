@extends('layouts.master')

@section('title')
    {{ __('All Price Plans') }}
@endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', [
        'path_array' => [
            __('Dashboard') => route('dashboard'),
            __('Price Plan') => '',
        ],
    ])
@endsection

@section('content')
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-8 col-span-12">
            <div class="dashboard-edit">
                <div class="mb-10">
                    <h4 class="dashboard-edit-title mb-6">{{ __('All Price Plans') }}</h4>
                </div>
                <table id="datatable-org" class="table hover stripe table-auto" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Badge Text') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($price_plans as $price_plan)
                            <tr>
                                <td>{{ $price_plan->id }}</td>
                                <td>{{ str()->limit($price_plan->type, 30) }}</td>
                                <td>{{ str()->limit($price_plan->name, 30) }}</td>
                                <td>{{ str()->limit($price_plan->badge_text, 30) }}</td>
                                <td>{{ $price_plan->is_highlighted ? __("Highlighted") : __("Normal") }}</td>
                                <td>
                                    <x-common.table.btn-dropdown :title=" __('Action') ">
                                        <x-common.table.btn-dropdown-option :type="__('edit')" class="edit-item"
                                            data-href="{{ route('dashboard.price_plans.edit', $price_plan->id) }}"
                                            data-type="{{ $price_plan->type }}"
                                            data-title="{{ $price_plan->title }}"
                                            data-money_sign="{{ $price_plan->money_sign }}"
                                            data-amount="{{ $price_plan->amount }}"
                                            data-duration="{{ $price_plan->duration }}"
                                            data-details="{{ $price_plan->details }}"
                                            data-features="{{ $price_plan->features }}"
                                            data-badge_text="{{ $price_plan->badge_text }}"
                                            data-is_highlighted="{{ $price_plan->is_highlighted }}"
                                            data-status="{{ $price_plan->status }}"
                                        />
                                        <x-common.table.btn-dropdown-option :type="__('delete')" class="delete-item"
                                            data-url="{{ route('dashboard.price_plans.delete', $price_plan->id) }}" />
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
                    <h4 class="dashboard-edit-title mb-6">{{ __('Add Price Plan') }}</h4>
                </div>
                @php
                    $type_label = __("Plan Type");
                    $name_label = __("Plan Title");
                    $money_sign = __("Money Sign");
                    $amount = __("Amount");
                    $duration = __("Duration in months ( 1 -12 )");
                    $name_label = __("Plan Name");
                    $details_label = __("Plan Info.");
                    $badge_text_label = __("Badge Text");
                @endphp

                <form action="{{ route('dashboard.price_plans.new') }}" method="POST">
                    @csrf
                    <x-form.input :name="'type'" :label="$type_label" />
                    <x-form.input :name="'title'" :label="$name_label" />
                    <x-form.input :name="'money_sign'" :label="$money_sign" />
                    <x-form.input :name="'amount'" :label="$amount" />
                    <x-form.input :name="'duration'" :label="$duration" />
                    <x-form.input :name="'details'" :label="$details_label" />
                    <x-form.input :name="'badge_text'" :label="$badge_text_label" />
                    <div class="col-span-12">
                        <div class="eduman-select-field mb-5">
                            <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Features") }}</h5>
                            <div class="eduman-input-field-style">
                                <div class="single-input-field w-full">
                                    <x-tinymce.editor :id="'features'" :name="'features'" :type="'html'" />
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('features')" class="mt-2" />
                        </div>
                    </div>

                    <div class="col-span-12 mb-5">
                        <label for="is_highlighted" class="mr-4">
                            <input class="mr-1" type="checkbox" name="is_highlighted" id="is_highlighted" value="1" />
                            {{ __("Is it highlighted?") }}
                        </label>
                    </div>

                    <div class="eduman-select-field mb-5">
                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Status") }}</h5>
                        <div class="eduman-radio-field-style">
                            <div class="single-input-field w-full">
                                <label for="opt-1" class="mr-4">
                                    <input class="mr-1" type="radio" name="status" id="opt-1" value="Active" />
                                    {{ __("Active") }}
                                </label>
                                <label for="opt-2" class="mr-4">
                                    <input class="mr-1" type="radio" name="status" id="opt-2" value="Pending" />
                                    {{ __("Pending") }}
                                </label>
                            </div>
                        </div>
                        @if ($errors->has("status"))
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        @endif
                    </div>
                    <div class="eduman-managesale-top-btn default-light-theme justify-center mt-8">
                        <button class="btn-primary" type="submit">{{ __('Create Price Plan') }}</button>
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
                                <h4 class="text-[20px] text-heading font-bold category-modal-title">{{ __('Edit Price Plan') }}
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
                            <div class="grid grid-cols-12 sm:gap-x-5">  
                                <div class="lg:col-span-6 md:col-span-6 col-span-12">
                                    <x-form.input :name="'type'" :id="'edit_type'" :label="$type_label" />
                                    <x-form.input :name="'title'" :id="'edit_title'" :label="$name_label" />
                                    <x-form.input :name="'badge_text'" :id="'edit_badge_text'" :label="$badge_text_label" />
                                </div>
                                <div class="lg:col-span-6 md:col-span-6 col-span-12">
                                    <x-form.input :name="'money_sign'" :id="'edit_money_sign'" :label="$money_sign" />
                                    <x-form.input :name="'amount'" :id="'edit_amount'" :label="$amount" />
                                    <x-form.input :name="'duration'" :id="'edit_duration'" :label="$duration" />
                                </div>
                                <div class="col-span-12">
                                    <x-form.input :name="'details'" :id="'edit_details'" :label="$details_label" />
                                </div>
                                <div class="col-span-12">
                                    <div class="eduman-select-field mb-5">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Features") }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <x-tinymce.editor :id="'edit_features'" :name="'features'" :type="'html'" />
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('features')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-span-12 mb-5">
                                    <label for="is_highlighted" class="mr-4">
                                        <input class="mr-1" type="checkbox" name="is_highlighted" id="is_highlighted" value="1" />
                                        {{ __("Is it highlighted?") }}
                                    </label>
                                </div>

                                <div class="col-span-12">
                                <div class="eduman-select-field mb-5">
                                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Status") }}</h5>
                                    <div class="eduman-radio-field-style">
                                        <div class="single-input-field w-full">
                                            <div class="inline-block mr-2">
                                                <label for="opt-3" class="mr-4">
                                                    <input class="mr-1" type="radio" name="status" id="opt-3" value="Active" />
                                                    {{ __("Active") }}
                                                </label>
                                            </div>
                                            <div class="inline-block">
                                                <label for="opt-4" class="mr-4">
                                                    <input class="mr-1" type="radio" name="status" id="opt-4" value="Pending" />
                                                    {{ __("Pending") }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has("status"))
                                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                    @endif
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
                    let type = $(this).data("type");
                    let title = $(this).data("title");
                    let duration = $(this).data("duration");
                    let money_sign = $(this).data("money_sign");
                    let amount = $(this).data("amount");
                    let details = $(this).data("details");
                    let features = $(this).data("features");
                    let badge_text = $(this).data("badge_text");
                    let is_highlighted = $(this).data("is_highlighted");
                    let status = $(this).data("status");
                    edit_type.value = type;
                    edit_title.value = title;
                    edit_duration.value = duration;
                    edit_money_sign.value = money_sign;
                    edit_amount.value = amount;
                    edit_details.value = details;
                    edit_badge_text.value = badge_text;
                    tinymce.get("edit_features").setContent(features)

                    if (is_highlighted) {
                        $(".edit-modal input[type=checkbox][value=1]").prop("checked", true);
                    }

                    if (status) {
                        $(".edit-modal input[type=radio][value='Active']").prop("checked", true);
                    } else {
                        $(".edit-modal input[type=radio][value='Pending']").prop("checked", true);
                    }
                    $(".pop-outer form").attr("action", href);
                    $(".pop-outer").fadeIn("slow");
                });

                $('#datatable-org tbody').on( 'click', 'a.edit-item', function () {
                    let href = $(this).data("href");
                    let type = $(this).data("type");
                    let title = $(this).data("title");
                    let duration = $(this).data("duration");
                    let money_sign = $(this).data("money_sign");
                    let amount = $(this).data("amount");
                    let details = $(this).data("details");
                    let features = $(this).data("features");
                    let badge_text = $(this).data("badge_text");
                    let is_highlighted = $(this).data("is_highlighted");
                    let status = $(this).data("status");
                    edit_type.value = type;
                    edit_title.value = title;
                    edit_duration.value = duration;
                    edit_money_sign.value = money_sign;
                    edit_amount.value = amount;
                    edit_details.value = details;
                    edit_badge_text.value = badge_text;
                    tinymce.get("edit_features").setContent(features)

                    if (is_highlighted) {
                        $(".edit-modal input[type=checkbox][value=1]").prop("checked", true);
                    }

                    if (status) {
                        $(".edit-modal input[type=radio][value='Active']").prop("checked", true);
                    } else {
                        $(".edit-modal input[type=radio][value='Pending']").prop("checked", true);
                    }
                    $(".pop-outer form").attr("action", href);
                    $(".pop-outer").fadeIn("slow");
                    return false;
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

                $(".add-feature").on("click", function (e) {
                    e.preventDefault();
                    $(".features_container").append(`@include("partials.price-plan-feature-item")`);
                });

                $(document).on("click", ".remove-feature", function (e) {
                    e.preventDefault();
                    $(this).closest(".feature-item").slideUp("slow", function () {
                        $(this).remove()
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
    <script>
    // datatable activation
    var table = $('#datatable-org').DataTable( {
        responsive: true
    });
    </script>
@endsection
