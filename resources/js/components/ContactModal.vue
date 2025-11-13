<template>
  <transition name="fade">
    <div
      v-if="isOpen"
      class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-end md:items-center justify-center md:p-6"
      @click.self="close"
    >
      <div class="relative h-auto w-full max-w-screen-sm flex justify-center">
        <!-- Botón de cierre -->
        <button
          @click="close"
          class="absolute -top-6 right-2 bg-white rounded-full p-2 shadow w-12 h-12"
        >
          ✕
        </button>

        <!-- Contenido principal -->
        <transition name="slide-up" appear>
          <div
            v-if="isOpen"
            class="bg-white px-6 pt-6 pb-12 rounded-t-lg md:rounded-lg shadow-xl w-full h-auto overflow-auto"
            @click.stop
          >
            <!-- CONTACTO -->
            <div v-if="type === 'contact'">
              <h2 class="text-center text-xl font-bold mb-8">
                Contacta a {{ product.title }}
              </h2>

              <div class="flex flex-wrap justify-center gap-4">
                <div
                  v-for="(contact, i) in product.contacts || []"
                  :key="i"
                  class="flex items-center gap-2"
                >
                  <component :is="getIconComponent(contact.type)" class="w-6 h-6" />

                  <a
                    :href="contact.type === 'email' ? `mailto:${contact.info}` : contact.info"
                    target="_blank"
                    class="text-blue-600 hover:underline"
                  >
                    {{ contact.info }}
                  </a>
                </div>
                <p v-if="!product.contacts?.length" class="text-gray-500">
                  No hay contactos disponibles
                </p>
              </div>
            </div>

            <!-- COMPARTIR -->
            <div v-else-if="type === 'share'" class="flex flex-col gap-8 bg-white rounded-xl p-4">
                <h2 class="text-center text-xl font-bold">Compartí a {{ product.title }}</h2>

                <div class="flex flex-col items-center md:flex-row md:items-start gap-4">
                    <!-- Imagen del producto -->
                    <img
                    :src="product.image_url"
                    :alt="product.title"
                    class="rounded-lg w-full max-w-24 h-auto object-cover"
                    />

                    <!-- Info del producto -->
                    <div class="flex flex-col gap-4 items-center md:items-start">
                    <div class="flex items-center flex-col md:flex-row md:items-start gap-2 mx-auto md:mx-0">
                        <div v-for="(category, i) in product.categories || []" :key="i" class="flex gap-1 items-center">
                        <img :src="category.image" :alt="category.name" class="w-3 h-3 rounded-none m-0" />
                        <h6>{{ category.name }}</h6>
                        </div>
                    </div>
                    <h4>{{ product.title }}</h4>
                    <p class="text-center md:text-left">{{ product.short_description }}</p>
                    </div>
                </div>

                <!-- Botones de compartir fijos -->
                <div class="flex justify-center gap-4 mt-4">
                    <!-- Facebook -->
                    <a
                    class="bg-gray-100 p-2 rounded-md hover:bg-gray-200"
                    :href="`https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`"
                    target="_blank"
                    >
                    <FacebookIcon class="w-5 h-5 fill-secondary" />
                    </a>

                    <!-- Whatsapp -->
                    <a
                    class="bg-gray-100 p-2 rounded-md hover:bg-gray-200"
                    :href="`https://api.whatsapp.com/send?text=${encodedText}%20${encodedUrl}`"
                    target="_blank"
                    >
                    <WhatsappIcon class="w-5 h-5 fill-secondary" />
                    </a>

                    <!-- Linkedin -->
                    <a
                    class="bg-gray-100 p-2 rounded-md hover:bg-gray-200"
                    :href="`https://www.linkedin.com/sharing/share-offsite/?url=${encodedUrl}`"
                    target="_blank"
                    >
                    <LinkedinIcon class="w-5 h-5 fill-secondary" />
                    </a>

                    <!-- Copiar enlace -->
                    <button
                    class="bg-gray-100 p-2 rounded-md hover:bg-gray-200"
                    @click="copyLink"
                    title="Copiar enlace"
                    >
                    <CopyIcon class="w-5 h-5 text-secondary" />
                    </button>
                </div>
            </div>

            <!-- Toast -->
            <transition name="fade">
              <div
                v-if="showToast"
                class="absolute w-max bottom-28 right-1/2 translate-x-1/2 bg-gray-800 text-white text-sm px-4 py-2 rounded shadow z-50"
              >
                Enlace copiado al portapapeles
              </div>
            </transition>
          </div>
        </transition>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import WhatsappIcon from '@/icons/WhatsappIcon.vue'
import MailIcon from '@/icons/MailIcon.vue'
import MovilIcon from '@/icons/MovilIcon.vue'
import CopyIcon from '@/icons/CopyIcon.vue'
import FacebookIcon from '@/icons/FacebookIcon.vue'
import LinkedinIcon from '@/icons/LinkedinIcon.vue'
const isOpen = ref(false)
const type = ref(null)
const product = ref({})
const showToast = ref(false)

const encodedUrl = computed(() => encodeURIComponent(window.location.href))
const encodedText = computed(() =>
  encodeURIComponent(`${product.value.title || ''} - ${product.value.short_description || ''}`)
)

onMounted(() => {
  window.addEventListener('open-contact-modal', (e) => {
    if (!e.detail) return
    type.value = e.detail.type
    product.value = e.detail.product || {}
    isOpen.value = true
  })
})

function close() {
  isOpen.value = false
}

function copyLink() {
  navigator.clipboard.writeText(window.location.href).then(() => {
    showToast.value = true
    setTimeout(() => (showToast.value = false), 2000)
  })
}

function getIconComponent(type) {
  switch(type) {
    case 'email': return MailIcon
    case 'whatsapp': return WhatsappIcon
    default: return MovilIcon
  }
}

function getSocialIcon(rrss) {
  if (!rrss) return null  // <-- Protección
  switch (rrss.toLowerCase()) {
    case 'facebook': return FacebookIcon
    case 'linkedin': return LinkedinIcon
    case 'whatsapp': return WhatsappIcon
    default: return null
  }
}


</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.slide-up-enter-active,
.slide-up-leave-active {
  transition: transform 0.3s, opacity 0.3s;
}
.slide-up-enter-from,
.slide-up-leave-to {
  transform: translateY(100%);
  opacity: 0;
}
</style>
