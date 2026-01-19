<template>
  <div class="p-4">
    <h1 class="text-xl font-bold mb-4">Calendario de Turnos</h1>

    <FullCalendar v-if="ready" :options="calendarOptions" />

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
      <div class="bg-white w-[550px] rounded-lg p-5 shadow-xl">

        <h2 class="text-lg font-semibold mb-4">
          Turnos para {{ selectedDate }}
        </h2>

        <div v-if="shiftsOfDay.length">
          <div
            v-for="shift in shiftsOfDay"
            :key="shift.id"
            class="flex justify-between border-b py-2"
          >
            <span>
              {{ shift.title }} |
              {{ time(shift.start) }} - {{ time(shift.end) }}
            </span>

            <div class="flex gap-2">
              <button @click="startEdit(shift)" class="text-blue-600 text-sm">Editar</button>
              <button @click="deleteShift(shift)" class="text-red-600 text-sm">Eliminar</button>
            </div>
          </div>
        </div>

        <p v-else class="text-sm text-gray-500">No hay turnos</p>

        <button @click="startCreate" class="mt-4 text-blue-600 text-sm">
          + Agregar turno
        </button>

        <button @click="closeModal" class="mt-4 ml-4 border px-3 py-1 rounded">
          Cerrar
        </button>
      </div>
    </div>

    <!-- Editor -->
    <div v-if="editingShift" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
      <div class="bg-white w-[400px] p-4 rounded">
        <h3 class="font-semibold mb-3">
          {{ editingShift.id ? 'Editar turno' : 'Nuevo turno' }}
        </h3>

        <select v-model.number="editingShift.pharmacy_id" class="border w-full mb-2">
          <option disabled value="">Selecciona farmacia</option>
          <option v-for="p in pharmacies" :key="p.id" :value="p.id">
            {{ p.title }}
          </option>
        </select>

        <input type="time" v-model="editingShift.start_time" class="border w-full mb-2" />
        <input type="time" v-model="editingShift.end_time" class="border w-full mb-2" />

        <div class="flex justify-end gap-2">
          <button @click="cancelEdit">Cancelar</button>
          <button @click="saveEdit" class="bg-green-600 text-white px-3 py-1 rounded">
            Guardar
          </button>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import axiosClient from "../../axios"

export default {
  components: { FullCalendar },

  data() {
    return {
      ready: false,
      showModal: false,
      selectedDate: null,
      shifts: [],
      editingShift: null,

      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        events: [],
        dateClick: info => this.openModal(info.dateStr)
      },
      pharmacies: [],
    }
  },

  computed: {
    shiftsOfDay() {
      return this.shifts.filter(s => s.start.startsWith(this.selectedDate))
    }
  },

  mounted() {
    this.fetchShifts(),
    this.fetchPharmacies()
  },

  methods: {
    time(dt) {
      return dt.split('T')[1].substring(0,5)
    },

    openModal(date) {
      this.selectedDate = date
      this.showModal = true
    },

    closeModal() {
      this.showModal = false
    },

    fetchShifts() {
      axiosClient.get('/pharmacy-shifts').then(res => {
        this.shifts = res.data
        this.calendarOptions.events = this.shifts
        this.ready = true
      })
    },

    fetchPharmacies() {
      axiosClient.get('/pharmacies-with-products').then(({ data }) => {
        this.pharmacies = data.map(f => ({
          id: f.id,
          title: f.product?.title ?? `Farmacia #${f.id}`
        }))
      })
    },

    refreshCalendar() {
      this.calendarOptions.events = this.shifts.map(s => ({
        id: s.id,
        title: s.title,
        start: s.start,
        end: s.end
      }))
    },

    startCreate() {
      this.editingShift = {
        pharmacy_id: '',
        start_time: '08:00',
        end_time: '09:00'
      }
    },

    startEdit(shift) {
      const pharmacy = this.pharmacies.find(p => p.id === Number(shift.pharmacy_id))
      this.editingShift = {
        id: shift.id,
        pharmacy_id: Number(shift.pharmacy_id),
        start_time: this.time(shift.start),
        end_time: this.time(shift.end)
      }
    },

    cancelEdit() {
      this.editingShift = null
    },

    saveEdit() {
      const s = this.editingShift

      if (!s.pharmacy_id || !s.start_time || !s.end_time) {
        alert('Datos inválidos')
        return
      }

      // ===== UPDATE =====
      if (s.id) {
        axiosClient.put(`/pharmacy-shifts/${s.id}`, {
          pharmacy_id: s.pharmacy_id,
          start_time: s.start_time,
          end_time: s.end_time
        }).then(() => {

          const shift = this.shifts.find(x => x.id === s.id)
          if (!shift) return

          const pharmacy = this.pharmacies.find(p => p.id === s.pharmacy_id)

          Object.assign(shift, {
            pharmacy_id: s.pharmacy_id,
            title: pharmacy?.title ?? `Farmacia #${s.pharmacy_id}`,
            start: `${this.selectedDate}T${s.start_time}`,
            end: `${this.selectedDate}T${s.end_time}`
          })

          this.refreshCalendar()
          this.editingShift = null
        })

      // ===== CREATE =====
      } else {
        axiosClient.post('/pharmacy-shifts', {
          shift_date: this.selectedDate,
          shifts: [{
            pharmacy_id: s.pharmacy_id,
            start_time: s.start_time,
            end_time: s.end_time
          }]
        }).then((response) => {

          const payload = response.data
          const saved = Array.isArray(payload)
            ? payload[0]
            : Array.isArray(payload?.data)
              ? payload.data[0]
              : payload

          if (!saved || !saved.id) {
            console.error('Respuesta inesperada del backend', response.data)
            return
          }

          const pharmacy = this.pharmacies.find(p => p.id === saved.pharmacy_id)
          
          this.shifts.push({
            id: saved.id,
            pharmacy_id: saved.pharmacy_id,
            title: pharmacy?.title ?? `Farmacia #${saved.pharmacy_id}`, 
            start: `${saved.shift_date}T${saved.start_time}`,
            end: `${saved.shift_date}T${saved.end_time}`
          })

          this.refreshCalendar()
          this.editingShift = null
        })
      }
    },

    deleteShift(shift) {
      if (!confirm("¿Eliminar?")) return

      const remove = () => {
        this.shifts = this.shifts.filter(s => s.id !== shift.id)
        this.refreshCalendar()
      }

      shift.id
        ? axiosClient.delete(`/pharmacy-shifts/${shift.id}`).then(remove)
        : remove()
    },
  }
}
</script>
<style>
  .fc-button-primary{
    background-color: black!important;
    border-color: black!important;
  }
</style>