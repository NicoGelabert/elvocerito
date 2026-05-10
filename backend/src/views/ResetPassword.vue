<template>
    <guest-layout title="Set new password">
        <form class="mt-8 space-y-6 w-[350px]" @submit.prevent="handleSubmit">

            <div v-if="error" class="flex items-center justify-between py-3 px-5 bg-red-500 text-white rounded">
                {{ error }}
                <span @click="error = ''" class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </span>
            </div>

            <div class="-space-y-px flex flex-col gap-y-8">

                <!-- Nueva contraseña -->
                <div>
                    <label for="new-password" class="sr-only">New Password</label>
                    <div class="relative">
                        <input v-model="password"
                               id="new-password" name="password"
                               :type="showPassword ? 'text' : 'password'"
                               required
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none sm:text-sm"
                               placeholder="New Password"/>
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                            <EyeIcon v-if="!showPassword" class="h-5 w-5"/>
                            <EyeSlashIcon v-else class="h-5 w-5"/>
                        </button>
                    </div>
                    <!-- Validaciones -->
                    <ul class="mt-2 space-y-1 text-xs">
                        <li :class="validations.minLength ? 'text-green-600' : 'text-gray-400'">
                            ✓ At least 8 characters
                        </li>
                        <li :class="validations.hasUppercase ? 'text-green-600' : 'text-gray-400'">
                            ✓ At least one uppercase letter
                        </li>
                        <li :class="validations.hasNumber ? 'text-green-600' : 'text-gray-400'">
                            ✓ At least one number
                        </li>
                        <li :class="validations.hasSpecial ? 'text-green-600' : 'text-gray-400'">
                            ✓ At least one special character (!@#$...)
                        </li>
                    </ul>
                </div>

                <!-- Repetir contraseña -->
                <div>
                    <label for="password-repeat" class="sr-only">Repeat Password</label>
                    <div class="relative">
                        <input v-model="passwordConfirm"
                               id="password-repeat" name="password_repeat"
                               :type="showPasswordConfirm ? 'text' : 'password'"
                               required
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none sm:text-sm"
                               placeholder="Repeat Password"/>
                        <button type="button" @click="showPasswordConfirm = !showPasswordConfirm"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                            <EyeIcon v-if="!showPasswordConfirm" class="h-5 w-5"/>
                            <EyeSlashIcon v-else class="h-5 w-5"/>
                        </button>
                    </div>
                    <p v-if="passwordConfirm && !validations.passwordsMatch" class="mt-1 text-xs text-red-500">
                        Passwords do not match
                    </p>
                </div>

            </div>

            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <router-link :to="{name: 'login'}" class="font-medium text-black hover:text-black/50">
                        Go back to Login
                    </router-link>
                </div>
            </div>

            <div>
                <button type="submit"
                        :disabled="!isValid"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:text-black hover:bg-white focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <LockClosedIcon class="h-5 w-5" aria-hidden="true"/>
                    </span>
                    Submit
                </button>
            </div>

            <p v-if="message" class="text-sm text-green-600">{{ message }}</p>

        </form>
    </guest-layout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { LockClosedIcon, EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/solid'
import GuestLayout from '../components/GuestLayout.vue'
import axiosClient from '../axios'

const route = useRoute()
const router = useRouter()

const password = ref('')
const passwordConfirm = ref('')
const showPassword = ref(false)
const showPasswordConfirm = ref(false)
const message = ref('')
const error = ref('')

const validations = computed(() => ({
    minLength: password.value.length >= 8,
    hasUppercase: /[A-Z]/.test(password.value),
    hasNumber: /[0-9]/.test(password.value),
    hasSpecial: /[!@#$%^&*(),.?":{}|<>]/.test(password.value),
    passwordsMatch: password.value === passwordConfirm.value,
}))

const isValid = computed(() => Object.values(validations.value).every(Boolean))

const handleSubmit = async () => {
    error.value = ''
    message.value = ''
    try {
        await axiosClient.post('/reset-password', {
            token: route.params.token,
            email: route.query.email,
            password: password.value,
            password_confirmation: passwordConfirm.value,
        })
        message.value = 'Password updated successfully. Redirecting...'
        setTimeout(() => router.push({ name: 'login' }), 2000)
    } catch (e) {
        error.value = e.response?.data?.message ?? 'Something went wrong.'
    }
}
</script>