<template>
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Clients</h1>
      <button type="button"
              @click="showAddNewModal()"
              class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Add new Client
      </button>
    </div>
    <ClientsTable @clickEdit="editClient"/>
    <ClientModal v-model="showClientModal" :client="clientModel" @close="onModalClose"/>
</template>
  
<script setup>
import {computed, onMounted, ref} from "vue";
import store from "../../store";
import ClientsTable from "./ClientsTable.vue";
import ClientModal from "./ClientModal.vue";

const DEFAULT_CLIENT = {
    id: '',
    name: '',
    description: '',
    image: '',
}

const clients = computed(() => store.state.clients);
console.log(clients)
const clientModel = ref({...DEFAULT_CLIENT})
const showClientModal = ref(false);

function showAddNewModal() {
    showClientModal.value = true
}

function editClient(c) {
    clientModel.value = c;
    showAddNewModal();
}

function onModalClose() {
    clientModel.value = {...DEFAULT_CLIENT}
}
</script>
  