<template>
  <!-- INICIO CONTENEDOR FILTROS Y LISTADO DE PRODUCTOS -->
  <div class="container flex flex-col gap-8 lg:flex-row">
    <!-- INICIO BOTÓN PARA ABRIR MODAL EN MOBILE Y TABLET  -->
    <button v-if="!isDesktop" @click="showModal = true" class="btn btn-secondary btn-filtro flex gap-4 items-center w-fit">
      <p>Filtrar por</p>
      <FilterIcon class="w-4 h-4 fill-gray_600" />
    </button>
    <!-- FIN BOTÓN PARA ABRIR MODAL EN MOBILE Y TABLET  -->

    <!-- INCIO MODAL CON FILTROS EN MOBILE Y TABLET -->
    <div class="modal-wrapper">
      <transition name="overlay-fade">
        <div v-if="showModal" class="modal-overlay pointer-events-auto" @click="showModal = false"></div>
      </transition>
      <transition name="modal-slide-up">
        <div v-if="showModal" class="modal-content">
          <div class="flex justify-between items-center">
            <h2>Filtros</h2>
            <button @click="showModal = false" class="close-btn">✖</button>
          </div>
          
          <!-- Categorías dentro del modal -->
          <div v-if="categories && categories.length > 0" class="filter_categories">
            <h4>Categorías</h4>
            <ul>
              <li 
                v-if="selectedCategory !== null" 
                @click="clearCategory"
                class="badge clear my-4"
              >
                <span class="capitalize">Limpiar Selección</span>
              </li>
              <li 
                v-for="category in categories" 
                :key="category.id" 
                @click="changeCategory(category.id)"
                :class="{ active: selectedCategory === category.id }"
                class="cursor-pointer flex items-center gap-2 pb-2"
              >
                <img 
                  :src="category.image || '/images/default-product.jpg'" 
                  alt="Imagen del producto" class="w-4 h-auto opacity-50"
                />
                <div v-if="selectedCategory === category.id" @click.stop="changeCategory(null)"
                      title="Quitar selección" class="flex w-full justify-between">
                  <span>{{ category.name }}</span>
                  <span class="rounded-full bg-gray_100 px-1">✕</span>
                </div>
                <div v-else @click="changeCategory(category.id)">
                  <span>
                    {{ category.name }}
                  </span>
                </div>
              </li>
            </ul>
          </div>
  
          <!-- Etiquetas dentro del modal -->
          <div v-if="tags && tags.length > 0" class="filter_tags">
            <h4>Etiquetas</h4>
            <ul>
              <li 
                v-if="selectedTags.length > 0"
                @click="clearTags"
                class="badge clear"
              >
                <span>Limpiar Selección</span>
              </li>
              <li 
                v-for="tag in tags" 
                :key="tag.id" 
                :class="{ active: selectedTags.includes(tag.id) }"
                class="badge"
              >
              <div v-if="!selectedTags.includes(tag.id)" @click="toggleTag(tag.id)">
                <span>
                  {{ tag.name }}
                </span>
              </div>
              <div v-else class="flex items-center gap-2"
                @click.stop="toggleTag(tag.id)"
                title="Quitar">
                <span
                    >
                  {{ tag.name }}
                </span>
                <span class="rounded-full bg-white/50 px-1">✕</span>
              </div>
              </li>
            </ul>
          </div>
        </div>
      </transition>
    </div>
      
    <!-- FIN MODAL CON FILTROS EN MOBILE Y TABLET -->

    <!-- INICIO FILTROS EN DESKTOP -->
    <div v-if="isDesktop" class="lg:w-1/4 flex flex-col gap-12 bg-white p-4 h-fit rounded-lg">
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
            class="badge"
          >
            <span>Todos</span>
          </li>
          <li 
            v-for="tag in tags" 
            :key="tag.id" 
            @click="toggleTag(tag.id)"
            :class="{ active: selectedTags.includes(tag.id) }"
            class="badge"
          >
            <span>{{ tag.name }}</span>
          </li>
        </ul>
      </div>
    </div>
    <!-- FIN FILTROS EN DESKTOP -->

    <!-- INICIO LISTADO PRODUCTOS -->
    <div v-if="filteredProducts.length > 0" class="product-list">
      <!-- INICIO PRODUCTO -->
      <div v-for="product in filteredProducts" :key="product.id" class="product_card">
        <!-- INICIO IMAGEN PRODUCTO -->
        <div class="relative">
          <img 
            :src="product.images?.[0]?.url || '/images/default-product.jpg'" 
            alt="Imagen del producto" 
          />
        </div>
        <!-- FIN IMAGEN PRODUCTO -->
        <!-- INICIO CONTENIDO PRODUCTO -->
        <div class="flex flex-col justify-between flex-1">
          <!-- INICIO PRODUCT NAME, DESCRIPTION -->
          <div class="flex flex-col justify-between flex-1 py-4 px-2 gap-4">
            <a :href="`/categorias/${product.categories?.[0]?.parent?.slug || 'sin-categoria'}/${product.categories?.[0]?.slug || 'sin-subcategoria'}/${product.slug}`">
              <div class="flex items-center justify-between mb-2">
                <h5 class="w-fit text-base leading-none">{{ product.title }}</h5>
              </div>
              <p class="text-xs text-gray_500 overflow-hidden line-clamp-2">{{ product.short_description }}</p>
            </a>  
            <!-- INICIO IMAGEN CATEGORÍA -->
            <div class="categories_badges relative">
              <div v-for="category in product.categories" :key="category.id" class="category_badge relative w-6 h-6">
                <img :src="category.image" :alt="category.name" class="" :data-tooltip-target="'tooltip-' + category.id">
                <!-- INICIO TOOLTIP -->
                <div :id="'tooltip-' + category.id" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                  <span class="whitespace-nowrap">{{category.name}}</span>
                  <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <!-- INICIO TOOLTIP -->
              </div>
            </div>
            <!-- FIN IMAGEN CATEGORÍA -->
          </div>
          <!-- FIN PRODUCT NAME, DESCRIPTION -->
          <!-- INICIO FOOTER DE PRODUCTO -->
          <div class="footer">
            <hr class="divider">
            <div class="flex justify-between items-center">
              <div v-if="product.contacts && product.contacts.length" class="flex items-center gap-2">
                <component :is="getIcon(product.contacts[0].type)" class="w-4 h-4" />
                <p>{{ product.contacts[0].info }}</p>
              </div>
              <p v-else>
                Sin contacto
              </p>
            </div>
          </div>
          <!-- FIN FOOTER DE PRODUCTO -->
        </div>
        <!-- FIN CONTENIDO PRODUCTO -->
      </div>
      <!-- FIN PRODUCTO -->
    </div>
    <!-- FIN LISTADO PRODUCTOS -->

    <!-- INICIO MENSAJE NO HAY PRODUCTOS -->
    <div v-else-if="!loading">
      <p>No hay productos disponibles.</p>
    </div>
    <!-- FIN MENSAJE NO HAY PRODUCTOS -->

    <!-- INICIO SPINNER -->
    <div v-if="loading" class="spinner-overlay">
      <div class="spinner"></div>
    </div>
    <!-- FIN SPINNER -->
  </div>
  <!-- FIN CONTENEDOR FILTROS Y LISTADO DE PRODUCTOS -->
