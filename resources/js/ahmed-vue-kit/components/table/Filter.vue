<template>
    <div class="row">
        <div class="col-md-12">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search..." v-model="filterText" @keyup="filterTable" />
                <button class="btn btn-outline-secondary" type="button" @click="resetFilter">
                    <i class="bi bi-arrow-counterclock"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'

const props = defineProps({
    rows: {
        type: Array,
        required: true
    }
})

const filterText = ref('')
const filteredRows = computed(() => {
    if (filterText.value === '') return props.rows
    return props.rows.filter(row => Object.values(row).some(value => value.toString().includes(filterText.value)))
})

const resetFilter = () => {
    filterText.value = ''
}

const filterTable = () => {
    // emit event to parent
    emit('filter-table', filteredRows.value)
}

</script>

<!-- Example -->
<Filter :rows="data" @filter-table="filteredData = $event" />
