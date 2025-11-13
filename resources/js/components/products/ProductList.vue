<template>
  <div class="relative product-list">
    <!-- Loading y errores -->
    <div v-if="loading" class="spinner-overlay"><div class="spinner"></div></div>
    <div v-if="error" class="error">{{ error }}</div>

    <div class="container flex flex-col lg:flex-row gap-4 anunciantes_destacados">
      <!-- Filtros -->
      <aside class="w-full lg:w-1/5 flex flex-col gap-4">
        <h4>Filtrar</h4>
        <hr class="divider-product_list" />
        <h5 class="text-gray_600">Categoría</h5>
        <ul class="flex flex-col gap-2 scroll-container overflow-auto">
          <template v-for="group in categories" :key="group.letter">
            <li class="mt-4 mb-1 text-gray-500 font-bold border-b border-gray-300 pb-1">{{ group.letter }}</li>
            <li
              v-for="category in group.categories"
              :key="category.id"
              :class="{ 'active-category': selectedCategory === category.slug }"
            >
              <button @click="filterByCategory(category.slug)" class="btn-products_list">
                {{ category.name }}
              </button>
            </li>
          </template>
        </ul>
      </aside>

      <!-- Listado de productos -->
      <div :class="{ 'loading-opacity': loading }" class="anunciantes_destacados_card bg-yellow-500">
        <ul>
          <li v-for="product in products" :key="product.id">
            <div class="card_body">
              <a
                :href="'/' + product.categories[0]?.slug + '/' + product.slug"
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
                  <div class="my-2">
                    <BadgeHorarios :horarios="product.horarios" />
                  </div>

                </div>
              </a>
            </div>

            <!-- Footer -->
            <div class="footer mx-2 md:mx-4">
              <hr class="divider" />
              <div class="flex justify-between my-4">
                <!-- Contactar -->
                <button
                  class="btn btn-secondary"
                  @click="openModal('contact', product)"
                >
                  Contactar
                </button>

                <!-- Compartir -->
                <button
                  class="btn btn-secondary"
                  @click="openModal('share', product)"
                >
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

export default {
  components: { 
    ShareIcon,
    BadgeHorarios,
},

  props: {
    initialCategory: {
      type: [String, null],
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
    }
  },

  mounted() {
    window.addEventListener('popstate', this.handlePopState)
    const urlParams = new URLSearchParams(window.location.search)
    const categoryFromUrl = urlParams.get('category')

    this.selectedCategory = categoryFromUrl || this.initialCategory
    this.fetchCategories()
    this.fetchProducts()
  },

  beforeUnmount() {
    window.removeEventListener('popstate', this.handlePopState)
  },

  methods: {
    async fetchProducts() {
      this.loading = true
      const categorySlug = this.selectedCategory || ''

      try {
        const response = await axios.get('/anunciantes', {
          params: { category: categorySlug },
          headers: { Accept: 'application/json' },
        })
        this.products = response.data.products
        console.log('Productos cargados:', this.products)
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
      if (slug) {
        url.searchParams.set('category', slug)
      } else {
        url.searchParams.delete('category')
      }
      window.history.pushState({}, '', url)
      this.fetchProducts()
    },

    handlePopState() {
      const urlParams = new URLSearchParams(window.location.search)
      const categoryFromUrl = urlParams.get('category')
      this.selectedCategory = categoryFromUrl
      this.fetchProducts()
    },

    // 👇 Aquí enviamos el producto completo
    openModal(type, product) {
      window.dispatchEvent(
        new CustomEvent('open-contact-modal', {
          detail: { type, product },
        })
      )
    },
  },
}
</script>
