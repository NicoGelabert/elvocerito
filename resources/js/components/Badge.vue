<template>
  <span :class="['badge', badgeClass]">
    <slot></slot>
  </span>
</template>

<script setup>
import { computed, defineProps } from 'vue'

const props = defineProps({
  status: {
    type: String,
    default: '', // "Disponible" o "No Disponible"
  },
})

const badgeClass = computed(() => {
  switch (props.status) {
    case 'Disponible':
      return 'open'
    case 'No Disponible':
      return 'closed'
    default:
      return ''
  }
})
</script>

<style scoped>
.badge {
  @apply inline-flex items-center justify-center px-2 py-1 rounded-md text-sm font-semibold min-w-[80px] transition-all;
}

/* OPEN */
.open {
  @apply bg-lime-200 shadow-2xl;
}

.open svg {
  @apply w-3 h-auto fill-lime-400 drop-shadow-[0_0_10px_#a3e635];
}

/* CLOSED */
.closed {
  @apply bg-red-200 shadow-md text-red-800;
}

/* Animaciones */
.badge-enter-active,
.badge-leave-active {
  transition: opacity 0.3s, transform 0.3s;
}
.badge-enter-from,
.badge-leave-to {
  opacity: 0;
  transform: scale(0.8);
}
</style>
