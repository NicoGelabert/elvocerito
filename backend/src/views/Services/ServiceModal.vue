<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <TransitionRoot as="template" :show="show">
    <Dialog as="div" class="relative z-10" @close="show = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                       leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity"/>
      </TransitionChild>

      <div class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300"
                           enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                           enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                           leave-from="opacity-100 translate-y-0 sm:scale-100"
                           leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel
              class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[700px] sm:w-full">
              <Spinner v-if="loading"
                       class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center"/>
              <header class="py-3 px-4 flex justify-between items-center">
                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                  {{ service.id ? `Update service: "${props.service.name}"` : 'Create new service' }}
                </DialogTitle>
                <button
                  @click="closeModal()"
                  class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </button>
              </header>
              <td class="border-b p-2 ">
              </td>
              <form @submit.prevent="onSubmit">
                <div class="bg-white px-4 pt-5 pb-4">
                  <CustomInput class="mb-2" v-model="service.name" label="Name" :errors="errors['name']"/>
                  <CustomInput class="mb-2" v-model="service.icon" label="icon" :errors="errors['icon']"/>
                  <CustomInput type="richtext" class="mb-2" v-model="service.short_description" label="Description" :errors="errors['short_description']"/>
                  <CustomInput type="richtext" class="mb-2" v-model="service.description" label="Description" :errors="errors['description']"/>
                  <CustomInput type="select"
                               :select-options="parentServices"
                               class="mb-2"
                               v-model="service.parent_id"
                               label="Parent" :errors="errors['parent_id']"/>

                  <!-- Attributes Section -->
                  <div class="my-4">
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Attributes</h4>
                    <div v-for="(attribute, index) in service.attributes" :key="index" class="flex items-center gap-2 mb-2">
                      <CustomInput class="flex-1" v-model="attribute.text" :label="'Attribute ' + (index + 1)" :errors="errors[`attributes.${index}.text`]"/>
                      <button class="group border-0 rounded-full" @click="removeAttribute(index)">
                        <TrashIcon
                          class="mr-2 h-5 w-5 text-black group-hover:text-red-500"
                          aria-hidden="true"
                        />
                      </button>
                    </div>
                    <button class="group flex items-end gap-2 border rounded-lg px-4 py-2 w-fit hover:bg-black hover:text-white" type="button" @click="addAttribute">
                      <h4 class="text-sm">New Attribute</h4>
                      <PlusCircleIcon
                        class="h-5 w-5 text-black group-hover:text-white"
                        aria-hidden="true"
                      />
                    </button>
                  </div>

                  <div class="flex items-center gap-4">
                    <div class="my-4">
                      <img v-if="service.image_url" class="w-16 h-16" :src="service.image_url" :alt="service.name">
                      <img v-else class="w-16 h-16 object-cover" src="../../assets/noimage.png">
                    </div>
                    <CustomInput type="file" class="mb-2" label="service Image" @change="file => service.image = file" :errors="errors['image']"/>
                  </div>
                  <CustomInput type="checkbox" class="mb-2" v-model="service.active" label="Active" :errors="errors['active']"/>
                </div>
                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                  <button type="submit"
                          class="bg-black text-base font-medium text-white border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-black/10 hover:text-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-black sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
                    Submit
                  </button>
                  <button type="button"
                          class="bg-white text-base font-medium text-gray-700 border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-gray-300 sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm"
                          @click="closeModal" ref="cancelButtonRef">
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
import {PlusCircleIcon, TrashIcon} from '@heroicons/vue/24/solid';

const props = defineProps({
  modelValue: Boolean,
  service: {
    required: true,
    type: Object,
  }
})
const service = ref({
  id: props.service.id,
  name: props.service.name,
  icon: props.service.icon,
  short_description: props.service.short_description,
  description: props.service.description,
  image: props.service.image,
  active: props.service.active,
  parent_id: props.service.parent_id,
  attributes: props.service.attributes || []  // Adding attributes field
})

console.log(service.attributes)

const loading = ref(false)
const errors = ref({})

const emit = defineEmits(['update:modelValue', 'close'])

const show = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})
const parentServices = computed(() => {
  return [
    {key: '', text: 'Select Parent Service'},
    ...store.state.services.data
      .filter(c => {
        if (service.value.id) {
          return c.id !== service.value.id
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
  service.value = {
    id: props.service.id,
    name: props.service.name,
    icon: props.service.icon,
    short_description: props.service.short_description,
    description:props.service.description,
    image_url: props.service.image_url,
    active: props.service.active,
    parent_id: props.service.parent_id,
    attributes: props.service.attributes || []  // Initialize attributes
  }
})

function closeModal() {
  show.value = false
  emit('close')
  errors.value = {};
}

function addAttribute() {
  service.value.attributes.push({ text: '' });
}

function removeAttribute(index) {
  service.value.attributes.splice(index, 1);
}

function onSubmit() {
  loading.value = true
  service.value.active = !!service.value.active
  if (service.value.id) {
    store.dispatch('updateService', service.value)
      .then(response => {
        loading.value = false;
        if (response.status === 200) {
          store.commit('showToast', 'Service was successfully updated');
          store.dispatch('getServices')
          closeModal()
        }
      })
      .catch(err => {
        loading.value = false;
        errors.value = err.response.data.errors
      })
  } else {
    store.dispatch('createService', service.value)
      .then(response => {
        loading.value = false;
        if (response.status === 201) {
          store.commit('showToast', 'Service was successfully created');
          store.dispatch('getServices')
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
