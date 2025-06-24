{{--
    # params
    - label
    - id
    - name
    - options
    - option_value
    - option_display
--}}

@php
$id = $id ?? $name;
$options = $options ?? "";
$selected = $selected ?? "";
@endphp

<div class="eduman-select-field mb-5">
    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ $label }}</h5>
    <div class="eduman-select-field-style">
        <select class="block" id="{{ $id }}" name="{{ $name }}">
            <option value="">{{ __("Select One") }}</option>
            @foreach ($options as $option)
                @if (is_array($option))
                    <option value="{{ $option[$option_value] }}" @selected($option[$option_value] == $selected)>
                        {{ $option[$option_display] }}
                    </option>
                @else
                    <option value="{{ $option->$option_value }}" @selected($option->$option_value == $selected)>
                        {{ $option->$option_display }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>
    @if ($errors->has($name))
        <x-input-error :messages="$errors->get($name)" class="mt-2" />
    @endif
</div>
