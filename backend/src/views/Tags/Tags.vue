<template>
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Tags</h1>
      <button type="button"
              @click="showAddNewModal()"
              class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Add new Tag
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
  