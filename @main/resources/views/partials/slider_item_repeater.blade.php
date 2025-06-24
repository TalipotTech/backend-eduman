<div class="repeater">
    <div class="flex items-center justify-end relative top-[10px]">
        <div class="flex flex-row gap-x-1">
            <div class="text-red-600">
                <a class="repeater-btn border-red-500 remove-repeater-item @isset($id) delete-item @endisset"
                    @isset($id) data-url="{{ route("dashboard.slider.items.delete", $id) }}" @endisset
                >
                    <i class="fa-light fa-xmark"></i>
                </a>
            </div>
            <div class="text-green-600">
                <a class="repeater-btn border-green-500 add-repeater-item">
                    <i class="fa-light fa-plus"></i>
                </a>
            </div>
        </div>
    </div>

    @php
        $title = $title ?? "";
        $description = $description ?? "";
        $image = $image ?? "";
        $btn_text = $btn_text ?? "";
        $btn_url = $btn_url ?? "";
    @endphp

    <div class="eduman-select-field mb-5">
        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Title') }}</h5>
        <div class="eduman-input-field-style">
            <div class="single-input-field w-full">
                <x-text-input id="title" name="title[]" :value="$title" class="block mt-1 w-full" type="text"
                    required autofocus />
            </div>
        </div>
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>
    <div class="eduman-select-field mb-5">
        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Description") }}</h5>
        <div class="eduman-input-field-style">
            <div class="single-input-field w-full">
                <x-tinymce.editor :id="'description'" :name="'description[]'" :value="$description" :type="'html'" />
            </div>
        </div>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
    <div class="eduman-select-field mb-8">
        <h5 class="text-[15px] text-heading font-semibold mb-3">
           {{  __("Upload Image") }}
        </h5>
        @if (!empty($image))
            <img src="{{ asset("public/storage/".$image) }}" alt="{{ $title }}">
        @endif
        <div class="custom-file">
            <input type="file" name="image[]" value="{{ $image }}" class="custom-file-input"
                id="image_url" />
            <label class="custom-file-label" for="image_url">{{ __("Select Image") }}</label>
        </div>
    </div>
    <div class="grid grid-cols-12 space-x-5">
        <div class="col-span-6">
            <div class="eduman-select-field mb-5">
                <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Button Text') }}</h5>
                <div class="eduman-input-field-style">
                    <div class="single-input-field w-full">
                        <x-text-input id="btn_text" name="btn_text[]" :value="$btn_text" class="block mt-1 w-full" type="text"
                            required autofocus />
                    </div>
                </div>
                <x-input-error :messages="$errors->get('btn_text')" class="mt-2" />
            </div>
        </div>
        <div class="col-span-6">
            <div class="eduman-select-field mb-5">
                <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Button URL') }}</h5>
                <div class="eduman-input-field-style">
                    <div class="single-input-field w-full">
                        <x-text-input id="btn_url" name="btn_url[]" :value="$btn_url" class="block mt-1 w-full" type="url"
                            required autofocus />
                    </div>
                </div>
                <x-input-error :messages="$errors->get('btn_url')" class="mt-2" />
            </div>
        </div>
    </div>
</div>
