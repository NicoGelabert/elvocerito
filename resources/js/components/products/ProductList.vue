<template>
  <div class="relative product-list">
    <!-- Loading y errores -->
    <div v-if="loading" class="spinner-overlay"><div class="spinner"></div></div>
    <div v-if="error" class="error">{{ error }}</div>

    <div class="container flex flex-col gap-4 anunciantes_destacados">
      <!-- Encabezado -->
      <h4 class="hidden md:block">Filtrar</h4>
      <hr class="divider-product_list hidden md:block" />

      <!-- MOBILE: botón de apertura -->
      <div class="block md:hidden">
        <button
          @click="toggleMobileFilters"
          class="flex items-center gap-2 px-4 py-2 text-sm font-medium bg-white border border-gray-300 rounded-lg shadow-sm hover:shadow-md transition-all duration-200"
        >
          <FilterIcon class="w-4 h-4 text-gray-600 fill-black" />
          <span>Filtrar</span>
        </button>

        <!-- Overlay flotante -->
        <transition name="fade-slide">
          <div
            v-if="showMobileFilters"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
          >
            <div class="bg-white w-11/12 max-w-md mx-auto p-6 rounded-2xl shadow-xl relative">
              <button
                @click="toggleMobileFilters"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600"
              >
                ✕
              </button>

              <h4 class="text-lg font-semibold mb-4">Filtros</h4>
              <hr class="mb-4" />

              <!-- Categoría -->
              <div class="mb-6">
                <h5 class="text-gray_600 mb-2">Categoría</h5>
                <button
                  @click="toggleDropdown"
                  class="flex gap-4 text-xs text-gray-500 w-full justify-between items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm hover:shadow-md transition-all duration-200"
                >
                  {{ selectedCategoryName || 'Selecciona una categoría' }}
                  <span :class="{ 'rotate-180': isOpen }" class="text-gray-400 transition-transform duration-300">▼</span>
                </button>

                <transition name="fade-slide">
                  <ul
                    v-if="isOpen"
                    class="absolute z-50 w-[calc(100%-3rem)] bg-white border border-gray-200 mt-1 max-h-72 overflow-auto rounded-lg shadow-lg"
                  >
                    <li>
                      <button
                        @click="selectCategory(null)"
                        class="w-full text-left px-4 py-2 hover:bg-blue-50 rounded"
                        :class="{ 'bg-blue-100 font-semibold': selectedCategory === null }"
                      >
                        Todas
                      </button>
                    </li>

                    <template v-for="group in categories" :key="group.letter">
                      <li class="px-4 py-1 mt-3 mb-1 text-gray-400 font-bold border-b">{{ group.letter }}</li>

                      <li v-for="category in group.categories" :key="category.id">
                        <button
                          @click="selectCategory(category)"
                          class="w-full text-left px-4 py-2 hover:bg-blue-50 rounded"
                          :class="{ 'bg-blue-100 font-semibold': selectedCategory === category.slug }"
                        >
                          {{ category.name }}
                        </button>
                      </li>
                    </template>
                  </ul>
                </transition>
              </div>

              <div class="flex gap-8">
                <!-- Reviews -->
                <div>
                  <h5 class="text-gray_600 mb-4">Sólo con Reviews</h5>
                  <div class="flex items-center gap-2">
                    <button
                      @click="toggleHasReviews"
                      class="relative w-9 h-5 rounded-full transition-all duration-300"
                      :class="hasReviewsOnly ? 'bg-yellow-500' : 'bg-gray-300'"
                    >
                      <span
                        class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full transition-all"
                        :class="hasReviewsOnly ? 'translate-x-4' : ''"
                      ></span>
                    </button>
                  </div>
                </div>
  
                <!-- Urgencias -->
                <div>
                  <h5 class="text-gray_600 mb-4">Urgencias</h5>
                  <div class="flex items-center gap-2">
                    <button
                      @click="toggleUrgencies"
                      class="relative w-9 h-5 rounded-full transition-all duration-300"
                      :class="showUrgenciesOnly ? 'bg-red-500' : 'bg-gray-300'"
                    >
                      <span
                        class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full transition-all"
                        :class="showUrgenciesOnly ? 'translate-x-4' : ''"
                      ></span>
                    </button>
                  </div>
                </div>
              </div>

              <div class="mt-6 text-right">
                <button
                  @click="toggleMobileFilters"
                  class="px-5 py-2 bg-primary text-white rounded-lg shadow"
                >
                  Aplicar filtros
                </button>
              </div>
            </div>
          </div>
        </transition>
      </div>

      <!-- DESKTOP / TABLET -->
      <div class="hidden md:flex w-full relative gap-8">
        <div>
          <h5 class="text-gray_600 mb-2">Categoría</h5>
          <button
            @click="toggleDropdown"
            class="flex gap-4 text-xs text-gray-500 w-auto justify-between items-center px-4 py-2 bg-white border rounded-lg shadow-sm hover:shadow-md"
          >
            {{ selectedCategoryName || 'Selecciona una categoría' }}
            <span :class="{ 'rotate-180': isOpen }" class="text-gray-400 transition-transform">▼</span>
          </button>

          <transition name="fade-slide">
            <ul
              v-if="isOpen"
              class="absolute z-10 w-full bg-white border mt-1 max-h-72 overflow-auto rounded-lg shadow-lg"
            >
              <li>
                <button
                  @click="selectCategory(null)"
                  class="w-full text-left px-4 py-2 hover:bg-blue-50 rounded"
                  :class="{ 'bg-blue-100 font-semibold': selectedCategory === null }"
                >
                  Todas
                </button>
              </li>

              <template v-for="group in categories" :key="group.letter">
                <li class="px-4 py-1 mt-3 mb-1 text-gray-400 font-bold border-b">
                  {{ group.letter }}
                </li>
                <li v-for="category in group.categories" :key="category.id">
                  <button
                    @click="selectCategory(category)"
                    class="w-full text-left px-4 py-2 hover:bg-blue-50 rounded"
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
          <h5 class="text-gray_600 mb-4">Sólo con Reviews</h5>
          <div class="flex items-center gap-2">
            <button
              @click="toggleHasReviews"
              class="relative w-7 h-4 rounded-full transition-all"
              :class="hasReviewsOnly ? 'bg-yellow-500' : 'bg-gray-300'"
            >
              <span
                class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-all"
                :class="hasReviewsOnly ? 'translate-x-3' : ''"
              ></span>
            </button>
          </div>
        </div>

        <div>
          <h5 class="text-gray_600 mb-4">Urgencias</h5>
          <div class="flex items-center gap-2">
            <button
              @click="toggleUrgencies"
              class="relative w-7 h-4 rounded-full transition-all"
              :class="showUrgenciesOnly ? 'bg-red-500' : 'bg-gray-300'"
            >
              <span
                class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-all"
                :class="showUrgenciesOnly ? 'translate-x-3' : ''"
              ></span>
            </button>
          </div>
        </div>

      </div>

      <!-- Listado -->
      <div :class="['anunciantes_destacados_card', { 'loading-opacity': loading }]">
        <ul>
          <li v-for="product in products.data" :key="product.id">
            <div class="card_body">
              <a
                :href="product.categories.length ? '/' + product.categories[0].slug + '/' + product.slug : '/' + product.slug"
                class="aspect-w-3 aspect-h-2 block overflow-hidden relative"
              >
              <div class="w-full flex justify-end">
                <span class="text-text_small text-gray-500">{{product.client_number}}</span>

              </div>
                <img :src="product.image_url" alt="" />
                <div v-if="product.categories?.length" class="anunciantes_destacados_card_content">
                  <div class="header">
                    
                    <div class="relative flex gap-2 items-center justify-center w-full">
                      
                      <div class="relative w-full md:w-auto">
                        <h6 class="z-[1] relative">{{ product.categories[0].name }}</h6>
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
                    <Badge v-if="product.urgencies" status="Urgencias"><span>Urgencias</span></Badge>
                  </div>
                  <RatingAverage :product-id="product.id" />
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

      <!-- Paginación -->
      <div v-if="products && products.links" class="pagination flex flex-wrap gap-2 mt-8 justify-center">
        <button
          v-for="(link, index) in products.links"
          :key="index"
          :disabled="!link.url"
          v-html="link.label"
          @click="goToLink(link)"
          class="px-3 py-1 border rounded text-sm"
          :class="{
            'bg-primary text-white font-bold': link.active,
            'opacity-50 cursor-not-allowed': !link.url
          }"
        ></button>
      </div>

    </div>
  </div>
