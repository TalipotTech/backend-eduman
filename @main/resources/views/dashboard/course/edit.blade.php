<x-app-layout>
    <x-tinymce.init />

    <div class=" eduman-dashboard-main">
        @include('layouts.navigation')

        <div class="eduman-header-breadcrumb-area mt-[30px] px-7">
            <div class="eduman-header-breadcrumb">
                <ul>
                    <li class="text-[14px] text-bodyText font-normal inline-block mr-2">{{ __("Home") }}
                    </li>
                    <li class="text-[12px] text-bodyText font-normal inline-block mr-2 translate-y-0">
                        <i class="far fa-chevron-right"></i>
                    </li>
                    <li class="text-[14px] text-bodyText font-normal inline-block mr-2">
                    {{ __("Edit Course") }}</li>
                </ul>
            </div>
        </div>

        <div class="eduman-content-area mt-[30px] px-7">
            <form method="POST" action="{{ route('dashboard.course.update', $course->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-12 sm:gap-x-5">
                    {{-- left --}}
                    <div class="lg:col-span-8 col-span-12">
                        <div class="eduman-addsupplier-area p-7 bg-white custom-shadow rounded-lg pt-5 mb-5">
                            <h4 class="text-[20px] font-bold text-heading mb-9">{{ __("Edit Course") }}</h4>
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <div class="grid grid-cols-12 sm:gap-x-5">
                                <div class="lg:col-span-12 md:col-span-12 col-span-12">
                                    <div class="eduman-select-field mb-5">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Title") }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <x-text-input id="email" class="block mt-1 w-full" type="text"
                                                    name="title" :value="$course->title" required autofocus />
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-span-12">
                                    <div class="eduman-select-field mb-5">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Teaser") }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <x-tinymce.editor :id="'teaser'" :name="'teaser'" :type="'html'"
                                                    :value="$course->teaser" />
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('teaser')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-span-12">
                                    <div class="eduman-select-field mb-5">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("More Info") }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <x-tinymce.editor :id="'more_info'" :name="'more_info'" :type="'html'"
                                                    :value="$course->more_info" />
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('more_info')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-span-12">
                                    <div class="eduman-select-field mb-5">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Description") }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <x-tinymce.editor :id="'description'" :name="'description'"
                                                    :type="'html'" :value="$course->description" />
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- right --}}
                    <div class="lg:col-span-4 col-span-12">
                        <div class="eduman-addsupplier-area p-7 custom-shadow rounded-lg pt-5 mb-5 bg-white">
                            <div class="grid grid-cols-12 sm:gap-x-5">
                                <div class="xl:col-span-6 lg:col-span-12 md:col-span-6 sm:col-span-6 col-span-12">
                                    <div class="eduman-select-field mb-5">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Course Fee") }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <x-text-input id="price" class="block mt-1 w-full" type="text"
                                                    name="price" :value="$course->price" required autofocus />
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="xl:col-span-6 lg:col-span-12 md:col-span-6 sm:col-span-6 col-span-12">
                                    <div class="eduman-select-field mb-5">
                                        <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Discounted Amount") }}</h5>
                                        <div class="eduman-input-field-style">
                                            <div class="single-input-field w-full">
                                                <x-text-input id="discount" class="block mt-1 w-full" type="number"
                                                    name="discount" :value="$course->discount" />
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('discount')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div class="eduman-select-field mb-5">
                                <div class="eduman-select-field mb-5">
                                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __('Select Language') }}</h5>
                                    <div class="eduman-select-field-style">
                                        <select class="block" id="edit_status" name="language">
                                            <option selected value="">{{ __('Select One') }}</option>
                                            <option @selected($course->language == 'English') value="English">{{ __('English') }}</option>
                                            <option @selected($course->language == 'French') value="French">{{ __('French') }}</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('category_id'))
                                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                    @endif
                                </div>
                            </div>
                            <div class="eduman-select-field mb-5">
                                <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Level") }}</h5>
                                <div class="eduman-input-field-style">
                                    <div class="single-input-field w-full">
                                        <x-text-input id="level" class="block mt-1 w-full" type="text"
                                            name="level" :value="$course->level" required autofocus />
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('level')" class="mt-2" />
                            </div>
                            <div class="eduman-select-field mb-5">
                                <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Credit") }}</h5>
                                <div class="eduman-input-field-style">
                                    <div class="single-input-field w-full">
                                        <x-text-input id="credit" class="block mt-1 w-full" type="text"
                                            name="credit" :value="$course->credit" required autofocus />
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('credit')" class="mt-2" />
                            </div>
                            <div class="eduman-select-field mb-5">
                                <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Duration") }}</h5>
                                <div class="eduman-input-field-style">
                                    <div class="single-input-field w-full">
                                        <x-text-input id="duration" class="block mt-1 w-full" type="text"
                                            name="duration" :value="$course->duration" required autofocus />
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                            </div>

                            <div class="lg:col-span-4 md:col-span-6 col-span-12">
                                <div class="eduman-select-field mb-5">
                                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Status") }}</h5>
                                    <div class="eduman-radio-field-style">
                                        <div class="single-input-field w-full">
                                            <label for="opt-1" class="mr-4">
                                                <input class="mr-1" type="radio" name="status" id="opt-1"
                                                    value="Active" @checked($course->status->value == 'Active') />
                                                    {{ __("Published") }}
                                            </label>
                                            <label for="opt-2" class="mr-4">
                                                <input class="mr-1" type="radio" name="status" id="opt-2"
                                                    value="Pending" @checked($course->status->value == 'Pending') />
                                                    {{ __("Pending") }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:col-span-4 md:col-span-6 col-span-12">
                                <div class="eduman-select-field mb-8">
                                    <h5 class="text-[15px] text-heading font-semibold mb-3">
                                    {{ __("Upload Feature Image") }} 
                                    </h5>
                                    <div class="custom-file mb-1">
                                        <input type="file" name="image_url" class="custom-file-input"
                                            id="image_url" />
                                        <label class="custom-file-label" for="image_url">{{ __("Select Image") }}</label>
                                    </div>
                                    <img src="{{ uploaded_asset($course->image_url) }}" alt="image" width="100" height="80" />
                                </div>
                            </div>
                            <div class="lg:col-span-4 md:col-span-6 col-span-12">
                                <div class="eduman-select-field mb-8">
                                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Upload Video") }} </h5>
                                    <div class="custom-file">
                                        <input type="file" name="video_url" class="custom-file-input"
                                            id="video_url" />
                                        <label class="custom-file-label" for="video_url">{{ __("Select Video") }}</label>
                                        <p>mp4 format supported</p>
                                    </div>
                                    @if (isset($course->video_url) && strlen($course->video_url))
                                    <video width="100" height="80" controls>
                                        <source src="{{ uploaded_asset($course->video_url) }}" type="video/mp4">
                                    </video>
                                    @endif
                                </div>
                            </div>
                            <div class="lg:col-span-4 md:col-span-6 col-span-12">
                                <div class="eduman-select-field mb-8">
                                    <h5 class="text-[15px] text-heading font-semibold mb-3">{{ __("Upload Documentation") }}
                                    </h5>
                                    <div class="custom-file">
                                        <input type="file" name="document_url" class="custom-file-input"
                                            id="document_url" />
                                        <label class="custom-file-label" for="document_url">{{ __("Select File") }}</label>
                                    </div>
                                    @if (isset($course->document_url) && strlen($course->document_url))
                                    <embed src="{{ uploaded_asset($course->document_url) }}" width="100" height="80" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-span-12">
                                <div class="eduman-managesale-top-btn default-light-theme justify-center mt-10 pt-2.5">
                                    <button class="btn-primary" type="submit">{{ __("Update Course") }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="eduman-copyright-area">
            <div class="eduman-copyright text-center bg-themeBlue h-20 leading-[80px] mt-20">
                <span class="text-[15px] text-white font-normal">{{ __("© Copyright at BDevs -2023") }}</span>
            </div>
        </div>
    </div>
</x-app-layout>
