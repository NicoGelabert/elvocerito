<template>
  <div v-if="average" class="flex items-center justify-center space-x-1">

      
      <!-- Estrellas -->
      <div class="flex">
          <StarIcon
          v-for="n in 5"
          :key="n"
          :class="getStarFill(n)"
          :half="isHalfStar(n)"
          />
        </div>
        <!-- Número -->
        <span class="font-semibold text-xs text-gray-500">{{ average }}</span>

  </div>
  <!-- Si no hay promedio, no muestra nada -->
</template>

<script>
import axios from 'axios';
import StarIcon from '@/icons/StarIcon.vue';

export default {
  components: { StarIcon },
  props: {
    productId: { type: Number, required: true }
  },
  data() {
    return {
      average: null
    };
  },
  async mounted() {
    const res = await axios.get(`/products/${this.productId}/rating-average`);
    this.average = res.data.average; // null si no hay ratings
  },
  methods: {
    // Devuelve color de la estrella según el promedio
    getStarFill(position) {
      if (this.average >= position) return 'fill-amber-300';
      if (this.average >= position - 0.5) return 'fill-amber-300'; // media estrella
      return 'fill-gray-300';
    },
    isHalfStar(position) {
      return this.average >= position - 0.5 && this.average < position;
    }
  }
};
</script>
