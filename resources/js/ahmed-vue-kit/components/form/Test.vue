<template>
  <div>
    <h2>Test Component using Vite</h2>

    <select :value="modelValue" @change="handleChange" class="form-control">
      <option value="bd">Bangladesh</option>
      <option value="usa">USA</option>
    </select>
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: String,
});

const emit = defineEmits(['update:modelValue']);

const handleChange = (e) => {
  const value = e.target.value;

  // send value to parent
  emit('update:modelValue', value);
};
</script>
