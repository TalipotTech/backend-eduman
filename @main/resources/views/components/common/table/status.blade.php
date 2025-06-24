@if (isset($status->value) && $status->value == "Pending")
    <span class="status-tag text-[12px] font-semibold leading-5 text-white px-2.5 h-5 rounded-[3px] inline-block bg-themeWarn">
        {{ $status }}
    </span>
@else
    <span class="status-tag text-[12px] font-semibold leading-5 text-white px-2.5 h-5 rounded-[3px] inline-block bg-themeGreen">
        {{ $status }}
    </span>
@endif
