<template>
  <div class="container flex flex-col gap-8 lg:flex-row">
    <!-- Botón para abrir el modal en mobile/tablet -->
    <button v-if="!isDesktop" @click="showModal = true" class="btn btn-secondary btn-filtro flex gap-4 items-center w-fit">
      <p>Filtrar por</p>
      <FilterIcon class="w-4 h-4 fill-gray_600" />
    </button>

    <!-- Modal en mobile/tablet -->
    <div v-if="!isDesktop && showModal" class="modal-overlay">
      <div class="modal-content">
        <div class="flex justify-between items-center">
          <h2>Filtros</h2>
          <button @click="showModal = false" class="close-btn">✖</button>
        </div>
        
        <!-- Categorías dentro del modal -->
        <div v-if="categories && categories.length > 0" class="filter_categories">
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
              class="cursor-pointer flex items-center gap-2"
            >
              <img 
                :src="category.image || '/images/default-product.jpg'" 
                alt="Imagen del producto" class="w-4 h-auto opacity-50"
              />
              {{ category.name }}
            </li>
          </ul>
        </div>

        <!-- Etiquetas dentro del modal -->
        <div v-if="tags && tags.length > 0" class="filter_tags">
          <h4>Etiquetas</h4>
          <ul>
            <li 
              @click="toggleTag('all')" 
              :class="{ active: selectedTags.length === tags.length }"
              class="badge truncate-text"
            >
              <span>Todos</span>
            </li>
            <li 
              v-for="tag in tags" 
              :key="tag.id" 
              @click="toggleTag(tag.id)"
              :class="{ active: selectedTags.includes(tag.id) }"
              class="badge truncate-text"
            >
              <span>{{ tag.name }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Filtros en desktop (siempre visibles) -->
    <div v-if="isDesktop" class="lg:w-1/4 flex flex-col gap-12">
      <div v-if="categories && categories.length > 0" class="filter_categories">
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
            class="cursor-pointer flex items-center gap-2"
          >
            <img 
              :src="category.image || '/images/default-product.jpg'" 
              alt="Imagen del producto" class="w-4 h-auto opacity-50"
            />
            {{ category.name }}
          </li>
        </ul>
      </div>

      <div v-if="tags && tags.length > 0" class="filter_tags">
        <h4>Etiquetas</h4>
        <ul>
          <li 
            @click="toggleTag('all')" 
            :class="{ active: selectedTags.length === tags.length }"
            class="badge truncate-text"
          >
            <span>Todos</span>
          </li>
          <li 
            v-for="tag in tags" 
            :key="tag.id" 
            @click="toggleTag(tag.id)"
            :class="{ active: selectedTags.includes(tag.id) }"
            class="badge truncate-text"
          >
            <span>{{ tag.name }}</span>
          </li>
        </ul>
      </div>
    </div>

    <!-- Productos -->
    <div v-if="filteredProducts.length > 0" class="product-list">
      <div v-for="product in filteredProducts" :key="product.id" class="p-2">
        <div class="relative">
          <img 
            :src="product.images?.[0]?.url || '/images/default-product.jpg'" 
            alt="Imagen del producto" 
          />
          <div class="absolute flex gap-2 top-2 right-2">
            <div v-for="category in product.categories" :key="category.id" class="bg-gray_50 border border-primary rounded-full p-1 fill-white">
              <img :src="category.image" alt="" class="border-none w-4 fill-white">
            </div>
          </div>
        </div>
        <div class="flex flex-col justify-between py-4 gap-2">
          <a :href="`/categorias/${product.categories?.[0]?.parent?.slug || 'sin-categoria'}/${product.categories?.[0]?.slug || 'sin-subcategoria'}/${product.slug}`">
            <div class="flex items-center justify-between mb-2">
              <h5 class="w-fit text-base leading-none">{{ product.title }}</h5>
            </div>
            <p class="text-xs text-gray_500 overflow-hidden line-clamp-2">{{ product.short_description }}</p>
          </a>
        </div>
      </div>
    </div>

    <div v-else-if="!loading">
      <p>No hay productos disponibles.</p>
    </div>

    <div v-if="loading" class="spinner-overlay">
      <div class="spinner"></div>
    </div>
  </div>
</template>

<script>
import FilterIcon from '@/icons/FilterIcon.vue';
export default {
  props: {
    products: Array,
    categories: Array,
    tags: Array,
  },
  components: {
    FilterIcon,
  },
  data() {
    return {
      selectedCategory: 'all',
      selectedTags: [],
      filteredProducts: [],
      loading: false,
      showModal: false, // Controla la visibilidad del modal en mobile
      isDesktop: window.innerWidth >= 1024, // Detecta si es desktop
    };
  },
  computed: {
    isMobileOrTablet() {
      return !this.isDesktop;
    },
  },
  methods: {
    changeCategory(categoryId) {
      this.selectedCategory = categoryId;
      this.filterProducts();
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
    },
  },
  mounted() {
    this.filteredProducts = [...this.products];
    window.addEventListener('resize', this.checkScreenSize);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkScreenSize);
  },
};
</script>