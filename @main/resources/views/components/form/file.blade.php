@props(['name', 'id' => '', 'label', 'value' => ''])

@php
$id = $id ?? $name;
@endphp

<div class="eduman-select-field mb-8">
    <h5 class="text-[15px] text-heading font-semibold mb-3">
        {{ $label }}
    </h5>
    <div class="custom-file">
        <input type="file" name="{{ $name }}" class="custom-file-input" id="{{ $id }}" />
        <label class="custom-file-label" for="{{ $id }}">{{ __("Select File") }}</label>
    </div>
    @if (isset($value) && strlen($value))
    <img src="{{ uploaded_asset($value) }}" alt="{{ $name }}">
    @endif
</div>
