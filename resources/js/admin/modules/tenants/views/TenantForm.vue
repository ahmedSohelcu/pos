<template>
  <form @submit.prevent>
    <!-- Header -->
    <div class="mb-4">
      <h5 class="fw-bold mb-1">Shop Information</h5>
      <small class="text-muted">Enter shop basic details below</small>
      <hr />
    </div>

    <div class="row g-3">
      <!-- Shop Name -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.name"
          label="Shop Name"
          type="text"
          :error="errors.name"
          placeholder="Enter shop name"
          icon="fa-store"
        />
      </div>

      <!-- Shop Email -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.email"
          label="Shop Email"
          type="email"
          :error="errors.email"
          placeholder="Enter shop email"
          icon="fa-envelope"
        />
      </div>

      <!-- Phone -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.phone"
          label="Shop Phone"
          type="text"
          :error="errors.phone"
          placeholder="Enter phone number"
          icon="fa-phone"
        />
      </div>

      <!-- Status -->
      <div class="col-md-6">
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

      <!-- Address -->
      <div class="col-md-12">
        <BaseInput
          v-model="model.address"
          label="Shop Address"
          :error="errors.address"
          placeholder="Enter shop address"
          icon="fa-location-dot"
        />
      </div>
    </div>
  </form>
</template>

<script setup>
import { route } from 'ziggy-js';
import BaseSelect from '../../../../ahmed-vue-kit/components/form/BaseSelect.vue';
import BaseInput from '../../../../ahmed-vue-kit/components/form/BaseInput.vue';

const props = defineProps({
  model: Object, // tenantStore.selectedItem
  errors: Object, // tenantStore.errors
});
</script>
