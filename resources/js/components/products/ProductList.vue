<template>
  <div class="relative product-list">
    <!-- Loading y errores -->
    <div v-if="loading" class="spinner-overlay"><div class="spinner"></div></div>
    <div v-if="error" class="error">{{ error }}</div>

    <div class="container flex flex-col gap-4 anunciantes_destacados">
      <h4>Filtrar</h4>
      <hr class="divider-product_list" />
      
      <!-- Filtro desplegable -->
      <div class="w-full relative flex gap-8">
        <div>
          <h5 class="text-gray_600 mb-2">Categoría</h5>
          <!-- Botón del dropdown -->
          <button
            @click="toggleDropdown"
            class="flex gap-4 text-xs text-gray-500 w-auto flex justify-between items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm hover:shadow-md transition-all duration-200"
          >
            {{ selectedCategoryName || 'Selecciona una categoría' }}
            <span :class="{ 'rotate-180': isOpen }" class="text-gray-400 transition-transform duration-300">▼</span>
          </button>
          <!-- Menú desplegable -->
          <transition name="fade-slide">
            <ul
              v-if="isOpen"
              class="absolute z-10 w-full bg-white border border-gray-200 mt-1 max-h-72 overflow-auto rounded-lg shadow-lg scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100"
            >
              <!-- Opción "Todas" -->
              <li>
                <button
                  @click="selectCategory(null)"
                  class="w-full text-left px-4 py-2 hover:bg-blue-50 transition-colors duration-200 rounded"
                  :class="{ 'bg-blue-100 font-semibold': selectedCategory === null }"
                >
                  Todas
                </button>
              </li>
    
              <template v-for="group in categories" :key="group.letter">
                <li class="px-4 py-1 mt-3 mb-1 text-gray-400 font-bold border-b border-gray-200">{{ group.letter }}</li>
                <li
                  v-for="category in group.categories"
                  :key="category.id"
                >
                  <button
                    @click="selectCategory(category)"
                    class="w-full text-left px-4 py-2 hover:bg-blue-50 transition-colors duration-200 rounded"
                    :class="{ 'bg-blue-100 font-semibold': selectedCategory === category.slug }"
                  >
                    {{ category.name }}
                  </button>
                </li>
              </template>
            </ul>
          </transition>
          
        </div>

        <div>
          <h5 class="text-gray_600 mb-4">Urgencias</h5>
          <div class="flex items-center gap-2">
            <button
              @click="toggleUrgencies"
              class="relative w-7 h-4 rounded-full transition-all duration-300 focus:outline-none"
              :class="showUrgenciesOnly ? 'bg-red-500 shadow-[0_0_3px_#ef4444]' : 'bg-gray-300'"
            >
              <span
                class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-all duration-300"
                :class="showUrgenciesOnly ? 'translate-x-3' : 'translate-x-0'"
              ></span>
              <!-- Luz interior -->
              <span
                class="absolute inset-0 rounded-full"
                :class="showUrgenciesOnly ? 'bg-red-400/30 animate-pulse' : ''"
              ></span>
            </button>
          </div>
        </div>

      </div>

      <!-- Listado de productos -->
      <div :class="['anunciantes_destacados_card', { 'loading-opacity': loading }]">
        <ul>
          <li v-for="product in products" :key="product.id">
            <div class="card_body">
              <a
                :href="product.categories.length ? '/' + product.categories[0].slug + '/' + product.slug : '/' + product.slug"
                class="aspect-w-3 aspect-h-2 block overflow-hidden relative"
              >
                <img :src="product.image_url" alt="" />
                <div v-if="product.categories?.length" class="anunciantes_destacados_card_content">
                  <div class="header">
                    <div class="flex flex-col gap-2 items-center justify-between">
                      <div class="relative flex gap-2 items-center justify-between">
                        <div class="max-w-[140px] z-[1]">
                          <h6 class="mx-auto">{{ product.categories[0].name }}</h6>
                        </div>
                        <span v-if="product.categories.length > 1" class="remaining-count">
                          +{{ product.categories.length - 1 }}
                        </span>
                      </div>
                    </div>
                    <h5 class="w-fit mx-auto">{{ product.title }}</h5>
                  </div>
                  <p>{{ product.short_description }}</p>
                  <div class="my-2 flex gap-2">
                    <BadgeHorarios :horarios="product.horarios || []" />
                    <!-- Badge de urgencias -->
                    <Badge v-if="product.urgencies" status="Urgencias"><span>Urgencias</span></Badge>
                  </div>
                </div>
              </a>
            </div>

            <!-- Footer -->
            <div class="footer mx-2 md:mx-4">
              <hr class="divider" />
              <div class="flex justify-between my-4">
                <button class="btn btn-secondary" @click="openModal('contact', product)">
                  Contactar
                </button>
                <button class="btn btn-secondary" @click="openModal('share', product)">
                  <ShareIcon class="fill-primary" />
                </button>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { ShareIcon } from '@heroicons/vue/24/outline'
