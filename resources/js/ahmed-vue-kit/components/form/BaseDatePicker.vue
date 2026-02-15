<script setup>
    import { ref, onMounted, onBeforeUnmount } from 'vue'

    // import Flatpickr from node_modules
    import flatpickr from 'flatpickr'

    // optional: import CSS
    import 'flatpickr/dist/flatpickr.css'

    const props = defineProps({
        modelValue: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            default: 'datetime_range'
        },
        label: String,
        placeholder: String,
        type: {
            type: String,
            default: 'datetimerange' //others date, datetime, time, daterange, datetimerange,
        }
    })

    const emit = defineEmits(['update:modelValue'])

    const inputRef = ref(null)
    let picker = null


    // onMounted(() => {
    //     if (props.type !== 'datetimerange') return
    //     picker = flatpickr(dateRangeRef.value, {
    //         mode: 'range',          // date range mode
    //         dateFormat: 'Y-m-d H:i', 
    //         defaultDate: props.modelValue || null,
    //         enableTime: true,       // include time
    //         allowInput: true,
    //         onChange: (selectedDates, dateStr) => {
    //             console.log('Selected Range:', dateStr)
    //         }
    //     })
    // })

    onMounted(() => {
        if (props.type === 'datetimerange') {
            picker = flatpickr(inputRef.value, {
                mode: 'range',
                dateFormat: 'Y-m-d H:i',
                enableTime: true,
                defaultDate: props.modelValue || null,
                allowInput: true,
                onChange: (selectedDates, dateStr) => {
                    emit('update:modelValue', dateStr)  // <--- important
                }
            })
        }
    })

    // clean up flatpickr instance
    onBeforeUnmount(() => {
        if (picker) picker.destroy()
    })
</script>


<template>
  <div class="mb-2 me-2">
      <label class="form-label">{{ label }}</label>

      <!-- date -->
      <input
          v-if="type === 'date'"
          type="date"
          class="form-control"
          :name="name"
          :placeholder="placeholder"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
      />

      <!-- time -->
      <input
          v-else-if="type === 'time'"
          type="time"
          class="form-control"
          :name="name"
          :placeholder="placeholder"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
      />

      <!-- datetime -->
      <input
          v-else-if="type === 'datetime'"
          type="datetime-local"
          class="form-control"
          :name="name"
          :placeholder="placeholder"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
      />

      <!-- datetime range -->
      <input
          v-else-if="type === 'datetimerange'"
          type="text"
          class="form-control"
          ref="inputRef"
          :name="name"
          :placeholder="placeholder"
          readonly
      />
  </div>
</template>




<!-- 
// How to use

<BaseDatePicker 
    type="datetimerange" 
    label="Select date & time range" 
    placeholder="Select date & time range" 
    />
    // Support types: date, time, datetime, datetimerange

-->