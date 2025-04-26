<template>
    <div class="flex items-center mb-2">
      <input
        v-bind="$attrs"
        :id="id"
        type="checkbox"
        v-model="model"
        class="h-4 w-4 text-blue-600 border-gray-300 rounded"
      />
      <label :for="id" class="ml-2 block text-sm text-gray-700">
        {{ label }}
      </label>
    </div>
  </template>
  
  <script setup>
  import { computed } from 'vue'
  
  const props = defineProps({
    modelValue: {
      type: [Boolean, Array],
      default: false,
    },
    label: {
      type: String,
      default: '',
    },
    value: {
      type: [String, Number, Boolean],
      default: true, 
      // used if inside a group
    },
    id: {
      type: String,
      default: () => `checkbox-${Math.random().toString(36).slice(2)}`,
    },
  })
  
  const emit = defineEmits(['update:modelValue'])
  
  const model = computed({
    get() {
      if (Array.isArray(props.modelValue)) {
        return props.modelValue.includes(props.value)
      }
      return props.modelValue
    },
    set(val) {
      if (Array.isArray(props.modelValue)) {
        const newValue = [...props.modelValue]
        if (val) {
          if (!newValue.includes(props.value)) {
            newValue.push(props.value)
          }
        } else {
          const index = newValue.indexOf(props.value)
          if (index > -1) {
            newValue.splice(index, 1)
          }
        }
        emit('update:modelValue', newValue)
      } else {
        emit('update:modelValue', val)
      }
    },
  })
  </script>
  

  <!-- uses -->
  <!-- ✅ Usage Examples
  1. Single Checkbox (Boolean)
  vue
  Copy
  Edit
  <script setup>
  import { BaseCheckbox } from 'core-lib'
  
  const isAgreed = ref(false)
  </script>
  
  <template>
    <BaseCheckbox
      v-model="isAgreed"
      label="I agree to the terms and conditions"
    />
  </template>
  🔵 Here isAgreed becomes true or false.
  
  2. Checkbox Group (Array)
  vue
  Copy
  Edit
  <script setup>
  import { BaseCheckbox } from 'core-lib'
  
  const selectedFruits = ref([])
  const fruits = ['Apple', 'Banana', 'Orange']
  </script>
  
  <template>
    <div>
      <div v-for="fruit in fruits" :key="fruit">
        <BaseCheckbox
          v-model="selectedFruits"
          :label="fruit"
          :value="fruit"
        />
      </div>
  
      <p class="mt-4">Selected Fruits: {{ selectedFruits.join(', ') }}</p>
    </div>
  </template>
  🔵 Here selectedFruits will be an array like ['Apple', 'Banana']. -->