<template>
  <div v-if="rating !== null" class="flex items-center space-x-1">

    <!-- Estrellas -->
    <div class="flex">
      <StarIcon
        v-for="n in 5"
        :key="n"
        :class="getStarFill(n)"
        :half="isHalfStar(n)"
      />
    </div>

    <!-- Número (opcional) -->
    <span
      v-if="showValue"
      class="font-semibold text-sm text-gray-500"
    >
      {{ formattedRating }}
    </span>

  </div>
</template>

<script>
import StarIcon from '@/icons/StarIcon.vue';

export default {
  name: 'RatingStars',
  components: { StarIcon },
  props: {
    rating: {
      type: Number,
      required: true
    },
    showValue: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    formattedRating() {
      return this.rating.toFixed(1);
    }
  },
  methods: {
    getStarFill(position) {
      if (this.rating >= position) return 'fill-amber-300';
      if (this.rating >= position - 0.5) return 'fill-amber-300';
      return 'fill-gray-300';
    },
    isHalfStar(position) {
      return this.rating >= position - 0.5 && this.rating < position;
    }
  }
};
</script>
