<template>
  <!-- INICIO CONTENEDOR FILTROS Y LISTADO DE PRODUCTOS -->
  <div class="container flex flex-col gap-6 lg:flex-row">
    <div v-if="!isDesktop" class="flex flex-col gap-4">
      <!-- INICIO BOTÓN PARA ABRIR MODAL EN MOBILE Y TABLET  -->
      <button @click="showModal = true" class="btn btn-secondary btn-filtro flex gap-4 items-center w-fit relative">
        <p>Filtrar por</p>
        <FilterIcon class="w-4 h-4 fill-gray_600" />
        <span 
          v-if="selectedCategory !== null || selectedTags.length > 0" 
          class="absolute -top-2 -right-1 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center pb-[0.1rem]"
        ><span v-if="filtersCount > 0" class="text-sm text-gray_50">{{ filtersCount }}</span>
      </span>
      </button>
      <!-- FIN BOTÓN PARA ABRIR MODAL EN MOBILE Y TABLET  -->
      <!-- INICIO FILTROS ACTIVOS -->
      <div v-if="selectedCategory !== null || selectedTags.length > 0" class="text-sm text-gray-600 flex items-center gap-4 flex-wrap">
        <div class="flex justify-between items-center w-full">
          <span class="text-secondary">Filtros activos:</span>
          <button @click="clearAllFilters" class="badge clear text-xs"><span>Limpiar todos</span></button>
        </div>
        <span v-if="selectedCategory !== null" class="badge active-filter text-xs">
          {{ getCategoryName(selectedCategory) }}
          <button @click="clearCategory" class="ml-1 text-xs">✕</button>
        </span>
        <span v-for="tagId in selectedTags" :key="tagId" class="badge active-filter text-xs">
          {{ getTagName(tagId) }}
          <button @click="toggleTag(tagId)" class="ml-1 text-xs">✕</button>
        </span>
      </div>
      <!-- FIN FILTROS ACTIVOS -->
    </div>
    <!-- INCIO MODAL CON FILTROS EN MOBILE Y TABLET -->
    <div class="modal-wrapper">
      <transition name="overlay-fade">
        <div v-if="showModal" class="modal-overlay pointer-events-auto" @click="showModal = false"></div>
      </transition>
      <transition name="modal-slide-up">
        <div v-if="showModal" class="modal-content">
          <button @click="showModal = false" class="absolute right-2 font-bold w-12 h-12 bg-white border border-gray_300 rounded-full z-50 -top-6">✖</button>
          <div class="flex justify-between items-start">
            <div class="flex justify-between items-baseline w-full">
              <h2>Filtros</h2>
              <span class="text-gray_700 text-sm" v-if="filtersCount > 0">({{ filtersCount }} activo{{ filtersCount > 1 ? 's' : '' }})</span>
            </div>

          </div>
          
          <div class="max-h-[71vh] overflow-y-auto">
            <!-- Categorías dentro del modal -->
            <div v-if="categories && categories.length > 0" class="filter_categories">
              <div class="flex justify-between items-center mb-4">
                <h4>Categorías</h4>
                <x-button 
                    v-if="selectedCategory !== null" 
                    @click="clearCategory"
                    class="badge clear"
                  >
                    <span class="capitalize">Limpiar Selección</span>
                </x-button>
              </div>
              <ul>
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
              <div class="flex justify-between items-center">
                <h4>Etiquetas</h4>
                <x-button 
                  v-if="selectedTags.length > 0"
                  @click="clearTags"
                  class="badge clear"
                >
                  <span>Limpiar Selección</span>
                </x-button>
              </div>
              <ul>
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
        </div>
      </transition>
    </div>
    <!-- FIN MODAL CON FILTROS EN MOBILE Y TABLET -->

    <!-- INICIO FILTROS EN DESKTOP -->
    <div v-if="isDesktop" class="lg:w-1/3 flex flex-col gap-8 bg-white p-4 h-fit rounded-lg">
      <!-- INICIO FILTROS ACTIVOS -->
      <div v-if="isDesktop">
        <div v-if="selectedCategory !== null || selectedTags.length > 0" class="text-sm text-gray-600 flex items-center gap-2 flex-wrap">
          <div class="flex justify-between items-center w-full">
            <span class="text-secondary">Filtros activos:</span>
            <button @click="clearAllFilters" class="badge clear text-xs"><span>Limpiar todos</span></button>
          </div>
          <span v-if="selectedCategory !== null" class="badge active-filter text-xs">
            {{ getCategoryName(selectedCategory) }}
            <button @click="clearCategory" class="ml-1 text-xs">✕</button>
          </span>
          <span v-for="tagId in selectedTags" :key="tagId" class="badge active-filter text-xs">
            {{ getTagName(tagId) }}
            <button @click="toggleTag(tagId)" class="ml-1 text-xs">✕</button>
          </span>
        </div>
      </div>
      <!-- FIN FILTROS ACTIVOS -->
      <div class="flex flex-col gap-8">
        <div v-if="categories && categories.length > 0" class="filter_categories">
          <div class="flex justify-between items-center">
            <h4>Categorías</h4>
            <x-button 
                v-if="selectedCategory !== null" 
                @click="clearCategory"
                class="badge clear"
              >
                <span class="capitalize">Limpiar Selección</span>
            </x-button>
          </div>
          <ul>
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
  
        <div v-if="tags && tags.length > 0" class="filter_tags">
          <div class="flex justify-between items-center">
            <h4>Etiquetas</h4>
            <x-button 
              v-if="selectedTags.length > 0"
              @click="clearTags"
              class="badge clear"
            >
              <span>Limpiar Selección</span>
            </x-button>
          </div>
          <ul>
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
    </div>
    <!-- FIN FILTROS EN DESKTOP -->    
    <div class="flex flex-col gap-4 lg:w-2/3">
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

                <!-- INICIO BOTÓN PARA ABRIR MODAL DE CONTACTO EN MOBILE Y TABLET  -->
                <button @click="showModalContact = product.id" class="btn btn-secondary flex gap-4 items-center w-fit relative">
                  Contactar
                </button>
                <!-- FIN BOTÓN PARA ABRIR MODAL EN MOBILE Y TABLET  -->
                <!-- INICIO MODAL -->
                <div class="modal-wrapper-product-contact">
                  <transition name="overlay-fade-product-contact">
                    <div v-if="showModalContact === product.id" class="w-full h-full bg-black bg-opacity-50 flex justify-center items-end pointer-events-auto" @click="showModalContact = null"></div>
                  </transition>
                  <transition name="modal-slide-up">
                    <div v-if="showModalContact === product.id" class="modal-content">
                      <button @click="showModalContact = null" class="absolute right-2 font-bold w-12 h-12 bg-white border border-gray_300 rounded-full z-50 -top-6">✖</button>
                      <h2 class="text-center text-xl font-bold mb-8">Contacta a {{ product.title }}</h2>
                      <div v-if="product.contacts && product.contacts.length" class="contact-icons w-full lg:w-auto">
                        <div v-for="(contact, index) in product.contacts" :key="index" class="contacto" :class="index !== product.contacts.length - 1 ? 'border-b border-gray-200 pb-4 mb-4' : ''">
                          <component :is="getIcon(contact.type)" class="w-4 h-4" />
                          <p class="text-right text-base text-gray-500 -mt-1 lg:mt-0">{{ contact.info }}</p>
                        </div>
                      </div>
                      <p v-else>
                        Sin contacto
                      </p>
                    </div>
                  </transition>
                </div>
                <!-- FIN BOTÓN PARA ABRIR MODAL DE CONTACTO EN MOBILE Y TABLET  -->

                <!-- INICIO BOTÓN PARA ABRIR MODAL DE COMPARTIR  -->
                <button @click="openShareModal(product)" class="btn btn-secondary flex gap-4 items-center w-fit relative">
                  <ShareIcon class="fill-primary"/>
                </button>
                <!-- FIN BOTÓN PARA ABRIR MODAL DE COMPARTIR -->
              </div>
            </div>
            <!-- FIN FOOTER DE PRODUCTO -->
          </div>
          <!-- FIN CONTENIDO PRODUCTO -->
        </div>
        <!-- FIN PRODUCTO -->
        <!-- INICIO MODAL COMPARTIR (solo una instancia) -->
        <div class="modal-wrapper-product-contact">
          <!-- Fondo oscuro -->
          <transition name="overlay-fade-product-contact">
            <div
              v-if="showModalShare"
              class="fixed inset-0 bg-black bg-opacity-50 z-40"
              @click.self="closeShareModal"
            ></div>
          </transition>

          <!-- Modal de compartir -->
          <transition name="modal-slide-up">
            <div
              v-if="showModalShare && productToShare"
              class="modal-content fixed bottom-0 left-0 right-0 z-50 bg-white rounded-t-xl p-4 max-w-2xl mx-auto"
            >
              <button
                @click="closeShareModal"
                class="absolute right-2 -top-6 font-bold w-12 h-12 bg-white border border-gray_300 rounded-full z-50"
              >✖</button>

              <div class="flex flex-col gap-8 bg-white rounded-xl p-4">
                <h2 class="text-center text-xl font-bold">Compartí a {{ productToShare.title }}</h2>

                <div class="flex flex-col items-center md:flex-row md:items-start gap-4">
                  <img :src="productToShare.images?.[0]?.url" :alt="productToShare.title" class="rounded-lg w-full max-w-24 h-auto object-cover" />
                  <div class="flex flex-col gap-4 items-center md:items-start">
                    <div v-if="productToShare.categories?.length" class="flex items-center flex-col md:flex-row md:items-start gap-2">
                      <div v-for="(category, index) in productToShare.categories" :key="index" class="flex gap-1">
                        <img :src="category.image" :alt="category.name" class="w-3 h-3" />
                        <h6>{{ category.name }}</h6>
                      </div>
                    </div>
                    <h4>{{ productToShare.title }}</h4>
                    <p class="text-center md:text-left">{{ productToShare.short_description }}</p>
                  </div>
                </div>

                <div class="flex justify-center gap-4">
                  <a class="bg-gray-100 p-2 rounded-md" :href="`https://www.facebook.com/sharer/sharer.php?u=${shareUrl}`" target="_blank">
                    <FacebookIcon class="w-5 h-5" />
                  </a>
                  <a class="bg-gray-100 p-2 rounded-md" :href="`https://api.whatsapp.com/send?text=${shareText}%20${shareUrl}`" target="_blank">
                    <WhatsappIcon class="w-5 h-5" />
                  </a>
                  <a class="bg-gray-100 p-2 rounded-md" :href="`https://www.linkedin.com/sharing/share-offsite/?url=${shareUrl}`" target="_blank">
                    <LinkedinIcon class="w-5 h-5" />
                  </a>
                  <button class="bg-gray-100 p-2 rounded-md hover:bg-gray-200" @click="copyToClipboard">
                    <CopyIcon class="w-5 h-5" />
                  </button>

                  <!-- Toast -->
                  <transition name="toast" @after-enter="startHideTimeout">
                    <div
                      v-if="show"
                      class="absolute w-max bottom-28 right-1/2 translate-x-1/2 bg-gray-800 text-white text-sm px-4 py-2 rounded shadow z-50"
                    >
                      Enlace copiado al portapapeles
                    </div>
                  </transition>
                </div>
              </div>
            </div>
          </transition>
        </div>
        <!-- FIN MODAL COMPARTIR -->
      </div>
      <!-- FIN LISTADO PRODUCTOS -->
      <!-- INICIO MENSAJE NO HAY PRODUCTOS -->
      <div v-else-if="!loading">
        <p>No hay anunciantes disponibles.</p>
      </div>
      <!-- FIN MENSAJE NO HAY PRODUCTOS -->
    </div>

    <!-- INICIO SPINNER -->
    <div v-if="loading" class="spinner-overlay">
      <div class="spinner"></div>
    </div>
    <!-- FIN SPINNER -->
  </div>
  <!-- FIN CONTENEDOR FILTROS Y LISTADO DE PRODUCTOS -->
