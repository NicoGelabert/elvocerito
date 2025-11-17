<template>
  <div class="review-form">

    <h3 class="text-lg font-semibold mb-4">Deja tu review</h3>

    <!-- Si hay mensaje, reemplaza el form -->
    <div v-if="message" class="p-4 bg-green-100 text-green-700 rounded shadow">
      {{ message }}
    </div>

    <!-- El formulario solo aparece si NO hay mensaje -->
    <form 
      v-else
      @submit.prevent="submitReview"
      class="p-4 bg-white rounded shadow relative transition duration-300"
      :class="{ 'opacity-50 pointer-events-none': loading }"
    >

      <!-- Overlay con spinner sólo cuando loading = true -->
      <div
        v-if="loading"
        class="absolute inset-0 flex items-center justify-center bg-white/50 rounded"
      >
        <div class="loader"></div>
      </div>

      <!-- Inputs -->
      <div class="mb-4">
        <label class="block text-gray-500 font-medium text-xs">Nombre</label>
        <input v-model="form.name" type="text" class="input" required>
      </div>

      <div class="mb-4">
        <label class="block text-gray-500 font-medium text-xs">Apellido</label>
        <input v-model="form.last_name" type="text" class="input" required>
      </div>

      <div class="mb-4">
        <label class="block text-gray-500 font-medium text-xs">Email</label>
        <input v-model="form.email" type="email" class="input" required>
      </div>

      <div class="mb-4 border-b border-gray-300 pb-6">
        <div class="flex gap-2 items-center">
          <label class="block text-gray-500 font-medium text-xs">Rating</label>
          <p class="text-yellow-400">★</p>
        </div>

        <vue-star-rating
          v-model:rating="form.rating"
          :increment="0.1"
          :star-size="20"
          :show-rating="true"
          class="text-yellow-400 gap-8"
        />
      </div>

      <div class="mb-4">
        <label class="block text-gray-500 font-medium text-xs">Comentario</label>
        <textarea 
          v-model="form.comment"
          rows="4"
          class="w-full border-0 border-b border-gray-300 focus:border-blue-500 focus:ring-0 outline-none transition-colors duration-200 py-1.5"
          required
        ></textarea>
      </div>

      <button type="submit" class="btn btn-secondary shadow transition duration-200">
        Enviar Review
      </button>

      <p v-if="error" class="mt-3 text-red-600">{{ error }}</p>

    </form>

  </div>
</template>
<script>
import axios from "axios";
import VueStarRating from "vue-star-rating";

export default {
  components: { VueStarRating },
  props: {
    productId: Number
  },
  data() {
    return {
      form: {
        name: '',
        last_name: '',
        email: '',
        rating: 0,
        comment: '',
        product_id: this.productId
      },
      message: '',
      error: '',
      loading: false
    };
  },
  methods: {
    async submitReview() {
      this.message = '';
      this.error = '';
      this.loading = true;

      try {
        const res = await axios.post('/reviews', this.form);
        this.message = res.data.message;
      } catch (err) {
        this.error = err.response?.data?.message || 'Ocurrió un error al enviar la review.';
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
.input {
  @apply w-full h-6 border-0 border-b border-gray-300 focus:border-blue-500 
         focus:ring-0 outline-none transition-colors duration-200 py-1.5;
}

/* spinner */
.loader {
  border: 4px solid #ccc;
  border-top-color: #555;
  border-radius: 50%;
  width: 28px;
  height: 28px;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>

