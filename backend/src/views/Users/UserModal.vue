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
                  {{ user.id ? `Update user: "${props.user.name}"` : 'Create new User' }}
                </DialogTitle>
                <button
                  @click="closeModal()"
                  class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </button>
              </header>
              <form @submit.prevent="onSubmit">
                <div class="bg-white px-4 pt-5 pb-4">
                  <CustomInput class="mb-2" v-model="user.name" label="Name"/>

                  <CustomInput class="mb-2" v-model="user.email" label="Email"/>
                  <span v-if="errors.email" class="block -mt-1 mb-2 text-xs text-red-500">{{ errors.email }}</span>

                  <div class="flex flex-col">
                    <CustomInput type="password" class="mb-2" v-model="user.password" label="Password"/>
                    <span v-if="errors.password" class="text-xs text-red-500 mb-1">{{ errors.password }}</span>
                    <span class="text-xs" :class="user.password?.length >= 8 ? 'text-green-500' : 'text-gray-400'">
                      ✓ Mínimo 8 caracteres
                    </span>
                    <span class="text-xs" :class="/[0-9]/.test(user.password) ? 'text-green-500' : 'text-gray-400'">
                      ✓ Al menos un número
                    </span>
                    <span class="text-xs" :class="/[a-zA-Z]/.test(user.password) ? 'text-green-500' : 'text-gray-400'">
                      ✓ Al menos una letra
                    </span>
                    <span class="text-xs" :class="/[\W_]/.test(user.password) ? 'text-green-500' : 'text-gray-400'">
                      ✓ Al menos un símbolo
                    </span>
                  </div>
                </div>
                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                  <button type="submit"
                          class="bg-black text-base font-medium text-white border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-black/10 hover:text-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-black sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
                    Guardar
                  </button>
                  <button type="button"
                          class="bg-white text-base font-medium text-gray-700 border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-gray-300 sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm"
                          @click="closeModal" ref="cancelButtonRef">
                    Cancelar
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
import {computed, onUpdated, reactive, ref, watch} from 'vue'
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";

const props = defineProps({
  modelValue: Boolean,
  user: {
    required: true,
    type: Object,
  }
})

const user = ref({
  id: props.user.id,
  name: props.user.name,
  email: props.user.email,
  password: '',
})

const errors = reactive({
  email: '',
  password: '',
})

const loading = ref(false)
const emit = defineEmits(['update:modelValue', 'close'])

const show = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})

watch(() => user.value.email, (val) => {
  errors.email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) ? '' : 'El email no es válido'
})

watch(() => user.value.password, (val) => {
  if (!val) {
    errors.password = ''
  } else if (val.length < 8) {
    errors.password = 'Mínimo 8 caracteres'
  } else if (!/[0-9]/.test(val)) {
    errors.password = 'Debe contener al menos un número'
  } else if (!/[a-zA-Z]/.test(val)) {
    errors.password = 'Debe contener al menos una letra'
  } else if (!/[\W_]/.test(val)) {
    errors.password = 'Debe contener al menos un símbolo'
  } else {
    errors.password = ''
  }
})

onUpdated(() => {
  user.value = {
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    password: '',
  }
})

function closeModal() {
  show.value = false
  emit('close')
}

function validate() {
  errors.email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(user.value.email) ? '' : 'El email no es válido'

  const p = user.value.password
  if (!p || p.length < 8) errors.password = 'Mínimo 8 caracteres'
  else if (!/[0-9]/.test(p)) errors.password = 'Debe contener al menos un número'
  else if (!/[a-zA-Z]/.test(p)) errors.password = 'Debe contener al menos una letra'
  else if (!/[\W_]/.test(p)) errors.password = 'Debe contener al menos un símbolo'
  else errors.password = ''

  return !errors.email && !errors.password
}

function onSubmit() {
  if (!validate()) return

  loading.value = true
  if (user.value.id) {
    store.dispatch('updateUser', user.value)
      .then(response => {
        loading.value = false
        if (response.status === 200) {
          store.dispatch('getUsers')
          closeModal()
        }
      })
  } else {
    store.dispatch('createUser', user.value)
      .then(response => {
        loading.value = false
        if (response.status === 201) {
          store.dispatch('getUsers')
          closeModal()
        }
      })
      .catch(() => {
        loading.value = false
      })
  }
}
</script>