</template>


<script>
import axios from "axios"
import { ShareIcon } from "@heroicons/vue/24/outline"
import FilterIcon from "@/icons/FilterIcon.vue"
import BadgeHorarios from "../BadgeHorarios.vue"
import Badge from "../Badge.vue"
import RatingAverage from "../reviews/RatingAverage.vue"

export default {
  components: { ShareIcon, BadgeHorarios, Badge, FilterIcon, RatingAverage },

  props: {
    initialCategory: {
      type: String,
      default: null,
    },
  },

  data() {
    return {
      products: { data: [] },
      categories: [],
      loading: true,
      error: null,
      selectedCategory: this.initialCategory,
      isOpen: false,
      showUrgenciesOnly: false,
      showMobileFilters: false,
      hasReviewsOnly: false,
    }
  },

  computed: {
    selectedCategoryName() {
      const cat = this.categories.flatMap(g => g.categories).find(c => c.slug === this.selectedCategory)
      return cat ? cat.name : ""
    },
  },

  mounted() {
    const urlParams = new URLSearchParams(window.location.search);
    this.selectedCategory = urlParams.get("category") || this.initialCategory;
    this.showUrgenciesOnly = urlParams.get("urgencies") === "true";
    this.hasReviewsOnly = urlParams.get("has_reviews") === "true";
    this.fetchCategories()
    this.fetchProducts()
  },

  methods: {
    async fetchProducts(page = 1) {
      this.loading = true

      const params = {
        page,
        category: this.selectedCategory || undefined,
        urgencies: this.showUrgenciesOnly || undefined,
        has_reviews: this.hasReviewsOnly || undefined,
      }

      try {
        const response = await axios.get("/anunciantes", {
          params,
          headers: { Accept: "application/json" },
        })

        this.products = response.data.products

        this.error = null

        // Actualizar URL
        const url = new URL(window.location);
        // Actualizar el número de página
        url.searchParams.set("page", this.products.current_page);
        // Filtro por categoría
        if (this.selectedCategory) {
          url.searchParams.set("category", this.selectedCategory);
        } else {
          url.searchParams.delete("category");
        }
        // Filtro por urgencias
        if (this.showUrgenciesOnly) {
          url.searchParams.set("urgencies", "true");
        } else {
          url.searchParams.delete("urgencies");
        }
        // Filtro por reviews
        if (this.hasReviewsOnly) {
          url.searchParams.set("has_reviews", "true");
        } else {
          url.searchParams.delete("has_reviews");
        }
        // Actualizar la URL sin recargar la página
        window.history.pushState({}, "", url);

      } catch (err) {
        this.error = "No se pudieron cargar los productos."
      } finally {
        this.loading = false
      }
    },

    async goToLink(link) {
      if (!link.url) return

      const urlObj = new URL(link.url)
      const page = urlObj.searchParams.get("page") || 1

      this.fetchProducts(page)
    },

    async fetchCategories() {
      try {
        const response = await axios.get("/categorias")
        this.categories = Object.entries(response.data.categories).map(([letter, categories]) => ({
          letter,
          categories,
        }))
      } catch {}
    },

    selectCategory(category) {
      this.selectedCategory = category ? category.slug : null
      this.isOpen = false
      this.fetchProducts(1)
    },

    toggleDropdown() {
      this.isOpen = !this.isOpen
    },

    // Toggle de urgencies
    toggleUrgencies() {
      this.showUrgenciesOnly = !this.showUrgenciesOnly
      this.fetchProducts(1)
    },

    // Toggle de Reviews
    toggleHasReviews() {
      this.hasReviewsOnly = !this.hasReviewsOnly;
      this.fetchProducts(1);
    },

    toggleMobileFilters() {
      this.showMobileFilters = !this.showMobileFilters
    },

    openModal(type, product) {
      window.dispatchEvent(new CustomEvent("open-contact-modal", { detail: { type, product } }))
    },
  },
}
</script>

<style scoped>
.rotate-180 {
  transform: rotate(180deg);
}

.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.25s ease;
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
