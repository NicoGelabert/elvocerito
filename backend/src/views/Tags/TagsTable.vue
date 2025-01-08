<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <div class="flex justify-between border-b-2 pb-3">
            <div class="flex items-center">
                <span class="ml-3">Found {{tags.data.length}} tags</span>
            </div>
        </div>
      
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <TableHeaderCell field="id" :sort-field="sortField" :sort-direction="sortDirection" @click="sortTags('id')">
                        ID
                    </TableHeaderCell>
                    <TableHeaderCell field="name" :sort-field="sortField" :sort-direction="sortDirection" @click="sortTags('name')">
                        Name
                    </TableHeaderCell>
                    <TableHeaderCell field="image" :sort-field="sortField" :sort-direction="sortDirection">
                        Image
                    </TableHeaderCell>
                    <TableHeaderCell field="active" :sort-field="sortField" :sort-direction="sortDirection" @click="sortTags('active')">
                        Active
                    </TableHeaderCell>
                    <TableHeaderCell field="parent_id" :sort-field="sortField" :sort-direction="sortDirection" @click="sortTags('parent_id')">
                        Parent
                    </TableHeaderCell>
                    <TableHeaderCell field="created_at" :sort-field="sortField" :sort-direction="sortDirection" @click="sortTags('created_at')">
                        Create Date
                    </TableHeaderCell>
                    <TableHeaderCell field="actions">
                        Actions
                    </TableHeaderCell>
                </tr>
            </thead>
            <tbody v-if="tags.loading || !tags.data.length">
                <tr>
                    <td colspan="7">
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
                    <td class="border-b p-2 ">{{ tag.name }}</td>
                    <td class="border-b p-2 ">
                        <img v-if="tag.image_url" class="w-16 h-16 object-cover" :src="tag.image_url" :alt="tag.name">
                        <img v-else class="w-16 h-16 object-cover" src="../../assets/noimage.png">
                    </td>
                    <td class="border-b p-2">{{ tag.active ? 'Yes' : 'No' }}</td>
                    <td class="border-b p-2">{{ tag.parent?.name }}</td>
                    <td class="border-b p-2">{{ tag.created_at }}</td>
                    <td class="border-b p-2 ">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="inline-flex items-center justify-center w-full justify-center rounded-full w-10 h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                    >
                                    <EllipsisVerticalIcon class="h-5 w-5 text-indigo-500" aria-hidden="true"/>
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
                                <MenuItems class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                >
                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                                                    active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                ]"
                                                @click="editTag(tag)"
                                                >
                                                <PencilSquareIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400" aria-hidden="true"
                                                />
                                                Edit
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                                                    active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                ]"
                                                @click="deleteTag(tag)"
                                                >
                                                <TrashIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400" aria-hidden="true"
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