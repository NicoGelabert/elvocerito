<x-app-layout>

    <x-home-hero-banner :homeherobanners="$homeherobanners" />

    <hr class="divider" id="services"/>
    
    <x-services :services="$services"/>
    
    <hr class="divider border-transparent" id="benefits" />
    
    <x-benefits :tags="$tags" />

    <hr class="divider" />
    
    <x-development :devprojects="$devprojects" />
    
    <!-- <x-clients :clients="$clients" /> -->
    
    <hr class="divider" />
    
    <x-portfolio :projects="$projects" />
    
    <!-- <x-features :features="$features"/> -->
    
    <hr class="divider" />
    
    <x-faq :faqs="$faqs"/>
    
    <hr class="divider" id="contact" />

    <x-contact />
    
</x-app-layout>