<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="flex items-center justify-between mb-3">
      <h1 v-if="!loading" class="text-3xl font-semibold">
        {{ author.id ? `Update author: "${author.name}"` : 'Create new Author' }}
      </h1>
    </div>
    <div class="bg-white rounded-lg shadow animate-fade-in-down">
        <Spinner v-if="loading" class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center z-50"/>
        <form v-if="!loading" @submit.prevent="onSubmit">
            <div class="grid grid-cols-3">
                <div class="col-span-2 px-4 pt-5 pb-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Name</h3>
                        <CustomInput class="mb-2" v-model="author.name" label="Author name" :errors="errors['name']"/>
                    </div>
                    <hr class="my-4">
                    <CustomInput type="select"
                               :select-options="parentAuthors"
                               class="mb-2"
                               v-model="author.parent_id"
                               label="Parent" :errors="errors['parent_id']"/>
                    <hr class="my-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Description</h3>
                        <CustomInput type="richtext" class="mb-2" v-model="author.description" label="Description" :errors="errors['description']"/>
                    </div>
                    <hr class="my-4">
                    <CustomInput type="checkbox" class="mb-2" v-model="author.active" label="Active"/>
                </div>
                <div class="col-span-1 px-4 pt-5 pb-4">
                    <h3 class="text-lg font-bold mb-2">Imagen</h3>
                    <!-- Imagen Previa -->
                    <div class="my-4">
                      <img v-if="author.image_url" class="w-16 h-16" :src="author.image_url" :alt="author.name">
                      <img v-else class="w-16 h-16 object-cover" src="../../assets/noimage.png">
                    </div>
                    <CustomInput type="file" class="mb-2" label="Author Image" @change="file => author.image = file"/>
                </div>
            </div>
            <footer class="bg-gray-50 rounded-b-lg px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="bg-black text-base font-medium text-white border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-black/10 hover:text-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-black sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
                    Save
                </button>
                <button type="button" @click="onSubmit($event, true)" class="bg-black text-base font-medium text-white border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-black/10 hover:text-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-black sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
                    Save & Close
                </button>
                <router-link :to="{name: 'app.authors'}" class="bg-white text-base font-medium text-gray-700 border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-gray-300 sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm" ref="cancelButtonRef">
                    Cancel
                </router-link>
            </footer>
        </form>
    </div>
</template>

<script setup>
import {computed, onMounted, ref} from 'vue'
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";
import {useRoute, useRouter} from "vue-router";
import ImagePreview from "../../components/ImagePreview.vue";
import {PlusCircleIcon, TrashIcon} from '@heroicons/vue/24/solid';

import axiosClient from "../../axios.js";
  
const route = useRoute()
const router = useRouter()

const author = ref({
    id: null,
    name: '',
    description: '',
    image: '',
    active: '',
    parent_id: '',
})

const errors = ref({});
const loading = ref(false);

const emit = defineEmits(['update:modelValue', 'close'])

const parentAuthors = computed(() => {
  return [
    {key: '', text: 'Select Parent Author'},
    ...store.state.alergens.data
      .filter(c => {
        if (alergen.value.id) {
          return c.id !== alergen.value.id
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

onMounted(() => {
    if (route.params.id) {
        loading.value = true
        store.dispatch('getAuthor', route.params.id)
        .then((response) => {
            loading.value = false;
            author.value = response.data;
        })
    }
})

function onSubmit($event, close = false) {
    loading.value = true
    errors.value = {};
    if (author.value.id) {
        store.dispatch('updateAuthor', author.value)
        .then(response => {
            loading.value = false;
            if (response.status === 200) {
                author.value = response.data
                store.commit('showToast', 'Author was successfully updated');
                store.dispatch('getAuthors')
                if (close) {
                    router.push({name: 'app.authors'})
                }
            }
        })
        .catch(err => {
            loading.value = false;
            errors.value = err.response.data.errors
        })
    } else {
        store.dispatch('createAuthor', author.value)
        .then(response => {
            loading.value = false;
            if (response.status === 201) {
                author.value = response.data
                store.commit('showToast', 'Author was successfully created');
                store.dispatch('getAuthors')
                if (close) {
                    router.push({name: 'app.authors'})
                } else {
                    author.value = response.data
                    router.push({name: 'app.authors.edit', params: {id: response.data.id}})
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
    