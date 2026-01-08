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
    case 'Urgencias':
      return 'urgencies'
    case 'De Turno':
      return 'de_turno'
    default:
      return ''
  }
})
</script>

<style scoped>
.badge {
  @apply inline-flex items-center justify-center px-2 py-1 rounded-md text-sm leading-none font-semibold transition-all shadow-sm;
}

/* OPEN */
.open {
  @apply bg-lime-200;
}

.open svg {
  @apply w-3 h-auto fill-lime-400 drop-shadow-[0_0_10px_#a3e635];
}

/* CLOSED */
.closed {
  @apply bg-red-200 text-red-800;
}

.urgencies{
  @apply bg-red-200 text-red-800;
}

.de_turno{
  @apply bg-cyan-200 text-cyan-800;
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
