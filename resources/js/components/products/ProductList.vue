<template>
  <div class="container flex">
    <!-- Categorías -->
    <div v-if="categories.length > 0" class="w-1/4 filter_categories">
      <h4>Categorías</h4>
      <ul>
        <li 
          @click="changeCategory('all')" 
          :class="{ active: selectedCategory === 'all' }"
          class="cursor-pointer"
        >
          Todos
        </li>
        <li 
          v-for="category in categories" 
          :key="category.id" 
          @click="changeCategory(category.id)"
          :class="{ active: selectedCategory === category.id }"
          class="cursor-pointer"
        >
          {{ category.name }}
        </li>
      </ul>
    </div>
    <!-- Fin categorías -->

    <!-- Productos -->
    <div v-if="filteredProducts.length > 0" class="product-list">
      <div v-for="product in filteredProducts" :key="product.id" class="p-2">
        
        <!-- Badge categoría -->
        <div v-if="product.categories && product.categories.length > 0">
          <ul class="category_badges">
            <li class="badge truncate-text" v-for="category in product.categories" :key="category.id">
              <span>{{ category.name }}</span>
            </li>
          </ul>
        </div>
        <!-- Fin badge categoría -->

        <!-- Imagen del producto -->
        <img 
          :src="product.images?.[0]?.url || '/images/default-product.jpg'" 
          alt="Imagen del producto" 
        />

        <div class="flex flex-col justify-between py-4 gap-2">
          <h5 class="w-fit">{{ product.title }}</h5>
          <div class="flex gap-4 card-buttons">
            <a :href="product.link" class="btn btn-primary btn-products_list">
              <WhatsappIcon />
            </a>
            <a 
              :href="`/todo/${product.categories?.[0]?.slug || 'sin-categoria'}/${product.slug}`" 
              class="btn btn-secondary btn-products_list"
            >
              <EyeIcon />
            </a>
          </div>
        </div>
      </div>
    </div>

    <div v-else-if="!loading">
      <p>No hay productos disponibles.</p>
    </div>

    <!-- Spinner -->
    <div v-if="loading" class="spinner-overlay">
      <div class="spinner"></div>
    </div>


  </div>
</template>

<script>
import StarIcon from '@/icons/StarIcon.vue';
import WhatsappIcon from '@/icons/WhatsappIcon.vue';
import EyeIcon from '@/icons/EyeIcon.vue';

export default {
  components: {
    StarIcon,
    WhatsappIcon,
    EyeIcon,
  },
  props: {
    products: Array, // Recibe la lista de productos
    categories: Array // Recibe las categorías asociadas
  },
  data() {
    return {
      selectedCategory: 'all', // Estado inicial: todos los productos
      filteredProducts: [], // Lista filtrada de productos
      loading: false // Estado del spinner
    };
  },
  methods: {
    changeCategory(categoryId) {
        console.log("Categoria seleccionada:", categoryId); // Verificar qué categoría está seleccionada
        this.selectedCategory = categoryId;
        this.loading = true;

        setTimeout(() => {
            if (this.selectedCategory === 'all') {
                this.filteredProducts = this.products;
            } else {
                // Filtrar productos basándonos en la relación 'categories'
                this.filteredProducts = this.products.filter(product => {
                    if (product.categories && Array.isArray(product.categories)) {
                        console.log("Categorias del producto:", product.categories); // Verificar qué categorías tiene cada producto
                        return product.categories.some(category => category.id === this.selectedCategory);
                    }
                    return false;
                });
            }

            console.log("Productos filtrados:", this.filteredProducts);
            this.loading = false;
        }, 500);
    }
},

  mounted() {
    console.log('Productos:', this.products);
    console.log('Categorías:', this.categories);

    // Verifica si `this.products` tiene datos antes de asignarlo
    if (Array.isArray(this.products) && this.products.length > 0) {
        this.filteredProducts = [...this.products]; // Copia los productos correctamente
    } else {
        this.filteredProducts = [];
    }
  }

};
</script>