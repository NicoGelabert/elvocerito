<x-app-layout>
    <div class="flex flex-col mb-16">
        <div class="md:mb-24">
            <x-search-hero/>
            <!-- <x-backgrounds.circulos /> -->
            <x-categories :categories="$categories"/>
            
        </div>
        <x-anunciantes-destacados :anunciantes_destacados="$anunciantes_destacados" />
        <div class="container">
            <hr class="divider">
        </div>
        <x-latest-reviews :ultimasReviews="$ultimasReviews" />
        <div class="container">
            <hr class="divider">
        </div>
        <x-ultimos-anunciantes :ultimos_anunciantes="$ultimos_anunciantes" />
        <!-- @if($viewedProducts->count() > 0 || $viewedCategories->count() > 0)
        <div class="container">
            <hr class="divider">
        </div>
        {{-- <x-recently-viewed :viewedProducts="$viewedProducts" :viewedCategories="$viewedCategories" /> --}}
        @endif -->
        <div class="container">
            <hr class="divider">
        </div>
        <x-news :articles="$articles" />
        <!-- {{-- <x-revista /> --}} Comentado Blade (entre llaves) -->
        <!-- <x-home-hero-banner :homeherobanners="$homeherobanners" /> -->
    </div>
    
    @foreach ($anunciantes_destacados as $anunciante_destacado)
    <x-contact-modal :product="$anunciante_destacado" />
    @endforeach
</x-app-layout>