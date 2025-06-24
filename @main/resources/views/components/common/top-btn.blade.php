@if (isset($type) && $type == "button")
<div class="eduman-managesale-top-btn default-light-theme">
    <button {{ $attributes->merge(['class' => 'mb-1 button', 'type' => 'button']) }}>
        <i class="fa-light {{ $icon ?? 'fa-plus' }}"></i> {{ $text ?? "" }}
    </button>
</div>
@else
<div class="eduman-managesale-top-btn default-light-theme">
    <a {{ $attributes->merge(['class' => 'mb-1 button']) }} href="{{ $url ?? "#0" }}">
        <i class="fa-light {{ $icon ?? 'fa-plus' }}"></i> {{ $text ?? "" }}
    </a>
</div>
@endif
