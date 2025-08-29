<section id="anunciantes_destacados">
    
    <div class="container flex flex-col gap-8"">
        <div class="anunciantes_destacados_title">
            <h3>Anunciantes destacados</h3>
        </div>
        <div class="anunciantes_destacados_card">
            <ul>
                @foreach ($anunciantes_destacados as $anunciante_destacado)
                <li>
                    <x-contact-modal :product="$anunciante_destacado" />
                    @if ($anunciante_destacado->prices)
                        <ul class="absolute top-2 left-2">
                            @foreach ($anunciante_destacado->prices as $price)
                                <li>
                                    <x-badge class="star" badge_title="{{ $price->number }}" />
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="card_body">
                        <a href="{{ route('product.view', [
                            'category' => optional($anunciante_destacado->categories->first())->slug ?? 'sin-categoria',
                            'product' => $anunciante_destacado->slug
                        ]) }}">
                        <img src="{{ $anunciante_destacado->image }}" alt="{{ $anunciante_destacado->title }}">
                            <div class="anunciantes_destacados_card_content">
                                <div class="header">
                                    <!-- INICIO CATEGORÍAS -->
                                    <div class="flex gap-2 items-center justify-between">
                                        @if ($anunciante_destacado->categories->count() > 0)
                                            @php
                                                $firstCategory = $anunciante_destacado->categories->first();
                                                $remainingCount = $anunciante_destacado->categories->count() - 1;
                                            @endphp
                                            
                                            <h6 class="truncate-text mx-auto">{{ $firstCategory->name }}</h6>
                                            
                                            @if ($remainingCount > 0)
                                                <span class="remaining-count">
                                                    +{{ $remainingCount }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    <!-- FIN CATEGORÍAS -->
                                     <div class="w-full">
                                         <h5>
                                             {{ $anunciante_destacado->title}}
                                         </h5>
                                     </div>
                                </div>
                                <p>{{ $anunciante_destacado->short_description }}</p>
                                <x-badge-horarios :anunciante_destacado="$anunciante_destacado"/>
                            </div>
                        </a>
                    </div>
                    <div class="footer mx-2 md:mx-4">
                        <hr class="divider">
                        <div class="flex justify-between my-4">
                            <!-- INICIO VÍAS DE CONTACTO -->
                            <x-button 
                                class="btn btn-secondary"
                                onclick="window.dispatchEvent(new CustomEvent('open-contact-modal', {
                                    detail: { type: 'contact', id: {{ $anunciante_destacado->id }} }
                                }))"
                                >
                                Contactar
                            </x-button>
                            <!-- FIN VÍAS DE CONTACTO -->
                            <!-- INICIO VÍAS DE COMPARTIR -->
                            <x-button 
                                class="btn btn-secondary"
                                onclick="window.dispatchEvent(new CustomEvent('open-contact-modal', {
                                    detail: { type: 'share', id: {{ $anunciante_destacado->id }} }
                                }))"
                                >
                                <x-icons.share class="fill-primary" />
                            </x-button>
                            <!-- FIN VÍAS DE COMPARTIR -->
                        </div>                        
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>