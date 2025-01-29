<header
    x-data="{
        mobileMenuOpen: false,
        cartItemsCount: {{ \App\Helpers\Cart::getCartItemsCount() }},
    }"
    @cart-change.window="cartItemsCount = $event.detail.count"
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
        <x-search class="hidden md:block lg:hidden" />
        <div class="flex items-center gap-4 lg:hidden">
            <div>
                <x-button href="#" class="btn btn-urgencies">urgencias <x-icons.urgencies /></x-button>
            </div>
            <x-hamburguer />
        </div>
    </div>
    <x-search class="md:hidden" />
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

<script>
    var prevScrollpos = window.pageYOffset;
    var navbar = document.getElementById("navbar");
    // navbar.style.top = "5px";
    var scrollThreshold = 15; // Umbral de desplazamiento mínimo antes de ocultar el encabezado
    window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;
        var scrollDifference = Math.abs(prevScrollpos - currentScrollPos);
        if (scrollDifference >= scrollThreshold) {
            if (prevScrollpos > currentScrollPos) {
                navbar.style.top = "0";
            } else {
                navbar.style.top = "-110px";
            }
        }
        prevScrollpos = currentScrollPos;

        var distanceFromTop = Math.abs(window.scrollY);
        if(distanceFromTop <= 5){
            document.getElementById("navbar").classList.remove("scrolled-bottom");
        }else{
            document.getElementById("navbar").classList.add("scrolled-bottom");
        }
    }
</script>