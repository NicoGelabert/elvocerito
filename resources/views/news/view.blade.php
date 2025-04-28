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
                    <x-button href="" class="bg-none">
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
                            <!-- INICIO TAGS -->
                            @if($article->tags->isNotEmpty())
                            <div class="article_tags">
                                <h4>Tags</h4>
                                <div class="">
                                    @foreach($article->tags as $tag)
                                    <x-badge badge_title="{{ $tag->name }}"/>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            <!-- FIN TAGS -->
                            <hr class="hidden md:block divider">
                            <!-- INICIO AUTOR -->
                            @if ($article->authors->isNotEmpty())
                            <div class="author">
                                <h4>Autor</h4>
                                @foreach($article->authors as $author)
                                <div class="flex gap-3">
                                    <img src="{{ $author->image }}" alt="{{ $author->name }}">
                                    <div class="flex flex-col justify-center">
                                        <h5>{{ $author->name }}</h5>
                                        <p>Notas publicadas: 5</p>
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
                                <div class="article-social-icons">
                                    <a href="#">
                                        <x-icons.facebook />
                                    </a>
                                    <a href="#">
                                        <x-icons.instagram />
                                    </a>
                                    <a href="#">
                                        <x-icons.youtube />
                                    </a>
                                    <a href="#">
                                        <x-icons.tiktok />
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
                            <ul class="list-disc px-8">
                                <li class="mb-2"><p>Lista item</p></li>
                                <li class="mb-2"><p>Lista item</p></li>
                                <li class="mb-2"><p>Lista item</p></li>
                            </ul>
                            <!-- FIN ITEMS -->
                            <!-- INICIO DESCRIPCIÓN -->
                            <div class="p-4 rounded-lg bg-gray-50 w-full lg:w-fit text-gray-500">
                                <p>{!! $article->description !!}</p>
                            </div>
                            <!-- FIN DESCRIPCIÓN -->
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
<style>
    .thumbnails {
  display: flex;
  margin: 1rem auto 0;
  padding: 0;
  justify-content: center;
}


.thumbnail {
  width: 70px;
  height: 70px;
  overflow: hidden;
  list-style: none;
  margin: 0 0.2rem;
  cursor: pointer;
}


.thumbnail img {
  width: 100%;
  height: auto;
}
</style>