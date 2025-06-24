@extends('layouts.master')

@section('title') {{ $slider->name . " " . __("Slider Items") }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Slider") => route("dashboard.slider.list"),
        __("Slider Items") => ""
    ]])
@endsection

@section('content')
    <div class="dashboard-edit">
        <div class="mb-10">
            <h4 class="dashboard-edit-title mb-6">{{ __('All Slider Items') }}</h4>
        </div>
        <form action="{{ route('dashboard.slider.items.new') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="slider_id" value="{{ $slider->id }}">
            <div class="repeate-container">
                @foreach ($slider_items as $item)
                    @include("partials.slider_item_repeater", [
                        "id" => $item->id,
                        "title" => $item->title,
                        "description" => $item->description,
                        "image" => $item->image,
                        "btn_text" => $item->btn_text,
                        "btn_url" => $item->btn_url,
                    ])
                @endforeach

                @include("partials.slider_item_repeater")
            </div>

            <div class="col-span-12">
                <div class="eduman-managesale-top-btn default-light-theme justify-center mt-8">
                    <button class="btn-primary" type="submit">{{ __('Save Slider Item') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
<x-utils.swal-js />
<script>
    (function () {
        "use strict"

        $(document).ready(function () {
            $(document).on("click", ".remove-repeater-item", function (e) {
                e.preventDefault();
                $(this).closest(".repeater").slideUp("slow", function () {
                    $(this).remove()
                })
            });

            $(document).on("click", ".add-repeater-item", function (e) {
                e.preventDefault();
                let new_item = `@include("partials.slider_item_repeater")`;
                new_item = $(new_item).hide()
                $(".repeate-container").append(new_item)
                new_item = $(new_item).slideDown("slow")
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
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        location.reload();
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
                return setTimeout(function() {
                    return location.reload();
                }, 1000);
            }
        });
    })(jQuery)
</script>
@endsection
