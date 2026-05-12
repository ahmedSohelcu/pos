<template>
  <div class="container-fluid">
    <BaseTable
      label="Subscription History"
      :columns="columns"
      :rows="subscriptionStore.rows"
      :loading="subscriptionStore.loading"
      :meta="subscriptionStore.meta"
      :filters="subscriptionFilters"
      :actions="subscriptionActions"
      @query-change="subscriptionStore.updateQuery"
      @create="createFromTableBtn"
      @refresh="subscriptionStore.fetchData"
      @bulk-delete="subscriptionStore.bulkDelete"
      :createNewButton="false"
    />

    <BaseModal
      v-model="subscriptionStore.showModal"
      size="lg"
      :loading="subscriptionStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="
        subscriptionStore.mode === 'edit'
          ? 'Edit Subscription'
          : 'Create Tenant'
      "
      :confirmText="
        subscriptionStore.mode === 'edit' ? 'Update Subscription' : 'Create'
      "
    >
      <SubscriptionForm
        :model="subscriptionStore.selectedItem ?? {}"
        :errors="subscriptionStore.errors ?? {}"
      />
    </BaseModal>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { subscriptionFilters } from './subscriptionFilters';
import { getSubscriptionActions } from './subscriptionActions';
// store
import { useSubscriptionStore } from '../store';
import BaseModal from '@kit/components/ui/BaseModal.vue';
import SubscriptionForm from './SubscriptionForm.vue';
import { SUBSCRIPTION_ENDPOINTS } from '@/data/endpoint';

const subscriptionStore = useSubscriptionStore();

const closeModal = () => {
  subscriptionStore.loading = false;
};
// fetch data
onMounted(() => {
  subscriptionStore.fetchData();
});

//-------------------------
//load table actions button
//-------------------------
const subscriptionActions = getSubscriptionActions(subscriptionStore);

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
      return `<span class="badge bg-${row.status?.class ?? 'secondary'}">${row.status?.name ?? ''}</span>`;
    },
  },
];

const createOrUpate = async () => {
  subscriptionStore.errors = {};
  if (subscriptionStore.mode === 'edit') {
    await subscriptionStore.update(
      SUBSCRIPTION_ENDPOINTS.update(subscriptionStore.selectedItem.id),
      subscriptionStore.selectedItem
    );
  } else {
    await subscriptionStore.create(
      SUBSCRIPTION_ENDPOINTS.store,
      subscriptionStore.selectedItem
    );
  }
};

const createFromTableBtn = () => {
  subscriptionStore.mode = 'create';
  subscriptionStore.errors = {};
  subscriptionStore.selectedItem = {};
  subscriptionStore.showModal = true;
};
</script>

<style scoped></style>
