<div class="w-full questions">
    @foreach ($faqsByCategory as $category => $faqs)
    <div class="faq-category mb-8">

        {{-- TÍTULO DE CATEGORÍA --}}
        <h2 class="text-2xl font-bold mb-6 text-center">
            {{ $categoryTitles[$category] ?? ucfirst(str_replace('_', ' ', $category)) }}
        </h2>


        <div class="questions">
            @foreach ($faqs as $faq)
                <div
                    x-data="{ expanded: false }"
                    class="question"
                >
                    <div class="flex justify-between items-center cursor-pointer" @click="expanded = !expanded">
                        <span>{!! $faq->question !!}</span>
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-180': expanded }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <div
                        x-show="expanded"
                        x-collapse
                        class="overflow-hidden"
                    >
                        <div 
                            class="text-gray-500 dark:text-gray-300 wysiwyg-content answer pt-4 transition-opacity duration-300"
                            :class="{ 'opacity-100': expanded, 'opacity-0': !expanded }"
                        >
                            {!! $faq->answer !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    @endforeach
</div>