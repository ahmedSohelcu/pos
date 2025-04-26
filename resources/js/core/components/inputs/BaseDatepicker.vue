<template>
    <div class="mb-4">
      <label :for="id" class="block text-sm font-medium mb-1">{{ label }}</label>
  
      <input
        v-bind="$attrs"
        :id="id"
        type="date"
        v-model="model"
        class="border rounded px-3 py-2 w-full"
      />
  
      <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
    </div>
  </template>
  
  <script setup>
  import { computed } from 'vue'
  
  const props = defineProps({
    modelValue: String,
    label: {
      type: String,
      default: '',
    },
    error: {
      type: String,
      default: '',
    },
    id: {
      type: String,
      default: () => `date-${Math.random().toString(36).slice(2)}`,
    },
  })
  
  const emit = defineEmits(['update:modelValue'])
  
  const model = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
  })
  </script>



<!-- Usage Example
vue
Copy
Edit
<script setup>
import { BaseDatePicker } from 'core-lib'

const birthdate = ref('')
</script>

<template>
  <BaseDatePicker
    v-model="birthdate"
    label="Birth Date"
  />

  <p class="mt-4">Selected Date: {{ birthdate }}</p>
</template>
🎯 Behavior:
You get a calendar popup (browser native date picker).

birthdate will become like: '2025-04-26' (YYYY-MM-DD format).

Works super clean with v-model.

✅ Laravel validation for Date
When you submit the form, on Laravel backend:

php
Copy
Edit
$request->validate([
    'birthdate' => 'required|date',
]);
Easy and safe! -->
  

<!-- you can later integrate vue-datepicker libraries like:

vue3-datepicker

vue-cal

v-calendar -->