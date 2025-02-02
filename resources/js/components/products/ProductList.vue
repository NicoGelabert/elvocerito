<template>
  <div class="relative product-list">
    <!-- INDICADOR DE CARGA -->
    <div v-if="loading" class="spinner-overlay">
      <div class="spinner"></div>
    </div>
    <!-- FIN INDICADOR DE CARGA -->

    <!-- MENSAJE DE ERROR -->
    <div v-if="error" class="error">{{ error }}</div>
    <!-- FIN MENSAJE DE ERROR -->

    <!-- FILTRO DE CATEGORÍAS Y LISTADOS DE PRODUCTOS -->
    <div class="container flex flex-col lg:flex-row gap-4">

      <!-- FILTRO DE CATEGORÍAS -->
      <aside class="w-full lg:w-1/5 flex flex-col gap-4">
        <h6>Filter By</h6>
        <hr class="divider">
        <p>Type</p>
        <ul class="flex flex-wrap justify-start gap-4">
          <li
          class=""
          :class="{ 'active-category': selectedCategory === null }"
          >
            <button
              @click="filterByCategory(null)"
              class="btn btn-secondary btn-products_list"
            >
              Todas
            </button>
          </li>
          <li v-for="category in categories" :key="category.id"
          class=""
          :class="{ 'active-category': selectedCategory === category.slug }"
          >
            <button
              @click="filterByCategory(category.slug)"
              class="btn btn-secondary btn-products_list"
            >
              {{ category.name }}
            </button>
          </li>
        </ul>
      </aside>
      <!-- FIN FILTRO DE CATEGORÍAS -->

      <!-- LISTADO DE PRODUCTOS -->
      <div :class="{ 'loading-opacity': loading }" class="flex-1">
        <ul class="grid gap-4 grid-cols-2 sm:grid-cols-3 md:grid-cols-3 xl:grid-cols-4">
          <!-- CARD -->
          <li v-for="product in products" :key="product.id" class="relative overflow-hidden flex flex-col justify-between">
            <!-- IMAGEN -->
            <div>
              <a :href="'/todo/' + product.categories[0]?.slug + '/' + product.slug" class="aspect-w-3 aspect-h-2 block overflow-hidden relative">
                <!-- BADGES -->
                <div class="pt-2 px-2 text-xs flex justify-between gap-2 absolute w-full">
                  <!-- BADGE CATEGORÍA -->
                  <div v-if="product.categories && product.categories.length > 0" >
                    <ul class="font-bold text-xs">
                      <li class="badge" v-for="category in product.categories" :key="category.id"><span>{{ category.name }}</span></li>
                    </ul>
                  </div>
                  <!-- FIN BADGE CATEGORÍA -->
                  <!-- BADGE RATING -->
                  <div v-if="product.prices && product.prices.length > 0">
                    <ul class="font-bold text-xs">
                      <li class="bg-primary text-gray_50 rounded-md py-1 px-2 ml-2 flex items-start gap-1" v-for="price in product.prices" :key="price.id"><StarIcon class="fill-gray_50 w-3 h-auto pt-[1px]" />{{ price.number }}</li>
                    </ul>
                  </div>
                  <!-- FIN BADGE RATING -->
                </div>
                <!-- FIN BADGES -->
                <img :src="product.image_url" alt="" class="card-image object-cover aspect-square rounded-lg hover:scale-105 transition-transform" />
              </a>
            </div>
            <!-- FIN IMAGEN -->
            <!-- CONTENIDO -->
            <div class="flex flex-col justify-between py-4 gap-2 h-full">
              <h5 class="w-fit">{{ product.title }}</h5>
              <div class="flex gap-4 card-buttons">
                <a href="{{ product.link }}" class="btn btn-primary btn-products_list"><WhatsappIcon /></a>
                <a :href="'/todo/' + product.categories[0]?.slug + '/' + product.slug" class="btn btn-secondary btn-products_list"><EyeIcon /></a>
              </div>
            </div>
            <!-- FIN CONTENIDO -->
          </li>
          <!-- FIN CARD -->
        </ul>
      </div>
      <!-- FIN LISTADO DE PRODUCTOS -->
    </div>
    <!-- FIN FILTRO DE CATEGORÍAS Y LISTADOS DE PRODUCTOS -->
  </div>
</template>

<script>
import axios from 'axios';
import StarIcon from '@/icons/StarIcon.vue';
import WhatsappIcon from '@/icons/WhatsappIcon.vue';
import EyeIcon from '@/icons/EyeIcon.vue';
export default {
components: {
  // Registro de componentes
  StarIcon,
  WhatsappIcon,
  EyeIcon,
},
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


