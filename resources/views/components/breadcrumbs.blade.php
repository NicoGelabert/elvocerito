@props([
    'breadcrumbs_location' => '',
])
<div class="breadcrumbs">
    <div class="container flex gap-2 items-center">
        <a href="/">
            <x-icons.home class="fill-gray_400" />
        </a>
        <p>/</p>
        <p class="">{{ $slot->isEmpty() ? $breadcrumbs_location : $slot }}</p>
    </div>
</div>