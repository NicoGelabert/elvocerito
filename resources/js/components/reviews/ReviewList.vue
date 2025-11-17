<template>
  <div class="reviews-list w-full">
    <h3 class="text-lg font-semibold mb-4">Reviews de este anunciante</h3>
    <div v-if="reviews.length === 0" class="text-gray-500">
      Este anunciante todavía no tiene reviews. Sé el primero!
    </div>
    <div v-else class="flex flex-col gap-4">
      <div v-for="review in reviews" :key="review.id" class="p-4 bg-white rounded shadow">
        <div class="flex justify-between items-center mb-2">
          <p class="font-semibold">{{ review.name }} {{ review.last_name }}</p>
          <p class="text-yellow-400">{{ Number(review.rating).toFixed(1) }} ★</p>
        </div>
        <p class="text-gray-700">{{ review.comment }}</p>
        <div v-if="review.admin_response" class="mt-2 p-2 bg-gray-100 rounded text-gray-600">
          <strong>Respuesta del anunciante:</strong> {{ review.admin_response }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    productId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      reviews: []
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
            rating: Number(r.rating) // forzar número
            }));
        } catch (err) {
            console.error('Error al cargar las reviews:', err);
        }
    }

  }
};
</script>

<style scoped>
/* Estilos opcionales */
</style>
