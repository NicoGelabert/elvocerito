<template>
  <div class="flex flex-col items-center justify-center">
    <button @click="downloadExcel" class="flex items-center gap-2 p-2 text-xs bg-gray-200 border border-gray-300 rounded-md text-gray-700">
      Descargar Tags
      <ArrowDownTrayIcon class="h-3 w-3" />
    </button>
  </div>
</template>

<script setup>
import { ArrowDownTrayIcon } from '@heroicons/vue/24/outline';
import axiosClient from '../../axios';

const downloadExcel = async () => {
  try {
    const response = await axiosClient.get('/export-tags', {
      responseType: 'blob'
    });

    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'tags.xlsx');
    document.body.appendChild(link);
    link.click();
  } catch (error) {
    console.error("Error descargando tags:", error);
  }
};
</script>
