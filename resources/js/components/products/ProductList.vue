<template>
  <div class="container flex flex-col gap-8 lg:flex-row">
    <div class="lg:w-1/4 flex flex-col gap-12">
      <!-- Categorías -->
      <div v-if="categories && categories.length > 0" class="filter_categories">
        <h4>Categorías</h4>

        <!-- Botón para abrir/cerrar menú en mobile -->
        <button @click="toggleMenu" class="lg:hidden">
          {{ isMenuOpen ? 'Cerrar' : 'Seleccionar Categoría' }}
        </button>

        <!-- Lista de categorías (controlado con v-show en mobile) -->
        <ul v-show="isMenuOpen || isDesktop">
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

      <!-- Etiquetas -->
      <div v-if="tags && tags.length > 0" class="filter_tags">
        <h4>Etiquetas</h4>
        <ul>
          <li 
            @click="toggleTag('all')" 
            :class="{ active: selectedTags.length === tags.length }"
            class="cursor-pointer badge"
          >
            Todos
          </li>
          <li 
            v-for="tag in tags" 
            :key="tag.id" 
            @click="toggleTag(tag.id)"
            :class="{ active: selectedTags.includes(tag.id) }"
            class="cursor-pointer badge"
          >
            {{ tag.name }}
          </li>
        </ul>
      </div>
      <!-- Fin etiquetas -->
    </div>

    <!-- Productos -->
    <div v-if="filteredProducts.length > 0" class="product-list">
      <div v-for="product in filteredProducts" :key="product.id" class="p-2">
        <!-- Mostrar categorías y productos -->
        <div v-if="product.categories && product.categories.length > 0">
          <ul class="category_badges">
            <li class="badge truncate-text" v-for="category in product.categories" :key="category.id">
              <span>{{ category.name }}</span>
            </li>
          </ul>
        </div>

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
            <a :href="`/categorias/${product.categories?.[0]?.parent?.slug || 'sin-categoria'}/${product.categories?.[0]?.slug || 'sin-subcategoria'}/${product.slug}`" class="btn btn-secondary btn-products_list">
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
    products: Object,
    categories: Array,
    tags: Array,
  },
  data() {
    return {
      selectedCategory: 'all',
      selectedTags: [],
      filteredProducts: [],
      loading: false,
      isMenuOpen: false, // El menú inicia cerrado en mobile
      isDesktop: window.innerWidth >= 1024, // Detecta si es desktop
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
    changeCategory(categoryId) {
      this.selectedCategory = categoryId;
      this.filterProducts();
      if (!this.isDesktop) this.isMenuOpen = false; // Cierra el menú en mobile
    },
    toggleTag(tagId) {
      if (tagId === 'all') {
        this.selectedTags = this.selectedTags.length === this.tags.length ? [] : this.tags.map(tag => tag.id);
      } else {
        const index = this.selectedTags.indexOf(tagId);
        if (index === -1) {
          this.selectedTags.push(tagId);
        } else {
          this.selectedTags.splice(index, 1);
        }
      }
      this.filterProducts();
    },
    filterProducts() {
      this.loading = true;
      setTimeout(() => {
        this.filteredProducts = this.products.filter(product => {
          let categoryMatch = this.selectedCategory === 'all' || product.categories.some(category => category.id === this.selectedCategory);
          let tagMatch = this.selectedTags.length === 0 || product.tags.some(tag => this.selectedTags.includes(tag.id));
          return categoryMatch && tagMatch;
        });

        this.loading = false;
      }, 500);
    },
    checkScreenSize() {
      this.isDesktop = window.innerWidth >= 1024;
      if (this.isDesktop) this.isMenuOpen = true; // En desktop, el menú siempre está abierto
      else this.isMenuOpen = false; // En mobile, el menú inicia cerrado
    },
  },
  mounted() {
    
  if (this.product && this.product.categories) {
    console.log('Categorías del producto:', this.product.categories);
    console.log('Categoría principal (padre) de la primera categoría:', this.product.categories?.[0]?.parent);
  }
    console.log("📦 Productos recibidos en Vue:", this.products);
    console.log("🏷 Tags recibidos en Vue:", this.tags);
    this.filteredProducts = [...this.products];
    
    window.addEventListener('resize', this.checkScreenSize);
    this.checkScreenSize(); // Chequea el tamaño al iniciar
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkScreenSize);
  },
};
</script>
