<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="flex items-center justify-between mb-3">
        <h1 v-if="!loading" class="text-3xl font-semibold">
            {{ category.id ? `Update category: "${category.name}"` : 'Create new category' }}
        </h1>
    </div>
    <div class="bg-white rounded-lg shadow animate-fade-in-down">
        <Spinner v-if="loading" class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center"/>
        <form v-if="!loading" @submit.prevent="onSubmit">
            <div class="grid grid-cols-3 items-start">
                <div class="col-span-2 px-4 pt-5 pb-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Category Name</h3>
                        <CustomInput class="mb-2" v-model="category.name" label="Name" :errors="errors['name']"/>
                    </div>
                    <hr class="my-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Category Description</h3>
                        <CustomInput type="richtext" class="mb-2" v-model="category.description" label="Description" :errors="errors['description']"/>
                    </div>
                    <hr class="my-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Parent Category</h3>
                        <CustomInput type="select" :select-options="parentCategories" class="mb-2" v-model="category.parent_id" label="Parent" :errors="errors['parent_id']"/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Active</h3>
                        <CustomInput type="checkbox" class="mb-2" v-model="category.active" label="Active" :errors="errors['active']"/>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="my-4">
                        <img v-if="category.image_url" class="w-16 h-16" :src="category.image_url" :alt="category.name">
                        <img v-else class="w-16 h-16 object-cover" src="../../assets/noimage.png">
                    </div>
                    <CustomInput type="file" class="mb-2" label="category Image" @change="file => category.image = file" :errors="errors['image']"/>
                </div>
            </div>
            <footer class="w-full bg-gray-50 rounded-b-lg px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="bg-black text-base font-medium text-white border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-black/10 hover:text-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-black sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
                    Save
                </button>
                <button type="button" @click="onSubmit($event, true)" class="bg-black text-base font-medium text-white border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-black/10 hover:text-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-black sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
                    Save & Close
                </button>
                <router-link :to="{name: 'app.categories'}" class="bg-white text-base font-medium text-gray-700 border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-gray-300 sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm" ref="cancelButtonRef">
                    Cancel
                </router-link>
            </footer>
        </form>
    </div>
</template>

<script setup>
import {computed, onUpdated, onMounted, ref} from 'vue';
import {ExclamationCircleIcon} from '@heroicons/vue/24/solid';
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";
import {useRoute, useRouter} from "vue-router";
import {PlusCircleIcon, TrashIcon} from '@heroicons/vue/24/solid';
import Treeselect from 'vue3-treeselect';
import 'vue3-treeselect/dist/vue3-treeselect.css';
import axiosClient from "../../axios.js";

const route = useRoute()
const router = useRouter()

const category = ref({
  id: null,
  name: '',
  images: '',
  description: '',
  active: false,
})

const loading = ref(false)
const errors = ref({})

const emit = defineEmits(['update:modelValue', 'close'])

onMounted(() => {
    if (route.params.id) {
        loading.value = true
        store.dispatch('getCategory', route.params.id)
        .then((response) => {
            loading.value = false;
            category.value = response.data;
        })
    }
    axiosClient.get('/categories/tree')
    .then(result => {
        categoriesOptions.value = result.data
    })
})

const parentCategories = computed(() => {
    return [
        {key: '', text: 'Select Parent Category'},
        ...store.state.categories.data
        .filter(c => {
            if (category.value.id) {
                return c.id !== category.value.id
            }
            return true;
        })
        .map(c => ({key: c.id, text: c.name}))
        .sort((c1, c2) => {
            if (c1.text < c2.text) return -1;
            if (c1.text > c2.text) return 1;
            return 0;
        })
    ]
})

function onSubmit($event, close = false) {
    loading.value = true
    errors.value = {};
    if (category.value.id) {
        store.dispatch('updateCategory', category.value)
        .then(response => {
            loading.value = false;
            if (response.status === 200) {
                category.value = response.data
                store.commit('showToast', 'Category was successfully updated');
                store.dispatch('getCategories')
                if (close) {
                    router.push({name: 'app.categories'})
                }
            }
        })
        .catch(err => {
            loading.value = false;
            errors.value = err.response.data.errors
        })
    } else {
        store.dispatch('createCategory', category.value)
        .then(response => {
            loading.value = false;
            if (response.status === 201) {
                category.value = response.data
                store.commit('showToast', 'Category was successfully created');
                store.dispatch('getCategories')
                if (close) {
                    router.push({name: 'app.categories'})
                } else {
                    category.value = response.data
                    router.push({name: 'app.categories.edit', params: {id: response.data.id}})
                }
            }
        })
        .catch(err => {
            loading.value = false;
            errors.value = err.response.data.errors
        })
    }
}
</script>
  