</template>

<script>
import CopyIcon from '@/icons/CopyIcon.vue';
import FacebookIcon from '@/icons/FacebookIcon.vue';
import FijoIcon from '@/icons/FijoIcon.vue';
import FilterIcon from '@/icons/FilterIcon.vue';
import LinkedinIcon from '@/icons/LinkedinIcon.vue';
import MailIcon from '@/icons/MailIcon.vue';
import MovilIcon from '@/icons/MovilIcon.vue';
import ShareIcon from '@/icons/ShareIcon.vue';
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
    },
  },
  components: {
    CopyIcon,
    FacebookIcon,
    FijoIcon,
    FilterIcon,
    LinkedinIcon,
    MailIcon,
    MovilIcon,
    ShareIcon,
    WhatsappIcon,
  },
  data() {
    return {
      selectedCategory: null,
      selectedTags: [],
      filteredProducts: [],
      loading: false,
      showModal: false, // Controla la visibilidad del modal en mobile
      showModalContact: null,
      showModalShare: false,
      productToShare: null,
      copied: false,
      isDesktop: window.innerWidth >= 1024, // Detecta si es desktop
      hovered: {},
    };
  },
  computed: {
    isMobileOrTablet() {
      return !this.isDesktop;
    },
    filtersCount() {
      return (this.selectedCategory !== null ? 1 : 0) + this.selectedTags.length;
    },
    shareUrl() {
      if (!this.productToShare) return encodeURIComponent(window.location.href);
      return encodeURIComponent(
        window.location.origin +
        `/categorias/${this.productToShare.categories?.[0]?.parent?.slug || 'sin-categoria'}` +
        `/${this.productToShare.categories?.[0]?.slug || 'sin-subcategoria'}` +
        `/${this.productToShare.slug}`
      );
    },
    shareText() {
      if (!this.productToShare) return '';
      return encodeURIComponent(`${this.productToShare.title} - ${this.productToShare.short_description} - ${this.productToShare.slug}`);
    },
    copyUrl() {
      if (!this.productToShare) return (window.location.href);
      return (
        window.location.origin +
        `/categorias/${this.productToShare.categories?.[0]?.parent?.slug || 'sin-categoria'}` +
        `/${this.productToShare.categories?.[0]?.slug || 'sin-subcategoria'}` +
        `/${this.productToShare.slug}`
      );
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
    getCategoryName(id) {
      const category = this.categories.find(c => c.id === id);
      return category ? category.name : 'Categoría';
    },
    getTagName(id) {
      const tag = this.tags.find(t => t.id === id);
      return tag ? tag.name : 'Etiqueta';
    },
    clearAllFilters() {
      this.selectedCategory = null;
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
    openShareModal(product) {
      this.productToShare = product;
      this.showModalShare = true;
    },
    closeShareModal() {
      this.showModalShare = false;
      this.productToShare = null;
    },
    copyToClipboard() {
      navigator.clipboard.writeText(this.copyUrl).then(() => {
        this.copied = true
        this.triggerToast();
        setTimeout(() => this.copied = false, 2000)  // Feedback dura 2 segundos
      }).catch(err => {
        console.error('Error copiando al portapapeles:', err)
      })
    },
    triggerToast() {
      this.show = true;
    },
    startHideTimeout() {
      if (this.hideTimeout) clearTimeout(this.hideTimeout);
      this.hideTimeout = setTimeout(() => {
        this.show = false;
      }, 2000);
    },
  },
  mounted() {
    this.filteredProducts = [...this.products];
    window.addEventListener('resize', this.checkScreenSize);
    setTimeout(() => {
      initTooltips();
    }, 0);
  },
  beforeUnmount() {
    if (this.hideTimeout) clearTimeout(this.hideTimeout);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkScreenSize);
  },
};
</script>
<style scoped>
.toast-enter-active,
.toast-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}
.toast-enter-from,
.toast-leave-to {
  opacity: 0;
  transform: translateY(100%);
}
.toast-enter-to,
.toast-leave-from {
  opacity: 1;
  transform: translateY(0);
}
</style>