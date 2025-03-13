<template>
    <div class="p-4 bg-white shadow rounded-lg">
        <h1 v-if="!loading" class="text-2xl font-bold">
            {{ category.id ? `Update Category: "${category.name}"` : 'Create new Category' }}
        </h1>
      
        <Spinner v-if="loading" class="my-4" />
      
        <form v-if="!loading" @submit.prevent="onSubmit">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="col-span-2 px-4 pt-5 pb-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Category Name</h3>
                        <CustomInput class="mb-2" v-model="category.name" label="Category name" :errors="errors['name']"/>
                    </div>
                    <hr class="my-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Description</h3>
                        <CustomInput type="richtext" class="mb-2" v-model="category.description" label="Description" :errors="errors['description']"/>
                    </div>
                    <hr class="my-4">
                    <CustomInput type="select" :select-options="parentCategories" class="mb-2" v-model="category.parent_id" label="Parent" :errors="errors['parent_id']"/>
                    <hr class="my-4">
                    <CustomInput type="checkbox" class="mb-2" v-model="category.active" label="Active" :errors="errors['active']"/>
                </div>
                <div class="col-span-1 px-4 pt-5 pb-4">
                    <h3 class="text-lg font-bold mb-2">Imagen</h3>
                    <!-- Imagen Previa -->
                     <div v-if="category.image_url" class="relative w-40 h-40 rounded-lg border border-dashed flex items-center justify-center overflow-hidden bg-gray-100">
                        <img :src="category.image_url" alt="Previsualización" class="object-cover w-full h-full">
                        <button class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600" @click="category.image_url = null">
                            ✕
                        </button>
                    </div>
                    <!-- Input para Cargar Imagen -->
                     <div v-else class="relative w-40 h-40 rounded-lg border border-dashed flex items-center justify-center hover:border-purple-500 overflow-hidden bg-gray-50">
                        <label class="flex flex-col items-center justify-center cursor-pointer text-gray-600 hover:text-purple-500">
                            <span>Seleccionar Imagen</span>
                            <input type="file" class="absolute inset-0 opacity-0 cursor-pointer" @change="onImageChange" />
                        </label>
                    </div>
                </div>
            </div>
            <footer class="bg-gray-50 rounded-b-lg px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
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
import { computed, ref, onMounted } from 'vue';
import CustomInput from "../../components/core/CustomInput.vue";
import { useRoute, useRouter } from 'vue-router';
import store from '../../store/index.js';
import Spinner from '../../components/core/Spinner.vue';
import Treeselect from 'vue3-treeselect';
import 'vue3-treeselect/dist/vue3-treeselect.css';
import axiosClient from "../../axios.js";

const route = useRoute();
const router = useRouter();

const category = ref({
    id: null,
    name: '',
    description: '',
    parent_id: '',
    image: '',
    image_url: '',
    active: '',
});

const loading = ref(false);
const errors = ref({});

const parentCategories = computed(() => [
    { key: '', text: 'Select Parent Category' },
    ...store.state.categories.data
    .filter(c => !category.value.id || c.id !== category.value.id)
    .map(c => ({ key: c.id, text: c.name }))
    .sort((c1, c2) => c1.text.localeCompare(c2.text))
]);

function onImageChange(event) {
    const file = event?.target?.files[0];
    if (file) {
        category.value.image = file;
        category.value.image_url = URL.createObjectURL(file);
    }
}

onMounted(() => {
    if (route.params.id) {
        loading.value = true;
        store.dispatch('getCategory', route.params.id)
        .then((response) => {
            category.value = response.data.data || {};
            if (category.value.image) {
                category.value.image_url = category.value.image;
            }
        })
        .catch((error) => {
            console.error('Error fetching category:', error);
        })
        .finally(() => {
            loading.value = false;
        });
    }
});

function onSubmit($event, close = false) {
    loading.value = true;
    errors.value = {};

    const action = category.value.id ? 'updateCategory' : 'createCategory';

    store.dispatch(action, category.value)
    .then(response => {
        loading.value = false;
        if (response.status === (category.value.id ? 200 : 201)) {
            category.value = response.data;
            store.commit('showToast', `Category was successfully ${category.value.id ? 'updated' : 'created'}`);
            store.dispatch('getCategories');
    
            if (close) {
                router.push({ name: 'app.categories' });
            } else if (!category.value.id) {
                router.push({ name: 'app.categories.edit', params: { id: response.data.id } });
            }
        }
    })
    .catch(err => {
        loading.value = false;
        errors.value = err.response.data.errors;
    });
}
</script>