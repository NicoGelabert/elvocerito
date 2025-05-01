<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div class="flex items-center justify-between mb-3">
    <h1 v-if="!loading" class="text-3xl font-semibold">
      {{ product.id ? `Editar anunciante: "${product.title}"` : 'Crear nuevo anunciante' }}
    </h1>
  </div>
  <div class="bg-white rounded-lg shadow animate-fade-in-down">
    <Spinner v-if="loading"
              class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center z-50"/>
    <form v-if="!loading" @submit.prevent="onSubmit">
      <div class="grid grid-cols-1 md:grid-cols-3">
        <div class="col-span-2 px-4 pt-5 pb-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Número de Cliente</h3>
            <CustomInput class="mb-2" v-model="product.client_number" label="Número de Cliente" :errors="errors['client_number']"/>
          </div>
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Nombre</h3>
            <CustomInput class="mb-2" v-model="product.title" label="Product Title" :errors="errors['title']"/>
          </div>
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Categorías</h3>
            <treeselect v-model="product.categories" :multiple="true" :options="categoriesOptions" :errors="errors['categories']"/>
          </div>
          <hr class="my-4">
          <div class="flex flex-col gap-2">
              <h3 class="text-lg font-bold">Tags</h3>
              <treeselect v-model="product.tags" :multiple="true" :options="tagsOptions" :errors="errors['tags']"/>
          </div>
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Descripción corta</h3>
            <CustomInput type="text" class="mb-2" v-model="product.short_description" label="Short Description" :errors="errors['short_description']"/>
          </div>
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Descripción larga</h3>
            <CustomInput type="richtext" class="mb-2" v-model="product.description" label="Description" :errors="errors['description']"/>
          </div>
          <!-- Inicio Listado de Items -->
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Listado de Items</h3>
            <div v-for="(listitem, index) in product.listitems" :key="index" class="flex gap-1">
              <CustomInput 
                v-model="listitem.item" 
                type="text" 
                class="mb-2 w-7/12" 
                label="Listado de Items" 
                :errors="errors[`listitems.${index}.item`]" 
              />
              <div class="w-1/12 flex items-center justify-center">
                <button class="group border-0 rounded-full hover:bg-black" v-if="product.listitems.length > 1" @click.prevent="removeListitem(index)">
                  <TrashIcon
                    class="h-5 w-5 text-black group-hover:text-white"
                    aria-hidden="true"
                  />
                </button>
              </div>
            </div>
            <button class="group flex items-end gap-2 border rounded-lg px-4 py-2 w-fit hover:bg-black hover:text-white" type="button" @click="addListitem">
              <h4 class="text-sm">Crear nuevo ítem</h4>
              <PlusCircleIcon
                class="h-5 w-5 text-black group-hover:text-white"
                aria-hidden="true"
              />
            </button>
          </div>
          <!-- Fin Listado de Items -->
          <!-- Inicio Direcciones -->
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Dirección</h3>
            <div v-for="(address, index) in product.addresses" :key="index" class="flex flex-col gap-1">
              <CustomInput 
                v-model="address.title" 
                type="text" 
                class="mb-2 md:w-7/12" 
                label="Title" 
                :errors="errors[`addresses.${index}.title`]" 
              />
              <div class="flex flex-wrap gap-1">
                <CustomInput 
                  v-model="address.via" 
                  type="select" 
                  class="mb-2 w-4/12 md:w-2/12" 
                  label="Tipo de Vía" 
                  :select-options="[
                    { key: 'Av.', text: 'Av.' },
                    { key: 'Calle', text: 'Calle' },
                    { key: 'Camino', text: 'Camino' },
                    { key: 'Ruta', text: 'Ruta' }
                  ]" 
                  :errors="errors[`addresses.${index}.via`]" 
                />
                <CustomInput 
                  v-model="address.via_name" 
                  type="text" 
                  class="mb-2 w-7/12 md:w-6/12"
                  label="Nombre de la vía"
                  :errors="errors[`addresses.${index}.via_name`]" 
                />
                <CustomInput 
                  v-model="address.via_number"
                  type="number"
                  class="mb-2 w-5/12 md:w-2/12"
                  label="Número"
                  step="1"
                  :errors="errors[`addresses.${index}.via_number`]" 
                />
                <CustomInput 
                  v-model="address.address_unit" 
                  type="text" 
                  class="mb-2 w-6/12 md:w-2/12"
                  label="Piso o departamento"
                  :errors="errors[`addresses.${index}.address_unit`]" 
                />
              </div>
              <div class="flex flex-wrap gap-1">
                <CustomInput 
                  v-model="address.city" 
                  type="text" 
                  class="mb-2 w-7/12 md:w-5/12"
                  label="Ciudad"
                  :errors="errors[`addresses.${index}.city`]" 
                />
                <CustomInput 
                  v-model="address.zip_code" 
                  type="text" 
                  class="mb-2 w-4/12 md:w-2/12"
                  label="Código Postal"
                  :errors="errors[`addresses.${index}.zip_code`]" 
                />
                <CustomInput 
                  v-model="address.province" 
                  type="text" 
                  class="mb-2 w-12/12 md:w-5/12"
                  label="Provincia"
                  :errors="errors[`addresses.${index}.province`]" 
                />
              </div>
              <div>
                <CustomInput 
                    v-model="address.link" 
                    type="text" 
                    class="mb-2 w-12/12 md:w-5/12"
                    label="Link"
                    :errors="errors[`addresses.${index}.link`]" 
                  />
                  <CustomInput 
                  v-model="address.google_maps" 
                  type="text" 
                  class="mb-2 w-12/12 md:w-5/12"
                  label="Google Maps"
                  :errors="errors[`addresses.${index}.google_maps`]" 
                />
              </div>
              <div class="w-1/12 flex items-center justify-center">
                <button class="group border-0 rounded-full hover:bg-black" v-if="product.addresses.length > 1" @click.prevent="removeAddress(index)">
                  <TrashIcon
                    class="h-5 w-5 text-black group-hover:text-white"
                    aria-hidden="true"
                  />
                </button>
              </div>
            </div>
            <button class="group flex items-end gap-2 border rounded-lg px-4 py-2 w-fit hover:bg-black hover:text-white" type="button" @click="addAddress">
              <h4 class="text-sm">Crear otra dirección</h4>
              <PlusCircleIcon
                class="h-5 w-5 text-black group-hover:text-white"
                aria-hidden="true"
              />
            </button>
          </div>
          <!-- Fin Direcciones -->
          <hr class="my-4">
          <!-- Inicio Horarios-->
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Horarios de Atención</h3>

            <div
              v-for="(dia, index) in diasSemana"
              :key="dia.key"
              class="flex flex-wrap md:flex-nowrap gap-4 items-center"
            >
              <!-- Checkbox del día -->
              <label class="flex items-center gap-2 w-full md:w-2/12">
                <input
                  type="checkbox"
                  :value="dia.key"
                  :checked="getHorario(dia.key) !== undefined"
                  @change="toggleDia(dia.key)"
                  class="form-checkbox h-4 w-4 text-blue-600"
                />
                <span class="text-sm">{{ dia.text }}</span>
              </label>

              <template v-if="getHorario(dia.key)">
                <CustomInput
                  v-model="getHorario(dia.key).apertura"
                  type="time"
                  class="w-5/12 md:w-2/12"
                  label="Apertura"
                  :errors="errors[`horarios.${index}.apertura`]"
                />
                <CustomInput
                  v-model="getHorario(dia.key).cierre"
                  type="time"
                  class="w-5/12 md:w-2/12"
                  label="Cierre"
                  :errors="errors[`horarios.${index}.cierre`]"
                />
              </template>
            </div>
            
          </div>
          <!-- Fin Horarios-->

          <!-- Inicio Información de contacto -->
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Información de contacto</h3>
            <div v-for="(contact, index) in product.contacts" :key="index" class="flex gap-1">
              <CustomInput 
                v-model="contact.type" 
                type="select" 
                class="mb-2 w-4/12" 
                label="Contact" 
                :select-options="[
                  { key: 'fijo', text: 'Teléfono Fijo' },
                  { key: 'móvil', text: 'Teléfono Móvil' },
                  { key: 'whatsapp', text: 'Whatsapp' },
                  { key: 'email', text: 'E-Mail' }
                ]" 
                :errors="errors[`contacts.${index}.type`]" 
              />
              <CustomInput 
                v-model="contact.info" 
                type="text" 
                class="mb-2 w-7/12" 
                label="Info" 
                :errors="errors[`contacts.${index}.info`]" 
              />
              <div class="w-1/12 flex items-center justify-center">
                <button class="group border-0 rounded-full hover:bg-black" v-if="product.contacts.length > 1" @click.prevent="removeContact(index)">
                  <TrashIcon
                    class="h-5 w-5 text-black group-hover:text-white"
                    aria-hidden="true"
                  />
                </button>
              </div>
            </div>
            <button class="group flex items-end gap-2 border rounded-lg px-4 py-2 w-fit hover:bg-black hover:text-white" type="button" @click="addContact">
              <h4 class="text-sm">New Contact</h4>
              <PlusCircleIcon
                class="h-5 w-5 text-black group-hover:text-white"
                aria-hidden="true"
              />
            </button>
          </div>
          <!-- Fin información de contacto-->
          <!-- Inicio Página web -->
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Página web</h3>
            <div v-for="(web, index) in product.webs" :key="index" class="flex gap-1">
              <CustomInput 
                v-model="web.webpage" 
                type="text" 
                class="mb-2 w-7/12" 
                label="Página web" 
                :errors="errors[`webs.${index}.webpage`]" 
              />
              <div class="w-1/12 flex items-center justify-center">
                <button class="group border-0 rounded-full hover:bg-black" v-if="product.webs.length > 1" @click.prevent="removeWeb(index)">
                  <TrashIcon
                    class="h-5 w-5 text-black group-hover:text-white"
                    aria-hidden="true"
                  />
                </button>
              </div>
            </div>
            <button class="group flex items-end gap-2 border rounded-lg px-4 py-2 w-fit hover:bg-black hover:text-white" type="button" @click="addWeb">
              <h4 class="text-sm">Crear nueva página</h4>
              <PlusCircleIcon
                class="h-5 w-5 text-black group-hover:text-white"
                aria-hidden="true"
              />
            </button>
          </div>
          <!-- Fin Página web -->
          <!-- Inicio RRSS -->
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Redes Sociales</h3>
            <div v-for="(social, index) in product.socials" :key="index" class="flex gap-1">
              <CustomInput 
                v-model="social.rrss" 
                type="select" 
                class="mb-2 w-4/12" 
                label="Social" 
                :select-options="[
                  { key: 'instagram', text: 'Instagram' },
                  { key: 'facebook', text: 'Facebook' },
                  { key: 'youtube', text: 'Youtube' },
                  { key: 'tiktok', text: 'Tik Tok' }
                ]" 
                :errors="errors[`socials.${index}.rrss`]" 
              />
              <CustomInput 
                v-model="social.link" 
                type="text" 
                class="mb-2 w-7/12" 
                label="Link" 
                :errors="errors[`socials.${index}.link`]" 
              />
              <div class="w-1/12 flex items-center justify-center">
                <button class="group border-0 rounded-full hover:bg-black" v-if="product.socials.length > 1" @click.prevent="removeSocial(index)">
                  <TrashIcon
                    class="h-5 w-5 text-black group-hover:text-white"
                    aria-hidden="true"
                  />
                </button>
              </div>
            </div>
            <button class="group flex items-end gap-2 border rounded-lg px-4 py-2 w-fit hover:bg-black hover:text-white" type="button" @click="addSocial">
              <h4 class="text-sm">Crear nueva red</h4>
              <PlusCircleIcon
                class="h-5 w-5 text-black group-hover:text-white"
                aria-hidden="true"
              />
            </button>
          </div>
          <!-- Fin RRSS -->
          
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Destacado en Home</h3>
            <CustomInput type="checkbox" class="mb-2" v-model="product.leading_home" label="Leading Home" :errors="errors['leading_home']"/>
          </div>
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Destacado en Categoría principal</h3>
            <CustomInput type="checkbox" class="mb-2" v-model="product.leading_category" label="Leading Category" :errors="errors['leading_category']"/>
          </div>
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Atiende Urgencias</h3>
            <CustomInput type="checkbox" class="mb-2" v-model="product.urgencies" label="Urgencies" :errors="errors['urgencies']"/>
          </div>
          <hr class="my-4">
          <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Publicado</h3>
            <CustomInput type="checkbox" class="mb-2" v-model="product.published" label="Published" :errors="errors['published']"/>
          </div>
        </div>
        <div class="col-span-1 px-4 pt-5 pb-4">
          <image-preview v-model="product.images"
                          :images="product.images"
                          v-model:deleted-images="product.deleted_images"
                          v-model:image-positions="product.image_positions"/>
        </div>
      </div>
      <footer class="bg-gray-50 rounded-b-lg px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="submit"
                class="bg-black text-base font-medium text-white border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-black/10 hover:text-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-black sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
          Guardar
        </button>
        <button type="button"
                @click="onSubmit($event, true)"
                class="bg-black text-base font-medium text-white border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-black/10 hover:text-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-black sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
          Guardar & Cerrar
        </button>
        <router-link :to="{name: 'app.products'}"
                      class="bg-white text-base font-medium text-gray-700 border rounded-md border-gray-300 shadow-sm w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-gray-300 sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm"
                      ref="cancelButtonRef">
          Cancelar
        </router-link>
      </footer>
    </form>
  </div>
