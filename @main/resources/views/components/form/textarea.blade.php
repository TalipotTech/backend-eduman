@props(['type' => 'text', 'name', 'id', 'label', 'value' => '' ])

@php
$id = $id ?? $name;
@endphp

<div class="eduman-select-field mb-5">
    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ $label }}</h5>
    <div class="eduman-input-field-style">
        <div class="single-input-field w-full">
            <x-tinymce.editor :id="$id" :name="$name" :type="'html'" :value="$value" />
        </div>
    </div>
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
