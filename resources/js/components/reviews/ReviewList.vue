<template>
  <div class="reviews-list w-full">
    <h3 class="text-lg font-semibold mb-4">Reviews de este anunciante</h3>
    <div v-if="reviews.length === 0" class="text-gray-500">
      Este anunciante todavía no tiene reviews. Sé el primero!
    </div>
    <div v-else class="flex flex-col gap-4">
      <div v-for="review in reviews" :key="review.id" class="p-4 bg-white rounded shadow">
        <div class="flex justify-between items-center mb-2">
          <div class="flex items-center relative">
            <p class="text-base font-semibold capitalize">{{ review.name }} {{ review.last_name }}</p>

            <div v-if="review.email_verified" class="ml-2 relative">
              <!-- Check icon -->
              <check-icon 
                class="w-5 h-5 text-green-500 cursor-pointer"
                @click="tooltipVisible[review.id] = !tooltipVisible[review.id]"
              />

              <!-- Tooltip -->
              <div 
                v-if="tooltipVisible[review.id]" 
                class="absolute left-1/2 transform -translate-x-1/2 -top-8 px-3 py-1 text-xs font-medium text-white bg-gray-800 rounded shadow-lg whitespace-nowrap"
              >
                Review verificada
                <div class="absolute top-5 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-800 rotate-45"></div>
              </div>
            </div>
          </div>
          
          <p class="text-yellow-400">{{ Number(review.rating).toFixed(1) }} ★</p>
        </div>
        <hr class="mb-2 font-semibold">
        <p class="mb-2 font-medium">{{ review.title }}</p>
        <p class="text-xs text-gray-700">{{ review.comment }}</p>
        <div v-if="review.admin_response" class="mt-2 p-2 bg-gray-100 rounded text-gray-600">
          <strong>Respuesta del anunciante:</strong> {{ review.admin_response }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import CheckIcon from '@/icons/CheckIcon.vue';

export default {
  components: { CheckIcon },
  props: {
    productId: { type: Number, required: true }
  },
  data() {
    return {
      reviews: [],
      tooltipVisible: {} // tooltip por review.id
    };
  },
  mounted() {
    this.fetchReviews();
  },
  methods: {
    async fetchReviews() {
      try {
        const response = await axios.get(`/products/${this.productId}/reviews`);
        this.reviews = response.data.map(r => ({
          ...r,
          rating: Number(r.rating)
        }));
      } catch (err) {
        console.error('Error al cargar las reviews:', err);
      }
    },
    toggle(id) {
      this.$set(this.tooltipVisible, id, !this.tooltipVisible[id]);
    }
  }
};
</script>
