<template>
    <div>
        <div class="flex flex-col md:flex-row justify-between mb-3 w-full gap-4">
            <h1 class="text-3xl font-semibold">Faqs</h1>
            <router-link :to="{name: 'app.faqs.create'}"
                          class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:text-black hover:bg-white focus:outline-none text-center"
            >
            Crear nueva Pregunta
            </router-link>
        </div>
        <FaqsTable/>
    </div>
  
  </template>
  
  <script setup>
  import {computed} from "vue";
  import store from "../../store";
  import FaqsTable from "./FaqsTable.vue";
  
  const faqs = computed(() => store.state.faqs);
  </script>