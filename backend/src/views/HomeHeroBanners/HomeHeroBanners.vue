<template>
    <div>
        <div class="flex flex-col md:flex-row justify-between mb-3 w-full gap-4">
            <h1 class="text-3xl font-semibold">Home Hero Banner</h1>
            <button type="button"
                  @click="showAddNewModal()"
                  class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:text-black hover:bg-white focus:outline-none"
                  >
                  Add new image
            </button>
        </div>
        <HomeHeroBannersTable @clickEdit="editHomeHeroBanner"/>
        <HomeHeroBannerModal v-model="showHomeHeroBannerModal" :homeHeroBanner="homeHeroBannerModel" @close="onModalClose"/>
    </div>
</template>

<script setup>
import {computed, ref} from "vue";
import store from "../../store";
import HomeHeroBannersTable from "./HomeHeroBannersTable.vue";
import HomeHeroBannerModal from "./HomeHeroBannerModal.vue";

const DEFAULT_HOMEHEROBANNER = {
    id:'',
    image: '',
    headline: '',
    description: '',
    link: '',
}

const homeherobanners = computed(() => store.state.homeHeroBanners);

const homeHeroBannerModel = ref({...DEFAULT_HOMEHEROBANNER});
const showHomeHeroBannerModal = ref(false);

function showAddNewModal(){
    showHomeHeroBannerModal.value = true
}

function editHomeHeroBanner(h){
    store.dispatch('getHomeHeroBanner', h.id)
    .then(({data}) => {
        homeHeroBannerModel.value = data
        showAddNewModal(); 
    })
}

function onModalClose(){
    homeHeroBannerModel.value = {...DEFAULT_HOMEHEROBANNER}
}

</script>