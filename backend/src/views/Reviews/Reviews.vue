<template>
    <div>
        <div class="flex flex-col md:flex-row justify-between mb-3 w-full gap-4">
            <h1 class="text-3xl font-semibold">Reviews</h1>
            <router-link :to="{name: 'app.reviews.create'}"
                          class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:text-black hover:bg-white focus:outline-none text-center"
            >
            Add new Review
            </router-link>
        </div>
        <ReviewsTable/>
    </div>
  
</template>

<script setup>
import {computed} from "vue";
import store from "../../store";
import ReviewsTable from "./ReviewsTable.vue";

const reviews = computed(() => store.state.reviews);
</script>