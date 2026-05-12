<template>
  <form @submit.prevent>
    <!-- Header -->
    <div class="mb-4">
      <h5 class="fw-bold mb-1">Plan Information</h5>
      <small class="text-muted">Enter Plan basic details below</small>
      <hr />
    </div>

    <div class="row g-3">
      <!-- Plan Name -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.name"
          label="Name"
          type="text"
          :error="errors.name"
          placeholder="Enter name"
          icon="fa-store"
        />
      </div>

      <!-- Shop Email -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.price"
          label="Price"
          type="number"
          :error="errors.price"
          placeholder="Enter price"
          icon="fa-envelope"
        />
      </div>

      <div class="col-md-6">
        <BaseSelect
          select2
          :options="[
            { id: 'monthly', name: 'Monthly' },
            { id: 'yearly', name: 'Yearly' },
          ]"
          label="Billing Interval"
          v-model="model.billing_interval"
          :error="errors.billing_interval"
          placeholder="Choose Interval"
        />
      </div>

      <!-- Phone -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.trial_days"
          label="Trial days"
          type="number"
          :error="errors.trial_days"
          placeholder="Enter trial days"
          icon="fa-phone"
        />
      </div>

      <!-- max_users -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.max_users"
          label="Max Users"
          type="number"
          :error="errors.max_users"
          placeholder="Enter max users"
          icon="fa-phone"
        />
      </div>

      <!-- max_products -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.max_products"
          label="Max Products"
          type="number"
          :error="errors.max_products"
          placeholder="Enter max products"
          icon="fa-phone"
        />
      </div>

      <div class="offset-md-6 col-md-6">
        <BaseSwitch
          v-model="model.is_active"
          size="md"
          name="is_active"
          activeColor="#198754"
          inactiveColor="#dc3545"
          activeText="ACTIVE"
          inactiveText="INACTIVE"
          label="Current Plan"
          :error="errors.is_active"
          description="Mark this plan as active or inactive"
        />
      </div>

      <!-- max_users -->
      <!-- <div class="col-md-6">
        <BaseInput
          v-model="model.max_branches"
          label="Max Branches"
          type="number"
          :error="errors.max_branches"
          placeholder="Enter max branches"
          icon="fa-phone"
        />
      </div> -->

      <!-- Is Active -->
      <!-- <div class="col-md-6">
        <BaseSelect
          :options="[
            { id: 1, name: 'Active'  },
            { id: 0, name: 'Inactive' },
          ]"
          select2
          label="Is Active"
          v-model="model.is_active"
          :error="errors.is_active"
          name="is_active"
          placeholder="Choose Status"
        />
      </div> -->

      <!-- description -->
      <div class="col-md-12">
        <BaseTextarea
          v-model="model.description"
          label="Description"
          :error="errors.description"
          placeholder="Enter details"
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
import { reactive } from 'vue';
const billing_intervals = reactive(['monthly', 'yearly']);
const props = defineProps({
  model: Object, // tenantStore.selectedItem
  errors: Object, // tenantStore.errors
});
</script>
