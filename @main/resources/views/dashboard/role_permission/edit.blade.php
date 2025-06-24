@extends('layouts.master')

@section('title') {{ __("Create Role") }} @endsection

@section('css')
<x-utils.datatable.css />
@endsection

@section('breadcrumb')
@include('layouts.breadcrumb', ["path_array" => [
    __("Dashboard") => route("dashboard"),
    __("Roles") => route("dashboard.role_permission.list"),
    __("Create Role") => ""
]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ __("Create role & user permission") }}</h4>
    <x-common.top-btn :icon="'fa-bars'" :text="__('All Roles')" class="mb-0" href="{{ route('dashboard.role_permission.list') }}" />
</div>

<form method="POST" action="{{ route('dashboard.role_permission.new') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="col-span-12">
            <div class="eduman-content-area mt-[30px] sm:px-7">
                <div class="eduman-managesale-area bg-white p-7 pt-5 custom-shadow rounded-lg mb-7">
                    <h4 class="text-[20px] font-bold text-heading mb-8">{{ __("Create Role") }}</h4>
                    <div class="grid grid-cols-12">
                        <div class="lg:col-span-4 md:col-span-6 col-span-12">
                            <div class="eduman-select-field mb-5">
                                <div class="eduman-input-field-style">
                                    <div class="single-input-field w-full">
                                        <input id="name" name="name" type="text" placeholder="{{ __('Create Role') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-4 md:col-span-6 col-span-12">
                            <div class="eduman-popup-btn default-light-theme mb-5 md:ml-5">
                                <button type="submit" id="btn-modal-submit"
                                    class="btn-primary justify-center">{{ __('Save Now') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form method="POST" action="{{ route('dashboard.role_permission.new') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="col-span-12">
            <div class="eduman-content-area mt-[30px] sm:px-7">
                <div class="eduman-managesale-area bg-white p-7 pt-5 custom-shadow rounded-lg mb-7">
                    <h4 class="text-[20px] font-bold text-heading mb-8">{{ __('Check Permission') }}</h4>
                    <div class="grid grid-cols-12">
                        <div class="lg:col-span-4 md:col-span-6 col-span-12">
                            <div class="eduman-select-field mb-5">
                                <div class="eduman-select-field-style">
                                    <select class="block" id="check_role" name="check_role">
                                        <option value="">{{ __("Select Role") }}</option>
                                        @foreach ($roles as $r)
                                            <option @selected($role == $r->name) value="{{ $r->name }}">
                                                {{ $r->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has("check_role"))
                                    <x-input-error :messages="$errors->get('check_role')" class="mt-2" />
                                @endif
                            </div>
                        </div>
                        <div class="lg:col-span-4 md:col-span-6 col-span-12 md:ml-5">
                            <div class="eduman-select-field mb-5">
                                <div class="eduman-select-field-style">
                                    <select class="block" id="check_email" name="check_email">
                                        <option value="">{{ __("Select User") }}</option>
                                        @foreach ($users as $user)
                                            <option @selected($email == $user->email) value="{{ $user->email }}">
                                                {{ $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has("check_email"))
                                    <x-input-error :messages="$errors->get('check_email')" class="mt-2" />
                                @endif
                            </div>
                        </div>

                        <div class="lg:col-span-4 md:col-span-6 col-span-12">
                            <div class="eduman-popup-btn default-light-theme mb-5 md:ml-5">
                                <button type="submit" id="btn-modal-submit"
                                    class="btn-primary justify-center">{{ __('Check Now') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form method="POST" action="{{ route('dashboard.role_permission.new', ['email' => $email, 'role' => $role]) }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}" />
    <input type="hidden" name="role" value="{{ $role }}" />
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="col-span-12">
            <div class="eduman-content-area mt-[30px] sm:px-7">
                <div class="eduman-managesale-area bg-white p-7 pt-5 custom-shadow rounded-lg mb-7">
                    <h4 class="text-[20px] font-bold text-heading mb-8">{{ __('User Permissions') }}</h4>
                    <div class="eduman-role-area">
                        <div class="eduman-role-inner">
                            <div class="eduman-role-inner-wrapper border border-solid border-grayBorder border-b-0">
                                <div class="eduman-role-list border-b border-solid border-grayBorder flex items-center">
                                    <div class="eduman-role-right w-full border-l border-solid border-grayBorder">
                                    @foreach ($permissions as $key => $permission)
                                        <div class="eduman-role-category-list custom-height-70 flex items-center border-b border-solid border-grayBorder">
                                            <div class="eduman-role-category">
                                                <h5>{{ ucfirst($key) }}</h5>
                                            </div>
                                            <div class="eduman-role-checkbox-wrapper">
                                                <div class="eduman-role-checkbox default-light-theme">
                                                    <input @checked( $rolePermissions && in_array($permission[0], $rolePermissions) ) type="checkbox" id="view_permission_{{$permission[0]}}" name="user_permission[{{$permission[0]}}]" value="{{$permission[0]}}" data-select-all="b-checkF" class="checkme">
                                                    <label for="view_permission_{{$permission[0]}}">{{ __('View') }}</label>
                                                </div>
                                                <div class="eduman-role-checkbox default-light-theme">
                                                    <input @checked( $rolePermissions && in_array($permission[1], $rolePermissions) ) type="checkbox" id="add_permission_{{$permission[1]}}" name="user_permission[{{$permission[1]}}]" value="{{$permission[1]}}" data-select-all="b-checkF" class="checkme">
                                                    <label for="add_permission_{{$permission[1]}}">{{ __('Add') }}</label>
                                                </div>
                                                <div class="eduman-role-checkbox default-light-theme">
                                                    <input @checked( $rolePermissions && in_array($permission[2], $rolePermissions) ) type="checkbox" id="edit_permission_{{$permission[2]}}" name="user_permission[{{$permission[2]}}]" value="{{$permission[2]}}" data-select-all="b-checkF" class="checkme">
                                                    <label for="edit_permission_{{$permission[2]}}">{{ __('Edit') }}</label>
                                                </div>
                                                <div class="eduman-role-checkbox default-light-theme">
                                                    <input @checked( $rolePermissions && in_array($permission[3], $rolePermissions) ) type="checkbox" id="delete_permission_{{$permission[3]}}" name="user_permission[{{$permission[3]}}]" value="{{$permission[3]}}" data-select-all="b-checkF" class="checkme">
                                                    <label for="delete_permission_{{$permission[3]}}">{{ __('Delete') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-12 md:col-span-12 col-span-12">
                            <div class="eduman-popup-btn default-light-theme mt-5 mb-5">
                                <button type="submit" id="btn-modal-submit"
                                    class="btn-primary justify-center">{{ __('Update Permission') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<x-utils.swal-js />
<x-utils.datatable.js />
<x-tinymce.init />
@endsection