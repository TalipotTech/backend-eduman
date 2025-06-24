{{--
    # params
    - label
    - name
    - value
--}}

<div class="eduman-select-field mb-5">
    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ $label }}</h5>
    <div class="eduman-radio-field-style">
        <div class="single-input-field w-full">
            <label for="opt-1" class="mr-4">
                <input class="mr-1" type="radio" name="{{ $name }}" @if(isset($value) && $value) checked @endif id="opt-1" value="Active" />
                {{ __("Published") }}
            </label>
            <label for="opt-2" class="mr-4">
                <input class="mr-1" type="radio" name="{{ $name }}" @if(isset($value) && !$value) checked @endif id="opt-2" value="Pending" />
                {{ __("Pending") }}
            </label>
        </div>
    </div>
    @if ($errors->has($name))
        <x-input-error :messages="$errors->get($name)" class="mt-2" />
    @endif
</div>
