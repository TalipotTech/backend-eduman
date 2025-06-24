@extends('layouts.master')

@php
$page_title = __("Page Setting");
@endphp

@section('title') {{ $page_title }} @endsection

@section('css')
    <x-utils.datatable.css />
@endsection

@section('breadcrumb')
    @include('layouts.breadcrumb', ["path_array" => [
        __("Dashboard") => route("dashboard"),
        __("Setting") => route("dashboard.event.list"),
        $page_title => ""
    ]])
@endsection

@section('content')
<div class="dashboard-edit flex justify-between items-center py-3">
    <h4 class="dashboard-edit-title mb-1">{{ "$page_title " . __("Settings") }}</h4>
</div>
<form method="POST" action="{{ route('dashboard.inner_page_settings.checkout') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-12 sm:gap-x-5">
        <div class="lg:col-span-12 md:col-span-12 col-span-12">
            <div class="dashboard-edit p-10">
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_title"),
                    "name" => "site_checkout_title",
                    "type" => "text",
                    "value" => $options["site_checkout_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_sub_title"),
                    "name" => "site_checkout_sub_title",
                    "type" => "text",
                    "value" => $options["site_checkout_sub_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_description"),
                    "name" => "site_checkout_description",
                    "type" => "text",
                    "value" => $options["site_checkout_description"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_keywords"),
                    "name" => "site_checkout_keywords",
                    "type" => "text",
                    "value" => $options["site_checkout_keywords"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_billing_title"),
                    "name" => "site_checkout_billing_title",
                    "type" => "text",
                    "value" => $options["site_checkout_billing_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_payment_title"),
                    "name" => "site_checkout_payment_title",
                    "type" => "text",
                    "value" => $options["site_checkout_payment_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_payment_default_title"),
                    "name" => "site_checkout_payment_default_title",
                    "type" => "text",
                    "value" => $options["site_checkout_payment_default_title"] ?? "",
                ]) 
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_payment_url"),
                    "name" => "site_checkout_payment_url",
                    "type" => "text",
                    "value" => $options["site_checkout_payment_url"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_paypal_payment_url"),
                    "name" => "site_checkout_paypal_payment_url",
                    "type" => "text",
                    "value" => $options["site_checkout_paypal_payment_url"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_stripe_payment_url"),
                    "name" => "site_checkout_stripe_payment_url",
                    "type" => "text",
                    "value" => $options["site_checkout_stripe_payment_url"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_pay_later_url"),
                    "name" => "site_checkout_pay_later_url",
                    "type" => "text",
                    "value" => $options["site_checkout_pay_later_url"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_btn_text"),
                    "name" => "site_checkout_btn_text",
                    "type" => "text",
                    "value" => $options["site_checkout_btn_text"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_btn_url"),
                    "name" => "site_checkout_btn_url",
                    "type" => "text",
                    "value" => $options["site_checkout_btn_url"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_account_title"),
                    "name" => "site_checkout_account_title",
                    "type" => "text",
                    "value" => $options["site_checkout_account_title"] ?? "",
                ])
                @include("partials.inputs.input", [
                    "label" => __("site_checkout_shipping_title"),
                    "name" => "site_checkout_shipping_title",
                    "type" => "text",
                    "value" => $options["site_checkout_shipping_title"] ?? "",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("site_checkout_payment_default_description"),
                    "name" => "site_checkout_payment_default_description",
                    "type" => "html",
                    "value" => $options["site_checkout_payment_default_description"] ?? "",
                ])
                @include("partials.inputs.textarea", [
                    "label" => __("site_checkout_account_description"),
                    "name" => "site_checkout_account_description",
                    "type" => "html",
                    "value" => $options["site_checkout_account_description"] ?? "",
                ])
                @include("partials.inputs.file", [
                    "label" => __("site_checkout_banner_image"),
                    "name" => "site_checkout_banner_image",
                    "value" => $options["site_checkout_banner_image"] ?? "",
                ])
                @include("partials.inputs.save-btn", [
                    "label" => __("Save Settings")
                ])
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
    <x-tinymce.init />
@endsection





