<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <div class="flex justify-between border-b-2 pb-3">
        <div class="flex items-center">
            <span class="whitespace-nowrap mr-3">Per Page</span>
            <select @change="getAuthors(null)" v-model="perPage"
                    class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
            </select>
            <span class="ml-3">Found {{authors.total}} authors</span>
        </div>
        <div>
            <input v-model="search" @change="getAuthors(null)"
                class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                placeholder="Type to Search authors">
        </div>
        </div>
  
        <table class="table-auto w-full">
        <thead>
        <tr>
            <TableHeaderCell field="id" :sort-field="sortField" :sort-direction="sortDirection" @click="sortAuthors('id')">
            ID
            </TableHeaderCell>
            <TableHeaderCell field="image" :sort-field="sortField" :sort-direction="sortDirection">
            Image
            </TableHeaderCell>
            <TableHeaderCell field="name" :sort-field="sortField" :sort-direction="sortDirection"
                            @click="sortAuthors('name')">
            Name
            </TableHeaderCell>
            <TableHeaderCell field="updated_at" :sort-field="sortField" :sort-direction="sortDirection"
                            @click="sortAuthors('updated_at')">
            Last Updated At
            </TableHeaderCell>
            <TableHeaderCell field="actions">
            Actions
            </TableHeaderCell>
        </tr>
        </thead>
        <tbody v-if="authors.loading || !authors.data.length">
        <tr>
            <td colspan="6">
            <Spinner v-if="authors.loading"/>
            <p v-else class="text-center py-8 text-gray-700">
                There are no authors
            </p>
            </td>
        </tr>
        </tbody>
        <tbody v-else>
        <tr v-for="(author, index) of authors.data" :key="index">
            <td class="border-b p-2 ">{{ author.id }}</td>
            <td class="border-b p-2 ">
            <img class="w-16 h-16 object-cover" :src="author.image_url" :alt="author.name">
            </td>
            <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
            {{ author.name }}
            </td>
            <td class="border-b p-2 ">
            {{ author.updated_at }}
            </td>
            <td class="border-b p-2 ">
            <Menu as="div" class="relative inline-block text-left">
                <div>
                <MenuButton
                    class="inline-flex items-center justify-center w-full justify-center rounded-full w-10 h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                >
                    <EllipsisVerticalIcon
                    class="h-5 w-5 text-black"
                    aria-hidden="true"/>
                </MenuButton>
                </div>
  
                <transition
                enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
                >
                <MenuItems
                    class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                    <div class="px-1 py-1">
                      <MenuItem v-slot="{ active }">
                        <router-link
                          :to="{name: 'app.authors.edit', params: {id: author.id}}"
                          :class="[
                            active ? 'bg-gray-200 text-black' : 'text-gray-900',
                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                          ]"
                        >
                          <PencilSquareIcon
                            :active="active"
                            class="mr-2 h-5 w-5 text-black"
                            aria-hidden="true"
                          />
                          Edit
                        </router-link>
                      </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <button
                        :class="[
                            active ? 'bg-black text-white' : 'text-gray-900',
                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                        ]"
                        @click="deleteAuthor(author)"
                        >
                        <TrashIcon
                            :active="active"
                            class="mr-2 h-5 w-5 text-gray-500"
                            aria-hidden="true"
                        />
                        Delete
                        </button>
                    </MenuItem>
                    </div>
                </MenuItems>
                </transition>
            </Menu>
            </td>
        </tr>
        </tbody>
        </table>
  
        <div v-if="!authors.loading" class="flex justify-between items-center mt-5">
        <div v-if="authors.data.length">
            Showing from {{ authors.from }} to {{ authors.to }}
        </div>
        <nav
            v-if="authors.total > authors.limit"
            class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
            aria-label="Pagination"
        >
            <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
            <a
            v-for="(link, i) of authors.links"
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
                i === authors.links.length - 1 ? 'rounded-r-md' : '',
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
  import {AUTHORS_PER_PAGE} from "../../constants";
  import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";
  import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
  import {EllipsisVerticalIcon, PencilSquareIcon, TrashIcon} from '@heroicons/vue/24/solid';
  const perPage = ref(AUTHORS_PER_PAGE);
  const search = ref('');
  const authors = computed(() => store.state.authors);
  const sortField = ref('updated_at');
  const sortDirection = ref('desc')
  const author = ref({})
  onMounted(() => {
  getAuthors();
  })
  function getForPage(ev, link) {
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  }
  getAuthors(link.url)
  }
  function getAuthors(url = null) {
  store.dispatch("getAuthors", {
    url,
    search: search.value,
    per_page: perPage.value,
    sort_field: sortField.value,
    sort_direction: sortDirection.value
  });
  }
  function sortAuthors(field) {
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
      getAuthors()
  }
  
  function deleteAuthor(author) {
  if (!confirm(`Are you sure you want to delete the author?`)) {
    return
  }
  store.dispatch('deleteAuthor', author.id)
    .then(res => {
      // TODO Show notification
      store.dispatch('getAuthors')
    })
  }
  </script>
  
  <style>
  </style>