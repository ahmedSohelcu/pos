<template>
  <div class="container-fluid">
    <BaseTable
      label="Tenant Management"
      :columns="columns"
      :rows="tenantStore.rows"
      :loading="tenantStore.loading"
      :meta="tenantStore.meta"
      :filters="tenantFilters"
      :actions="tenantActions"
      @query-change="tenantStore.updateQuery"
      @create="createFromTableBtn"
      @refresh="tenantStore.fetchData"
      @bulk-delete="tenantStore.bulkDelete"
    />
    {{ auth.permissions }}
    <BaseModal
      v-model="tenantStore.showModal"
      size="lg"
      :loading="tenantStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="tenantStore.mode === 'edit' ? '' : 'Create Tenant'"
      :confirmText="tenantStore.mode === 'edit' ? 'Update' : 'Create'"
    >
      <TenantForm
        :model="tenantStore.selectedItem ?? {}"
        :errors="tenantStore.errors ?? {}"
      />
    </BaseModal>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { tenantFilters } from './tenantFilters';
import { getTenantActions } from './tenantActions';
// store
import { useTenantStore } from '../store';
import BaseModal from '@kit/components/ui/BaseModal.vue';
import TenantForm from './TenantForm.vue';
import { TENANT_ENDPOINTS } from '@/data/endpoint';
import { useAuthStore } from '../../../../ahmed-vue-kit/stores/authStore';

const tenantStore = useTenantStore();
const auth = useAuthStore();
const closeModal = () => {
  tenantStore.loading = false;
};
// fetch data
onMounted(() => {
  tenantStore.fetchData();
});

//-------------------------
//load table actions button
//-------------------------
const tenantActions = getTenantActions(tenantStore);

const columns = [
  { name: 'id', label: 'ID', sortable: true },
  {
    name: 'name',
    label: 'Shop Name',
    sortable: true,
    custom: (row) => `<span class="badge bg-success">${row.name}</span>`,
  },
  {
    name: 'email',
    label: 'Email',
    sortable: true,
    custom: (row) =>
      `<button class='btn btn-sm btn-outline-successs'>${row.email}</button>`,
  },
  { name: 'phone', label: 'Phone', sortable: true },
  { name: 'address', label: 'Address', sortable: true },
  {
    name: 'created_at',
    label: 'Created At',
    sortable: true,
    custom: (row) => {
      return new Date(row.created_at).toLocaleString();
    },
  },
  {
    name: 'status_id',
    label: 'Status',
    sortable: true,
    custom: (row) => {
      return `<span class="badge bg-${row.status?.class ?? 'secondary'}">${
        row.status?.name ?? ''
      }</span>`;
    },
  },
];

const createOrUpate = async () => {
  tenantStore.errors = {};
  if (tenantStore.mode === 'edit') {
    await tenantStore.update(
      TENANT_ENDPOINTS.update(tenantStore.selectedItem.id),
      tenantStore.selectedItem
    );
  } else {
    await tenantStore.create(TENANT_ENDPOINTS.store, tenantStore.selectedItem);
  }
};

const createFromTableBtn = () => {
  tenantStore.mode = 'create';
  tenantStore.errors = {};
  tenantStore.selectedItem = {};
  tenantStore.showModal = true;
};
</script>

<style scoped></style>
