<script setup>
    import { computed } from 'vue'

    const props = defineProps({
        modelValue: {
            type: [Array, String, Number, Boolean],
            default: () => []
        },
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

    // check if a value is selected
    const isChecked = (val) => {
    if (Array.isArray(props.modelValue)) {
        return props.modelValue.includes(val)
    }
    return props.modelValue === val
    }

    // toggle value in array (multiple) or single
    const toggle = (val, checked) => {
    if (Array.isArray(props.modelValue)) {
        let newVal = [...props.modelValue]
        if (checked) {
        if (!newVal.includes(val)) newVal.push(val)
        } else {
        newVal = newVal.filter(i => i !== val)
        }
        emit('update:modelValue', newVal)
    } else {
        emit('update:modelValue', checked ? val : null)
    }
    }
</script>

<template>
  <div class="mb-3">
    <label v-if="label" class="form-label fw-semibold">{{ label }}</label>

    <div>
      <div
        v-for="option in options"
        :key="option[valueKey]"
        class="form-check"
        :class="{ 'form-check-inline': inline }"
      >
        <input
          class="form-check-input"
          type="checkbox"
          :name="name"
          :id="`${name}_${option[valueKey]}`"
          :value="option[valueKey]"
          :checked="isChecked(option[valueKey])"
          @change="toggle(option[valueKey], $event.target.checked)"
        />
        <label
          class="form-check-label"
          :for="`${name}_${option[valueKey]}`"
        >
          {{ option[labelKey] }}
        </label>
      </div>
    </div>

    <div v-if="error" class="text-danger small mt-1">{{ error }}</div>
  </div>
</template>


<!--
    --------------
    How To Use
    --------------
    <BaseCheckbox
        v-model="form.fruits"
        name="fruits"
        label="fruits"
        :options="fruits"
        :error="errors.fruits"
        inline //or inline='true'
        labelKey="type" //defaut name
        />

        // Get selected value
        {{form.categories}}

        const fruits = [
            { id: 1, name: 'Banana'},
            { id: 2, name: 'Jack Fruits'},
            { id: 3, name: 'Pine Apple'},
        ]

        ** inline / inline='true'/ inline='false' 
        ** labelKey="name" / according to array key name like name/type etc

        // to make selected for edit update
        -----------------------------------
        ** form.fruits: [1, 2,3], --to make selected

        <p>Selected Fruit IDs: {{ form.fruits }}</p>
        ====================END===========================


        -------------------------------------
        //For Example
        -------------------------------------
         const { form, errors, submit, loading } = useForm({
            username: '',
            email: '',
            phone: '',
            time: '',
            status_id: 1,
            states: [],
            category: [],
            gender: 1,
            fruits: [1, 2,3],
        })

        // Submit Form
        const saveUser = async () => {
            console.log(form)
            // await submit(route('selectable_statuses'), 'GET')
            alert('Saved successfully')
        }
        -------------------------------------
-->