<template>
    <guest-layout title="Request new password">
        
        <form class="mt-8 space-y-6 w-[350px]" action="#" method="POST">
            <input type="hidden" name="remember" value="true"/>
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                <label for="email-address" class="sr-only">Email address</label>
                <input id="email-address" name="email" type="email" autocomplete="email" required=""
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Email address"/>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="text-sm">
                <router-link :to="{name: 'login'}" class="font-medium text-black hover:text-black/50"> Remember your
                    password?
                </router-link>
                </div>
            </div>

            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:text-black hover:bg-white focus:outline-none">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <LockClosedIcon class="h-5 w-5" aria-hidden="true"/>
                    </span>
                Submit
                </button>
            </div>
        </form>
        
    </guest-layout>

</template>


<script setup>
import {LockClosedIcon} from '@heroicons/vue/24/solid'
import GuestLayout from '../components/GuestLayout.vue';

</script>