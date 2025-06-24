@props(['title'])

<div class="eduman-salereturns-table-actionB">
    <div class="dropdown">
        <button class="common-action-menu-style">{{ $title ?? "Action" }}
            <i class="fa-sharp fa-solid fa-caret-down"></i>
        </button>
        <div class="dropdown-list">
            {{ $slot }}
        </div>
    </div>
</div>
