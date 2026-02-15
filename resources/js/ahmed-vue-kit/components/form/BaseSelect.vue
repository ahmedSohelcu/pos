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
        optionKeyName: {
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
  <div class="mb-2 me-2 justify-content-between mb-2">
    <label v-if="label" class="form-label">{{ label ?? '' }}</label>    
    
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
        {{ option[optionKeyName] }} 
      </option>
    </select>
    <small v-if="error" class="text-danger">{{ error }}</small>
  </div>
</template>

<!-- How to use
    <div class="col">
    //options through api call
        <BaseSelect
            class="me-2"
            v-model="form.category"
            name="category_id"
            :getApiRoute="route('selectable_statuses')"
            label="Category"
            placeholder="Choose category"                          
        />
        <div class="me-2">{{ form.category }}</div>
    </div>

    //options through and options array
    <div class="col">
        <BaseSelect
        class="me-2"
        v-model="form.category"
        name="category_id"
        :options="categories"
        label="Country"
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
