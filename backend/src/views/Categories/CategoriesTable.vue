<template>
  <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
      <div class="flex flex-col md:flex-row justify-between border-b-2 pb-3 gap-4">
      <div class="flex flex-col md:flex-row gap-4 md:items-center">
          <span class="whitespace-nowrap mr-3">Per Page</span>
          <select @change="getCategories(null)" v-model="perPage"
                  class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="50">50</option>
          <option value="100">100</option>
          </select>
          <span class="ml-3">Found {{categories.total}} categories</span>
      </div>
      <div>
          <input v-model="search" @change="getCategories(null)"
              class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Type to Search categories">
      </div>
      </div>

      <table class="table-auto w-full">
      <thead class="hidden md:contents">
      <tr>
          <TableHeaderCell field="id" :sort-field="sortField" :sort-direction="sortDirection" @click="sortCategories('id')">
          ID
          </TableHeaderCell>
          <TableHeaderCell field="image" :sort-field="sortField" :sort-direction="sortDirection">
          Image
          </TableHeaderCell>
          <TableHeaderCell field="name" :sort-field="sortField" :sort-direction="sortDirection"
                          @click="sortCategories('name')">
          Name
          </TableHeaderCell>
          
          <TableHeaderCell field="parent_id" :sort-field="sortField" :sort-direction="sortDirection"
                          @click="sortCategories('parent_id')">
          Parent ID
          </TableHeaderCell>
          <TableHeaderCell field="updated_at" :sort-field="sortField" :sort-direction="sortDirection"
                          @click="sortCategories('updated_at')">
          Last Updated At
          </TableHeaderCell>
          <TableHeaderCell field="actions">
          Actions
          </TableHeaderCell>
      </tr>
      </thead>
      <tbody v-if="categories.loading || !categories.data.length">
      <tr>
          <td colspan="6">
          <Spinner v-if="categories.loading"/>
          <p v-else class="text-center py-8 text-gray-700">
              There are no categories
          </p>
          </td>
      </tr>
      </tbody>
      <tbody v-else>
      <tr v-for="(category, index) of categories.data" :key="index">
          <td class="border-b p-2 ">{{ category.id }}</td>
          <td class="border-b p-2 md:p-2 hidden md:table-cell">
          <img class="w-16 h-16 object-cover" :src="category.image_url" :alt="category.name">
          </td>
          <td class="border-b p-2">
             <div class="truncate overflow-hidden text-ellipsis whitespace-nowrap w-[100px]">
             {{ category.name }}
             </div>
          </td>
          <td class="border-b p-2 hidden hidden md:table-cell">
          {{ category.parent_id }}
          </td>
          <td class="border-b p-2 hidden hidden md:table-cell">
          {{ category.updated_at }}
          </td>
          <td class="border-b p-2 ">
            <ActionMenu
               :editType="'router-link'"
               :editTo="{ name: 'app.categories.edit', params: { id: category.id } }"
               :remove="() => deleteCategory(category)"
             />
          </td>
      </tr>
      </tbody>
      </table>

      <div v-if="!categories.loading" class="flex justify-between items-center mt-5">
      <div v-if="categories.data.length">
          Showing from {{ categories.from }} to {{ categories.to }}
      </div>
      <nav
          v-if="categories.total > categories.limit"
          class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
          aria-label="Pagination"
      >
          <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
          <a
          v-for="(link, i) of categories.links"
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
              i === categories.links.length - 1 ? 'rounded-r-md' : '',
              !link.url ? ' bg-gray-100 text-gray-700': ''
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
import {CATEGORIES_PER_PAGE} from "../../constants";
import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {EllipsisVerticalIcon, PencilSquareIcon, TrashIcon} from '@heroicons/vue/24/solid';
import CategoryModal from "./CategoryModal.vue";
import ActionMenu from "../../components/core/ActionMenu.vue";

const perPage = ref(CATEGORIES_PER_PAGE);
const search = ref('');
const categories = computed(() => store.state.categories);
const sortField = ref('updated_at');
const sortDirection = ref('desc')
const category = ref({})
const showCategoryModal = ref(false);
const emit = defineEmits(['clickEdit'])
onMounted(() => {
getCategories();
})
function getForPage(ev, link) {
ev.preventDefault();
if (!link.url || link.active) {
  return;
}
getCategories(link.url)
}
function getCategories(url = null) {
store.dispatch("getCategories", {
  url,
  search: search.value,
  per_page: perPage.value,
  sort_field: sortField.value,
  sort_direction: sortDirection.value
});
}
function sortCategories(field) {
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
    getCategories()
}
function showAddNewModal() {
showCategoryModal.value = true
}
function deleteCategory(category) {
if (!confirm(`Are you sure you want to delete the category?`)) {
  return
}
store.dispatch('deleteCategory', category.id)
  .then(res => {
    // TODO Show notification
    store.dispatch('getCategories')
  })
}
function editCategory(p) {
emit('clickEdit', p)
}
</script>

<style>
</style>