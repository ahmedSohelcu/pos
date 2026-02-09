<script setup>
    import { ref, computed, onMounted, watch } from 'vue'
    import api from '../../api/api'

    const props = defineProps({
        modelValue: {
            type: [String, Number],
            default: '' 
        },
        label: {
            type: String,
            default: '' 
        },
        name: {
            type: String,
            default: ''
        },
        options: {
            type: Array,
            default: () => [] 
        },
        getApiRoute: {
            type: String,
            default: ''
        },
        optionName: {
            type: String,
            default: 'name' 
        },
        placeholder: {
            type: String,
            default: 'Select an option' 
        },
        error: {
            type: String,
            default: '' 
        },
        disabled: {
            type: Boolean,
            default: false 
        },
        select2: {
            type: Boolean,
            default: true 
        },
        multiple: {
            type: Boolean,
            default: false 
        },
        customClass: {
            type: String,
            default: '' 
        },
    });

    const optionsRef = ref([]);
    const loadingRef = ref(false);

    const emit = defineEmits(['update:modelValue'])

    const loadOptions = async () => {
        if (props.getApiRoute) {
            loadingRef.value = true
            try {
                const res = await api.get(props.getApiRoute);
                optionsRef.value = res.data;
            } finally {
                loadingRef.value = false
            }
        }
    }

    const selectedOption = computed(
        () => optionsRef.value.find(o => o.id === props.modelValue)
    )

    const finalOptions = computed(() => {
        if (props.options.length) return props.options
        return optionsRef.value
    })

    onMounted(() => {
        loadOptions();
    })

</script>

<template>
  <div class="mb-3">
    <label v-if="label" class="form-label">{{ label }}</label>    
    <select
      :name="name"
      :class="['form-select', { 'activate-select2': select2, 'is-invalid': error }]"
      :multiple="multiple"
      :value="modelValue"
      :disabled="disabled"
      @change="emit('update:modelValue', $event.target.value)"
    >
      <option value="" disabled>
        {{ loadingRef ? 'Loading...' : placeholder }}
      </option>

      <option v-for="option in finalOptions ?? []" :key="option.id" :value="option.id">
        {{ option[optionName] }}
      </option>
    </select>
    <small v-if="error" class="text-danger">{{ error }}</small>
  </div>
</template>

