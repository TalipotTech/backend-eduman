{{--
    # Follow this to include this partial
        @include('layouts.breadcrumb', ["path_array" => [
            __("Dashboard") => route("dashboard"),
        ]])

    # Notes:
        - First parameter is the name to be displayed
        - And the second parameter is the url. If url is not needed, keep it empty.
--}}

@if (!empty($path_array))
    <div class="eduman-header-breadcrumb-area mt-[30px] px-7">
        <div class="eduman-header-breadcrumb">
            <ul>
                @foreach ($path_array as $name => $url)
                    <li class="text-[14px] text-bodyText font-normal inline-block mr-2">
                        @if (!$loop->last && strlen($url))
                            <a href="{{ $url }}">{{ $name ?? "" }}</a>
                        @else
                            {{ $name ?? "" }}
                        @endif
                    </li>
                    @if (!$loop->last)
                        <li class="text-[12px] text-bodyText font-normal inline-block mr-2 translate-y-0">
                            <i class="far fa-chevron-right"></i>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
@endif
