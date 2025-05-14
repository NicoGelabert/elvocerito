<template>
  <button @click="downloadExcel">Descargar Excel</button>
</template>

<script setup>
import axiosClient from '../../axios' ;  // <-- Correcto: tu cliente configurado

const downloadExcel = async () => {
  try {
    const response = await axiosClient.get('/export-products', {
      responseType: 'blob'  // Correcto para descargar archivos binarios
    });

    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'productos.xlsx');
    document.body.appendChild(link);
    link.click();
  } catch (error) {
    console.error("Error descargando productos:", error);
  }
};
</script>
