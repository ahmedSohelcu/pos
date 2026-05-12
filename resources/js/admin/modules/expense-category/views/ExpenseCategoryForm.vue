<template>
  <form @submit.prevent>
    <!-- Header -->
    <div class="mb-4">
      <h5 class="fw-bold mb-1">Expense Category</h5>
      <small class="text-muted">Enter basic information</small>
      <hr />
    </div>

    <!-- Shop Name -->
    <div class="col">
      <BaseInput
        v-model="model.name"
        label="Name"
        type="text"
        :error="errors.name"
        placeholder="Enter Category Name"
        icon="fa-store"
      />
    </div>

    <!-- Status -->
    <!-- <div class="col">
      <BaseSelect
        :getApiRoute="TENANT_ENDPOINTS.selectable"
        select2
        label="Tenants"
        v-model="model.tenant_id"
        :error="errors.tenant_id"
        name="tenant_id"
        placeholder="Choose Tenant"
      />
    </div> -->

    <div>
      <!-- Description -->
      <div class="col">
        <BaseTextArea
          v-model="model.description"
          label="Description"
          type="text"
          :error="errors.description"
          placeholder="Enter category description"
          icon="fa-align-left"
        />
      </div>
    </div>

    <div class="">
      <BaseSwitch
        v-model="model.is_active"
        size="sm"
        name="is_active"
        activeColor="#198754"
        inactiveColor="#dc3545"
        activeText="ACTIVE"
        inactiveText="INACTIVE"
        label="Category Status"
        :error="errors.is_active"
        description="Mark this category as active or inactive"
      />
    </div>
  </form>
</template>

<script setup>
import { route } from 'ziggy-js';
import BaseSelect from '@kit/components/form/BaseSelect.vue';
import BaseInput from '@kit/components/form/BaseInput.vue';
import BaseTextArea from '@kit/components/form/BaseTextarea.vue';
import { TENANT_ENDPOINTS } from '../../../../data/endpoint';

const props = defineProps({
  model: Object, // tenantStore.selectedItem
  errors: Object, // tenantStore.errors
});
</script>
