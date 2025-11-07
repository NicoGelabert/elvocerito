<template>
    <div class="relative product-list">
        <!-- Indicador de carga -->
        <div v-if="loading" class="spinner-overlay">
            <div class="spinner"></div>
        </div>
        <!-- Mensaje de error -->
        <div v-if="error" class="error">{{ error }}</div>

        <!-- Filtro de categorías y listado de productos -->
        <div class="container flex flex-col lg:flex-row gap-4">
            <aside class="w-full lg:w-1/5 flex flex-col gap-4">
                <h4>Filtrar</h4>
                <hr class="divider-product_list">
                <h5 class="text-gray_600">Categoría</h5>
                <ul class="flex flex-col gap-2 scroll-container overflow-auto">

                    <!-- Grupos de letras -->
                    <template v-for="group in categories" :key="group.letter">
                        <!-- Separador de letra -->
                        <li class="mt-4 mb-1 text-gray-500 font-bold border-b border-gray-300 pb-1">
                            {{ group.letter }}
                        </li>

                        <!-- Categorías de la letra -->
                        <li v-for="category in group.categories" :key="category.id" class="" :class="{ 'active-category': selectedCategory === category.slug, 'inactive-category': selectedCategory !== category.slug }">
                            <button @click="filterByCategory(category.slug)" class="btn-products_list">
                                <span>{{ category.name }}</span>
                            </button>
                        </li>
                    </template>
                </ul>
            </aside>

            <!-- Productos, con clase de opacidad condicional -->
            <div :class="{ 'loading-opacity': loading }" class="flex-1">
                <ul class="grid gap-4 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                    <li v-for="product in products" :key="product.id" class="relative overflow-hidden flex flex-col">
                        <a :href="'/' + product.categories[0]?.slug + '/' + product.slug" class="aspect-w-3 aspect-h-2 block overflow-hidden relative">
                            <div v-if="product.categories && product.categories.length > 0" class="mt-2 text-xs flex gap-2 absolute">
                                <ul class="font-bold text-xs">
                                    <li class="bg-gray_200 text-gray_600 rounded-md py-1 px-2 ml-2" v-for="category in product.categories" :key="category.id">{{ category.name }}</li>
                                </ul>
                            </div>
                            <img :src="product.image_url" alt="" class="card-image object-cover aspect-square rounded-lg hover:scale-105 transition-transform" />
                        </a>
                        <div class="flex flex-col py-4 gap-2">
                            <div v-if="product.prices && product.prices.length > 0">
                                <ul class="font-bold text-sm text-gray_500">
                                    <li v-for="price in product.prices" :key="price.id">{{ price.size }}</li>
                                </ul>
                            </div>
                            <h5 class="w-fit">{{ product.title }}</h5>
                            <div class="flex gap-4 card-buttons">
                                <a v-if="product.link" :href="product.link" target="_blank" class="btn btn-primary btn-products_list"><span>Book </span></a>
                                <a :href="'/' + product.categories[0]?.slug + '/' + product.slug" class="btn btn-secondary btn-products_list"><span>See More </span></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    props: {
        // Categoría inicial (pasada desde Blade, opcional)
        initialCategory: {
            type: [String, null],
            default: null
        }
    },
    data() {
        return {
            products: [],
            categories: [],
            loading: true,
            error: null,
            selectedCategory: this.initialCategory,
        };
    },
    mounted() {
        // Escuchar cambios del historial (botón atrás / adelante)
        window.addEventListener('popstate', this.handlePopState);

        // Leer categoría desde la URL si existe
        const urlParams = new URLSearchParams(window.location.search);
        const categoryFromUrl = urlParams.get('category');

        if (categoryFromUrl) {
            this.selectedCategory = categoryFromUrl;
        } else if (this.initialCategory) {
            this.selectedCategory = this.initialCategory;
        }

        this.fetchCategories();
        this.fetchProducts();
    },
    beforeUnmount() {
        window.removeEventListener('popstate', this.handlePopState);
    },
    methods: {
        async fetchProducts() {
            this.loading = true;
            const categorySlug = this.selectedCategory || '';

            try {
                const response = await axios.get('/anunciantes', {
                    params: { category: categorySlug },
                    headers: { 'Accept': 'application/json' },
                });

                this.products = response.data.products;
                this.error = null;
            } catch (error) {
                console.error('Error al cargar productos:', error);
                this.error = 'No se pudieron cargar los productos.';
            } finally {
                this.loading = false;
            }
        },
        async fetchCategories() {
            try {
                const response = await axios.get('/categorias');
                this.categories = Object.entries(response.data.categories).map(([letter, categories]) => ({
                    letter,
                    categories,
                }));
            } catch (error) {
                console.error('Error al cargar categorías:', error);
            }
        },
        filterByCategory(slug) {
            this.selectedCategory = slug;

            // 🧭 Actualizar la URL sin recargar
            const url = new URL(window.location);
            if (slug) {
                url.searchParams.set('category', slug);
            } else {
                url.searchParams.delete('category');
            }
            window.history.pushState({}, '', url);

            this.fetchProducts();
        },
        handlePopState() {
            // Se ejecuta cuando el usuario usa los botones de navegación del navegador
            const urlParams = new URLSearchParams(window.location.search);
            const categoryFromUrl = urlParams.get('category');
            this.selectedCategory = categoryFromUrl;
            this.fetchProducts();
        },
    }
};
</script>