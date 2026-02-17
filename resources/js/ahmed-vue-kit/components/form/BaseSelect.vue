<script setup>
import { ref, computed, onMounted, onBeforeUnmount, nextTick, watch } from 'vue'
import api from '../../api/api'

const props = defineProps({
    modelValue: {
        type: [String, Number, Array],
        default: ''
    },
    label: String,
    name: String,
    options: {
        type: Array,
        default: () => []
    },
    getApiRoute: String,
    optionKeyName: {
        type: String,
        default: 'name'
    },
    placeholder: {
        type: String,
        default: 'Select an option'
    },
    error: String,
    disabled: Boolean,
    select2: Boolean,
    multiple: Boolean,
    customClass: String,
})

const emit = defineEmits(['update:modelValue'])

const selectRef = ref(null)
const optionsRef = ref([])
const loadingRef = ref(false)
let selectInstance = null

// ==========================
// Load Options (API)
// ==========================
const loadOptions = async () => {
    if (!props.getApiRoute) return

    loadingRef.value = true
    try {
        const res = await api.get(props.getApiRoute)
        optionsRef.value = res.data
    } finally {
        loadingRef.value = false
    }
}

const finalOptions = computed(() => {
    return props.options.length ? props.options : optionsRef.value
})

// ==========================
// Init Select2 (SAFE)
// ==========================
const initSelect2 = async () => {
    if (!props.select2 || !selectRef.value) return

    await nextTick()

    const $select = window.$(selectRef.value)

    // Prevent duplicate init
    if ($select.hasClass('select2-hidden-accessible')) {
        $select.select2('destroy')
    }

    selectInstance = $select.select2({
        placeholder: props.placeholder,
        allowClear: !props.multiple,
        width: '100%',
        closeOnSelect: !props.multiple
    })

    // Set initial value safely
    $select.val(props.modelValue).trigger('change.select2')

    // Sync with v-model
    $select.on('change.select2', function () {
        const value = props.multiple
            ? ($(this).val() || [])
            : $(this).val()

        if (JSON.stringify(value) !== JSON.stringify(props.modelValue)) {
            emit('update:modelValue', value)
        }
    })
}

// ==========================
// Destroy Select2 (IMPORTANT)
// ==========================
const destroySelect2 = () => {
    if (!props.select2 || !selectRef.value) return

    const $select = window.$(selectRef.value)

    if ($select.hasClass('select2-hidden-accessible')) {
        $select.off('change.select2')
        $select.select2('destroy')
    }

    selectInstance = null
}

// ==========================
// Watch modelValue
// ==========================
watch(
    () => props.modelValue,
    async (val) => {
        if (!props.select2 || !selectRef.value) return

        const $select = window.$(selectRef.value)
        const currentVal = $select.val()

        if (JSON.stringify(currentVal) !== JSON.stringify(val)) {
            $select.val(val).trigger('change.select2')
        }
    }
)

// ==========================
// Watch options change
// ==========================
watch(
    () => JSON.stringify(finalOptions.value),
    async () => {
        if (!props.select2) return

        destroySelect2()
        await nextTick()
        initSelect2()
    }
)

// ==========================
// Lifecycle
// ==========================
onMounted(async () => {
    await loadOptions()
    await nextTick()

    if (props.select2) {
        initSelect2()
    }
})

onBeforeUnmount(() => {
    destroySelect2()
})
</script>

<template>
<div class="mb-2 me-2 justify-content-between">

    <label v-if="label" class="form-label">
        {{ label }}
    </label>

    <select
        ref="selectRef"
        :name="name"
        :multiple="multiple"
        :disabled="disabled"
        :class="[
            'form-selects',
            customClass,
            { 'is-invalid': error }
        ]"
        @change="!select2 && emit(
            'update:modelValue',
            multiple
                ? Array.from($event.target.selectedOptions).map(o => o.value)
                : $event.target.value
        )"
    >
        <option
            v-if="!multiple"
            value=""
            disabled
        >
            {{ loadingRef ? 'Loading...' : placeholder }}
        </option>

        <option
            v-for="option in finalOptions ?? []"
            :key="option.id"
            :value="option.id"
        >
            {{ option[optionKeyName] }}
        </option>
    </select>

    <small v-if="error" class="text-danger">
        {{ error }}
    </small>

</div>
</template>

<style>
    /* Increase Select2 height */
    .select2-container .select2-selection--single {
        height: 35px !important;
        /* padding: 8px 12px; */
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 35px !important;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        height: 35px !important;
    }

    /* Multiple Select height */
    .select2-container .select2-selection--multiple {
        min-height: 35px !important;
        /* padding: 5px; */
    }

    .form-label {
        color: #6c757d;
        text-transform: uppercase;
        font-size: 14px;
        font-weight: 600;
        color: #344767;
        margin-bottom: 6px;
        letter-spacing: 0.3px;
    }

</style>

<!-- 
    ---------------
    How to use
    ---------------
    <div class="col">
    //options through api call
        <BaseSelect
            v-model="form.category_id"
            name="category_id"
            :getApiRoute="route('selectable_statuses')" //or :optinons="categories"
            label="Category"
            placeholder="Choose category"                          
        />
        <div class="me-2">{{ form.category }}</div>
    </div>

    //options through and options array
    //pass select2 for single and select2 multiple for multiple
    <div class="col">
        <BaseSelect
        class="me-2"
        v-model="form.category_id"
        name="category_id"
        :options="categories"
        label="Country"
        select2
        multiple
        placeholder="Choose category"                                    
    />
    <div class="me-2">{{ form.category }}</div>              
</div>      

Supports
---------

    1. label
    2. name
    3. options array to build options (first priority)
    4. getApiRoute to call api for options (if optinos not provided)
    5. optionKeyName -- by default its name, some times may be type others
    6. placeholder
    7. error
    8. disabled


-->
