<template>
  <div class="container-fluid">
    <BaseTable
      label="Unit Management"
      :columns="columns"
      :rows="unitStore.rows"
      :loading="unitStore.loading"
      :meta="unitStore.meta"
      :filters="unitFilters"
      :actions="unitActions"
      @query-change="unitStore.updateQuery"
      @create="createFromTableBtn"
      @refresh="unitStore.fetchData"
      @bulk-delete="unitStore.bulkDelete"
    />

    <BaseModal
      v-model="unitStore.showModal"
      size="md"
      :loading="unitStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="unitStore.mode === 'edit' ? 'Update Unit' : 'Add New Unit'"
      :confirmText="unitStore.mode === 'edit' ? 'Update' : 'Create'"
    >
      <unitForm
        :model="unitStore.selectedItem ?? {}"
        :errors="unitStore.errors ?? {}"
      />
    </BaseModal>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { getUnitActions } from './unitActions';
// store
import { useUnitStore } from '../store';
import BaseModal from '@kit/components/ui/BaseModal.vue';
import unitForm from './unitForm.vue';
import { UNIT_ENDPOINTS } from '@/data/endpoint';
import { unitFilters } from './unitFilters';
const unitStore = useUnitStore();

const closeModal = () => {
  unitStore.loading = false;
};
// fetch data
onMounted(() => {
  unitStore.fetchData();
});

//-------------------------
//load table actions button
//-------------------------
const unitActions = getUnitActions(unitStore);

const columns = [
  { name: 'id', label: 'ID', sortable: true },
  {
    name: 'name',
    label: 'Unit Name',
    sortable: true,
    custom: (row) => `<span class="badge bg-success">${row.name ?? ''}</span>`,
  },
  {
    name: 'short_name',
    label: 'Short Name',
    sortable: true,
    custom: (row) =>
      `<span class="badge bg-secondary">${row.short_name ?? ''}</span>`,
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
      return `<span class="text-white badge bg-${row.status?.class ?? ''}">${row.status?.name ?? '-'}</span>`;
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
  unitStore.errors = {};
  if (unitStore.mode === 'edit') {
    await unitStore.update(
      UNIT_ENDPOINTS.update(unitStore.selectedItem.id),
      unitStore.selectedItem
    );
  } else {
    await unitStore.create(UNIT_ENDPOINTS.store, unitStore.selectedItem);
  }
};

const createFromTableBtn = () => {
  unitStore.mode = 'create';
  unitStore.errors = {};
  unitStore.selectedItem = {};
  unitStore.showModal = true;
};
</script>

<style scoped></style>
