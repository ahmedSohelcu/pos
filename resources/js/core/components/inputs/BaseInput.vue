<template>
    <div class="mb-4">
      <label :for="id" class="block text-sm font-medium mb-1">{{ label }}</label>
      <input
        v-bind="$attrs"
        :id="id"
        :type="type"
        v-model="model"
        class="border rounded px-3 py-2 w-full"
      />
    </div>
  </template>
  
  <script setup>
  import { computed } from 'vue'
  
  const props = defineProps({
    modelValue: [String, Number],
    type: {
      type: String,
      default: 'text',
    },
    label: {
      type: String,
      default: '',
    },
    id: {
      type: String,
      default: () => `input-${Math.random().toString(36).slice(2)}`,
    },
  })
  
  const emit = defineEmits(['update:modelValue'])
  
  const model = computed({
    get: () => props.modelValue,
    set: value => emit('update:modelValue', value)
  })
  </script>
  


<!-- 
//=====================================
  Uses: 
//=====================================
 -->

<!-- 
    Can reuse it for
             text,
             email,
             number,
             password
            
             just by changing the type prop.

            It supports v-model naturally.
 -->



 <!-- How to Use in Laravel Vue project:
vue
Copy
Edit
<script setup>
import { BaseInput, BaseFileUpload } from 'core-lib'

const name = ref('')
const email = ref('')
const files = ref([])
</script>

<template>
  <form>
    <BaseInput v-model="name" label="Name" />
    <BaseInput v-model="email" label="Email" type="email" />
    <BaseFileUpload v-model:files="files" label="Upload files" multiple />
  </form>
</template> -->