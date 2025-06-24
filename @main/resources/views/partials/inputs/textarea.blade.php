{{--
    # params
    - label
    - id
    - name
    - value
--}}

@php
$id = $id ?? $name;
$type = $type ?? "text";
$value = $value ?? "";
@endphp

<div class="eduman-select-field mb-5">
    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ $label }}</h5>
    <div class="eduman-input-field-style">
        <div class="single-input-field w-full">
            @if (isset($type) && $type == "html")
            <x-tinymce.editor :id="$id" :name="$name" :type="'html'" :value="$value" />
            @else
            <textarea id="{{ $id }}" name="{{ $name }}">{{ $value }}</textarea>
            @endif
        </div>
    </div>
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
