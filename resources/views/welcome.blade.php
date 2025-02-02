<x-app-layout>
    <div class="flex flex-col gap-16">
        <x-home-hero-banner :homeherobanners="$homeherobanners" />
        <hr class="divider container">
        <x-categories :categories="$categories"/>
        <hr class="divider container">
        <x-anunciantes-destacados :anunciantes_destacados="$anunciantes_destacados" />
        <hr class="divider container">
        <x-ultimos-anunciantes :ultimos_anunciantes="$ultimos_anunciantes" />
        <x-como-buscar-en-la-guia />
        <x-news />
        <hr class="divider container">
    </div>
</x-app-layout>