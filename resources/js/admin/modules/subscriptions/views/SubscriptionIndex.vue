<template>
  <div class="container-fluid">
    <BaseTable
      label="Active Subscriptions"
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
      :title="subscriptionStore.mode === 'edit' ? '' : ''"
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
import { formatDate } from '../../../../ahmed-vue-kit/utils/helpers';

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
    name: 'tenant_id',
    label: 'Tenant Name',
    sortable: true,
    custom: (row) =>
      `<span class="badge bg-success">${row.tenant?.name}</span>`,
  },
  {
    name: 'plan_id',
    label: 'Plane Name',
    sortable: true,
    custom: (row) => 
      `<span class="badge bg-secondary">${row.plan?.name}</span>`,
  },
  {
    name: 'is_current',
    label: 'Is Current',
    sortable: true,
    custom: (row) =>
      `<span class="badge ${row.is_current ? 'bg-success' : 'bg-danger'}">${row.is_current ? 'ACTIVE' : 'INACTIVE'}</span>`,
  },
  {
    name: 'start_date',
    label: 'Start Date',
    sortable: true,
    custom: (row) =>
      `<button class='btn btn-sm btn-outline-successs'>${row.starts_at}</button>`,
  },
  {
    name: 'end_date',
    label: 'End Date',
    sortable: true,
    custom: (row) =>
      `<button class='btn btn-sm btn-outline-successs'>${row.ends_at}</button>`,
  },

  {
    name: 'subscription_status',
    label: 'subscription_status',
    sortable: true,
    custom: (row) => {
      return `<span class="badge bg-${row.subscription_status === 'active' ? 'success' : 'danger'}">${row.subscription_status ?? ''}</span>`;
    },
  },

  {
    name: 'created_at',
    label: 'Created At',
    sortable: true,
    custom: (row) => {
      return formatDate(row?.created_at);
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
