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
                        <div
                            @click="if (!isMd) open = !open"
                            :class="{
                                'w-full cursor-pointer': !isMd,
                                'cursor-default pointer-events-none': isMd
                            }"
                            class="flex justify-between"
                        >
                            <p>Legales</p><x-icons.chevron-down />
                        </div>
                        <ul @click.outside="if (!isMd) open = false"
                            x-show="open || isMd"
                            x-transition
                            x-cloak
                            class="footer-sub-menu dropdown md:block"
                        >
                            <li>
                                <a href="/legal/terminos-y-condiciones"><p>Términos y condiciones</p></a>
                            </li>
                            <li>
                                <a href="/legal/politica-de-privacidad"><p>Política de Privacidad</p></a>
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
                        <div
                            @click="if (!isMd) open = !open"
                            :class="{
                                'w-full cursor-pointer': !isMd,
                                'cursor-default pointer-events-none': isMd
                            }"
                            class="flex justify-between"
                        >

                            <p>Publicá con nosotros</p><x-icons.chevron-down />
                        </div>
                        <ul @click.outside="if (!isMd) open = false"
                            x-show="open || isMd"
                            x-transition
                            x-cloak
                            class="footer-sub-menu dropdown md:block"
                        >
                            <li>
                                <a href="/beneficios-de-publicar-en-el-vocerito"><p>Beneficios de publicar en El Vocerito</p></a>
                            </li>
                            <li>
                                <a href="/preguntas-frecuentes"><p>Preguntas Frecuentes</p></a>
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
                        <div
                            @click="if (!isMd) open = !open"
                            :class="{
                                'w-full cursor-pointer': !isMd,
                                'cursor-default pointer-events-none': isMd
                            }"
                            class="flex justify-between"
                        >
                            <p>Sobre El Vocerito</p><x-icons.chevron-down />
                        </div>
                        <ul @click.outside="if (!isMd) open = false"
                            x-show="open || isMd"
                            x-transition
                            x-cloak
                            class="footer-sub-menu dropdown md:block"
                        >
                            <li>
                                <a href="/un-poco-de-historia"><p>Un poco de historia</p></a>
                            </li>
                            <li>
                                <a href="/como-usar-la-guia"><p>Cómo usar la guía</p></a>
                            </li>                        
                        </ul>
                    </li>
                </ul>            
            </div>
            <div class="footer-subscription">
                <p>Suscribite a nuestro newsletter</p>
                <form 
                    x-data="newsletterForm()" 
                    @submit.prevent="submit"
                    class="form"
                >
                    @csrf
                    <!-- Honeypot anti-spam -->
                    <div style="position:absolute;left:-9999px;">
                        <input type="text" name="company" x-model="company" tabindex="-1" autocomplete="off">
                    </div>
                    
                    <div class="relative w-full">
                        <input 
                            type="email"
                            name="email"
                            x-model="email"
                            placeholder="Email"
                            required
                            class="pl-10 w-full"
                        >

                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <x-icons.mail />
                        </div>
                    </div>

                    <x-button type="submit" class="btn btn-terciary">
                        <span x-show="!loading">Suscribirme</span>
                        <span x-show="loading">Enviando...</span>
                    </x-button>

                    <p class="text-green-600 mt-2" x-show="success" x-text="success"></p>
                    <p class="text-red-600 mt-2" x-show="error" x-text="error"></p>
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

<script>
function newsletterForm() {
    return {
        email: '',
        company: '', // honeypot
        loading: false,
        success: '',
        error: '',

        async submit() {
            this.loading = true;
            this.success = '';
            this.error = '';

            try {
                let response = await fetch("{{ route('newsletter.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        email: this.email,
                        company: this.company // enviar honeypot
                    })
                });

                let data = await response.json();

                if (response.ok) {
                    this.success = data.message;
                    this.email = '';
                } else {
                    this.error = data.message ?? 'Error al suscribirse';
                }

            } catch (e) {
                this.error = 'Error del servidor';
            }

            this.loading = false;
        }
    }
}
</script>
