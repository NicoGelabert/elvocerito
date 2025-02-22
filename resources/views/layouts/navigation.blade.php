<header
    x-data="{
        mobileMenuOpen: false,
        cartItemsCount: {{ \App\Helpers\Cart::getCartItemsCount() }},
        showElement: false
    }"
    @cart-change.window="cartItemsCount = $event.detail.count"
    @scroll.window="showElement = window.scrollY > 375"
    class="flex flex-col gap-2 md:gap-0 p-4"
    id="navbar"
>
    <!-- Responsive Menu -->
    <div class="flex items-center justify-between z-10 w-full">
        <div
            class="block fixed z-10 top-0 bottom-0 h-full w-full transition-all mobile-menu lg:hidden"
            :class="mobileMenuOpen ? 'left-0' : 'left-full'"
        >
            <x-menu layout="col" gap="8" class="mobile-menu-inner" />
        </div>
        <div class="logo flex items-center lg:hidden">
            <x-application-logo/>
        </div>
        <x-search class="hidden md:block lg:hidden" 
                  x-show="showElement"
                  x-transition:enter="transition-opacity duration-500 ease-in" 
                  x-transition:leave="transition-opacity duration-500 ease-out"/>
        <div class="flex items-center gap-4 lg:hidden">
            <div>
                <x-button href="#" class="btn btn-urgencies">urgencias <x-icons.urgencies /></x-button>
            </div>
            <x-hamburguer />
        </div>
    </div>
    <x-search class="md:hidden" 
              x-show="showElement"
              x-transition:enter="transition-opacity duration-500 ease-in" 
              x-transition:leave="transition-opacity duration-500 ease-out"/>
    <!--/ Responsive Menu -->

    <!-- Main Menu -->   
    
    <div
        :class="mobileMenuOpen ? 'hidden' : ''"
        class="hidden lg:flex w-full"
    >
        <x-menu class="desktop-menu-inner" />
    </div>
    <!--/ Main Menu -->
    
    
</header>