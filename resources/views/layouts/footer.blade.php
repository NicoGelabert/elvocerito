<footer>
    <div class="footer-container">
        <div class="flex flex-col items-center gap-y-8">
            <div class="logo footer-logo">
                <x-logo-footer />
                <x-social-icons />
            </div>
            <ul class="footer-menu">
                
            </ul>
            <div class="flex gap-4">
                <p><a href="/politica-de-privacidad">{{ __('Política de Privacidad') }}</a></p>
                <p><a href="/terminos-y-condiciones">{{ __('Términos y Condiciones') }}</a></p>
            </div>
            <p class="">Fuengirola, Málaga.</p>
        </div>
    </div>
    <hr class="footer-divider" />
    <div class="post-footer">
        <span class="developed-by">{{__('Sitio diseñado y desarrollado por')}}<a href="https://nicolasgelabert.com.ar" target="_blank"> Nicolás Gelabert</a></span>
        <ul class="flex gap-x-4">
            @foreach (Config::get('languages') as $lang => $language)
                @if ($lang != App::getLocale())
                    <li>
                        <a class="flex items-center gap-x-1 opacity-50" href="{{ route('lang.switch', $lang) }}">
                            <span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span>
                            <span>{{$language['display']}}</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a class="flex items-center gap-x-1" href="{{ route('lang.switch', $lang) }}">
                            <span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span>
                            <span>{{$language['display']}}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</footer>