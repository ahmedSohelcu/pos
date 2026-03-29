<template>
  <form @submit.prevent>
    <!-- Header -->
    <div class="mb-4">
      <h5 class="fw-bold mb-1">Customer Information</h5>
      <small class="text-muted">Enter customer basic details below</small>
      <hr />
    </div>

    <div class="row g-3">
      <!-- Tenant -->
      <div v-if="auth?.user?.user_type === 'system_admin'" class="col-md-6">
        <BaseSelect
          :getApiRoute="TENANT_ENDPOINTS.selectable"
          select2
          label="Tenant"
          v-model="model.tenant_id"
          :error="errors.tenant_id"
          placeholder="Choose Tenant"
        />
      </div>

      <!-- Shop Name -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.name"
          label="Customer Name"
          type="text"
          :error="errors.name"
          placeholder="User name"
          icon="fa-store"
        />
      </div>

      <!-- Shop Email -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.email"
          label="Email"
          type="email"
          :error="errors.email"
          placeholder="Enter email"
          icon="fa-envelope"
        />
      </div>

      <!-- Phone -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.phone"
          label="Phone"
          type="text"
          :error="errors.phone"
          placeholder="Enter phone number"
          icon="fa-phone"
        />
      </div>

      <!-- Status -->
      <div class="col-md-6">
        <BaseSelect
          :getApiRoute="STATUS_ENDPOINTS.selectable('common')"
          select2
          label="Status"
          v-model="model.status_id"
          :error="errors.status_id"
          name="status_id"
          placeholder="Choose Status"
        />
      </div>

      <!-- Address -->
      <div class="col-md-12">
        <BaseTextarea
          v-model="model.address"
          label="Customer Address"
          :error="errors.address"
          placeholder="Enter customer address"
          icon="fa-location-dot"
        />
      </div>
    </div>
  </form>
</template>

<script setup>
import { route } from 'ziggy-js';
import BaseSelect from '@kit/components/form/BaseSelect.vue';
import BaseInput from '@kit/components/form/BaseInput.vue';
import { STATUS_ENDPOINTS, TENANT_ENDPOINTS } from '../../../../data/endpoint';
import { useAuthStore } from '../../../../ahmed-vue-kit/stores/authStore';
const auth = useAuthStore();

const props = defineProps({
  model: Object, // userStore.selectedItem
  errors: Object, // userStore.errors
});
</script>
