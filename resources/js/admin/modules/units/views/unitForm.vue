<template>
  <form @submit.prevent>
    <!-- Header -->
    <!-- <div class="mb-4"> -->
    <!-- <h5 class="fw-bold mb-1">Shop Information</h5> -->
    <!-- <small class="text-muted">Enter shop basic details below</small> -->
    <!-- <hr /> -->
    <!-- </div> -->

    <div class="rodw g-3">
      <!-- Unit Name -->
      <div class="col">
        <BaseInput
          v-model="model.name"
          label="Name"
          type="text"
          :error="errors.name"
          placeholder="Enter Unit Name"
          icon="fa-store"
        />
      </div>

      <div class="col">
        <BaseInput
          v-model="model.short_name"
          label="Short Name"
          type="text"
          :error="errors.short_name"
          placeholder="Enter Unit Name"
          icon="fa-store"
        />
      </div>

      <!-- Status -->
      <div class="col">
        <BaseSelect
          :getApiRoute="TENANT_ENDPOINTS.selectable"
          select2
          label="Tenants"
          v-model="model.tenant_id"
          :error="errors.tenant_id"
          name="tenant_id"
          placeholder="Choose Tenant"
        />
      </div>

      <!-- Status -->
      <div class="col">
        <BaseSelect
          :getApiRoute="route('selectable_statuses', { type: 'user' })"
          select2
          label="Status"
          v-model="model.status_id"
          :error="errors.status_id"
          name="status_id"
          placeholder="Choose Status"
        />
      </div>
    </div>
  </form>
</template>

<script setup>
  import { route } from 'ziggy-js';
  import BaseSelect from '@kit/components/form/BaseSelect.vue';
  import BaseInput from '@kit/components/form/BaseInput.vue';
  import { TENANT_ENDPOINTS, UNIT_ENDPOINTS } from '../../../../data/endpoint';

  const props = defineProps({
    model: Object, // tenantStore.selectedItem
    errors: Object, // tenantStore.errors
  });
</script>
