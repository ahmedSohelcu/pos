<template>
  <div class="container-fluid">
    <BaseTable
      label="Plan Management"
      :columns="columns"
      :rows="planStore.rows"
      :loading="planStore.loading"
      :meta="planStore.meta"
      :filters="planFilters"
      :actions="planActions"
      @query-change="planStore.updateQuery"
      @create="createFromTableBtn"
      @refresh="planStore.fetchData"
      @bulk-delete="planStore.bulkDelete"
    />

    <BaseModal
      v-model="planStore.showModal"
      size="lg"
      :loading="planStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="planStore.mode === 'edit' ? '' : ''"
      :confirmText="planStore.mode === 'edit' ? 'Update' : 'Create'"
    >
      <PlanForm
        :model="planStore.selectedItem ?? {}"
        :errors="planStore.errors ?? {}"
      />
    </BaseModal>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
// store
import { usePlanStore } from '../store';
import BaseModal from '@kit/components/ui/BaseModal.vue';
import PlanForm from './PlanForm.vue';
import { PLAN_ENDPOINTS } from '@/data/endpoint';
import { planFilters } from './planFilters';
import { getPlanActions } from './planActions';
import { formatDate } from '../../../../ahmed-vue-kit/utils/helpers';

const planStore = usePlanStore();

const closeModal = () => {
  planStore.loading = false;
};
// fetch data
onMounted(() => {
  planStore.fetchData();
});

//-------------------------
//load table actions button
//-------------------------
const planActions = getPlanActions(planStore);

const columns = [
  { name: 'id', label: 'ID', sortable: true },
  {
    name: 'name',
    label: 'Plan Name',
    sortable: true,
    custom: (row) => `<span class="badge bg-success">${row.name}</span>`,
  },
  {
    name: 'slug',
    label: 'Slug',
    sortable: true,
    custom: (row) =>
      `<button class='btn btn-sm btn-outline-warning'>${row.slug}</button>`,
  },
  {
    name: 'price',
    label: 'Price',
    sortable: true,
  },
  {
    name: 'trial_days',
    label: 'Trial Days',
    sortable: true,
  },
  {
    name: 'max_products',
    label: 'Max Products',
    sortable: true,
  },
  {
    name: 'max_users',
    label: 'Max Users',
    sortable: true,
  },
  {
    name: 'is_active',
    label: 'Is Active',
    sortable: true,
  },
  {
    name: 'created_at',
    label: 'Created At',
    sortable: true,
    custom: (row) => {
      return formatDate(row.created_at);
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
  planStore.errors = {};
  if (planStore.mode === 'edit') {
    await planStore.update(
      PLAN_ENDPOINTS.update(planStore.selectedItem.id),
      planStore.selectedItem
    );
  } else {
    await planStore.create(PLAN_ENDPOINTS.store, planStore.selectedItem);
  }
};

const createFromTableBtn = () => {
  planStore.mode = 'create';
  planStore.errors = {};
  planStore.selectedItem = {};
  planStore.showModal = true;
};
</script>

<style scoped></style>
