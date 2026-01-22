<header
    x-data="{
        mobileMenuOpen: false,
        cartItemsCount: {{ \App\Helpers\Cart::getCartItemsCount() }},
        showElement: false
    }"
    @cart-change.window="cartItemsCount = $event.detail.count"
    @scroll.window="showElement = window.scrollY > 375"
    class="flex flex-col-reverse gap-2 md:gap-0 py-2 px-4"
    id="navbar"
>
    <!-- RESPONSIVE MENU -->
    <div class="flex items-center justify-between w-full">
        <div
            class="block z-20 fixed top-0 bottom-0 h-full w-full transition-all mobile-menu lg:hidden"
            :class="mobileMenuOpen ? 'left-0' : 'left-full'"
        >
            <x-menu layout="col" gap="8" class="mobile-menu-inner" />
        </div>
        <div class="logo flex items-center lg:hidden">
            <x-logo />
        </a>
        </div>
        <x-hamburguer />
    </div>    
    <!-- RESPONSIVE MENU -->

    <!-- MAIN MENU -->
    <div
        :class="mobileMenuOpen ? 'hidden' : ''"
        class="hidden lg:flex w-full"
    >
        <x-menu class="desktop-menu-inner" />
    </div>
    <!-- MAIN MENU -->
    
    
</header>