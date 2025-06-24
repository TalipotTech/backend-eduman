@props(['id', 'name', 'value', 'html'])

@if(isset($html) && $html === "html")
    <textarea
        {{ $attributes->merge(['class' => 'tiny-editor']) }}
        @isset($id) id="{{ $id }}" @endisset
        @isset($name) name="{{ $name }}" @endisset
    >@isset($value) {!! $value !!} @endisset</textarea>
@else
    <textarea
        {{ $attributes->merge(['class' => 'tiny-editor']) }}
        @isset($id) id="{{ $id }}" @endisset
        @isset($name) name="{{ $name }}" @endisset
    >@isset($value) {{ $value }} @endisset</textarea>
@endif
