<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <div class="flex flex-col md:flex-row justify-between border-b-2 pb-3 gap-4">
        <div class="flex md:items-center flex-col md:flex-row gap-4">
            <span class="whitespace-nowrap mr-3">Per Page</span>
            <select @change="getTags(null)" v-model="perPage"
                    class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
            </select>
            <span class="ml-3">Found {{tags.total}} tags</span>
        </div>
        <div>
            <input v-model="search" @change="getTags(null)"
                class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                placeholder="Type to Search tags">
        </div>
        </div>
  
        <table class="table-auto w-full">
        <thead class="hidden md:contents">
        <tr>
            <TableHeaderCell field="id" :sort-field="sortField" :sort-direction="sortDirection" @click="sortTags('id')">
            ID
            </TableHeaderCell>
            <TableHeaderCell field="image" :sort-field="sortField" :sort-direction="sortDirection">
            Image
            </TableHeaderCell>
            <TableHeaderCell field="name" :sort-field="sortField" :sort-direction="sortDirection"
                            @click="sortTags('name')">
            Name
            </TableHeaderCell>
            <TableHeaderCell field="updated_at" :sort-field="sortField" :sort-direction="sortDirection"
                            @click="sortTags('updated_at')">
            Last Updated At
            </TableHeaderCell>
            <TableHeaderCell field="actions">
            Actions
            </TableHeaderCell>
        </tr>
        </thead>
        <tbody v-if="tags.loading || !tags.data.length">
        <tr>
            <td colspan="6">
            <Spinner v-if="tags.loading"/>
            <p v-else class="text-center py-8 text-gray-700">
                There are no tags
            </p>
            </td>
        </tr>
        </tbody>
        <tbody v-else>
        <tr v-for="(tag, index) of tags.data" :key="index">
            <td class="border-b p-2 ">{{ tag.id }}</td>
            <td class="border-b p-2 hidden md:table-cell">
                <img v-if="tag.image_url" class="w-16 h-16 object-cover" :src="tag.image_url" :alt="tag.name">
                <img v-else class="w-16 h-16 object-cover" src="../../assets/noimage.png">
            </td>
            <td class="border-b p-2">
             <div class="truncate overflow-hidden text-ellipsis whitespace-nowrap w-[100px]">
               {{ tag.name }}
             </div>
            </td>
            <td class="border-b p-2 hidden md:table-cell">
            {{ tag.updated_at }}
            </td>
            <td class="border-b p-2 ">
                <ActionMenu :edit="() => editTag(tag)" :remove="() => deleteTag(tag)" />
            </td>
        </tr>
        </tbody>
        </table>
  
        <div v-if="!tags.loading" class="flex justify-between items-center mt-5">
        <div v-if="tags.data.length">
            Showing from {{ tags.from }} to {{ tags.to }}
        </div>
        <nav
            v-if="tags.total > tags.limit"
            class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
            aria-label="Pagination"
        >
            <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
            <a
            v-for="(link, i) of tags.links"
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
                i === tags.links.length - 1 ? 'rounded-r-md' : '',
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
import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {EllipsisVerticalIcon, PencilSquareIcon, TrashIcon} from '@heroicons/vue/24/solid';
import TagModal from "./TagModal.vue";
import ActionMenu from "../../components/core/ActionMenu.vue";

const tags = computed(() => store.state.tags);
const sortField = ref('name');
const sortDirection = ref('asc')

const tag = ref({})
const showTagModal = ref(false);

const emit = defineEmits(['clickEdit'])

onMounted(() => {
    getTags();
})

function getForPage(ev, link) {
    ev.preventDefault();
    if (!link.url || link.active) {
        return;
    }

    getTags(link.url)
}

function getTags(url = null) {
    store.dispatch("getTags", {
        url,
        sort_field: sortField.value,
        sort_direction: sortDirection.value
    });
}

function sortTags(field) {
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

    getTags()
}

function showAddNewModal() {
    showTagModal.value = true
}

function deleteTag(tag) {
    if (!confirm(`Are you sure you want to delete the tag?`)) {
        return
    }
    store.dispatch('deleteTag', tag)
    .then(res => {
        store.commit('showToast', 'Tag was successfully deleted');
        store.dispatch('getTags')
    })
}

function editTag(t) {
    emit('clickEdit', t)
}
</script>