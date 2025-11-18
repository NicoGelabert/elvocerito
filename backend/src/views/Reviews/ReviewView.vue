<template>
  <div class="flex items-center justify-between mb-3">
    <h1 v-if="!loading" class="text-3xl font-semibold">
      {{ review.id ? `Update review: "${review.title}"` : 'Create new Review' }}
    </h1>
  </div>

  <div class="bg-white rounded-lg shadow animate-fade-in-down">
    <Spinner v-if="loading"
      class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center z-50" />

    <form v-if="!loading" @submit.prevent="onSubmit">
      <div class="grid grid-cols-1 md:grid-cols-3">
        <div class="col-span-2 px-4 pt-5 pb-4">

            <!-- PRODUCT TITLE -->
            <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Product</h3>
            <CustomInput class="mb-2" v-model="review.product_title" label="Product Title" :errors="errors['product_id']" disabled/>
            </div>

            <hr class="my-4">

            <!-- RATING -->
            <div class="flex flex-col gap-2">
            <h3 class="text-lg font-bold">Rating</h3>
            <CustomInput type="number" min="0" max="5" step="0.1" class="mb-2" v-model.number="review.rating" label="Rating" :errors="errors['rating']"/>
            </div>

            <hr class="my-4">
            <!-- TITLE -->
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-bold">Review Title</h3>
                <CustomInput class="mb-2" v-model="review.title" label="Review Title" :errors="errors['title']"/>
            </div>

            <hr class="my-4">

            <!-- COMMENT -->
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-bold">Comment</h3>
                <CustomInput type="richtext" class="mb-2" v-model="review.comment" label="Comment" :errors="errors['comment']"/>
            </div>

            <hr class="my-4">

            <!-- NAME -->
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-bold">Nombre</h3>
                <CustomInput class="mb-2" v-model="review.name" label="First name" :errors="errors['name']"/>
            </div>

            <hr class="my-4">

            <!-- LAST NAME -->
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-bold">Apellido</h3>
                <CustomInput class="mb-2" v-model="review.last_name" label="Last name" :errors="errors['last_name']"/>
            </div>

            <hr class="my-4">

            <!-- PUBLISHED -->
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-bold">Published</h3>
                <CustomInput type="checkbox" class="mb-2" v-model="review.published" label="Published" :errors="errors['published']"/>
            </div>

        </div>
      </div>

      <footer class="bg-gray-50 rounded-b-lg px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="submit"
          class="bg-black text-base font-medium text-white border rounded-md w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-black/10 hover:text-black sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
          Save
        </button>

        <button type="button" @click="onSubmit($event, true)"
          class="bg-black text-base font-medium text-white border rounded-md w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-black/10 hover:text-black sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
          Save & Close
        </button>

        <router-link :to="{name: 'app.reviews'}"
          class="bg-white text-base font-medium text-gray-700 border rounded-md w-full inline-flex justify-center mt-3 px-4 py-2 hover:bg-gray-50 sm:w-auto sm:mt-0 sm:ml-3 sm:text-sm">
          Cancel
        </router-link>
      </footer>

    </form>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import CustomInput from "../../components/core/CustomInput.vue";
import Spinner from "../../components/core/Spinner.vue";
import store from "../../store";
import { useRoute, useRouter } from "vue-router";

const route = useRoute()
const router = useRouter()

const review = ref({
  id: null,
  product_id: null,
  product_title: "",
  name: "",
  last_name: "",
  email: "",
  rating: 0,
  title: "",
  comment: "",
  published: false,
})

const loading = ref(false)
const errors = ref({})

onMounted(() => {
  if (route.params.id) {
    loading.value = true
    store.dispatch('getReview', route.params.id)
      .then(response => {
        loading.value = false
        review.value = response.data.data
      })
  }
})

function onSubmit($event, close = false) {
  loading.value = true
  errors.value = {}

  const action = review.value.id ? 'updateReview' : 'createReview'

  store.dispatch(action, review.value)
    .then(response => {
      loading.value = false
      store.commit('showToast', 'Review saved successfully')
      store.dispatch('getReviews')

      if (close) {
        router.push({ name: 'app.reviews' })
      } else if (!review.value.id) {
        router.push({ name: 'app.reviews.edit', params: { id: response.data.id } })
      }
    })
    .catch(err => {
      loading.value = false
      errors.value = err.response?.data?.errors || {}
    })
}
</script>
