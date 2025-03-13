<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <div class="flex flex-col md:flex-row justify-between border-b-2 pb-3 gap-4">
            <div class="flex md:items-center flex-col md:flex-row gap-4">
                <span class="whitespace-nowrap mr-3">Per Page</span>
                <select @change="getHomeHeroBanners(null)"
                        v-model="perPage"
                        class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="ml-3">Found {{ homeHeroBanners.total }} home hero banners</span>
            </div>
            <div>
                <input @change="getHomeHeroBanners(null)"
                       v-model="search"
                       class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                       placeholder="Type to Search images"
                >
            </div>
        </div>

        <table class="table-auto w-full">
            <thead class="hidden md:contents">
                <tr>
                    <TableHeaderCell field="id" :sort-field="sortField" :sort-direction="sortDirection" @click="sortHomeHeroBanners('id')">
                        ID
                    </TableHeaderCell>
                    <TableHeaderCell field="image" :sort-field="sortField" :sort-direction="sortDirection">
                        Image
                    </TableHeaderCell>
                    <TableHeaderCell field="headline" :sort-field="sortField" :sort-direction="sortDirection" @change="sortHomeHeroBanners('headline')">
                        Headline
                    </TableHeaderCell>
                    <TableHeaderCell field="updated_at" :sort-field="sortField" :sort-direction="sortDirection" @change="sortHomeHeroBanners('updated_at')">
                        Last Updated At
                    </TableHeaderCell>
                    <TableHeaderCell field="actions">
                        Actions
                    </TableHeaderCell>
                </tr>
            </thead>
            <tbody v-if="homeHeroBanners.loading || !homeHeroBanners.data.length">
                <tr>
                    <td colspan="6">
                        <Spinner v-if="homeHeroBanners.loading"/>
                        <p v-else class="text-center py-8 text-gray-700">
                            There are no images
                        </p>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr v-for="(homeHeroBanner, index) of homeHeroBanners.data" :key="index">
                    <td class="border-b p-2">{{ homeHeroBanner.id }}</td>
                    <td class="border-b p-2 hidden md:table-cell">
                        <img class="w-16 h-16 object-cover" :src="homeHeroBanner.image_url" :alt="homeHeroBanner.headline">
                    </td>
                    <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
                        <div class="truncate overflow-hidden text-ellipsis whitespace-nowrap w-[100px]">
                            {{ homeHeroBanner.headline }}
                        </div>
                    </td>
                    <td class="border-b p-2 hidden md:table-cell">
                        {{ homeHeroBanner.updated_at }}
                    </td>
                    <td class="border-b p-2">
                        <ActionMenu :edit="() => editHomeHeroBanner(homeHeroBanner)" :remove="() => deleteHomeHeroBanner(homeHeroBanner)" />
                    </td>
                </tr>
            </tbody>
        </table>

        <div v-if="!homeHeroBanners.loading" class="flex justify-between items-center mt-5">
            <div v-if="homeHeroBanners.data.length">
                Showing from {{ homeHeroBanners.from }} to {{ homeHeroBanners.to }}
            </div>
            <nav v-if="homeHeroBanners.total > homeHeroBanners.limit"
                class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
                aria-label="Pagination"
            >
            <a 
                v-for="(link, i) of homeHeroBanners.links"
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
                    i === homeHeroBanners.links.length - 1 ? 'rounded-r-md' : '',
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
import {HOMEHEROBANNERS_PER_PAGE} from '../../constants';
import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {EllipsisVerticalIcon, PencilSquareIcon, TrashIcon} from '@heroicons/vue/24/solid';
import HomeHeroBannerModal from "./HomeHeroBannerModal.vue";
import ActionMenu from "../../components/core/ActionMenu.vue";

const perPage = ref(HOMEHEROBANNERS_PER_PAGE);
const search = ref('');
const homeHeroBanners = computed(() => store.state.homeHeroBanners);
const sortField = ref('updated_at');
const sortDirection = ref('desc');

const homeHeroBanner = ref({});
const showHomeHeroBannerModal = ref(false);

const emit = defineEmits(['clickEdit']);

onMounted(() => {
    getHomeHeroBanners();
})
console.log(homeHeroBanners)

function getForPage(ev, link) {
    ev.preventDefault();
    if (!link.url || link.active) {
        return;
    }
    getHomeHeroBanners(link.url)
}

function getHomeHeroBanners(url = null){
    store.dispatch('getHomeHeroBanners', {
        url,
        search: search.value,
        per_page: perPage.value,
        sort_field: sortField.value,
        sort_direction: sortDirection.value
    })
}

function sortHomeHeroBanners(field){
    if(field === sortField.value){
        if(sortDirection.value === 'desc'){
            sortDirection.value = 'asc'
        }else{
            sortDirection.value = 'desc'
        }
    }else{
        sortField.value = field;
        sortDirection.value = 'asc'
    }
    getHomeHeroBanners()
}

function showAddNewModal(){
    showHomeHeroBannerModal.value = true
}

function deleteHomeHeroBanner(homeHeroBanner){
    if(!confirm(`Are you sure you want to delete the image?`)){
        return
    }
    store.dispatch('deleteHomeHeroBanner', homeHeroBanner.id)
    .then(res => {
        store.dispatch('getHomeHeroBanners')
    })
}

function editHomeHeroBanner(h){
    emit('clickEdit', h)
}

</script>