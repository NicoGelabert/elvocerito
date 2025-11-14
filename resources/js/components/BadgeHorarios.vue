<template>
    <Badge v-if="estado === 'Disponible'" :status="estado">
        <span>{{ estado }}</span>
    </Badge>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Badge from './Badge.vue'

const props = defineProps({
  horarios: {
    type: Array,
    default: () => []
  }
})

const estado = ref('Cargando...')
const estadoClass = ref('')

function convertirAHorasMinutos(hora) {
  const [h, m] = hora.split(':').map(Number)
  return h * 60 + m
}

function comprobarEstado() {
  const diasSemana = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"]
  const ahora = new Date()
  const diaActual = diasSemana[ahora.getDay()]
  const horaActual = ahora.getHours() * 60 + ahora.getMinutes()

  const horarioHoy = props.horarios.find(h => h.dia.toLowerCase() === diaActual.toLowerCase())

  let disponible = false

  if (horarioHoy) {
    const aperturaMin = convertirAHorasMinutos(horarioHoy.apertura)
    const cierreMin = convertirAHorasMinutos(horarioHoy.cierre)

    if (aperturaMin <= cierreMin) {
      disponible = horaActual >= aperturaMin && horaActual < cierreMin
    } else {
      disponible = horaActual >= aperturaMin || horaActual < cierreMin
    }
  }

  estado.value = disponible ? 'Disponible' : ''
  estadoClass.value = disponible ? 'open' : ''
}


onMounted(() => {
  comprobarEstado()
  setInterval(comprobarEstado, 60000)
})
</script>
