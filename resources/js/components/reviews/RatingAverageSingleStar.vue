<template>
  <div class="flex items-center space-x-1">
    <template v-if="average">
      <StarIcon class="w-4 h-4 fill-transparent stroke-2 stroke-primary" />
      <span class="font-bold text-base text-secondary leading-none pt-[0.1rem]">{{ average }}</span>
      <span class="text-xs text-primary italic leading-none pt-[0.1rem]">({{ reviewsCount }})</span>
    </template>
    <template v-else>
      <StarIcon class="w-4 h-4 fill-transparent stroke-2 stroke-gray-500" />
      <span class="text-xs text-gray-500 leading-none pt-[0.1rem]">0</span>
    </template>
  </div>
</template>

<script>
import axios from 'axios';
import StarIcon from '@/icons/StarIcon.vue';

export default {
  components: { StarIcon },
  props: {
    productId: { type: Number, required: true },
    reviewsCount: { type: Number, default: 0 },
  },
  data() {
    return {
      average: null,
    };
  },
  async mounted() {
    const res = await axios.get(`/products/${this.productId}/rating-average`);
    this.average = res.data.average;
  },
};
</script>