</template>
<style>
select option[value=""] {
  color: gray !important; /* Cambia el color a gris */
}
</style>
<script setup>
import {onMounted, ref} from 'vue'
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";
import {useRoute, useRouter} from "vue-router";
import ImagePreview from "../../components/ImagePreview.vue";
import {PlusCircleIcon, TrashIcon} from '@heroicons/vue/24/solid';
// import the component
import Treeselect from 'vue3-treeselect'
// import the styles
import 'vue3-treeselect/dist/vue3-treeselect.css'
import axiosClient from "../../axios.js";

const route = useRoute()
const router = useRouter()

const product = ref({
  id: null,
  title: null,
  short_description: '',
  description: '',
  leading_home: false,
  leading_category: false,
  client_number : '',
  urgencies: false,
  published: false,
  categories: [],
  images: [],
  deleted_images: [],
  image_positions: {},
  contacts: [{ type: '', info: '' }],
  socials: [{ rrss: '', link: '' }],
  addresses: [{ title: '', via: '' , via_name: '' , via_number: '' , address_unit: '' , city: '' , zip_code: '' , province: '', link: '', google_maps: '' }],
  tags:[],
  horarios: [{ dia: '', apertura: '', cierre: ''}],
  webs: [{ webpage: '' }],
  listitems: [{ item: '' }],
})

