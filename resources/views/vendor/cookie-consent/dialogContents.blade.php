<!-- banner de cookies -->
<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 bg-black z-10 hidden">
    <div class="mx-auto flex items-center justify-center flex-wrap gap-4 rounded-lg p-8">
        <p class="small cookie-consent__message text-white">
            {!! trans('cookie-consent::texts.message') !!}
        </p>
        <x-button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer btn btn-primary">
            <span>{{ trans('cookie-consent::texts.agree') }}</span>
        </x-button>
        <x-button class="js-cookie-consent-customize cookie-consent__customize cursor-pointer btn btn-secondary">
            <span>{{ trans('cookie-consent::texts.customize') }}</span>
        </x-button>
    </div>
</div>

<!-- modal de personalización -->
<div id="cookieConsentModal" class="cookie-consent-modal hidden">
    <div class="modal-content">
        <h2>Personalizar Cookies</h2>
        <p>Elige qué cookies quieres aceptar:</p>
        <form>
            <label>
                <input type="checkbox" id="cookie-analytics" name="analytics" checked>
                Cookies de análisis
            </label>
            <label>
                <input type="checkbox" id="cookie-marketing" name="marketing" checked>
                Cookies de marketing
            </label>
            <!-- Agrega más opciones si es necesario -->
        </form>
        <button class="js-cookie-consent-save">Guardar preferencias</button>
    </div>
</div>
