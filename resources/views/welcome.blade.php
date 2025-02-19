<x-app-layout>
    <div class="flex flex-col gap-12 mt-32 mb-16">
        <x-home-hero-banner :homeherobanners="$homeherobanners" />
        <div class="container">
            <hr class="divider">
        </div>
        <x-categories :categories="$categories"/>
        <div class="container">
            <hr class="divider">
        </div>
        <x-anunciantes-destacados :anunciantes_destacados="$anunciantes_destacados" />
        <div class="container">
            <hr class="divider">
        </div>
        <x-ultimos-anunciantes :ultimos_anunciantes="$ultimos_anunciantes" />
        <x-como-buscar-en-la-guia />
        <x-news :articles="$articles" />
    </div>
</x-app-layout>