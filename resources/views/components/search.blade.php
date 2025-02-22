<div {{ $attributes->merge(['class' => "search_bar"]) }}>
    <div>
        <form action="">
            <input type="text" placeholder="Buscá una empresa o servicio">
            <div class="absolute right-6 top-1/2 transform -translate-y-1/2 text-gray-400">
                <x-icons.search />
            </div>
        </form>
    </div>
</div>