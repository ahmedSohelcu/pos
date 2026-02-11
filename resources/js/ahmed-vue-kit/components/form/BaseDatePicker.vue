<script setup>
    import { ref, onMounted, onBeforeUnmount } from 'vue'

    // import Flatpickr from node_modules
    import flatpickr from 'flatpickr'

    // optional: import CSS
    import 'flatpickr/dist/flatpickr.css'

    const dateRangeRef = ref(null)
    let picker = null

    const props = defineProps({
        modelValue: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            default: 'datetime_range'
        },
        label: {
            type: String,
            default: 'Select date & time range'
        },
        placeholder: {
            type: String,
            default: 'Select date'
        },
        type: {
            type: String,
            default: 'datetimerange' //others date, datetime, time, daterange, datetimerange,
        }
    })

    onMounted(() => {
        if (props.type !== 'datetimerange') return
        picker = flatpickr(dateRangeRef.value, {
            mode: 'range',          // date range mode
            dateFormat: 'Y-m-d H:i', 
            defaultDate: props.modelValue || null,
            enableTime: true,       // include time
            allowInput: true,
            onChange: (selectedDates, dateStr) => {
                console.log('Selected Range:', dateStr)
            }
        })
    })

    onBeforeUnmount(() => {
        if (picker) picker.destroy()  // clean up
    })
</script>

<template>   
    <div v-if="props.type  === 'date'">
        <label class="form-label">{{props.label ?? ''}}</label>

        <input type="date" class="form-control" 
            :name="props.name ?? 'date'"
            :placeholder="props.placeholder ?? 'Select date'"/>
    </div>

    <div v-if="props.type === 'time'">
        <label class="form-label">{{props.label ?? ''}}</label>
        <input 
            type="time" 
            class="form-control" 
            :name="props.name ?? 'time'"
            :placeholder="props.placeholder ?? 'Select time'"
        />
    </div>

    <div v-if="props.type === 'datetime'">
        <label class="form-label">{{props.label ?? ''}}</label>
        <input
            type="datetime-local"
            class="form-control"
            :name="props.name ?? 'date_time'"
            :placeholder="props.placeholder ?? 'Select date & time'"
        >
    </div>

    <div class="mb-3" v-if="props.type === 'datetimerange'">
        <label class="form-label">{{props.label ?? ''}}</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fa fa-calendar"></i>
            </span>
            <input
                type="text"
                :name="props.name ?? 'datetime_range'"
                ref="dateRangeRef"
                class="form-control"
                :placeholder="props.placeholder ?? 'Select date & time Range'"
                readonly
            />
        </div>     
    </div>
</template>





<!-- 
// How to use

<BaseDatePicker 
    type="datetimerange" 
    label="Select date & time range" 
    placeholder="Select date & time range" 
    />
    // Support types: date, time, datetime, daterange, datetimerange

-->