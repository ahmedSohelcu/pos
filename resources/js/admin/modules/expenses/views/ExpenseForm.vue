<template>
  <form @submit.prevent>
    <!-- Header -->
    <div class="mb-4">
      <h5 class="fw-bold mb-1">Expense</h5>
      <small class="text-muted">Enter basic information</small>
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

      <!-- <input type="hidden" name="tenant_id" :v-model="auth.user.tenant_id ?? null" /> -->

      <!-- Expense Category -->
      <div class="col-md-6">
        <BaseSelect
          :getApiRoute="EXPENSE_CATEGORY_ENDPOINTS.selectable"
          select2
          label="Expense Category"
          v-model="model.expense_category_id"
          :error="errors.expense_category_id"
          name="expense_category_id"
          placeholder="Choose Expense Category"
        />
      </div>

      <!-- Amount -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.amount"
          label="Amount"
          type="number"
          :error="errors.amount"
          placeholder="Enter amount"
          icon="fa-money-bill-alt"
        />
      </div>

      <!-- Expense Date -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.expense_date"
          label="Expense Date"
          type="date"
          :error="errors.expense_date"
          placeholder="Enter expense date"
          icon="fa-calendar-day"
        />
      </div>

      <!-- Reference -->
      <div class="col-md-6">
        <BaseInput
          v-model="model.reference"
          label="Reference"
          type="text"
          :error="errors.reference"
          placeholder="Enter reference"
          icon="fa-file-alt"
        />
      </div>

      <!-- Status -->
      <div class="col-md-6">
        <BaseSelect
          :getApiRoute="route('selectable_statuses', { type: 'common' })"
          select2
          label="Status"
          v-model="model.status_id"
          :error="errors.status_id"
          name="status_id"
          placeholder="Choose Status"
        />
      </div>

      <!-- Note -->
      <div class="col-md-12">
        <BaseTextarea
          v-model="model.note"
          label="Note"
          :error="errors.note"
          placeholder="Enter note"
          icon="fa-align-left"
        />
      </div>
    </div>
  </form>
</template>

<script setup>
import { route } from "ziggy-js";
import BaseSelect from "@kit/components/form/BaseSelect.vue";
import BaseInput from "@kit/components/form/BaseInput.vue";
import { EXPENSE_CATEGORY_ENDPOINTS, TENANT_ENDPOINTS } from "../../../../data/endpoint";
import { useAuthStore } from "../../../../ahmed-vue-kit/stores/authStore";

const auth = useAuthStore();

const props = defineProps({
  model: Object, // tenantStore.selectedItem
  errors: Object, // tenantStore.errors
});
</script>
