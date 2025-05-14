<template>
  <div class="mb-2 flex flex-col md:flex-row justify-between">
    <h1 class="text-3xl font-semibold">Dashboard</h1>
    <div class="flex flex-col md:flex-row itens-start md:items-center">
      <label class="mr-2">Cambiar período</label>
      <CustomInput type="select" v-model="chosenDate" @change="onDatePickerChange" :select-options="dateOptions"/>
    </div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
    <!--    Total Products -->
    <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow "
    style="animation-delay: 0.1s">
      <router-link :to="{name: 'app.products'}" class="flex flex-col items-center justify-center mb-2">
        <label class="text-lg font-semibold block mb-2 text-center">Anunciantes totales</label>
        <template v-if="!loading.totalProductsCount">
          <span class="text-3xl font-semibold">{{ totalProductsCount }}</span>
        </template>
        <Spinner v-else text="" class=""/>
      </router-link>
      <DownloadProductList/>
    </div>
    <!--/    Total Products -->
    <!--    Active Products -->
    <router-link :to="{name: 'app.products'}">
      <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center"
           style="animation-delay: 0.1s">
        <label class="text-lg font-semibold block mb-2">Anunciantes activos</label>
        <template v-if="!loading.activeProductsCount">
          <span class="text-3xl font-semibold">{{ activeProductsCount }}</span>
        </template>
        <Spinner v-else text="" class=""/>
      </div>
    </router-link>
    <!--/    Active Products -->
    <!--    Active Categories -->
    <router-link :to="{name: 'app.categories'}">
      <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center"
           style="animation-delay: 0.1s">
        <label class="text-lg font-semibold block mb-2">Categorías activas</label>
        <template v-if="!loading.activeCategoriesCount">
          <span class="text-3xl font-semibold">{{ activeCategoriesCount }}</span>
        </template>
        <Spinner v-else text="" class=""/>
      </div>
    </router-link>
    <!--/    Active Categories -->
  </div>

  <div class="grid grid-rows-1 md:grid-rows-2 md:grid-flow-col grid-cols-1 md:grid-cols-3 gap-3">
    <div class="col-span-1 md:col-span-1 row-span-1 md:row-span-2 bg-white py-6 px-5 rounded-lg shadow">
      <label class="text-lg font-semibold block mb-2">Últimos anunciantes</label>
      <template v-if="!loading.latestProducts">
        <router-link :to="{name: 'app.products.edit', params: {id: p.id}}" v-for="p of latestProducts" :key="`product-${p.id}`"
                     class="mb-3 flex gap-4">
          <div class="w-12 h-12 bg-gray-200 flex items-center justify-center rounded-full mr-2">
            <img :src="p.images.length ? p.images[0].url : '../../assets/noimage.png'" alt="Imagen del producto" class="aspect-square object-cover" :key="p.images[0]?.url || 'no-image'">
          </div>
          <div>
            <h3>{{ p.title }}</h3>
            <p>{{ new Date(p.created_at).toLocaleString('es-ES', { dateStyle: 'long', timeStyle: 'short' }) }}</p>
          </div>
        </router-link>
      </template>
      <Spinner v-else text="" class=""/>
    </div>
    <div class="col-span-1 md:col-span-1 row-span-1 md:row-span-2 bg-white py-6 px-5 rounded-lg shadow">
      <label class="text-lg font-semibold block mb-2">Categorías Populares</label>
      <template v-if="!loading.popularCategoriesCount">
        <div class="mb-3 flex gap-4 items-center" v-for="c of popularCategoriesCount" :key="c.id">
          <div class="w-12 h-12 bg-gray-200 flex items-center justify-center rounded-full mr-2">
            <img :src="c.image" alt="Imagen de la categoría" class="aspect-square object-cover">
          </div>
          <div>
            <h3>{{ c.name }}</h3>
          </div>
        </div>
      </template>
      <Spinner v-else text="" class=""/>
    </div>
  </div>

</template>

<script setup>
import {UserIcon} from '@heroicons/vue/24/outline'
import DoughnutChart from '../components/core/Charts/Doughnut.vue'
import axiosClient from "../axios.js";
import {computed, onMounted, ref} from "vue";
import Spinner from "../components/core/Spinner.vue";
import DownloadProductList from "./Products/DownloadProductList.vue";
import CustomInput from "../components/core/CustomInput.vue";
import {useStore} from "vuex";

