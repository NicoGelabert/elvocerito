<template>
    <div class="p-4 bg-white shadow rounded-lg">
        <h1 v-if="!loading" class="text-2xl font-bold">
            {{ faq.id ? `Editar Pregunta: "${faq.question}"` : 'Crear nueva Pregunta' }}
        </h1>
      
        <Spinner v-if="loading" class="my-4" />
      
        <form v-if="!loading" @submit.prevent="onSubmit">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="col-span-2 px-4 pt-5 pb-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Categoría</h3>
                        <CustomInput
                            type="select"
                            class="mb-2"
                            v-model="faq.category"
                            label="Faq category"
                            :select-options="[
                                { key: 'guia_papel', text: 'Guía Papel' },
                                { key: 'guia_digital', text: 'Guía Digital' },
                                { key: 'publicidad', text: 'Publicidad' },
                                { key: 'guia_usuarios', text: 'Guía Usuarios' }
                            ]"
                            :errors="errors['category']"
                        />
                    </div>
                    <hr class="my-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Pregunta</h3>
                        <CustomInput type="richtext" class="mb-2" v-model="faq.question" label="Question" :errors="errors['question']"/>
                    </div>
                    <hr class="my-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Respuesta</h3>
                        <CustomInput type="richtext" class="mb-2" v-model="faq.answer" label="Answer" :errors="errors['answer']"/>
                    </div>
                    <hr class="my-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Publicado</h3>
                        <CustomInput type="checkbox" class="mb-2" v-model="faq.published" label="Published" :errors="errors['published']"/>
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
                <router-link :to="{name: 'app.faqs'}" class="bg-white text-base font-medium text-gray-700 border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-gray-300 sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm" ref="cancelButtonRef">
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

const faq = ref({
    id: null,
    category: '',
    question: '',
    answer: '',
    published: false,
});


const loading = ref(false);
const errors = ref({});

onMounted(() => {
    if (route.params.id) {
        loading.value = true;
        store.dispatch('getFaq', route.params.id)
        .then((response) => {
            faq.value = response.data || {};
        })
        .catch((error) => {
            console.error('Error fetching faq:', error);
        })
        .finally(() => {
            loading.value = false;
        });
    }
});

function onSubmit($event, close = false) {
    loading.value = true;
    errors.value = {};

    const action = faq.value.id ? 'updateFaq' : 'createFaq';

    store.dispatch(action, faq.value)
    .then(response => {
        loading.value = false;
        if (response.status === (faq.value.id ? 200 : 201)) {
            faq.value = response.data;
            store.commit('showToast', `Faq was successfully ${faq.value.id ? 'updated' : 'created'}`);
            store.dispatch('getFaqs');
    
            if (close) {
                router.push({ name: 'app.faqs' });
            } else if (!faq.value.id) {
                router.push({ name: 'app.faqs.edit', params: { id: response.data.id } });
            }
        }
    })
    .catch(err => {
        loading.value = false;
        errors.value = err.response.data.errors;
    });
}
</script>