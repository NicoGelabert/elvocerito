<template>
    <Menu as="div" class="relative inline-block text-left">
        <div>
            <MenuButton class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black bg-opacity-0 hover:bg-opacity-5 focus:outline-none">
                <EllipsisVerticalIcon class="h-5 w-5 text-black" aria-hidden="true" />
            </MenuButton>
        </div>
        <transition enter-active-class="transition duration-100 ease-out" enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
            <MenuItems class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                        <component
                            :is="editActionComponent"
                            :class="[active ? 'bg-gray-200 text-black' : 'text-gray-900', 'group flex w-full items-center rounded-md px-2 py-2 text-sm']"
                            v-bind="editProps"
                            >
                            <PencilSquareIcon class="mr-2 h-5 w-5 text-black" aria-hidden="true" />
                                Edit
                        </component>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <button
                            @click="remove"
                            :class="[active ? 'bg-red-500 text-white' : 'text-gray-900','group flex w-full items-center rounded-md px-2 py-2 text-sm']"
                            >
                            <TrashIcon class="mr-2 h-5 w-5 text-red-500" aria-hidden="true" />
                                Delete
                        </button>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { computed } from "vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { EllipsisVerticalIcon, PencilSquareIcon, TrashIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
    edit: Function,
    remove: Function,
    editType: {
        type: String,
        default: "button", // Puede ser "button" o "router-link"
        validator: (value) => ["button", "router-link"].includes(value),
    },
    editTo: {
        type: Object,
        default: null,
    },
});

const editActionComponent = computed(() => (props.editType === "router-link" ? "router-link" : "button"));
const editProps = computed(() => (props.editType === "router-link" ? { to: props.editTo } : { onClick: props.edit }));
</script>
