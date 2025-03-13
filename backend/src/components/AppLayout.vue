<template>
  <div class="min-h-screen bg-gray-100 flex flex-col">

        <!-- Navbar content start -->
        <Navbar></Navbar>
        <!-- Navbar content end -->

      <div class="flex w-full" >

        <!-- Sidebar start -->
        <Sidebar @toggle-sidebar="toggleSidebar" :class="{'-ml-[22%] md:-ml-[15%] lg:-ml-[19.5%]': !sidebarOpened}"/>
        <!-- Sidebar end -->

        <main class="p-6 px-2 md:px-6 w-full">
            <router-view></router-view>
        </main>

      </div>

  </div>
  <!-- <div class="min-h-full bg-gray-200 flex items-center justify-center">
      <Spinner />
      <Toast />
  </div> -->

</template>

<script setup>
import {ref, computed, onMounted, onUnmounted} from 'vue'
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
import store from "../store";
import Spinner from "./core/Spinner.vue";
import Toast from "./core/Toast.vue";

const {title} = defineProps({
  title: String
})
const sidebarOpened = ref(true);
const currentUser = computed(() => store.state.user.data);

function toggleSidebar() {
  sidebarOpened.value = !sidebarOpened.value
}

function updateSidebarState() {
  sidebarOpened.value = window.outerWidth > 768;
}

onMounted(() => {
  store.dispatch('getCurrentUser')
  store.dispatch('getCountries')
  updateSidebarState();
  window.addEventListener('resize', updateSidebarState)
})

onUnmounted(() => {
  window.removeEventListener('resize', updateSidebarState)
})

</script>

<style scoped>

</style>