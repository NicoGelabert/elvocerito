<template>
    <div class="relative flex">
      <!-- Botón de información -->
      <button
        type="button"
        @click="toggleTooltip"
        class="text-gray-500 hover:text-gray-700 focus:outline-none"
      >
        <!-- Icono de información -->
        <InformationCircleIcon class="w-5 h-5" />
      </button>
  
      <!-- Contenido del tooltip -->
      <div
        v-if="showTooltip"
        ref="tooltipRef"
        class="absolute right-8 z-10 w-96 p-2 mt-1 text-sm text-white bg-gray-800 rounded-lg shadow-lg"
      >
        <!-- Botón de cierre dentro del tooltip -->
        <button
          type="button"
          @click="closeTooltip"
          class="absolute top-0 right-0 m-2 text-white hover:text-gray-400 focus:outline-none"
        >
          <CloseIcon class="w-4 h-4" />
        </button>
        <span v-html="content"></span>
      </div>
    </div>
  </template>
  
  <script>
  import { InformationCircleIcon, XMarkIcon as CloseIcon } from '@heroicons/vue/24/outline';
  
  export default {
    name: "Tooltip",
    components: {
      InformationCircleIcon,
      CloseIcon,
    },
    props: {
      content: {
        type: String,
        required: true,
      },
    },
    data() {
      return {
        showTooltip: false,
      };
    },
    methods: {
      toggleTooltip() {
        this.showTooltip = !this.showTooltip;
      },
      closeTooltip() {
        this.showTooltip = false;
      },
      handleClickOutside(event) {
        // Verificar si el clic ocurrió fuera del tooltip
        if (this.showTooltip && this.$el && !this.$el.contains(event.target)) {
          this.showTooltip = false;
        }
      },
    },
    mounted() {
      // Agregar el event listener para cerrar el tooltip al hacer clic fuera
      document.addEventListener("click", this.handleClickOutside);
    },
    beforeDestroy() {
      // Remover el event listener al destruir el componente
      document.removeEventListener("click", this.handleClickOutside);
    },
  };
  </script>
  