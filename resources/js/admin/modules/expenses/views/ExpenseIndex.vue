<template>
  <div class="container-fluid">
    <BaseTable
      label="Expense Management"
      :columns="columns"
      :rows="expenseStore.rows"
      :loading="expenseStore.loading"
      :meta="expenseStore.meta"
      :filters="expenseFilters"
      :actions="expenseActions"
      @query-change="expenseStore.updateQuery"
      @create="createFromTableBtn"
    />
    <BaseModal
      v-model="expenseStore.showModal"
      size="lg"
      :loading="expenseStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="expenseStore.mode === 'edit' ? '' : ''"
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
import { expenseFilters } from './expenseFilters';
import { getExpenseActions } from './expenseActions';
// store
import { useExpenseStore } from '../store';
import BaseModal from '@kit/components/ui/BaseModal.vue';
import ExpenseForm from './ExpenseForm.vue';
import { EXPENSE_ENDPOINTS } from '@/data/endpoint';
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
const expenseActions = getExpenseActions(expenseStore);

const columns = [
  {
    label: '#',
    custom: (row, index) => index + 1,
  },
  {
    name: 'note',
    label: 'Expense',
    sortable: true,

    // custom: (row) => `<span class="badge bg-success">${row.note}</span>`,
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
      EXPENSE_ENDPOINTS.update(expenseStore.selectedItem.id),
      expenseStore.selectedItem
    );
  } else {
    await expenseStore.create(
      EXPENSE_ENDPOINTS.store,
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
