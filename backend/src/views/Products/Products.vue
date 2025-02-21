<template>
  <div>
      <div class="flex justify-between mb-3">
          <h1 class="text-3xl font-semibold">Anunciantes</h1>
          <router-link :to="{name: 'app.products.create'}"
                        class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:text-black hover:bg-white focus:outline-none"
          >
          Crear Nuevo Anunciante
          </router-link>
      </div>
      <ProductsTable/>
  </div>

</template>

<script setup>
import {computed} from "vue";
import store from "../../store";
import ProductsTable from "./ProductsTable.vue";

const products = computed(() => store.state.products);
</script>