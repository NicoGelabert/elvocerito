<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-KRY5MKQRS3"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-KRY5MKQRS3');
        </script>
        <!-- Google tag (gtag.js) -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="description" content="Chimi Creativo es un estudio especializado en diseño gráfico, desarrollo web y branding que transforma tus ideas en experiencias visuales impactantes. Ofrecemos soluciones personalizadas que destacan por su creatividad e innovación. Descubre cómo podemos impulsar tu marca y darle vida a tus proyectos con nuestro equipo de expertos en diseño y desarrollo.">

        <meta name="keywords" content="Chimi Creativo, estudio de diseño gráfico, desarrollo web, diseño de marca, branding, diseño web, agencia de diseño, diseño UX/UI, identidad visual, Málaga, diseño creativo, diseño de logotipos, marketing digital, soluciones creativas">
        
        <title inertia>{{ config('app.name', 'El Vocerito') }}</title>

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/common/iso_vocerito.svg') }}">

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div id="loader-wrapper" class="dark:bg-black">
            <div class="w-40">
                <x-application-logo/>
            </div>
            <div id="loader">
                <div id="progress-bar"></div>
            </div>
            <div id="loader-percentage">0%</div>
        </div>
        <div id="body-content">
            <!-- Toast -->
            <div
                x-data="toast"
                x-show="visible"
                x-transition
                x-cloak
                @notify.window="show($event.detail.message)"
                class="toast z-20 fixed w-full max-w-[350px] bottom-0 mb-8 right-0 mr-8 py-4 px-4 rounded-3xl"
            >
                <div class="flex justify-between w-full items-center z-10">
                    <div class="font-semibold" x-text="message"></div>
                    <button
                        @click="close"
                        class="w-[30px] h-[30px] flex items-center justify-center rounded-full hover:bg-black/10 transition-colors"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
                <!-- Progress -->
                <div>
                    <div
                        class="progress absolute left-0 bottom-0 right-0 h-full rounded-3xl"
                        :style="{'width': `${percent}%`}"
                    ></div>
                </div>
            </div>
            <!--/ Toast -->
            @include('layouts.navigation')
            <main class="w-full mx-auto container h-screen">
                {{ $slot }}
            </main>            
            @include('layouts.footer')
            
        </div>
    </body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let percentage = 0;
        const progressBar = document.getElementById('progress-bar');
        const interval = setInterval(function() {
            if (percentage < 100) {
                percentage += 1;
                document.getElementById('loader-percentage').innerText = percentage + '%';
                progressBar.style.width = percentage + '%';
            } else {
                clearInterval(interval);
                document.getElementById('loader-wrapper').style.display = 'none';
                const content = document.getElementById('body-content');
                content.style.display = 'block';
                setTimeout(function() {
                    content.classList.add('fade-in');
                }, 10);
            }
        });
    });
</script>