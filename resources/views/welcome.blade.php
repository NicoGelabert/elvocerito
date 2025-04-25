<x-app-layout>
    <div class="flex flex-col gap-8 mb-16">
        <div>
            <x-search-hero />
            <!-- <x-backgrounds.circulos /> -->
            <x-categories :categories="$categories"/>
            
        </div>
        <div class="container mt-24 md:mt-20">
            <hr class="border-transparent">
        </div>
        <x-home-hero-banner :homeherobanners="$homeherobanners" />
        <div class="container">
            <hr class="divider">
        </div>
        <x-anunciantes-destacados :anunciantes_destacados="$anunciantes_destacados" />
        <div class="container">
            <hr class="divider">
        </div>
        <x-ultimos-anunciantes :ultimos_anunciantes="$ultimos_anunciantes" />
        <x-revista />
        <x-news :articles="$articles" />
    </div>
</x-app-layout>