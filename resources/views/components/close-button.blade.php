<button x-show="isOpen" @click="isOpen = false"
    x-transition:enter="transition transform duration-300"
    x-transition:enter-start="opacity-0 translate-y-full"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition transform duration-300"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-full"
    {{ $attributes->merge(['class' => 'absolute right-2 font-bold w-12 h-12 bg-white border border-gray_300 rounded-full z-50']) }}>
    ✖
</button>