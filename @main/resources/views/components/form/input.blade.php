@props(['type' => 'text', 'name', 'id', 'label', 'value' => '' ])

@php
$id = $id ?? $name;
@endphp

<div class="eduman-select-field mb-5">
    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ $label }}</h5>
    <div class="eduman-input-field-style">
        <div class="single-input-field w-full">
            <x-text-input
                id="{{ $id }}"
                name="{{ $name }}"
                class="block mt-1 w-full"
                type="{{ $type }}"
                value="{{ $value }}"
            />
        </div>
    </div>
    @if ($errors->has($name))
        <x-input-error :messages="$errors->get($name)" class="mt-2" />
    @endif
</div>