const diasSemana = [
  { key: 'lunes', text: 'Lunes' },
  { key: 'martes', text: 'Martes' },
  { key: 'miércoles', text: 'Miércoles' },
  { key: 'jueves', text: 'Jueves' },
  { key: 'viernes', text: 'Viernes' },
  { key: 'sábado', text: 'Sábado' },
  { key: 'domingo', text: 'Domingo' },
];

// Buscar un horario por día
function getHorario(diaKey) {
  return product.value.horarios.find(h => h.dia === diaKey);
}

// Alternar selección de día
function toggleDia(diaKey) {
  const index = product.value.horarios.findIndex(h => h.dia === diaKey);
  if (index === -1) {
    product.value.horarios.push({ dia: diaKey, apertura: '', cierre: '' });
  } else {
    product.value.horarios.splice(index, 1);
  }
}

const errors = ref({});

const loading = ref(false);
const categoriesOptions = ref([]);
const tagsOptions = ref([]);

const emit = defineEmits(['update:modelValue', 'close'])

onMounted(() => {
  if (route.params.id) {
    loading.value = true
    store.dispatch('getProduct', route.params.id)
      .then((response) => {
        loading.value = false;
        product.value = response.data;
        if (!product.value.contacts.length) {
          product.value.contacts.push({ type: '', info: '' });
        }
        if (!product.value.socials.length) {
          product.value.socials.push({ rrss: '', link: '' });
        }
        if (!product.value.addresses.length) {
          product.value.addresses.push({ title: '', via: '' , via_name: '' , via_number: '' , address_unit: '' , city: '' , zip_code: '' , province: '', link: '', google_maps: ''  });
        }
        if (product.value && Array.isArray(product.value.horarios) && product.value.horarios.length === 0) {
          product.value.horarios.push({ dia: '', apertura: '', cierre: '' });
        }
        if (!product.value.webs.length) {
          product.value.webs.push({ webpage: '' });
        }
        if (!product.value.listitems.length) {
          product.value.listitems.push({ item: '' });
        }
      })
  }
  
  axiosClient.get('/categories/tree')
  .then(result => {
    categoriesOptions.value = result.data.sort((a, b) => a.label.localeCompare(b.label));
  })
  
  axiosClient.get('/tags/tree')
  .then(result => {
    tagsOptions.value = result.data.sort((a, b) => a.label.localeCompare(b.label));
  })

})

