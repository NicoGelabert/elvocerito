<template>
    <div>
        <div class="flex justify-between mb-3">
            <h1 class="text-3xl font-semibold">Projects</h1>
            <router-link :to="{name: 'app.projects.create'}"
                          class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:text-black hover:bg-white focus:outline-none"
            >
            Add new Project
            </router-link>
        </div>
        <ProjectsTable/>
    </div>
  
  </template>
  
  <script setup>
  import {computed} from "vue";
  import store from "../../store";
  import ProjectsTable from "./ProjectsTable.vue";
  
  const projects = computed(() => store.state.projects);
  </script>