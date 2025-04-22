<footer>
    <div class="footer container">
        <div class="identity">
            <div class="footer-logo">
                <x-logo />
            </div>
            <x-social-icons />
        </div>
        <div class="flex flex-col md:flex-row justify-between gap-8">
            <div class="footer-menu">
                <ul>
                    <li x-data="{ open: false, isMd: window.matchMedia('(min-width: 768px)').matches }"
                        x-init="
                            const updateIsMd = () => isMd = window.matchMedia('(min-width: 768px)').matches;
                            window.addEventListener('resize', updateIsMd);
                            updateIsMd();
                        "
                        class="relative">
                        <a
                            @click="if (!isMd) open = !open"
                            :class="{'w-full': open}"
                            class="flex justify-between cursor-pointer"
                        >
                            <p>Legales</p><x-icons.chevron-down />
                        </a>
                        <ul @click.outside="if (!isMd) open = false"
                            x-show="open || isMd"
                            x-transition
                            x-cloak
                            class="footer-sub-menu dropdown md:block"
                        >
                            <li>
                                <a href=""><p>Términos y condiciones</p></a>
                            </li>
                            <li>
                                <a href=""><p>Política de cookies</p></a>
                            </li>                        
                        </ul>
                    </li>

                    <li x-data="{ open: false, isMd: window.matchMedia('(min-width: 768px)').matches }"
                        x-init="
                            const updateIsMd = () => isMd = window.matchMedia('(min-width: 768px)').matches;
                            window.addEventListener('resize', updateIsMd);
                            updateIsMd();
                        "
                        class="relative">
                        <a
                            @click="if (!isMd) open = !open"
                            :class="{'w-full': open}"
                            class="flex justify-between cursor-pointer"
                        >
                            <p>Publicá con nosotros</p><x-icons.chevron-down />
                        </a>
                        <ul @click.outside="if (!isMd) open = false"
                            x-show="open || isMd"
                            x-transition
                            x-cloak
                            class="footer-sub-menu dropdown md:block"
                        >
                            <li>
                                <a href=""><p>Beneficios de publicar en El Vocerito</p></a>
                            </li>
                            <li>
                                <a href=""><p>Preguntas Frecuentes</p></a>
                            </li>                        
                        </ul>
                    </li>

                    <li x-data="{ open: false, isMd: window.matchMedia('(min-width: 768px)').matches }"
                        x-init="
                            const updateIsMd = () => isMd = window.matchMedia('(min-width: 768px)').matches;
                            window.addEventListener('resize', updateIsMd);
                            updateIsMd();
                        "
                        class="relative">
                        <a
                            @click="if (!isMd) open = !open"
                            :class="{'w-full': open}"
                            class="flex justify-between cursor-pointer"
                        >
                            <p>Sobre El Vocerito</p><x-icons.chevron-down />
                        </a>
                        <ul @click.outside="if (!isMd) open = false"
                            x-show="open || isMd"
                            x-transition
                            x-cloak
                            class="footer-sub-menu dropdown md:block"
                        >
                            <li>
                                <a href=""><p>Un poco de historia</p></a>
                            </li>
                            <li>
                                <a href=""><p>Cómo usar la guía</p></a>
                            </li>                        
                        </ul>
                    </li>
                </ul>            
            </div>
            <div class="footer-subscription">
                <p>Suscribite a nuestro newsletter</p>
                <form action="#" class="form">
                    @csrf
                    <div class="relative w-full">
                        <input id="nameInput" type="text" name="name" placeholder="Email" required class="pl-10 w-full">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <x-icons.mail />
                        </div>
                    </div>
                    <x-button class="btn btn-terciary">Suscribirme</x-button>
                </form>
            </div>
        </div>
        <div class="need_help">
            <ul>
                <li><p class="text-gray_200">¿Necesitás ayuda?</p></li>
                <li><a href=""><p>Contactanos</p></a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="post_footer">
            <p class="text-small">©Todos los derechos reservados.</p>
            <p class="text-small">Diseño y desarrollo por <a href="">Chimi Creativo</a></p>
        </div>
    </div>
</footer>