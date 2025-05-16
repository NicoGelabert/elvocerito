<x-app-layout>
    <div class="flex flex-col gap-8 mb-16">
        <div>
            <x-search-hero />
            <!-- <x-backgrounds.circulos /> -->
            <x-categories :categories="$categories"/>
            
        </div>
        <div class="container mt-32 md:mt-20">
            <hr class="border-transparent">
        </div>
        <x-home-hero-banner :homeherobanners="$homeherobanners" />
        <div class="container">
            <hr class="divider">
        </div>
        <x-anunciantes-destacados :anunciantes_destacados="$anunciantes_destacados" />
        @if($viewedProducts->count() > 0)
        <div class="container">
            <hr class="divider">
        </div>
        <x-recently-viewed :viewedProducts="$viewedProducts" />
        @endif
        <x-revista />
        <x-ultimos-anunciantes :ultimos_anunciantes="$ultimos_anunciantes" />
        <div class="container">
            <hr class="divider">
        </div>
        <x-news :articles="$articles" />
    </div>
</x-app-layout>