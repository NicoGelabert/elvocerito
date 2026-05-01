<template>
  <div>
      <div class="flex flex-col md:flex-row justify-between mb-3 w-full gap-4">
          <h1 class="text-3xl font-semibold">Categorías</h1>
          <div class="flex gap-8">
            <ExportButton
              url="/export-categories"
              filename="categorias.xlsx"
              label="Descargar Categorías"
            />
            <router-link type="button" :to="{name: 'app.categories.create'}"
                          class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:text-black hover:bg-white focus:outline-none text-center"
            >
            Crear nueva categoría
            </router-link>
          </div> 
      </div>
      <CategoriesTable/>
  </div>

</template>

<script setup>
import {computed} from "vue";
import store from "../../store";
import CategoriesTable from "./CategoriesTable.vue";
import ExportButton from "../../components/ExportButton.vue";

const categories = computed(() => store.state.categories);
</script>