<template>
  <div class="container-fluid">
    <BaseTable
      label="Brand Management"
      :columns="columns"
      :rows="brandStore.rows"
      :loading="brandStore.loading"
      :meta="brandStore.meta"
      :filters="brandFilters"
      :actions="brandActions"
      @query-change="brandStore.updateQuery"
      @create="createFromTableBtn"
      @refresh="brandStore.fetchData"
      @bulk-delete="brandStore.bulkDelete"
    />

    <BaseModal
      v-model="brandStore.showModal"
      size="md"
      :loading="brandStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="brandStore.mode === 'edit' ? 'Update Brand' : 'Add New Brand'"
      :confirmText="brandStore.mode === 'edit' ? 'Update' : 'Create'"
    >
      <BrandForm
        :model="brandStore.selectedItem ?? {}"
        :errors="brandStore.errors ?? {}"
      />
    </BaseModal>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { brandFilters } from './brandFilters';
import { getBrandActions } from './brandActions';
// store
import { useBrandStore } from '../store';
import BaseModal from '@kit/components/ui/BaseModal.vue';
import BrandForm from './brandForm.vue';
import { BRAND_ENDPOINTS } from '@/data/endpoint';

const brandStore = useBrandStore();

const closeModal = () => {
  brandStore.loading = false;
};
// fetch data
onMounted(() => {
  brandStore.fetchData();
});

//-------------------------
//load table actions button
//-------------------------
const brandActions = getBrandActions(brandStore);

const columns = [
  { name: 'id', label: 'ID', sortable: true },
  {
    name: 'name',
    label: 'Brand Name',
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
      return `<span class="text-light badge bg-${row.status?.class ?? ''}">${
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
  brandStore.errors = {};
  if (brandStore.mode === 'edit') {
    await brandStore.update(
      BRAND_ENDPOINTS.update(brandStore.selectedItem.id),
      brandStore.selectedItem
    );
  } else {
    await brandStore.create(BRAND_ENDPOINTS.store, brandStore.selectedItem);
  }
};

const createFromTableBtn = () => {
  brandStore.mode = 'create';
  brandStore.errors = {};
  brandStore.selectedItem = {};
  brandStore.showModal = true;
};
</script>

<style scoped></style>
