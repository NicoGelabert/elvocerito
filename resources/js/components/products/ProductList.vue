<template>
  <div class="relative product-list">
    <!-- Loading y errores -->
    <div v-if="loading" class="spinner-overlay"><div class="spinner"></div></div>
    <div v-if="error" class="error">{{ error }}</div>

    <div class="container cards__section">
      <div class="w-full">
        <h3>{{ title }}</h3>
      </div>
      <!-- MOBILE: botón de apertura para mostrar en mobile -->
      <div class="hidden">
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
            class="bg-popup flex items-center justify-center"
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

              <div class="flex flex-wrap gap-8">
                <!-- Reviews -->
                <div>
                  <h5 class="text-gray_600 mb-4">Sólo con Reviews</h5>
                  <div class="flex items-center gap-2">
                    <button
                      @click="toggleHasReviews"
                      class="relative w-9 h-5 rounded-full transition-all duration-300"
                      :class="hasReviewsOnly ? 'bg-amber-300' : 'bg-gray-300'"
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

                <!-- Farmacia de Turno -->
                <div v-if="isFarmaciaSelected">
                  <h5 class="text-gray_600 mb-4">Farmacia de Turno</h5>
                  <div class="flex items-center gap-2">
                    <button
                      @click="toggleOnDuty"
                      class="relative w-9 h-5 rounded-full transition-all duration-300"
                      :class="showOnDutyOnly ? 'bg-cyan-400' : 'bg-gray-300'"
                    >
                      <span
                        class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full transition-all"
                        :class="showOnDutyOnly ? 'translate-x-4' : ''"
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
      <div class="flex items-center w-full relative gap-4 min-w-0">

        <!-- Dropdown fijo -->
        <div v-if="showCategoryFilter" class="flex-shrink-0 relative">
          <button
            @click="toggleDropdown"
            class="flex gap-4 text-sm text-gray-500 w-auto justify-between items-center px-4 py-2 bg-white border rounded-lg shadow-sm hover:shadow-md"
          >
            {{ selectedCategoryName || 'Selecciona una categoría' }}
            <span :class="{ 'rotate-180': isOpen }" class="text-gray-400 transition-transform">▼</span>
          </button>

          <transition name="fade-slide">
            <ul
              v-if="isOpen"
              class="absolute z-10 w-56 bg-white border mt-1 max-h-72 overflow-auto rounded-lg shadow-lg"
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

        <!-- Badges con scroll -->
         <div class="relative flex-1 min-w-0">
          <!-- Fade derecha -->
          <div class="pointer-events-none absolute right-0 top-0 h-full w-8 bg-gradient-to-l from-gray_50 to-transparent z-10"></div>
          <div class="flex flex-nowrap gap-4 overflow-x-auto py-1 scrollbar-none">

          <!-- Badge botón categoría, no dropdown -->
          <!-- <button
            class="flex-shrink-0 flex items-center justify-center px-2 py-1 rounded-md leading-none font-semibold transition-all shadow-sm border border-gray-300 bg-gray-200 text-gray-70 w-fit"
            @click="selectCategory(null)"
            v-if="selectedCategoryName && showCategoryFilter"
          >
            <h1 class="text-xs leading-none">Categoría {{ selectedCategoryName }}</h1>
            <span class="text-xs font-light ml-1">x</span>
          </button> -->

          <!-- Badge botón filtrado por reviews -->
          <button
            class="flex-shrink-0 items-center justify-center px-2 py-1 rounded-md text-xs leading-none font-semibold transition-all shadow-sm border border-gray-300 text-gray-700 w-fit"
            @click="toggleHasReviews"
            :class="hasReviewsOnly ? 'bg-gray-200' : 'bg-transparent'"
          >
            Con Reseñas <span class="font-light ml-1" :class="hasReviewsOnly ? 'inline' : 'hidden'">x</span>
          </button>

          <!-- Badge botón filtrado por urgencias -->
          <button
            class="flex-shrink-0 items-center justify-center px-2 py-1 rounded-md text-xs leading-none font-semibold transition-all shadow-sm border border-gray-300 text-gray-700 w-fit"
            @click="toggleUrgencies"
            :class="showUrgenciesOnly ? 'bg-gray-200' : 'bg-transparent'"
          >
            Disponible 24hs <span class="font-light ml-1" :class="showUrgenciesOnly ? 'inline' : 'hidden'">x</span>
          </button>

          <!-- Badge botón filtrado por antigüedad -->
          <button
            class="flex-shrink-0 items-center justify-center px-2 py-1 rounded-md text-xs leading-none font-semibold transition-all shadow-sm border border-gray-300 text-gray-700 w-fit"
            @click="toggleSortOrder"
            :class="sortOrder === 'oldest' ? 'bg-gray-200' : 'bg-transparent'"
          >
            Más antiguos <span class="font-light ml-1" :class="sortOrder === 'oldest' ? 'inline' : 'hidden'">x</span>
          </button>

          <!-- Badge botón filtrado por farmacias de turno (solo si Farmacias) -->
          <button
            class="flex-shrink-0 items-center justify-center px-2 py-1 rounded-md text-xs leading-none font-semibold transition-all shadow-sm border border-gray-300 text-gray-700 w-fit"
            @click="toggleOnDuty"
            v-if="isFarmaciaSelected"
            :class="showOnDutyOnly ? 'bg-gray-200' : 'bg-transparent'"
          >
            Hoy de Turno <span class="font-light ml-1" :class="showOnDutyOnly ? 'inline' : 'hidden'">x</span>
          </button>

          </div>
        </div>
      </div>

      <!-- Listado -->
      <div :class="['cards__list', { 'loading-opacity': loading }]">
        <ul class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <li v-for="product in products.data" :key="product.id">
            <div class="card__body">
              <div class="card__content">
                  <div class="card__left">
                      <img class="card__img__rounded" :src="product.image_url" alt="product.title">
                  </div>
                  <div class="card__right">
                      <div class="card__info" v-if="product.categories?.length">
                          <h6>{{ product.categories[0].name }}</h6>
                          <Badge status="Disponible">
                            <span>Desde {{ formatYear(product.created_at) }}</span>
                          </Badge>
                          <h5>{{ product.title }}</h5>
                          <p class="description">{{ product.short_description }}</p>
                      </div>
                      <div class="card__meta">
                          <div class="card__rating">
                              <RatingAverage :product-id="product.id" />
                          </div>
                          <Badge v-if="product.urgencies" status="Urgencias">
                            <UrgenciesIcon />
                            <span>Disponible 24hs</span>
                          </Badge>
                          <Badge v-if="product.is_on_duty_now" status="De Turno">
                            <span>Hoy de turno</span>
                          </Badge>
                      </div>
                  </div>
              </div>
              <hr class="divider my-2 w-full">
              <div class="card__footer card__footer--between">
                  <a :href="product.categories.length ? '/' + product.categories[0].slug + '/' + product.slug : '/' + product.slug" class="btn btn-secondary">
                    Ver servicio
                  </a>
                  <button class="btn btn-primary" @click="openModal('contact', product)">
                    Contactar
                  </button>
              </div>
          </div>
          </li>
        </ul>
        <div v-if="!loading && products.data && products.data.length === 0" class="w-full text-center py-12 text-gray-400">
          No se han encontrado resultados.
        </div>
      </div>

      <!-- Paginación -->
      <div v-if="showPagination && products && products.links && products.links.length > 3" class="pagination flex flex-wrap gap-2 mt-8 justify-center">
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
import UrgenciesIcon from "@/icons/UrgenciesIcon.vue"