// Contact Info
function addContact() {
  product.value.contacts.push({ type: '', info: '' });
}

function removeContact(index) {
  product.value.contacts.splice(index, 1);
  if (product.value.contacts.length === 0) {
    addContact(); 
  }
}
// Fin Contact Info
// Social Media
function addSocial() {
  product.value.socials.push({ rrss: '', link: '' });
}

function removeSocial(index) {
  product.value.socials.splice(index, 1);
  if (product.value.socials.length === 0) {
    addSocial(); 
  }
}
// End Social Media

// Addresses
function addAddress() {
  product.value.addresses.push({ title: '', via: '' , via_name: '' , via_number: '' , address_unit: '' , city: '' , zip_code: '' , province: '' , link: '', google_maps: '' });
}

function removeAddress(index) {
  product.value.addresses.splice(index, 1);
  if (product.value.addresses.length === 0) {
    addAddress(); 
  }
}
// End Addresses

// Página web
function addWeb() {
  product.value.webs.push({ webpage: '' });
}

function removeWeb(index) {
  product.value.webs.splice(index, 1);
  if (product.value.webs.length === 0) {
    addWeb(); 
  }
}
// End Página web

// Listado de Items
function addListitem() {
  product.value.listitems.push({ item: '' });
}

function removeListitem(index) {
  product.value.listitems.splice(index, 1);
  if (product.value.listitems.length === 0) {
    addListitem(); 
  }
}
// End Listado de Items

