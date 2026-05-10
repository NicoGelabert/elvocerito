<template>
    <header class="flex justify-between items-center p-3 h-14 shadow bg-white">
        <Logo class="block h-12 w-auto fill-black" />
        
        <Menu as="div" class="relative inline-block text-left">
            <MenuButton class="flex items-center" @click="toggleChevronDownIcon()">
                <div :class="avatarColor"
                    class="rounded-full w-8 h-8 mr-2 flex items-center justify-center text-white text-xs font-semibold">
                    {{ initials }}
                </div>
                <small>{{currentUser.name}}</small>
                    <div :class="[toggleIconDown ? 'iconClosed' : 'iconOpen']" >
                        <ChevronUpIcon
                        class="h-5 w-5 text-violet-200 hover:text-violet-100"
                        aria-hidden="true"
                    />
                    </div>
            </MenuButton>

            <transition
                enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
            >
                <MenuItems
                class="absolute right-0 mt-2 w-36 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                    <div class="px-1 py-1">
                        <MenuItem v-slot="{ active }">
                            <button
                                :class="[
                                active ? 'bg-black text-white' : 'text-black',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                ]"
                            >
                                <UserIcon
                                :active="active"
                                class="mr-2 h-5 w-5"
                                aria-hidden="true"
                                />
                                Profile
                            </button>
                        </MenuItem>
                        <MenuItem v-slot="{ active }">
                            <button
                                @click="logout"
                                :class="[
                                active ? 'bg-black text-white' : 'text-black',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                ]"
                            >
                                <ArrowRightOnRectangleIcon
                                :active="active"
                                class="mr-2 h-5 w-5"
                                aria-hidden="true"
                                />
                                Logout
                            </button>
                        </MenuItem>
                    </div>
                </MenuItems>
            </transition>
        </Menu>
  </header>
  
</template>

<script setup>
import { ChevronLeftIcon, ChevronUpIcon, UserIcon, ArrowRightOnRectangleIcon } from '@heroicons/vue/24/outline'
import {Menu, MenuButton, MenuItems, MenuItem} from '@headlessui/vue'
import store from "../store";
import router from "../router";
import {ref,computed} from "vue";
import Logo from './commons/Logo.vue';

const emit = defineEmits(['toggle-sidebar'])

const currentUser = computed(() => store.state.user.data);
const toggleIconDown = ref(true);
const toggleChevronDownIcon = () => {
  toggleIconDown.value = !toggleIconDown.value;
}


function logout() {
  store.dispatch('logout')
    .then(() => {
      router.push({name: 'login'})
    })
}

const colors = [
    'bg-red-500', 'bg-orange-500', 'bg-amber-500', 'bg-yellow-500',
    'bg-lime-500', 'bg-emerald-500', 'bg-teal-500', 'bg-cyan-500',
    'bg-blue-500', 'bg-indigo-500',
]

const initials = computed(() => {
    const name = currentUser.value?.name ?? ''
    return name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase()
})

const avatarColor = computed(() => {
    const hash = initials.value.split('').reduce((acc, c) => acc + c.charCodeAt(0), 0)
    return colors[hash % colors.length]
})

</script>

<style scoped>
.iconOpen{
  transform: rotate(0);
  transition: transform 0.25s cubic-bezier(0.79, 0.33, 0.14, 0.53);
}
.iconClosed{
  transform: rotate(180deg);
  transition: transform 0.25s cubic-bezier(0.79, 0.33, 0.14, 0.53);
}
</style>