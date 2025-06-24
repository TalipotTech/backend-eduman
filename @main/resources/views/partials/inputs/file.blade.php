{{--
    # params
    - id
    - label
    - name
    - value
    - file_type
--}}

@php
$id = $id ?? $name;
$value = $value ?? "";
@endphp

<div class="eduman-select-field mb-8">
    <h5 class="text-[15px] text-heading font-semibold mb-3">
        {{ $label }}
    </h5>
    <div class="custom-file mb-1">
        <input type="file" name="{{ $name }}" class="custom-file-input" id="{{ $id }}" />
        <label class="custom-file-label" for="{{ $id }}">{{ __("Select File") }}</label>
    </div>
    @if (isset($value) && strlen($value) && isset($file_type) && $file_type == 'video')
    <video width="100" height="80" controls>
        <source src="{{ uploaded_asset($value) }}" type="video/mp4">
    </video>
    @elseif (isset($value) && strlen($value) && isset($file_type) && $file_type == 'docs')
    <embed src="{{ uploaded_asset($value) }}" width="100" height="80" />
    @elseif (isset($value) && strlen($value))
    <img width="100" height="80" src="{{ uploaded_asset($value) }}" alt="{{ $label }}">
    @endif
</div>
