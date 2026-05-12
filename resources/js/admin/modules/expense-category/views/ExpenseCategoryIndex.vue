<template>
  <div class="container-fluid">
    <BaseTable
      label="Expense Category"
      :columns="columns"
      :rows="expenseCategoryStore.rows"
      :loading="expenseCategoryStore.loading"
      :meta="expenseCategoryStore.meta"
      :filters="expenseCategoryFilters"
      :actions="expenseCategoryActions"
      @query-change="expenseCategoryStore.updateQuery"
      @create="createFromTableBtn"
      @refresh="expenseCategoryStore.fetchData"
      @bulk-delete="expenseCategoryStore.bulkDelete"
    />

    <BaseModal
      v-model="expenseCategoryStore.showModal"
      size="lg"
      :loading="expenseCategoryStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="expenseCategoryStore.mode === 'edit' ? '' : ''"
      :confirmText="expenseCategoryStore.mode === 'edit' ? 'Update' : 'Create'"
    >
      <ExpenseCategoryForm
        :model="expenseCategoryStore.selectedItem ?? {}"
        :errors="expenseCategoryStore.errors ?? {}"
      />
    </BaseModal>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { expenseCategoryFilters } from './expenseCategoryFilters';
import { getExpenseCategoryActions } from './expenseCategoryActions';
// store
import { useExpenseCategoryStore } from '../store';
import BaseModal from '@kit/components/ui/BaseModal.vue';
import ExpenseCategoryForm from './ExpenseCategoryForm.vue';
import { EXPENSE_CATEGORY_ENDPOINTS } from '@/data/endpoint';

const expenseCategoryStore = useExpenseCategoryStore();

const closeModal = () => {
  expenseCategoryStore.loading = false;
};
// fetch data
onMounted(() => {
  expenseCategoryStore.fetchData();
});

//-------------------------
//load table actions button
//-------------------------
const expenseCategoryActions = getExpenseCategoryActions(expenseCategoryStore);

const columns = [
  {
    label: '#',
    custom: (row, index) => index + 1,
  },
  {
    name: 'name',
    label: 'Expense Category Name',
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
    name: 'is_active',
    label: 'Is Active',
    sortable: true,
    custom: (row) => {
      return `<span class="badge ${row.is_active ? 'bg-success' : 'bg-danger'}">${
        row.is_active ? 'Active' : 'Inactive'
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
  expenseCategoryStore.errors = {};
  if (expenseCategoryStore.mode === 'edit') {
    await expenseCategoryStore.update(
      EXPENSE_CATEGORY_ENDPOINTS.update(expenseCategoryStore.selectedItem.id),
      expenseCategoryStore.selectedItem
    );
  } else {
    await expenseCategoryStore.create(
      EXPENSE_CATEGORY_ENDPOINTS.store,
      expenseCategoryStore.selectedItem
    );
  }
};

const createFromTableBtn = () => {
  expenseCategoryStore.mode = 'create';
  expenseCategoryStore.errors = {};
  expenseCategoryStore.selectedItem = {};
  expenseCategoryStore.showModal = true;
};
</script>

<style scoped></style>
