@php
$value = $value ?? "";
@endphp

<div class="eduman-input-field-style mb-2 grid grid-cols-12 gap-x-2 feature-item">
    <div class="single-input-field w-full col-span-10">
        <x-text-input id="feature" name="features[]" class="block mt-1 w-full" type="text" :value="$value" />
    </div>
    <button class="bg-red-400 text-white col-span-2 remove-feature">{{ __('x') }}</button>
</div>
