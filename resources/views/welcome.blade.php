<x-app-layout>
    <div class="flex flex-col gap-8 mb-16">
        <div>
            <x-search-hero />
            <!-- <x-backgrounds.circulos /> -->
            <x-categories :categories="$categories"/>
            
        </div>
        @if($viewedProducts->count() > 0 || $viewedCategories->count() > 0)
        <div class="container">
            <hr class="divider">
        </div>
        <x-recently-viewed :viewedProducts="$viewedProducts" :viewedCategories="$viewedCategories" />
        <div class="container">
            <hr class="divider">
        </div>
        @endif
        <x-anunciantes-destacados :anunciantes_destacados="$anunciantes_destacados" />
        <div class="container">
            <hr class="divider">
        </div>
        <x-home-hero-banner :homeherobanners="$homeherobanners" />
        <x-revista />
        <x-latest-reviews :ultimasReviews="$ultimasReviews" />
        <div class="container">
            <hr class="divider">
        </div>
        <x-ultimos-anunciantes :ultimos_anunciantes="$ultimos_anunciantes" />
        <div class="container">
            <hr class="divider">
        </div>
        <x-news :articles="$articles" />
    </div>
</x-app-layout>