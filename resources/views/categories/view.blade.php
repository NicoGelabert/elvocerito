<x-app-layout>
    <div class="category_view product-index">
        <!-- INICIO BREADCRUMBS -->
        <div class="breadcrumbs">
            <div class="container flex gap-2 items-center">
                <a href="/">
                    <x-icons.home class="fill-gray_400" />
                </a>
                <p>/</p>
                <a href="/servicios">
                    <p class="hidden md:block">Categorías</p>
                    <p class="md:hidden">...</p>
                </a>
                <p>/</p>
                <h2 class="text-small">{{ $category->name }}</h2>
            </div>
        </div>
        <!-- FIN BREADCRUMBS -->

        <div class="cards__section container">
            <div class="title">
                <h3>{{ $category->name }}</h3>
            </div>
            <div class="cards__list">
                <ul class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @foreach ($products as $product)
                    <li>
                        <x-contact-modal :product="$product" />
                        <div class="card__body">
                            <div class="card__content">
                                <div class="card__left">
                                    <img class="card__img__rounded" src="{{ $product->image }}" alt="{{ $product->title }}">
                                    <div class="badge open">
                                        <span>Desde {{ optional($product->created_at)->translatedFormat('Y') ?? 'Fecha no disponible' }}</span>
                                    </div>
                                </div>
                                <div class="card__right">
                                    <div class="card__info">
                                        <!-- INICIO CATEGORÍA -->
                                        @php
                                            $firstCategory = $product->categories->first();
                                        @endphp
                                        <h6>{{ $firstCategory->name }}</h6>
                                        <!-- FIN CATEGORÍA -->
                                        <h5>
                                            {{ $product->title}}
                                        </h5>
                                        <p class="description {{ ($product->reviews_count > 0 || $product->urgencies) ? '!line-clamp-2' : 'line-clamp-3' }}">
                                            {{ $product->short_description }}
                                        </p>
                                    </div>
                                    @if ($product->reviews_count > 0 || $product->urgencies)
                                    <div class="card__meta">
                                        @if ($product->reviews_count > 0)
                                        <div class="card__rating">
                                            @php
                                                $average = \App\Models\Review::where('product_id', $product->id)
                                                    ->where('published', true)
                                                    ->where('email_verified', true)
                                                    ->avg('rating');
                                                $average = $average ? round($average, 1) : null;
                                            @endphp

                                            @if($average)
                                                <x-icons.star class="w-4 h-4 fill-amber-300" />
                                                <span class="font-semibold text-xs text-gray-500">{{ $average }}</span>
                                            @endif

                                            <span class="text-xs text-gray-500">
                                                ({{ $product->reviews_count }})
                                            </span>
                                        </div>
                                        @endif

                                        @if($product->urgencies)
                                        <div class="card__badges">
                                            <x-badge-urgencies :product="$product"/>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <hr class="divider my-2 w-full">
                            <div class="card__footer card__footer--between">
                                <!-- INICIO VÍAS DE CONTACTO -->
                                <x-button 
                                    class="btn btn-primary"
                                    onclick="window.location.href='{{ route('product.view', [
                                        'category' => optional($product->categories->first())->slug ?? 'sin-categoria',
                                        'product' => $product->slug
                                    ]) }}'"
                                    >
                                    Ver servicio
                                </x-button>
                                <!-- FIN VÍAS DE CONTACTO -->
                                <!-- INICIO VÍAS DE CONTACTO -->
                                <x-button 
                                    class="btn btn-secondary"
                                    onclick="window.dispatchEvent(new CustomEvent('open-contact-modal', {
                                        detail: { type: 'contact', id: {{ $product->id }} }
                                    }))"
                                    >
                                    Contactar
                                </x-button>
                                <!-- FIN VÍAS DE CONTACTO -->
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
