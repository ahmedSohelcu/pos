<script setup>
    import { ref, watch } from 'vue'

    const props = defineProps({
        modelValue: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            required: true
        },
        id: {
            type: String,
            default: ''
        },
        label: String,
        placeholder: String,
        rows: {
            type: Number,
            default: 3
        },
        error: String
    })

    const emit = defineEmits(['update:modelValue'])

    // Internal v-model binding
    const internalValue = ref(props.modelValue)

    // Watch internal value and emit updates
    watch(internalValue, (val) => {
        emit('update:modelValue', val)
    })

    // Keep internal value in sync if parent updates
    watch(() => props.modelValue, (val) => {
        internalValue.value = val
    })
</script>

<template>
  <div class="mb-3">
    <label v-if="label" class="form-label fw-semibold">{{ label }}</label>

    <textarea
      class="form-control"
      :id="id"
      :name="name"
      :placeholder="placeholder"
      :rows="rows"
      v-model="internalValue"
      :class="{ 'is-invalid': error }"
    ></textarea>

    <div v-if="error" class="text-danger small mt-1">{{ error }}</div>
  </div>
</template>


<!--

    ---------------
    How To Use
    ---------------
    <BaseTextarea
          v-model="form.description"
          name="description"
          label="Description"
          placeholder="Enter a description here..."
          :rows="5"
          :error="errors.description"
        />  
    
    -->