function onSubmit($event, close = false) {
  loading.value = true
  errors.value = {};
  product.value.contacts = product.value.contacts.filter(
    (contact) => contact.type !== '' && contact.info !== ''
  );
  product.value.socials = product.value.socials.filter(
    (social) => social.rrss !== '' && social.link !== ''
  );
  product.value.addresses = product.value.addresses.filter(
    (address) => Object.values(address).some(value => value !== '')
  );
  product.value.horarios = product.value.horarios.filter(
    (horario) => Object.values(horario).some(value => value !== '')
  );
  product.value.webs = product.value.webs.filter(
    (web) => web.webpage !== ''
  );
  product.value.listitems = product.value.listitems.filter(
    (listitem) => listitem.item !== ''
  );
  if (product.value.id) {
    store.dispatch('updateProduct', product.value)
      .then(response => {
        loading.value = false;
        if (response.status === 200) {
          product.value = response.data
          store.commit('showToast', 'Product was successfully updated');
          store.dispatch('getProducts')
          if (close) {
            router.push({name: 'app.products'})
          }
        }
      })
      .catch(err => {
        loading.value = false;
        errors.value = err.response.data.errors
      })
  } else {
    store.dispatch('createProduct', product.value)
      .then(response => {
        loading.value = false;
        if (response.status === 201) {
          product.value = response.data
          store.commit('showToast', 'Product was successfully created');
          store.dispatch('getProducts')
          if (close) {
            router.push({name: 'app.products'})
          } else {
            product.value = response.data
            router.push({name: 'app.products.edit', params: {id: response.data.id}})
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
  