import BadgeHorarios from '../BadgeHorarios.vue';
import Badge from '../Badge.vue';

export default {
  components: { ShareIcon, BadgeHorarios, Badge },

  props: {
    initialCategory: {
      type: String,
      default: null,
    },
  },

  data() {
    return {
      products: [],
      categories: [],
      loading: true,
      error: null,
      selectedCategory: this.initialCategory,
      isOpen: false,
      showUrgenciesOnly: false,
    }
  },

  computed: {
    selectedCategoryName() {
      const cat = this.categories.flatMap(g => g.categories).find(c => c.slug === this.selectedCategory)
      return cat ? cat.name : ''
    }
  },

  watch: {
    showUrgenciesOnly() {
      this.fetchProducts()
    }
  },

  mounted() {
    window.addEventListener('popstate', this.handlePopState)
    document.addEventListener('click', this.handleClickOutside)

    const urlParams = new URLSearchParams(window.location.search)
    const categoryFromUrl = urlParams.get('category')
    this.selectedCategory = categoryFromUrl || this.initialCategory

    this.fetchCategories()
    this.fetchProducts()
  },

  beforeUnmount() {
    window.removeEventListener('popstate', this.handlePopState)
    document.removeEventListener('click', this.handleClickOutside)
  },

  methods: {
    async fetchProducts() {
      this.loading = true

      // 💡 Siempre limpiar los parámetros
      const params = {}

      if (this.selectedCategory && this.selectedCategory.trim() !== '') {
        params.category = this.selectedCategory
      }

      if (this.showUrgenciesOnly) {
        params.urgencies = true
      }

      try {
        const response = await axios.get('/anunciantes', {
          params: this.selectedCategory ? { category: this.selectedCategory } : {},
          headers: { Accept: 'application/json' },
        })

        let products = response.data.products

        if (this.showUrgenciesOnly) {
          products = products.filter(p => p.urgencies)
        }

        this.products = products
        this.error = null
      } catch (error) {
        console.error('Error al cargar productos:', error)
        this.error = 'No se pudieron cargar los productos.'
      } finally {
        this.loading = false
      }
    },

    async fetchCategories() {
      try {
        const response = await axios.get('/categorias')
        this.categories = Object.entries(response.data.categories).map(([letter, categories]) => ({
          letter,
          categories,
        }))
      } catch (error) {
        console.error('Error al cargar categorías:', error)
      }
    },

    filterByCategory(slug) {
      this.selectedCategory = slug
      const url = new URL(window.location)
      if (slug) url.searchParams.set('category', slug)
      else url.searchParams.delete('category')
      window.history.pushState({}, '', url)
      this.fetchProducts()
    },

    selectCategory(category) {
      this.selectedCategory = category ? category.slug : null  // null = todas
      this.isOpen = false
      this.filterByCategory(this.selectedCategory)
    },

    toggleDropdown() {
      this.isOpen = !this.isOpen
    },

    handleClickOutside(event) {
      if (!this.$el.contains(event.target)) {
        this.isOpen = false
      }
    },

    handlePopState() {
      const urlParams = new URLSearchParams(window.location.search)
      this.selectedCategory = urlParams.get('category')
      this.fetchProducts()
    },

    openModal(type, product) {
      window.dispatchEvent(
        new CustomEvent('open-contact-modal', { detail: { type, product } })
      )
    },
    toggleUrgencies() {
      this.showUrgenciesOnly = !this.showUrgenciesOnly
      this.fetchProducts()
    },
  },
}
</script>

<style scoped>
.rotate-180 {
  transform: rotate(180deg);
  transition: transform 0.3s;
}

.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.2s ease;
}
.fade-slide-enter-from {
  opacity: 0;
  transform: translateY(-5px);
}
.fade-slide-enter-to {
  opacity: 1;
  transform: translateY(0);
}
.fade-slide-leave-from {
  opacity: 1;
  transform: translateY(0);
}
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-5px);
}
</style>