const store = useStore();
const dateOptions = computed(() => store.state.dateOptions);
const chosenDate = ref('all')

const loading = ref({
  totalProductsCount: true,
  activeProductsCount: true,
  latestProducts: true,
  activeCategoriesCount: true,
  popularCategoriesCount: true,
  // customersCount: true,
  // paidOrders: true,
  // totalIncome: true,
  // ordersByCountry: true,
  // latestCustomers: true,
  // latestOrders: true
})
const totalProductsCount = ref(0);
const activeProductsCount = ref(0);
const latestProducts = ref([]);
const activeCategoriesCount = ref(0);
const popularCategoriesCount = ref([]);
// const customersCount = ref(0);
// const paidOrders = ref(0);
// const totalIncome = ref(0);
// const ordersByCountry = ref([]);
// const latestCustomers = ref([]);
// const latestOrders = ref([]);

function updateDashboard() {
  const d = chosenDate.value
  loading.value = {
    totalProductsCount: true,
    activeProductsCount: true,
    latestProducts: true,
    activeCategoriesCount: true,
    popularCategoriesCount: true,
    // customersCount: true,
    // paidOrders: true,
    // totalIncome: true,
    // ordersByCountry: true,
    // latestCustomers: true,
    // latestOrders: true
  }
  axiosClient.get(`/dashboard/total-products-count`, {params: {d}}).then(({data}) => {
    totalProductsCount.value = data;
    loading.value.totalProductsCount = false;
  })
  axiosClient.get(`/dashboard/active-products-count`, {params: {d}}).then(({data}) => {
    activeProductsCount.value = data;
    loading.value.activeProductsCount = false;
  })
  axiosClient.get(`/dashboard/latest-products`, {params: {d}}).then(({data}) => {
    latestProducts.value = data;
    loading.value.latestProducts = false;
  })
  axiosClient.get(`/dashboard/active-categories-count`, {params: {d}}).then(({data}) => {
    activeCategoriesCount.value = data;
    loading.value.activeCategoriesCount = false;
  })
  axiosClient.get(`/dashboard/popular-categories`, {params: {d}}).then(({data}) => {
    popularCategoriesCount.value = data;
    loading.value.popularCategoriesCount = false;
  })
  // axiosClient.get(`/dashboard/customers-count`, {params: {d}}).then(({data}) => {
  //   customersCount.value = data
  //   loading.value.customersCount = false;
  // })
  // axiosClient.get(`/dashboard/orders-count`, {params: {d}}).then(({data}) => {
  //   paidOrders.value = data;
  //   loading.value.paidOrders = false;
  // })
  // axiosClient.get(`/dashboard/income-amount`, {params: {d}}).then(({data}) => {
  //   totalIncome.value = new Intl.NumberFormat('en-US', {
  //     style: 'currency',
  //     currency: 'USD',
  //     minimumFractionDigits: 0
  //   })
  //     .format(data);
  //   loading.value.totalIncome = false;
  // })

  // axiosClient.get(`/dashboard/orders-by-country`, {params: {d}}).then(({data: countries}) => {
  //   loading.value.ordersByCountry = false;
  //   const chartData = {
  //     labels: [],
  //     datasets: [{
  //       backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
  //       data: []
  //     }]
  //   }
  //   countries.forEach(c => {
  //     chartData.labels.push(c.name);
  //     chartData.datasets[0].data.push(c.count);
  //   })
  //   ordersByCountry.value = chartData
  // })
  
//   axiosClient.get(`/dashboard/latest-customers`, {params: {d}}).then(({data: customers}) => {
//     latestCustomers.value = customers;
//     loading.value.latestCustomers = false;
//   })
//   axiosClient.get(`/dashboard/latest-orders`, {params: {d}}).then(({data: orders}) => {
//     latestOrders.value = orders.data;
//     loading.value.latestOrders = false;
//   })
}

function onDatePickerChange() {
  updateDashboard()
}

onMounted(() => updateDashboard())
</script>

<style scoped>

</style>
