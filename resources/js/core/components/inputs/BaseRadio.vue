<template>
    <div class="mb-4">
      <label class="block text-sm font-medium mb-2">{{ label }}</label>
  
      <div class="flex flex-col gap-2">
        <div
          v-for="option in options"
          :key="option.value"
          class="flex items-center"
        >
          <input
            v-bind="$attrs"
            type="radio"
            :id="`${id}-${option.value}`"
            :name="id"
            :value="option.value"
            v-model="model"
            class="h-4 w-4 text-blue-600 border-gray-300"
          />
          <label
            :for="`${id}-${option.value}`"
            class="ml-2 block text-sm text-gray-700"
          >
            {{ option.label }}
          </label>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { computed } from 'vue'
  
  const props = defineProps({
    modelValue: [String, Number],
    label: {
      type: String,
      default: '',
    },
    options: {
      type: Array,
      default: () => [],
      // [{ label: 'Male', value: 'male' }]
    },
    id: {
      type: String,
      default: () => `radio-${Math.random().toString(36).slice(2)}`,
    },
  })
  
  const emit = defineEmits(['update:modelValue'])
  
  const model = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
  })
  </script>
  


  <!-- uses -->
  <!-- Usage Example:
  vue
  Copy
  Edit
  <script setup>
  import { BaseRadio } from 'core-lib'
  
  const selectedGender = ref('')
  const genders = [
    { label: 'Male', value: 'male' },
    { label: 'Female', value: 'female' },
    { label: 'Other', value: 'other' },
  ]
  </script>
  
  <template>
    <div>
      <BaseRadio
        v-model="selectedGender"
        label="Gender"
        :options="genders"
      />
  
      <p class="mt-4">Selected Gender: {{ selectedGender }}</p>
    </div>
  </template>
  🎯 What Happens:
  User sees a list of radios (Male / Female / Other).
  
  Only one option can be selected at a time (standard radio behavior).
  
  selectedGender is updated automatically.
  
  Example after selecting:
  
  yaml
  Copy
  Edit
  Selected Gender: male -->

  
