@if (session()->has('message'))
    <div class="mb-10">
        @php
            $style_classes = "";

            if (session()->get('status') === "success") {
                $style_classes = "bg-green-100 border-green-300";
            } elseif (session()->get('status') === "error") {
                $style_classes = "bg-red-100 border-red-300";
            }
        @endphp
        <div
            class="flex p-4 rounded border {{ $style_classes }}">
            {{ session()->get('message') }}
        </div>
    </div>
@endif
