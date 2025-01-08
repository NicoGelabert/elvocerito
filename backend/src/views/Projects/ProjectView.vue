<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="flex items-center justify-between mb-3">
      <h1 v-if="!loading" class="text-3xl font-semibold">
        {{ project.id ? `Update project: "${project.title}"` : 'Create new Project' }}
      </h1>
    </div>
    <div class="bg-white rounded-lg shadow animate-fade-in-down">
        <Spinner
            v-if="loading"
            class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center z-50"/>
        <form v-if="!loading" @submit.prevent="onSubmit">
            <div class="grid grid-cols-3">
                <div class="col-span-2 px-4 pt-5 pb-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Project Name</h3>
                        <CustomInput class="mb-2" v-model="project.title" label="Project Title" :errors="errors['title']"/>
                    </div>
                    <hr class="my-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Service</h3>
                        <treeselect v-model="project.services" :multiple="true" :options="servicesOptions" :errors="errors['services']"/>
                    </div>
                    <hr class="my-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Client</h3>
                        <treeselect v-model="project.clients" :multiple="true" :options="clientsOptions" :errors="errors['clients']"/>
                    </div>
                    <hr class="my-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Description</h3>
                        <CustomInput type="richtext" class="mb-2" v-model="project.description" label="Description" :errors="errors['description']"/>
                    </div>
                    <hr class="my-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Tags</h3>
                        <treeselect v-model="project.tags" :multiple="true" :options="tagsOptions" :errors="errors['tags']"/>
                    </div>
                    <hr class="my-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Published</h3>
                        <CustomInput type="checkbox" class="mb-2" v-model="project.published" label="Published" :errors="errors['published']"/>
                    </div>
                </div>
                <div class="col-span-1 px-4 pt-5 pb-4">
                    <image-preview
                        v-model="project.images"
                        :images="project.images"
                        v-model:deleted-images="project.deleted_images"
                        v-model:image-positions="project.image_positions"
                    />
                </div>
            </div>
            <footer class="bg-gray-50 rounded-b-lg px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit"
                        class="bg-black text-base font-medium text-white border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-black/10 hover:text-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-black sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
                        Save
                </button>
                <button type="button"
                        @click="onSubmit($event, true)"
                        class="bg-black text-base font-medium text-white border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-black/10 hover:text-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-black sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
                        Save & Close
                </button>
                <router-link
                        :to="{name: 'app.projects'}"
                        class="bg-white text-base font-medium text-gray-700 border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-gray-300 sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm"
                        ref="cancelButtonRef">
                        Cancel
                </router-link>
            </footer>
        </form>
    </div>
</template>
    
<script setup>
import {onMounted, ref} from 'vue'
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";
import {useRoute, useRouter} from "vue-router";
import ImagePreview from "../../components/ImagePreview.vue";
import {PlusCircleIcon, MinusCircleIcon} from '@heroicons/vue/24/solid';
// import the component
import Treeselect from 'vue3-treeselect'
// import the styles
import 'vue3-treeselect/dist/vue3-treeselect.css'
import axiosClient from "../../axios.js";

const route = useRoute()
const router = useRouter()

const project = ref({
    id: null,
    title: null,
    images: [],
    deleted_images: [],
    image_positions: {},
    description: '',
    published: false,
    services: [],
    tags: [],
    clients: [],
})

const errors = ref({});
const loading = ref(false);
const servicesOptions = ref([]);
const tagsOptions = ref([]);
const clientsOptions = ref([]);

const emit = defineEmits(['update:modelValue', 'close'])

onMounted(() => {
    if (route.params.id) {
        loading.value = true
        store.dispatch('getProject', route.params.id)
        .then((response) => {
            loading.value = false;
            project.value = response.data;
        })
    }
    axiosClient.get('/services/tree')
    .then(result => {
        servicesOptions.value = result.data
    })
    axiosClient.get('/tags/tree')
    .then(result => {
        tagsOptions.value = result.data
    })
    axiosClient.get('/clients/tree')
    .then(result => {
        clientsOptions.value = result.data
    })
})

function onSubmit($event, close = false) {
    loading.value = true
    errors.value = {};
    if (project.value.id) {
        store.dispatch('updateProject', project.value)
        .then(response => {
            loading.value = false;
            if (response.status === 200) {
                project.value = response.data
                store.commit('showToast', 'Project was successfully updated');
                store.dispatch('getProjects')
                if (close) {
                    router.push({name: 'app.projects'})
                }
            }
        })
        .catch(err => {
            loading.value = false;
            errors.value = err.response.data.errors
        })
    } else {
        store.dispatch('createProject', project.value)
        .then(response => {
            loading.value = false;
            if (response.status === 201) {
                project.value = response.data
                store.commit('showToast', 'Project was successfully created');
                store.dispatch('getProjects')
                if (close) {
                    router.push({name: 'app.projects'})
                } else {
                    project.value = response.data
                    router.push({name: 'app.projects.edit', params: {id: response.data.id}})
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
    