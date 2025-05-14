<template>
  <div>
      <div class="flex flex-col md:flex-row justify-between mb-3 w-full gap-4">
          <h1 class="text-3xl font-semibold">Categories</h1>
          <div class="flex gap-8">
          <DownloadCategoryList />
            <router-link type="button" :to="{name: 'app.categories.create'}"
                          class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:text-black hover:bg-white focus:outline-none text-center"
            >
            Add new Category
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
import DownloadCategoryList from "./DownloadCategoryList.vue";

const categories = computed(() => store.state.categories);
</script>