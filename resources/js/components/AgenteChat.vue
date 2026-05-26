<template>
  <!-- Botón flotante -->
  <div class="agente-fab" @click="abierto = !abierto">
    <span v-if="!abierto">💬</span>
    <span v-else>✕</span>
  </div>

  <!-- Panel del chat -->
  <Transition name="chat">
    <div v-if="abierto" class="agente-panel">
      <div class="agente-header">
        <span>🔍 Buscador de anunciantes</span>
        <button @click="abierto = false">✕</button>
      </div>

      <!-- Mensajes -->
      <div class="mensajes" ref="mensajesRef">
        <div v-if="mensajes.length === 0" class="vacio">
          <p>👋 ¿Qué estás buscando?</p>
          <div class="sugerencias">
            <button v-for="s in sugerencias" :key="s" @click="enviar(s)">{{ s }}</button>
          </div>
        </div>

        <div v-for="(msg, i) in mensajes" :key="i" :class="['mensaje', msg.role]">
          <div class="burbuja" v-html="formatear(msg.content)"></div>
        </div>

        <div v-if="cargando" class="mensaje assistant">
          <div class="burbuja cargando">
            <span></span><span></span><span></span>
          </div>
        </div>
      </div>

      <!-- Input -->
      <div class="input-area">
        <input
          v-model="pregunta"
          @keydown.enter="enviar()"
          :disabled="cargando"
          placeholder="Ej: quiero un plomero en Lomas..."
          type="text"
          ref="inputRef"
        />
        <button @click="enviar()" :disabled="cargando || !pregunta.trim()">↑</button>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, nextTick, watch } from 'vue'
import axios from 'axios'

const abierto  = ref(false)
const inputRef = ref(null)

const pregunta    = ref('')
const mensajes    = ref([])  // { role: 'user'|'assistant', content: string }
const historial   = ref([])  // historial completo para el agente (incluye tool calls)
const cargando    = ref(false)
const mensajesRef = ref(null)

const sugerencias = [
  '🔌 Electricista',
  '👷 Construcciones',
  '🔧 Plomero',
  '💊 Farmacia de turno',
]

// Cuando abre el panel, foco automático en el input
watch(abierto, async (val) => {
  if (val) {
    await nextTick()
    inputRef.value?.focus()
  }
})

async function enviar(texto = null) {
  const query = texto || pregunta.value
  if (!query.trim() || cargando.value) return

  pregunta.value = ''
  mensajes.value.push({ role: 'user', content: query })
  cargando.value = true
  await scrollAbajo()

  try {
    const { data } = await axios.post('/api/agente', {
      pregunta: query,
      historial: historial.value,
    })

    // Guardar historial completo para la próxima vuelta (memoria del agente)
    historial.value = data.historial

    mensajes.value.push({ role: 'assistant', content: data.respuesta })
  } catch (e) {
    mensajes.value.push({ role: 'assistant', content: '❌ Hubo un error. Intentá de nuevo.' })
  } finally {
    cargando.value = false
    await scrollAbajo()
  }
}

function formatear(texto) {
  if (!texto) return ''
  return texto
    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
    .replace(/\[([^\]]+)\]\((https?:\/\/[^\)]+)\)/g, '<a href="$2" target="_blank" class="text-blue-600 underline hover:text-blue-800">$1</a>')
    .replace(/\n/g, '<br>')
}

async function scrollAbajo() {
  await nextTick()
  mensajesRef.value?.scrollTo({ top: mensajesRef.value.scrollHeight, behavior: 'smooth' })
}
</script>