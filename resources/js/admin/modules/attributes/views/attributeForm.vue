<template>
  <form>
    <div class="row g-4">
      <!-- Attribute Name -->
      <div class="col-12">
        <BaseInput
          v-model="model.name"
          label="Attribute Name"
          type="text"
          :error="errors.name"
          placeholder="Enter Attribute Name (Color, Size)"
          icon="fa-tag"
        />
      </div>

      <!-- Tenant -->
      <div class="col-12">
        <BaseSelect
          :getApiRoute="TENANT_ENDPOINTS.selectable"
          select2
          label="Tenant"
          v-model="model.tenant_id"
          :error="errors.tenant_id"
          name="tenant_id"
          placeholder="Choose Tenant"
        />
      </div>

      <!-- Status -->
      <div class="col-12">
        <BaseSwitch
          v-model="model.is_active"
          size="sm"
          name="is_active"
          activeColor="#198754"
          inactiveColor="#dc3545"
          activeText="ACTIVE"
          inactiveText="INACTIVE"
          label="Attribute Status"
          :error="errors.is_active"
          description="Mark this attribute as active or inactive"
        />
      </div>

      <!-- Attribute Values -->
      <div class="col-12">
        <label class="form-label fw-bold">Attribute Values</label>

        <div
          v-for="(val, index) in values"
          :key="val.id ?? index"
          class="mb-3 d-flex align-items-center gap-2"
        >
          <BaseInput
            v-model="val.value"
            type="text"
            placeholder="Enter value (e.g. Red, Large)"
            class="flex-grow-1"
          />

          <div class="d-flex gap-1 mb-3">
            <button
              v-if="values.length > 1"
              type="button"
              class="btn btn-outline-danger btn-sm"
              @click="removeValue(index)"
            >
              <i class="fa fa-trash"></i> Remove
            </button>

            <button
              v-if="index === values.length - 1 || values.length === 0"
              type="button"
              class="btn btn-outline-primary btn-sm"
              @click="addValue"
            >
              <i class="fa fa-plus"></i> Add
            </button>
          </div>
        </div>

        <div class="mt-2 text-muted">
          <strong>Existing Values:</strong>
          {{ model?.values?.map((v) => v.value).join(', ') ?? 'None' }}
        </div>
      </div>
    </div>
  </form>
</template>

<script setup>
import { ref, watch } from 'vue';
import BaseSelect from '@kit/components/form/BaseSelect.vue';
import BaseInput from '@kit/components/form/BaseInput.vue';
import BaseSwitch from '@kit/components/form/BaseSwitch.vue';
import { TENANT_ENDPOINTS } from '../../../../data/endpoint';

const props = defineProps({
  model: Object,
  errors: Object,
});

const values = ref([]);

watch(
  () => props.model,
  (model) => {
    if (model && model.values && model.values.length) {
      values.value = model.values.map((v) => ({
        id: v.id,
        value: v.value,
      }));
    } else {
      // ensure at least one row exists
      values.value = [{ id: null, value: '' }];
    }
  },
  { immediate: true }
);

function addValue() {
  values.value.push({ id: null, value: '' });
}

function removeValue(index) {
  values.value.splice(index, 1);
}

function prepareValues() {
  return values.value
    .filter((v) => v.value && v.value.trim() !== '')
    .map((v) => ({
      id: v.id,
      value: v.value,
    }));
}

defineExpose({
  prepareValues,
});
</script>
