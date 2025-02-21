<template>
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Tags</h1>
      <button type="button"
              @click="showAddNewModal()"
              class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:text-black hover:bg-white focus:outline-none"
      >
        Crear nuevo Tag
      </button>
    </div>
    <TagsTable @clickEdit="editTag"/>
    <TagModal v-model="showTagModal" :tag="tagModel" @close="onModalClose"/>
</template>
  
<script setup>
import {computed, onMounted, ref} from "vue";
import store from "../../store";
import TagsTable from "./TagsTable.vue";
import TagModal from "./TagModal.vue";

const DEFAULT_TAG = {
    id: '',
    name: '',
    description: '',
    image: '',
}

const tags = computed(() => store.state.tags);
console.log(tags)
const tagModel = ref({...DEFAULT_TAG})
const showTagModal = ref(false);

function showAddNewModal() {
    showTagModal.value = true
}

function editTag(t) {
    tagModel.value = t;
    showAddNewModal();
}

function onModalClose() {
    tagModel.value = {...DEFAULT_TAG}
}
</script>
  