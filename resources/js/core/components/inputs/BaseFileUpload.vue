<template>
    <div class="mb-4">
      <label :for="id" class="block text-sm font-medium mb-1">{{ label }}</label>
      <input
        v-bind="$attrs"
        :id="id"
        type="file"
        :multiple="multiple"
        @change="onFileChange"
        class="block w-full text-sm text-gray-500"
      />
    </div>
  </template>
  
  <script setup>
  const props = defineProps({
    label: String,
    multiple: {
      type: Boolean,
      default: false,
    },
    id: {
      type: String,
      default: () => `file-${Math.random().toString(36).slice(2)}`,
    },
  })
  
  const emit = defineEmits(['update:files'])
  
  function onFileChange(event) {
    const files = event.target.files
    emit('update:files', props.multiple ? [...files] : files[0])
  }
  </script>
  