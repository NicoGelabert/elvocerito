<x-app-layout>
    <x-breadcrumbs breadcrumbs_location="Preguntas Frecuentes" />
    <div class="faqs">
        <div class="flex flex-col w-full justify-between gap-8 max-w-screen-xl container py-16">
            <h1 class="text-center">Preguntas Frecuentes</h1>
            <x-faqs :faqsByCategory="$faqsByCategory"/>
        </div>
    </div>
</x-app-layout>