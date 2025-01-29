<x-app-layout>
    <div class="flex flex-col gap-16">
        <x-home-hero-banner :homeherobanners="$homeherobanners" />
        <hr class="divider">
        <x-categories :categories="$categories"/>
        <x-anunciantes-destacados :anunciantes_destacados="$anunciantes_destacados" />
        <x-ultimos-anunciantes :ultimos_anunciantes="$ultimos_anunciantes" />
        <x-como-buscar-en-la-guia />
        <x-news />
    </div>
</x-app-layout>