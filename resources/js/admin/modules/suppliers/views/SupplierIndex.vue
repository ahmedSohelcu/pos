<template>
  <div class="container-fluid">
    <BaseTable
      label="Category Management"
      :columns="columns"
      :rows="expenseStore.rows"
      :loading="expenseStore.loading"
      :meta="expenseStore.meta"
      :filters="expenseFilters"
      :actions="expenseActionsActions"
      @query-change="expenseStore.updateQuery"
      @create="createFromTableBtn"
      @refresh="expenseStore.fetchData"
      @bulk-delete="expenseStore.bulkDelete"
    />

    <BaseModal
      v-model="expenseStore.showModal"
      size="md"
      :loading="expenseStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="
        expenseStore.mode === 'edit' ? 'Update Category' : 'Add New Category'
      "
      :confirmText="expenseStore.mode === 'edit' ? 'Update' : 'Create'"
    >
      <ExpenseForm
        :model="expenseStore.selectedItem ?? {}"
        :errors="expenseStore.errors ?? {}"
      />
    </BaseModal>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { expenseFilters } from './supplierFilters';
import { getExpenseActions } from './supplierActions';
// store
import { useExpenseStore } from '../store';
import BaseModal from '@kit/components/ui/BaseModal.vue';
import ExpenseForm from './SupplierForm.vue';
import { CATEGORY_ENDPOINTS } from '@/data/endpoint';

const expenseStore = useExpenseStore();

const closeModal = () => {
  expenseStore.loading = false;
};
// fetch data
onMounted(() => {
  expenseStore.fetchData();
});

//-------------------------
//load table actions button
//-------------------------
const expenseActionsActions = getExpenseActions(expenseStore);

const columns = [
  {
    label: '#',
    custom: (row, index) => index + 1,
  },
  {
    name: 'name',
    label: 'Category Name',
    sortable: true,
    custom: (row) => `<span class="badge bg-success">${row.name}</span>`,
  },
  {
    name: 'slug',
    label: 'Slug',
    sortable: true,
    custom: (row) => row.slug ?? '',
  },
  {
    name: 'tenant_id',
    label: 'Tenant',
    sortable: true,
    custom: (row) => {
      return `<span class="text-primary">${row.tenant?.name ?? '-'}</span>`;
    },
  },
  {
    name: 'status_id',
    label: 'Status',
    sortable: true,
    custom: (row) => {
      return `<span class="text-dark badge bg-${row.status?.class ?? ''}">${
        row.status?.name ?? '-'
      }</span>`;
    },
  },
  {
    name: 'created_at',
    label: 'Created At',
    sortable: true,
    custom: (row) => {
      return new Date(row.created_at).toLocaleString();
    },
  },
];

const createOrUpate = async () => {
  expenseStore.errors = {};
  if (expenseStore.mode === 'edit') {
    await expenseStore.update(
      CATEGORY_ENDPOINTS.update(expenseStore.selectedItem.id),
      expenseStore.selectedItem
    );
  } else {
    await expenseStore.create(
      CATEGORY_ENDPOINTS.store,
      expenseStore.selectedItem
    );
  }
};

const createFromTableBtn = () => {
  expenseStore.mode = 'create';
  expenseStore.errors = {};
  expenseStore.selectedItem = {};
  expenseStore.showModal = true;
};
</script>

<style scoped></style>
