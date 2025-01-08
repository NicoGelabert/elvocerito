<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-10" @close="show = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity"/>
            </TransitionChild>
        
            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[700px] sm:w-full">
                            <Spinner v-if="loading" class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center"/>
                            <header class="py-3 px-4 flex justify-between items-center">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                    {{ client.id ? `Update client: "${props.client.name}"` : 'Create new client' }}
                                </DialogTitle>
                                <button 
                                    @click="closeModal()"
                                    class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </header>
                            <td class="border-b p-2 "></td>
                            <form @submit.prevent="onSubmit">
                                <div class="bg-white px-4 pt-5 pb-4">
                                    <CustomInput class="mb-2" v-model="client.name" label="Name" :errors="errors['name']"/>
                                    <CustomInput type="select" :select-options="parentClients" class="mb-2" v-model="client.parent_id" label="Parent" :errors="errors['parent_id']"/>
                                    <div class="flex items-center gap-4">
                                        <div class="my-4">
                                            <img v-if="client.image_url" class="w-16 h-16" :src="client.image_url" :alt="client.name">
                                            <img v-else class="w-16 h-16 object-cover" src="../../assets/noimage.png">
                                        </div>
                                        <CustomInput type="file" class="mb-2" label="client Image" @change="file => client.image = file"/>
                                    </div>
                                    <CustomInput type="checkbox" class="mb-2" v-model="client.active" label="Active"  :errors="errors['active']"/>
                                </div>
                                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex  sm:flex-row-reverse">
                                    <button type="submit" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                                        Submit
                                    </button>
                                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="closeModal" ref="cancelButtonRef">
                                        Cancel
                                    </button>
                                </footer>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
  
<script setup>
import {computed, onUpdated, ref} from 'vue'
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {ExclamationCircleIcon} from '@heroicons/vue/24/solid';
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";

const props = defineProps({
    modelValue: Boolean,
    client: {
        required: true,
        type: Object,
    }
})

const client = ref({
    id: props.client.id,
    name: props.client.name,
    image: props.client.image,
    active: props.client.active,
    parent_id: props.client.parent_id,
})

const loading = ref(false)
const errors = ref({})

const emit = defineEmits(['update:modelValue', 'close'])

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

const parentClients = computed(() => {
    return [
        {key: '', text: 'Select Parent Client'},
        ...store.state.clients.data
        .filter(c => {
            if (client.value.id) {
                return c.id !== client.value.id
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

onUpdated(() => {
    client.value = {
        id: props.client.id,
        name: props.client.name,
        image_url: props.client.image_url,
        active: props.client.active,
        parent_id: props.client.parent_id,
    }
})

function closeModal() {
    show.value = false
    emit('close')
    errors.value = {};
}

function onSubmit() {
    loading.value = true
    client.value.active = !!client.value.active
    if (client.value.id) {
        store.dispatch('updateClient', client.value)
        .then(response => {
            loading.value = false;
            if (response.status === 200) {
                store.commit('showToast', 'Client was successfully updated');
                store.dispatch('getClients')
                closeModal()
            }
        })
        .catch(err => {
            loading.value = false;
            errors.value = err.response.data.errors
        })
    } else {
        store.dispatch('createClient', client.value)
        .then(response => {
            loading.value = false;
            if (response.status === 201) {
                store.commit('showToast', 'Client was successfully created');
                store.dispatch('getClients')
                closeModal()
            }
        })
        .catch(err => {
            loading.value = false;
            errors.value = err.response.data.errors
        })
    }
}
</script>