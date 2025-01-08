<template>
    <div class="relative product-list mb-16">
      <!-- Indicador de carga -->
      <div v-if="loading" class="spinner-overlay">
        <div class="spinner"></div>
      </div>
  
      <!-- Mensaje de error -->
      <div v-if="error" class="error">{{ error }}</div>
  
      <!-- Filtro de categorías y listado de productos -->
      <div class="max-w-screen-xl mx-4 flex flex-col md:flex-row gap-8">
        <aside class="w-full md:w-1/6">
          <ul class="flex flex-wrap gap-2">
            <li
            class="mt-1 bg-demo_white text-xs w-fit rounded-full px-3 py-2 text-demo_primary"
            :class="{ 'active-category': selectedCategory === null }"
            >
              <button
                @click="filterByCategory(null)"
                class="text-left"
              >
                Todos
              </button>
            </li>
            <li v-for="category in categories" :key="category.id"
            class="mt-1 bg-demo_white text-xs w-fit rounded-full px-3 py-2 text-demo_primary"
            :class="{ 'active-category': selectedCategory === category.slug }"
            >
              <button
                @click="filterByCategory(category.slug)"
                class="text-left"
              >
                {{ category.name }}
              </button>
            </li>
          </ul>
        </aside>
  
        <!-- Productos, con clase de opacidad condicional -->
        <div :class="{ 'loading-opacity': loading }" class="flex-1">
          <ul class="grid gap-4 grid-cols-2 sm:grid-cols-2 md:grid-cols-4">
            <li v-for="product in products" :key="product.id" class="relative overflow-hidden rounded-lg bg-white dark:bg-black flex">
              <a :href="'/products/' + product.categories[0]?.slug + '/' + product.slug" class="aspect-w-3 aspect-h-2 block overflow-hidden">
                <div v-if="product.alergens && product.alergens.length > 0">
                  <ul>
                    <li v-for="alergen in product.alergens" :key="alergen.id" class="text-xs w-fit rounded-full px-2 py-1 absolute z-10 top-4 left-4 text-sm"
                    :class="alergen.name === 'Analógica' ? 'bg-demo_secondary_soft text-demo_secondary' : 'bg-demo_primary_soft text-demo_primary'">{{ alergen.name }}</li>
                  </ul>
                </div>
                <img :src="product.image_url" alt="" class="card-image object-cover hover:scale-105 hover:rotate-1 transition-transform" />
                <div class="flex flex-col p-4 gap-2">
                  <div v-if="product.prices && product.prices.length > 0">
                    <ul class="font-bold text-sm">
                      <li v-for="price in product.prices" :key="price.id">${{ price.number }}</li>
                    </ul>
                  </div>
                  <h6 class="underline-hover w-fit">{{ product.title }}</h6>
                  <!-- <p class="text-xs" v-if="product.quantity">Stock: {{ product.quantity }}</p>
                  <p class="text-xs" v-else>Sin cantidad disponible</p> -->
                  <div v-if="product.categories && product.categories.length > 0" class="mt-2 text-xs flex gap-2">
                    <ul class="font-bold text-xs">
                      <li v-for="category in product.categories" :key="category.id">{{ category.name }}</li>
                    </ul>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </template>  

<script>
import axios from 'axios';

export default {
  data() {
    return {
      products: [],  // Para almacenar los productos
      categories: [],  // Para almacenar las categorías
      loading: true,  // Para manejar el estado de carga
      error: null,    // Para manejar errores de la API
      selectedCategory: null,  // Para manejar la categoría seleccionada
    };
  },
  mounted() {
    // Llamamos a la función que obtiene las categorías y los productos cuando el componente se monta
    this.fetchCategories();
    this.fetchProducts();
  },
  methods: {
    // Obtener las categorías
    fetchCategories() {
      axios.get('/api/categories')  // Hacemos la petición a la API de categorías
        .then(response => {
          this.categories = response.data.data;  // Asignamos las categorías (data está envuelto en 'data')
        })
        .catch(error => {
          console.error("Error al obtener categorías:", error);
          this.error = "Ocurrió un error al cargar las categorías.";  // Mostramos un mensaje de error
        });
    },

    // Obtener productos con filtro de categoría
    fetchProducts() {
      const categorySlug = this.selectedCategory ? this.selectedCategory : '';  // Si hay categoría seleccionada, la pasamos
      axios.get('/api/products', {
        params: {
          category: categorySlug,  // Filtro por categoría
        },
      })
        .then(response => {
          this.products = response.data.data;  // Asignamos los productos (data está envuelto en 'data')
          this.loading = false;  // Cambiamos el estado de carga
        })
        .catch(error => {
          console.error("Error al obtener productos:", error);
          this.error = "Ocurrió un error al cargar los productos.";  // Mostramos un mensaje de error
          this.loading = false;  // Terminamos el estado de carga
        });
    },

    // Filtrar productos por categoría
    filterByCategory(slug) {
      this.selectedCategory = slug;  // Establecemos la categoría seleccionada
      this.loading = true;  // Activamos el estado de carga
      this.fetchProducts();  // Volvemos a cargar los productos filtrados
    },
  },
};
</script>


