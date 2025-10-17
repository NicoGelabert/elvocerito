<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Punto Sur Pastelería') }}</title>

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/img/puntosur.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=albert-sans:200,300,500,700|battambang:100,300,400,700,900" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>

    <main class="w-full mx-auto flex flex-col justify-evenly items-center h-screen px-10">
        <div class="enconstruccion">
            <x-logo />
        </div>
        <div class="w-full grid grid-cols-1 mx-16 gap-y-8 text-center">
            <h2 class="text-3xl font-bold sm:text-4xl">Página en construcción</h2>
            <!-- <hr class="h-px border-t-0 bg-transparent bg-gradient-to-r from-transparent via-neutral-500 to-transparent opacity-25 dark:opacity-100" />
            <p class="text-lg leading-8 text-gray-400">Encontranos en el local de Av. Ramón y Cajal 10, Fuengirola, Málaga</p>
            <div class="flex gap-6 social-icons justify-center">
                <a href="https://wa.me/34623037048" class="h-10 w-10 aspect-square rounded-md bg-black/5 p-2 ring-1 ring-black/10" target="_blank">
                    <i class="flex text-2xl leading-none fi fi-brands-whatsapp"></i>
                </a>
                <a href="https://www.instagram.com/chimi.creativo/?hl=es" class="h-10 w-10 aspect-square rounded-md bg-black/5 p-2 ring-1 ring-black/10" target="_blank">
                    <i class="flex text-2xl leading-none fi fi-brands-instagram"></i>
                </a>
                <a href="https://maps.app.goo.gl/22GUnZ2foJeEYud98" class="h-10 w-10 aspect-square rounded-md bg-black/5 p-2 ring-1 ring-black/10" target="_blank">
                    <i class="flex text-2xl leading-none fi fi-rs-map-marker"></i>
                </a>
            </div> -->
        </div>
    </main>
    </body>
</html>
<style>
    .enconstruccion svg{
        height: auto;
        width: 16rem;
    }
</style>