export default {
  components: { ShareIcon, BadgeHorarios, Badge, FilterIcon, RatingAverage, UrgenciesIcon },

  props: {
    initialCategory: {
      type: String,
      default: null,
    },
    baseUrl: {
      type: String,
      default: null,
    },
    showCategoryFilter: {
      type: Boolean,
      default: true,
    },
    showPagination: {
      type: Boolean,
      default: true,
    },
    title: {
      type: String,
      default: '¿Qué necesitás hacer?',
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
      showOnDutyOnly: false,
      sortOrder: 'newest',
    }
  },

  computed: {
    selectedCategoryName() {
      const cat = this.categories.flatMap(g => g.categories).find(c => c.slug === this.selectedCategory)
      return cat ? cat.name : ""
    },
    isFarmaciaSelected() {
      const cat = this.categories.flatMap(g => g.categories).find(c => c.slug === this.selectedCategory)
      return cat?.name?.toLowerCase() === 'farmacias'
    },
  },

  mounted() {
    const urlParams = new URLSearchParams(window.location.search);
    this.selectedCategory = urlParams.get("category") || this.initialCategory;
    this.showUrgenciesOnly = urlParams.get("urgencies") === "true";
    this.hasReviewsOnly = urlParams.get("has_reviews") === "true";
    this.showOnDutyOnly = urlParams.get("on_duty") === "true";
    this.sortOrder = urlParams.get("sort") || 'newest';
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
        on_duty: this.showOnDutyOnly || undefined,
        sort: this.sortOrder || undefined,
      }

      try {
        const response = await axios.get("/anunciantes", {
          params,
          headers: { Accept: "application/json" },
        })

        this.products = response.data.products
        this.error = null

        // Actualizar URL
        const url = new URL(this.baseUrl || window.location.href);
        url.searchParams.set("page", this.products.current_page);

        // Solo agrega ?category si NO hay baseUrl
        if (!this.baseUrl) {
          if (this.selectedCategory) {
            url.searchParams.set("category", this.selectedCategory);
          } else {
            url.searchParams.delete("category");
          }
        }

        if (this.showUrgenciesOnly) {
          url.searchParams.set("urgencies", "true");
        } else {
          url.searchParams.delete("urgencies");
        }

        if (this.hasReviewsOnly) {
          url.searchParams.set("has_reviews", "true");
        } else {
          url.searchParams.delete("has_reviews");
        }

        if (this.showOnDutyOnly) {
          url.searchParams.set("on_duty", "true");
        } else {
          url.searchParams.delete("on_duty");
        }

        if (this.showPagination) {
          url.searchParams.set("page", this.products.current_page);
        } else {
          url.searchParams.delete("page");
        }

        if (this.sortOrder && this.sortOrder !== 'newest') {
          url.searchParams.set("sort", this.sortOrder);
        } else {
          url.searchParams.delete("sort");
        }

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
      if (this.showOnDutyOnly) this.showOnDutyOnly = false
      this.products.data = []
      this.isOpen = false
      this.fetchProducts(1)
    },

    toggleDropdown() {
      this.isOpen = !this.isOpen
    },

    toggleUrgencies() {
      this.showUrgenciesOnly = !this.showUrgenciesOnly
      this.fetchProducts(1)
    },

    toggleHasReviews() {
      this.hasReviewsOnly = !this.hasReviewsOnly
      this.fetchProducts(1)
    },

    toggleSortOrder() {
      this.sortOrder = this.sortOrder === 'oldest' ? 'newest' : 'oldest'
      this.fetchProducts(1)
    },

    toggleOnDuty() {
      this.showOnDutyOnly = !this.showOnDutyOnly
      this.fetchProducts(1)
    },

    toggleMobileFilters() {
      this.showMobileFilters = !this.showMobileFilters
    },

    openModal(type, product) {
      window.dispatchEvent(new CustomEvent("open-contact-modal", { detail: { type, product } }))
    },

    formatYear(date) {
      if (!date) return ''
      const d = new Date(date)
      return d.getFullYear()
    }
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
.scrollbar-none {
  scrollbar-width: none;
}
.scrollbar-none::-webkit-scrollbar {
  display: none;
}
</style>