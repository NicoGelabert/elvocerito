<template>
  <div class="flex flex-col items-center justify-center">
    <button
      @click="downloadExcel"
      class="flex items-center gap-2 p-2 text-xs bg-gray-200 border border-gray-300 rounded-md text-gray-700"
    >
      {{ label }}
      <ArrowDownTrayIcon class="h-3 w-3" />
    </button>
  </div>
</template>

<script setup>
import { ArrowDownTrayIcon } from '@heroicons/vue/24/outline';
import axiosClient from '../axios';

const props = defineProps({
  url: {
    type: String,
    required: true
  },
  filename: {
    type: String,
    required: true
  },
  label: {
    type: String,
    default: 'Descargar Excel'
  }
});

const downloadExcel = async () => {
  try {
    const response = await axiosClient.get(props.url, {
      responseType: 'blob'
    });

    const blob = new Blob([response.data]);
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', props.filename);
    document.body.appendChild(link);
    link.click();
  } catch (error) {
    console.error(`Error descargando ${props.filename}:`, error);
  }
};
</script>
