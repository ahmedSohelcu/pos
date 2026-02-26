<template>
  <div class="container-fluid">
    <BaseTable
      label="User Management"
      :columns="columns"
      :rows="rows"
      :show-search="true"
      :actions="tenantActions"
      :filters="tenantFilters"
      @query-change="handleQueryChange"
    />
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import useApiTable from '../../../../ahmed-vue-kit/composables/useApiTable';
import { tenantFilters } from './tenantFilters';
import { tenantActions } from './tenantActions';

const { query, rows, loading, meta, fetchData, handleQueryChange } =
  useApiTable('http://lara-vue-admin.test/api/v1/tenants');

onMounted(async () => {
  await fetchData();
});

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
      `<button class='btn btn-sm btn-primary'>${row.email}</button>`,
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
    name: 'status',
    label: 'Status',
    sortable: true,
    custom: (row) => {
      return `<span class="badge bg-${row.status === 'active' ? 'success' : 'danger'}">${row.status}</span>`;
    },
  },
];
</script>

<style scoped></style>
