<template>
  <form @submit.prevent>
    <!-- Header -->
    <div class="mb-4">
      <h5 class="fw-bold mb-1">Shop Information</h5>
      <small class="text-muted">Enter shop basic details below</small>
      <hr />
    </div>

    <div class="row g-3">
      <!-- ================= TENANT ================= -->
      <div class="col-md-6">
        <BaseSelect
          :getApiRoute="TENANT_ENDPOINTS.selectable"
          select2
          :class="'p-3 bg-light rounded-3 border h-100'"
          label="Tenant"
          v-model="model.tenant_id"
          :error="errors.tenant_id"
          name="tenant_id"
          placeholder="Choose Tenant"
        />
      </div>

      <!-- ================= PLAN ================= -->
      <div class="col-md-6">
        <BaseSelect
          :getApiRoute="PLAN_ENDPOINTS.selectable"
          select2
          :class="'p-3 bg-light rounded-3 border h-100'"
          label="Plan"
          v-model="model.plan_id"
          :error="errors.plan_id"
          name="plan_id"
          placeholder="Choose Plan"
        />
      </div>

      <!-- ================= START DATE ================= -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.starts_at"
          label="Start Date"
          :class="'p-3 bg-light rounded-3 border h-100'"
          type="date"
          :error="errors.starts_at"
          placeholder="Enter start date"
          icon="fa-calendar-day"
        />
      </div>

      <!-- ================= END DATE ================= -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.ends_at"
          label="End Date"
          type="date"
          :class="'p-3 bg-light rounded-3 border h-100'"
          :error="errors.ends_at"
          placeholder="Enter end date"
          icon="fa-calendar-day"
        />
      </div>

      <!-- ================= STATUS ================= -->
      <div class="col-md-6">
        <BaseSelect
          :getApiRoute="route('selectable_statuses', { type: 'subscription' })"
          select2
          label="Status"
          :class="'p-3 bg-light rounded-3 border h-100'"
          v-model="model.status_id"
          :error="errors.status_id"
          name="status_id"
          placeholder="Choose Status"
        />
      </div>

      <!-- ================= IS CURRENT ================= -->
      <div class="col-md-6">
        <BaseSwitch
          v-model="model.is_current"
          size="md"
          name="is_current"
          :class="'p-3 bg-light rounded-3 border h-100'"
          activeColor="#198754"
          inactiveColor="#dc3545"
          activeText="ACTIVE"
          inactiveText="INACTIVE"
          label="Current Subscription"
          :error="errors.is_current"
          description="Mark this subscription as active"
        />
      </div>
    </div>
  </form>
</template>

<script setup>
import { route } from 'ziggy-js';
import BaseSelect from '@kit/components/form/BaseSelect.vue';
import BaseInput from '@kit/components/form/BaseInput.vue';
import { PLAN_ENDPOINTS, TENANT_ENDPOINTS } from '../../../../data/endpoint';

const props = defineProps({
  model: Object, // tenantStore.selectedItem
  errors: Object, // tenantStore.errors
});
</script>
