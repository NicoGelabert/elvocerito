<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
      <div class="flex flex-col md:flex-row justify-between border-b-2 pb-3 gap-4">
        <div class="flex md:items-center flex-col md:flex-row gap-4">
          <span class="whitespace-nowrap mr-3">Per Page</span>
          <select @change="getReviews(null)" v-model="perPage"
                  class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
          <span class="ml-3">Found {{ reviews.total }} reviews</span>
        </div>
        <div>
          <input v-model="search" @change="getReviews(null)"
                 class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                 placeholder="Type to Search reviews">
        </div>
      </div>
  
      <table class="table-auto w-full">
        <thead class="hidden md:contents">
        <tr>
            <TableHeaderCell field="product_title" :sort-field="sortField" :sort-direction="sortDirection" @click="sortReviews('product_title')">
                Anunciante
            </TableHeaderCell>
            <TableHeaderCell field="rating" :sort-field="sortField" :sort-direction="sortDirection" @click="sortReviews('rating')">
                Rating
            </TableHeaderCell>
            <TableHeaderCell field="title" :sort-field="sortField" :sort-direction="sortDirection"
                @click="sortReviews('title')">
                Título
            </TableHeaderCell>
            <TableHeaderCell field="published" :sort-field="sortField" :sort-direction="sortDirection" @click="sortReviews('published')">
                Publicado
            </TableHeaderCell>
            <TableHeaderCell field="updated_at" :sort-field="sortField" :sort-direction="sortDirection"
                            @click="sortReviews('updated_at')">
                Última actualización
            </TableHeaderCell>
            <TableHeaderCell field="actions">
                Actions
            </TableHeaderCell>
        </tr>
        </thead>
        <tbody v-if="reviews.loading || !reviews.data.length">
        <tr>
          <td colspan="8">
            <Spinner v-if="reviews.loading"/>
            <p v-else class="text-center py-8 text-gray-700">
              There are no reviews
            </p>
          </td>
        </tr>
        </tbody>
        <tbody v-else>
        <tr v-for="(review, index) of reviews.data" :key="index">
          <td class="border-b p-2">{{ review.product_title }}</td>
          <td class="border-b p-2">{{ review.rating }}</td>
          <td class="border-b p-2">
             <div class="truncate overflow-hidden text-ellipsis whitespace-nowrap w-[100px]">
               {{ review.title }}
             </div>
          </td>
          <td class="border-b p-2">
            <span
                v-if="review.published"
                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full text-green-700"></span>
                <span class="text-xs text-gray-500">Publicado</span>
            </span>
            <span
                v-else
                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                <span class="w-2 h-2 mr-2 bg-red-500 rounded-full text-red-700"></span>
                <span class="text-xs text-gray-500">Sin Publicar</span>
            </span>
          </td>

          <td class="border-b p-2 hidden md:table-cell">
            {{ review.updated_at }}
          </td>
          <td class="border-b p-2 ">
            <ActionMenu
               :editType="'router-link'"
               :editTo="{ name: 'app.reviews.edit', params: { id: review.id } }"
               :remove="() => deleteReview(review)"
             />
          </td>
        </tr>
        </tbody>
      </table>
  
      <div v-if="!reviews.loading" class="flex flex-col md:flex-row gap-4 justify-between items-center mt-5">
        <div v-if="reviews.data.length">
          Showing from {{ reviews.from }} to {{ reviews.to }}
        </div>
        <nav
          v-if="reviews.total > reviews.limit"
          class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
          aria-label="Pagination"
        >
          <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
          <a
            v-for="(link, i) of reviews.links"
            :key="i"
            :disabled="!link.url"
            href="#"
            @click="getForPage($event, link)"
            aria-current="page"
            class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
            :class="[
                link.active
                  ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                  : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                i === 0 ? 'rounded-l-md' : '',
                i === reviews.links.length - 1 ? 'rounded-r-md' : '',
                !link.url ? ' bg-gray-100 text-gray-700': '',
                 (link.label.includes('Previous') || link.label.includes('Next')) ? 'hidden md:inline' : ''
              ]"
            v-html="link.label"
          >
          </a>
        </nav>
      </div>
    </div>
  </template>
  
  <script setup>
  import {computed, onMounted, ref} from "vue";
  import store from "../../store";
  import Spinner from "../../components/core/Spinner.vue";
  import {REVIEWS_PER_PAGE} from "../../constants";
  import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";
  import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
  import {EllipsisVerticalIcon, PencilSquareIcon, TrashIcon} from '@heroicons/vue/24/solid';
  import ActionMenu from "../../components/core/ActionMenu.vue";
  
  const perPage = ref(REVIEWS_PER_PAGE);
  const search = ref('');
  const reviews = computed(() => store.state.reviews);
  const sortField = ref('updated_at');
  const sortDirection = ref('desc')
  
  const review = ref({})
  
  onMounted(() => {
    getReviews();
  })
  
  function getForPage(ev, link) {
    ev.preventDefault();
    if (!link.url || link.active) {
      return;
    }
  
    getReviews(link.url)
  }
  
  function getReviews(url = null) {
    store.dispatch("getReviews", {
      url,
      search: search.value,
      per_page: perPage.value,
      sort_field: sortField.value,
      sort_direction: sortDirection.value
    });
  }
  
  function sortReviews(field) {
    if (field === sortField.value) {
      if (sortDirection.value === 'desc') {
        sortDirection.value = 'asc'
      } else {
        sortDirection.value = 'desc'
      }
    } else {
      sortField.value = field;
      sortDirection.value = 'asc'
    }
  
    getReviews()
  }
  
  function deleteReview(review) {
    if (!confirm(`Are you sure you want to delete the review?`)) {
      return
    }
    store.dispatch('deleteReview', review.id)
      .then(res => {
        store.commit('showToast', 'Review was successfully deleted');
        store.dispatch('getReviews')
      })
  }
  
  </script>
  