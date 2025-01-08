<template>
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Alergens</h1>
    <button type="button"
            @click="showAddNewModal()"
            class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      Add new Alergen
    </button>
  </div>
  <AlergensTable @clickEdit="editAlergen"/>
  <AlergenModal v-model="showAlergenModal" :alergen="alergenModel" @close="onModalClose"/>
</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import store from "../../store";
import AlergensTable from "./AlergensTable.vue";
import AlergenModal from "./AlergenModal.vue";

const DEFAULT_ALERGEN = {
  id: '',
  name: '',
  description: '',
  image: '',
}

const alergens = computed(() => store.state.alergens);
console.log(alergens)
const alergenModel = ref({...DEFAULT_ALERGEN})
const showAlergenModal = ref(false);

function showAddNewModal() {
  showAlergenModal.value = true
}

function editAlergen(a) {
    alergenModel.value = a;
    showAddNewModal();
}

function onModalClose() {
  alergenModel.value = {...DEFAULT_ALERGEN}
}
</script>

<style scoped>

</style>
