<script setup>
    
    import { computed } from 'vue'

    /**
     * Props for the BaseInput component
     * @typedef {Object} BaseInputProps
     * @property {String|Number} modelValue - The value of the input
     * @property {String} [label] - The label for the input
     * @property {String} [type=text] - The type of the input (e.g. text, email, password, etc.)
     * @property {String} [error] - The error message to display
     * @property {String} [placeholder] - The placeholder text for the input
     */
    const props = defineProps({
        modelValue: {
            type: [String, Number],
            default: '',
        },                
        label: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            default: ''
        },
        type: {
            type: String,
            default: 'text'
        },       
        placeholder: {
            type: String,
            default: ''
        },
        disabled: {
            type: Boolean,
            default: false
        },    
        error: {
            type: String,
            default: ''
        },
        customClass: {
            type: String,
            default: ''
        },
        size: {
            type: String,
            default: 'md',
            validator: v => ['sm','md','lg'].includes(v)
        }
    })

    /**
     * Emits an event to update the modelValue
     * @param {String|Number} value - The new value of the input
     */
    const emit = defineEmits(['update:modelValue'])

    const sizeClass = computed(() => {
        return props.size === 'md' ? '' : `form-control-${props.size}`
    })
</script>

<template>
  <div class="mb-3">
    <label v-if="label" class="form-label">{{ label }}</label>
    
    <input
      :type="type"      
      :placeholder="placeholder"
      :value="modelValue"
      :class="['form-control', sizeClass, { 'is-invalid': error }, customClass]"
      :disabled="disabled"
      @input="emit('update:modelValue', $event.target.value)"
    />

    <small v-if="error" class="text-danger">{{ error }}</small>
  </div>
</template>

    
// Example how to use the component
<!-- 
const form = reactive({
  name: '',
  email: ''
})-->
<!-- 
<BaseInput
    label="Name"
    name="name"
    :modelValue="form.name"
    placeholder="Enter your name"
    error="Please enter your name"
    @update:modelValue="val => name = val"
/>

 <div class="col">
            <BaseInput
              class="me-2"
              label="Name"      
              error=""
              placeholder="Enter your name"
              @update:modelValue="val => form.name = val"
            />
            <div class="me-2">{{ form.name }}</div>
          </div>
          
OR

<BaseInput
    label="Name"
    v-model="form.name"
    :modelValue="form.name"
    placeholder="Enter your name"
            error="Please enter your name"
/>
-->
