@if($cookieConsentConfig['enabled'] && ! $alreadyConsentedWithCookies)
    <!-- Banner de cookies -->
    <div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 shadow-cookie bg-white dark:bg-dark_gray text-black dark:text-white z-10">
        <div class="mx-auto flex items-center flex-wrap gap-4 rounded-lg p-8 max-w-screen-xl">
            <p class="cookie-consent__message">
                {!! trans('cookie-consent::texts.message') !!}
            </p>
            <x-button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer btn-primary">
                <i class="fi fi-rr-arrow-right arrow-to-right"></i><span>{{ trans('cookie-consent::texts.agree') }}</span>
            </x-button>
            <x-button class="js-cookie-consent-customize cookie-consent__customize cursor-pointer btn-primary">
            <i class="fi fi-rr-arrow-right arrow-to-right"></i><span>{{ trans('cookie-consent::texts.customize') }}</span>
            </x-button>
        </div>
    </div>

    <!-- Modal para personalizar cookies -->
    <div id="cookieConsentModal" class="cookie-consent-modal hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-50">
        <div class="modal-content bg-white dark:bg-dark_gray mx-auto p-6 rounded-xl max-w-lg mt-20 flex flex-col gap-4">
            <h2 class="text-xl">{!! trans('cookie-consent::texts.modal-title') !!}</h2>
            <p class="text-sm cookie-consent__message">
                {!! trans('cookie-consent::texts.modal-message') !!}
            </p>
            <form id="cookie-preferences-form" class="flex flex-col gap-2">
                <label>
                    <input type="checkbox" id="cookie-analytics" name="analytics" checked>
                    {{ trans('cookie-consent::texts.analitycs-cookies') }}
                </label>
                <label>
                    <input type="checkbox" id="cookie-marketing" name="marketing" checked>
                    {{ trans('cookie-consent::texts.marketing-cookies') }}
                </label>
            </form>
            <div class="mt-4">
                <x-button class="js-cookie-consent-save btn-primary" onclick="saveCookiePreferences()"><i class="fi fi-rr-arrow-right arrow-to-right"></i><span>{{ trans('cookie-consent::texts.save-preferences') }}</span></x-button>
                <x-button class="js-cookie-consent-close btn-secondary" onclick="hideCustomizeDialog()">{{ trans('cookie-consent::texts.close') }}</x-button>
            </div>
        </div>
    </div>

    <script>
        // Función para establecer cookies
        function setCookie(name, value, expirationInDays) {
            const date = new Date();
            date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + value
                + ';expires=' + date.toUTCString()
                + ';path=/';
        }

        // Función para cargar cookies de análisis
        function loadAnalyticsCookies() {
            // Código para cargar Google Analytics
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        
            ga('create', 'UA-XXXXXXXX-X', 'auto');
            ga('send', 'pageview');
        }

        // Función para eliminar cookies de Google Analytics
        function deleteAnalyticsCookies() {
            document.cookie = '_ga=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
            document.cookie = '_ga_9Q6H0QETRF=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
        }

        // Función para cargar cookies de marketing (ejemplo: notificaciones push)
        function loadMarketingCookies() {
            console.log('Cargando cookies de marketing');
            // Aquí iría el código para habilitar las cookies de marketing, como notificaciones push.
        }

        // Función para eliminar cookies de marketing
        function deleteMarketingCookies() {
            document.cookie = 'ls_smartpush=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
        }

        // Función para cargar cookies necesarias según preferencias del usuario
        function loadCookiesFromPreferences() {
            // Obtener preferencias de cookies almacenadas en localStorage
            var analyticsPreference = localStorage.getItem('cookie-preferences-analytics') === 'true';
            var marketingPreference = localStorage.getItem('cookie-preferences-marketing') === 'true';

            // Si las cookies de análisis están activadas, cargamos Google Analytics
            if (analyticsPreference) {
                loadAnalyticsCookies();
            }

            // Si las cookies de marketing están activadas, cargamos las cookies de marketing
            if (marketingPreference) {
                loadMarketingCookies();
            }
        }

        // Mostrar modal de personalización
        function showCustomizeDialog() {
            var modal = document.getElementById('cookieConsentModal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        // Ocultar el modal
        function hideCustomizeDialog() {
            var modal = document.getElementById('cookieConsentModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Guardar preferencias de cookies
        function saveCookiePreferences() {
            var analytics = document.getElementById('cookie-analytics').checked;
            var marketing = document.getElementById('cookie-marketing').checked;

            // Guardar preferencias en localStorage
            localStorage.setItem('cookie-preferences-analytics', analytics);
            localStorage.setItem('cookie-preferences-marketing', marketing);

            // Si las cookies de análisis están activadas, cargamos Google Analytics
            if (analytics) {
                loadAnalyticsCookies();
            } else {
                deleteAnalyticsCookies();
            }

            // Si las cookies de marketing están activadas, cargamos las cookies de marketing
            if (marketing) {
                loadMarketingCookies();
            } else {
                deleteMarketingCookies();
            }

            // Actualizar la laravel_cookie_consent
            setCookie('{{ $cookieConsentConfig['cookie_name'] }}', 1, {{ $cookieConsentConfig['cookie_lifetime'] }});

            // Ocultar el modal y el banner
            hideCustomizeDialog();
            hideCookieDialog();
        }

        // Consentir cookies necesarias
        function consentWithCookies() {
            // Activar la cookie de consentimiento de Laravel
            setCookie('{{ $cookieConsentConfig['cookie_name'] }}', 1, {{ $cookieConsentConfig['cookie_lifetime'] }});

            // Verificar preferencias de cookies de análisis y marketing
            var analytics = localStorage.getItem('cookie-preferences-analytics') === 'true';
            var marketing = localStorage.getItem('cookie-preferences-marketing') === 'true';

            // Si las cookies de análisis están activadas, cargamos Google Analytics
            if (analytics) {
                loadAnalyticsCookies();
            }

            // Si las cookies de marketing están activadas, cargamos las cookies de marketing
            if (marketing) {
                loadMarketingCookies();
            }

            hideCookieDialog();
        }

        // Verificar si la cookie de consentimiento ya existe
        function cookieExists(name) {
            return (document.cookie.split('; ').indexOf(name + '=1') !== -1);
        }

        // Ocultar el banner de cookies
        function hideCookieDialog() {
            const dialogs = document.getElementsByClassName('js-cookie-consent');
            for (let i = 0; i < dialogs.length; ++i) {
                dialogs[i].style.display = 'none';
            }
        }

        // Verificar el consentimiento al cargar
        if (cookieExists('{{ $cookieConsentConfig['cookie_name'] }}')) {
            hideCookieDialog();
        }

        // Eventos para los botones
        const agreeButton = document.querySelector('.js-cookie-consent-agree');
        if (agreeButton) {
            agreeButton.addEventListener('click', consentWithCookies);
        }

        const customizeButton = document.querySelector('.js-cookie-consent-customize');
        if (customizeButton) {
            customizeButton.addEventListener('click', showCustomizeDialog);
        }
    </script>
@endif
