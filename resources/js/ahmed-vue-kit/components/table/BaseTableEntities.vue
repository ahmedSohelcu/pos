<script setup>
import { ref, computed, onMounted, watch } from 'vue';

const props = defineProps({
  modelValue: {
    // for v-model support
    type: Number,
    default: 10,
  },
  entities: {
    type: Array,
    default: [
      {
        value: 5,
        label: '5',
      },
      {
        value: 10,
        label: '10',
      },
      {
        value: 25,
        label: '25',
      },
      {
        value: 50,
        label: '50',
      },
      {
        value: 100,
        label: '100',
      },
    ],
  },
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
  <div>
    <label>Show</label>
    <select
      :value="modelValue"
      @change="emit('update:modelValue', Number($event.target.value))"
      class="form-select"
      style="width: 100px; display: inline-block; margin-left: 5px"
    >
      <option
        v-for="entity in entities"
        :value="entity.value"
        :key="entity.value"
      >
        {{ entity.label }}
      </option>
    </select>
    <label class="mr-2">entries</label>
  </div>
</template>

<!-- How to use
    


-->