</template>

<script>
import FilterIcon from '@/icons/FilterIcon.vue';
import FijoIcon from '@/icons/FijoIcon.vue';
import MailIcon from '@/icons/MailIcon.vue';
import MovilIcon from '@/icons/MovilIcon.vue';
import WhatsappIcon from '@/icons/WhatsappIcon.vue';
import { createPopper } from '@popperjs/core';

export default {
  props: {
    products: {
      type: Array,
      required: true
    },
    categories: {
      type: Array,
      default: () => []
    },
    tags: {
      type: Array,
      default: () => []
    }
  },
  components: {
    FilterIcon,
    FijoIcon,
    MailIcon,
    MovilIcon,
    WhatsappIcon,
  },
  data() {
    return {
      selectedCategory: 'null',
      selectedTags: [],
      filteredProducts: [],
      loading: false,
      showModal: false, // Controla la visibilidad del modal en mobile
      isDesktop: window.innerWidth >= 1024, // Detecta si es desktop
      hovered: {},
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
    clearCategory() {
      this.selectedCategory = null;
      this.filterProducts();
    },
    toggleTag(tagId) {
      const index = this.selectedTags.indexOf(tagId);
      if (index === -1) {
        this.selectedTags.push(tagId);
      } else {
        this.selectedTags.splice(index, 1);
      }
      this.filterProducts();
    },
    clearTags() {
      this.selectedTags = [];
      this.filterProducts();
    },
    filterProducts() {
      this.loading = true;
      setTimeout(() => {
        this.filteredProducts = this.products.filter(product => {
          let categoryMatch = this.selectedCategory === null || product.categories.some(category => category.id === this.selectedCategory);
          let tagMatch = this.selectedTags.length === 0 || product.tags.some(tag => this.selectedTags.includes(tag.id));
          return categoryMatch && tagMatch;
        });
        this.loading = false;
      }, 500);
    },
    checkScreenSize() {
      this.isDesktop = window.innerWidth >= 1024;
    },
    getIcon(type) {
      switch (type) {
        case 'fijo':
          return 'FijoIcon'
        case 'email':
          return 'MailIcon'
        case 'móvil':
          return 'MovilIcon'
        case 'whatsapp':
          return 'WhatsappIcon'
        default:
          return null
      }
    },
  },
  mounted() {
    this.filteredProducts = [...this.products];
    window.addEventListener('resize', this.checkScreenSize);
    setTimeout(() => {
      initTooltips();
    }, 0);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkScreenSize);
  },
};
</script>