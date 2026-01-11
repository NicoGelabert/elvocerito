@section('meta')
    <title>{{ $article->title }}</title>
    <meta name="description" content="{{ $article->news_lead }}">
    <meta name="keywords" content="{{ $article->tags->pluck('name')->implode(', ') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ $article->news_lead }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($article->images->isNotEmpty())
        <meta property="og:image" content="{{ asset($article->images->first()->url) }}">
    @endif
@endsection

<x-app-layout>
    <div id="article-view">
        <!-- INICIO HOJA ARTICULO -->
        <div class="article">
            <!-- INICIO BREADCRUMBS -->
            <div class="breadcrumbs">
                <div class="container flex gap-2 items-center">
                    <a href="/">
                        <x-icons.home class="fill-gray_400" />
                    </a>
                    <p>/</p>
                    <x-button href="/novedades" class="bg-none">
                        <p>Artículos</p>
                    </x-button>
                    <p>/</p>
                    <h2 class="text-small">{{$article->title}}</h2>
                </div>
            </div>
            <!-- FIN BREADCRUMBS -->
            <!-- INICIO PRIMERA FILA -->
            <div class="container">
                <div class="flex flex-col-reverse lg:flex-row gap-6 bg-white rounded-xl p-4">
                    <!-- INICIO PRIMERA COLUMNA -->
                    <div class="article_header custom-scrollbar lg:overflow-x-hidden flex-1">
                        @php
                            $primeraImagen = $article->images->first();
                        @endphp
                        <img src="{{ $primeraImagen->url }}" alt="" class="hidden md:block article_img">
                        <!-- INICIO CONTENEDOR ARTICULO HEADER SIN IMAGEN -->
                        <div class="flex flex-col lg:pr-4 lg:pl-2 gap-4">
                            <!-- INICIO AUTOR -->
                            @if ($article->authors->isNotEmpty())
                            <div class="author">
                                <h4>Autor</h4>
                                @foreach($article->authors as $author)
                                <div class="flex gap-3">
                                    <img src="{{ $author->image }}" alt="{{ $author->name }}">
                                    <div class="flex flex-col justify-center">
                                        <h5>{{ $author->name }}</h5>
                                        <p>Notas publicadas: {{ $author->articles->count() }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <!-- FIN AUTOR -->
                            <hr class="hidden md:block divider">
                            <!-- INICIO REDES SOCIALES -->
                            <div class="article_rrss">
                                <h4>Compartí</h4>
                                @php
                                    $shareUrl = urlencode(url()->current());
                                    $shareText = urlencode($article->title . ' - ' . $article->news_lead);
                                @endphp
                                <div class="article-social-icons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank">
                                        <x-icons.facebook />
                                    </a>
                                    <a href="https://api.whatsapp.com/send?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank">
                                        <x-icons.whatsapp />
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text={{ $shareText }}&url={{ $shareUrl }}" target="_blank">
                                        <x-icons.x />
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank">
                                        <x-icons.linkedin />
                                    </a>
                                </div>
                            </div>
                            <!-- FIN REDES SOCIALES -->
                        </div>
                        <!-- FIN CONTENEDOR ARTICULO HEADER SIN IMAGEN -->
                    </div>
                    <!-- FIN PRIMERA COLUMNA -->
                    <!-- INICIO SEGUNDA COLUMNA -->
                    <div class="article_body">
                        <div class="flex flex-col gap-8" >
                            <!-- INICIO IMAGEN EN MOBILE -->
                            @php
                            $primeraImagen = $article->images->first();
                            @endphp
                            <img src="{{ $primeraImagen->url }}" alt="" class="md:hidden article_img">
                            <!-- FIN IMAGEN EN MOBILE -->
                            <!-- INICIO SUBTITLE -->
                            <span>{{$article->subtitle}}</span>
                            <!-- FIN TITLE -->
                            <!-- INICIO SUBTITLE -->
                            <h2>{{$article->title}}</h2>
                            <!-- FIN TITLE -->
                            <!-- INICIO COPETE O NEWSLEAD -->
                            <div class="p-4 rounded-lg bg-gray-50 w-full lg:w-fit">
                                {{$article->news_lead}}
                            </div>
                            <!-- FIN COPETE O NEWSLEAD -->
                            <!-- INICIO ITEMS -->
                            @if($article->items->isNotEmpty())
                            <ul class="list-disc px-8">
                                @foreach($article->items as $item)
                                <li class="mb-2"><p>{{ $item->texto }}</p></li>
                                @endforeach
                            </ul>
                            @endif
                            <!-- FIN ITEMS -->
                            <!-- INICIO DESCRIPCIÓN -->
                            <div class="article_description">
                                <p>{!! $article->description !!}</p>
                            </div>
                            <!-- FIN DESCRIPCIÓN -->
                            <!-- INICIO TAGS -->
                            @if($article->tags->isNotEmpty())
                            <div class="article_tags">
                                <h4>Tags</h4>
                                <div class="flex flex-wrap gap-4">
                                    @foreach($article->tags as $tag)
                                    <x-badge badge_title="{{ $tag->name }}"/>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            <!-- FIN TAGS -->
                            <!-- INICIO GALERÍA DE IMÁGENES -->
                            @if ($article->images->count() > 1)
                            <div class="article_gallery">
                                <x-image-gallery :images="$article->images" class="article_gallery_images"></x-image-gallery>
                            </div>
                            @endif
                            <!-- FIN GALERÍA DE IMÁGENES -->
                        </div>
                    </div>
                    <!-- FIN SEGUNDA COLUMNA -->
                </div>
            </div>
            <!-- FIN PRIMERA FILA -->
        </div>
        <!-- FIN HOJA ARTICULO -->
    </div>
</x-app-layout>