<template>
    <div class="mb-4">
      <label :for="id" class="block text-sm font-medium mb-1">{{ label }}</label>
      <select
        v-bind="$attrs"
        :id="id"
        :multiple="multiple"
        v-model="model"
        class="border rounded px-3 py-2 w-full"
        :size="multiple ? 5 : undefined"
      >
        <option
          v-if="!multiple && placeholder"
          disabled
          value=""
        >
          {{ placeholder }}
        </option>
  
        <option
          v-for="option in options"
          :key="option.value"
          :value="option.value"
        >
          {{ option.label }}
        </option>
      </select>
    </div>
  </template>
  
  <script setup>
  import { computed } from 'vue'
  
  const props = defineProps({
    modelValue: {
      type: [String, Number, Array],
      default: () => ([]),
    },
    label: {
      type: String,
      default: '',
    },
    options: {
      type: Array,
      default: () => [],
    },
    placeholder: {
      type: String,
      default: 'Select an option',
    },
    multiple: {
      type: Boolean,
      default: false,
    },
    id: {
      type: String,
      default: () => `select-${Math.random().toString(36).slice(2)}`,
    },
  })
  
  const emit = defineEmits(['update:modelValue'])
  
  const model = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
  })
  </script>
  

<!-- //========================================================== -->
  <!-- uses -->
<!-- //========================================================== -->
  <!-- Usage Examples
  Single Select:
  vue
  Copy
  Edit
  <script setup>
  import { BaseSelect } from 'core-lib'
  
  const selectedCountry = ref('')
  
  const countries = [
    { label: 'USA', value: 'us' },
    { label: 'Canada', value: 'ca' },
    { label: 'Mexico', value: 'mx' },
  ]
  </script>
  
  <template>
    <BaseSelect
      v-model="selectedCountry"
      label="Country"
      :options="countries"
      placeholder="Select country"
    />
  </template>
  Multiple Select:
  vue
  Copy
  Edit
  <script setup>
  import { BaseSelect } from 'core-lib'
  
  const selectedSkills = ref([])
  
  const skills = [
    { label: 'Vue.js', value: 'vue' },
    { label: 'React', value: 'react' },
    { label: 'Laravel', value: 'laravel' },
    { label: 'Node.js', value: 'node' },
  ]
  </script>
  
  <template>
    <BaseSelect
      v-model="selectedSkills"
      label="Skills"
      :options="skills"
      :multiple="true"
    />
  </template> -->
  