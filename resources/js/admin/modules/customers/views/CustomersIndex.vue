<template>
  <div class="container-fluid">
    <BaseTable
      label="Customer Management"
      :columns="columns"
      :rows="customerStore.rows"
      :loading="customerStore.loading"
      :meta="customerStore.meta"
      :filters="customerFilters"
      :actions="customerActions"
      @query-change="customerStore.updateQuery"
      @create="createFromTableBtn"
      @refresh="customerStore.fetchData"
      @bulk-delete="customerStore.bulkDelete"
    />

    <BaseModal
      v-model="customerStore.showModal"
      size="lg"
      :loading="customerStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="customerStore.mode === 'edit' ? '' : ''"
      :confirmText="customerStore.mode === 'edit' ? 'Update' : 'Create'"
    >
      <CustomerForm
        :model="customerStore.selectedItem ?? {}"
        :errors="customerStore.errors ?? {}"
      />
    </BaseModal>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { useCustomerStore } from '../store';
import { getCustomerActions } from './customerActions';
import { customerFilters } from './customerFilters';
import BaseModal from '@kit/components/ui/BaseModal.vue';
import { CUSTOMER_ENDPOINTS } from '@/data/endpoint';
import CustomerForm from './CustomerForm.vue';
const customerStore = useCustomerStore();

onMounted(() => {
  customerStore.fetchData();
});

const closeModal = () => {
  customerStore.loading = false;
};
//---------------------------
// load tenant action buttons
//---------------------------
const customerActions = getCustomerActions(customerStore);

//-----------------------
//Table Column
//-----------------------
const columns = [
  {
    label: '#',
    sortable: false,
    custom: (row, index) => index + 1,
  },
  {
    name: 'name',
    label: 'Customer Name',
    sortable: true,
    custom: (row) =>
      `<span class="badge bg-success">${row.user?.name ?? ''}</span>`,
  },
  {
    name: 'email',
    label: 'Email',
    sortable: true,
    custom: (row) =>
      `<button class='btn btn-sm btn-outline-successs'>${row.use?.email ?? ''}</button>`,
  },
  {
    name: 'phone',
    label: 'Phone',
    sortable: true,
    custom: (row) =>
      `<button class='btn btn-sm btn-outline-successs'>${row.user?.phone ?? ''}</button>`,
  },
  { name: 'address', label: 'Address', sortable: true },
  {
    name: 'created_at',
    label: 'Created At',
    sortable: true,
    custom: (row) => {
      return new Date(row?.created_at).toLocaleString();
    },
  },
  {
    name: 'status_id',
    label: 'Status',
    sortable: true,
    custom: (row) => {
      return `<span class="badge bg-${row.status?.class ?? 'secondary'}">${row.status?.name ?? ''}</span>`;
    },
  },
];

const createOrUpate = async () => {
  customerStore.errors = {};
  if (customerStore.mode === 'edit') {
    await customerStore.update(
      CUSTOMER_ENDPOINTS.update(customerStore.selectedItem.id),
      customerStore.selectedItem
    );
  } else {
    await customerStore.create(
      CUSTOMER_ENDPOINTS.store,
      customerStore.selectedItem
    );
  }
};

const createFromTableBtn = () => {
  customerStore.mode = 'create';
  customerStore.errors = {};
  customerStore.selectedItem = {};
  customerStore.showModal = true;
};
</script>

<style scoped></style>
