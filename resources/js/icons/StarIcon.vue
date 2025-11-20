<template>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4">
    <!-- Estrella de fondo gris -->
    <path
      fill="#D1D5DB"
      d="M12 17.27L18.18 21l-1.64-7.03
         L22 9.24l-7.19-.61L12 2 9.19 8.63
         2 9.24l5.46 4.73L5.82 21z"
    />

    <!-- Estrella amarilla completa -->
    <path
      v-if="!half"
      :class="class"
      d="M12 17.27L18.18 21l-1.64-7.03
         L22 9.24l-7.19-.61L12 2 9.19 8.63
         2 9.24l5.46 4.73L5.82 21z"
    />

    <!-- Media estrella -->
    <clipPath id="half">
      <rect x="0" y="0" width="12" height="24"/>
    </clipPath>
    <path
      v-if="half"
      :class="class"
      clip-path="url(#half)"
      d="M12 17.27L18.18 21l-1.64-7.03
         L22 9.24l-7.19-.61L12 2 9.19 8.63
         2 9.24l5.46 4.73L5.82 21z"
    />
  </svg>
</template>

<script>
export default {
  props: {
    fill: { type: String, default: 'gray' }, // 'yellow' o 'gray'
    half: { type: Boolean, default: false }   // true = media estrella
  }
};
</script>
