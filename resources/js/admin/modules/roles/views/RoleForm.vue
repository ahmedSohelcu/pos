<template>
  <form @submit.prevent>
    <!-- Header -->
    <div class="mb-4">
      <h5 class="fw-bold mb-1">Role Information</h5>
    </div>

    <BaseInput
      v-model="model.name"
      label="Role Name"
      type="text"
      :error="errors.name"
      placeholder="Enter role name"
      icon="fa-store"
    />

    <BaseInput
      v-model="model.guard_name"
      label="Guard Name"
      type="text"
      :error="errors.guard_name"
      placeholder="Enter guard name"
      icon="fa-envelope"
    />
    <BaseSelect
      :getApiRoute="TENANT_ENDPOINTS.selectable"
      select2
      label="Tenant"
      v-model="model.tenant_id"
      :error="errors.tenant_id"
      name="tenant_id"
      placeholder="Choose Tenant"
    />
  </form>
</template>

<script setup>
import { route } from 'ziggy-js';
import BaseSelect from '@kit/components/form/BaseSelect.vue';
import BaseInput from '@kit/components/form/BaseInput.vue';
import { STATUS_ENDPOINTS } from '@/data/endpoint';
import { TENANT_ENDPOINTS } from '../../../../data/endpoint';

const props = defineProps({
  model: Object, // tenantStore.selectedItem
  errors: Object, // tenantStore.errors
});
</script>
