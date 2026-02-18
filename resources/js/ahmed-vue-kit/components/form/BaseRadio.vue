<script setup>
    import { computed } from 'vue'

    const props = defineProps({
        modelValue: [String, Number, Boolean],
        options: {
            type: Array,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        label: String,
        error: String,
        inline: {
            type: Boolean,
            default: false
        },
        valueKey: {
            type: String,
            default: 'id'
        },
        labelKey: {
            type: String,
            default: 'name'
        }
    })

    const emit = defineEmits(['update:modelValue'])

    const updateValue = (value) => {
    emit('update:modelValue', value)
    }

    const wrapperClass = computed(() => {
        return props.inline ? 'd-flex gap-3' : ''
    })
</script>

<template>
  <div class="mb-3">
    <label v-if="label" class="form-label fw-semibold">
      {{ label }}
    </label>

    <div :class="wrapperClass">
      <div
        v-for="option in options"
        :key="option[valueKey]"
        class="form-check"
        :class="{ 'form-check-inline': inline }"
      >
        <input
          class="form-check-input"
          type="radio"
          :name="name"
          :id="`${name}_${option[valueKey]}`"
          :value="option[valueKey]"
          :checked="modelValue == option[valueKey]"
          @change="updateValue(option[valueKey])"
        />

        <label
          class="form-check-label"
          :for="`${name}_${option[valueKey]}`"
        >
          {{ option[labelKey] }}
        </label>
      </div>
    </div>

    <div v-if="error" class="text-danger small mt-1">
      {{ error }}
    </div>
  </div>
</template>



    
<!-------------------
     how to use
-----------------
    <BaseRadio
        v-model="form.gender"
        name="gender"
        label="Gender"
        :options="genders"
        :error="errors.gender"
        :inline="true" // OR inline
    />

    01. labelKey="name" //by default name
    const genders = [
        { id: 1, gender: 'Male'},
        { id: 2, gender: 'Female'},
        { id: 3, gender: 'Others'},
    ]

    02. labelKey="gender" //by default name
    const genders = [
        { id: 1, gender: 'Male'},
        { id: 2, gender: 'Female'},
        { id: 3, gender: 'Others'},
    ]
-->