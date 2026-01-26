<x-app-layout>
    <div class="article-index">
        <!-- INICIO BREADCRUMBS -->
        <div class="breadcrumbs">
            <div class="container flex gap-2 items-center">
                <a href="/">
                    <x-icons.home class="fill-gray_400" />
                </a>
                <p>/</p>
                <h2 class="text-small">Artículos</h2>
            </div>
        </div>
        <!-- FIN BREADCRUMBS -->
        <div class="articles_list container">
            @foreach($articles as $article)
                <a href="{{ route('news.view', $article) }}">
                    <div class="article_card">
                        <img src="{{ $article->image }}" alt="{{ $article->title }}">
                        <span class="text-text_small">{{ $article->subtitle }}</span>
                        <h4>{{ $article->title }}</h4>
                        <p class="line-clamp-3">{{ $article->news_lead }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="container mt-8 flex justify-center">
            {{ $articles->links() }}
        </div>

    </div>

</x-app-layout>