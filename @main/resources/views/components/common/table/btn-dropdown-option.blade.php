@props(['type', 'btnText'])

<a {{ $attributes->merge(['class' => 'dropdown-menu-item']) }}>
    @isset($type)
        @if($type === "delete")
            <img src="{{ asset('assets/admin/img/icon/action-6.png') }}" alt="{{ __('Delete button') }}">
            @isset($btnText)
                <span>{{ $btnText }}</span>
            @else
                <span>{{ __("Delete") }}</span>
            @endisset
        @else
            <img src="{{ asset('assets/admin/img/icon/action-2.png') }}" alt="{{ __('Edit button') }}">
            @isset($btnText)
                <span>{{ $btnText }}</span>
            @else
                <span>{{ __("Edit") }}</span>
            @endisset
        @endif
    @endisset
</a>
