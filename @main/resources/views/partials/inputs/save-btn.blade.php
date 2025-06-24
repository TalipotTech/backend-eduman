{{--
    # params
    - type
    - style_class
--}}

@php
$type = $type ?? "submit";
$style_class = $style_class ?? "btn-primary";
@endphp

<div class="col-span-12 mt-12">
    <div class="eduman-managesale-top-btn default-light-theme justify-center">
        <button class="{{ $style_class }}" type="{{ $type }}">{{ $label }}</button>
    </div>
</div>
