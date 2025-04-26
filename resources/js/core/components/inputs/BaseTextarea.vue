<template>
  <div class="mb-4">
    <label :for="id" class="block text-sm font-medium mb-1">{{ label }}</label>
    <textarea
      v-bind="$attrs"
      :id="id"
      v-model="model"
      class="border rounded px-3 py-2 w-full"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: String,
  label: String,
  id: {
    type: String,
    default: () => `textarea-${Math.random().toString(36).slice(2)}`,
  },
})

const emit = defineEmits(['update:modelValue'])

const model = computed({
  get: () => props.modelValue,
  set: value => emit('update:modelValue', value)
})
</script>
