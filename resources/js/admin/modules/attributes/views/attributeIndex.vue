<template>
  <div class="container-fluid">
    <BaseTable
      label="Attribute Management"
      :columns="columns"
      :rows="attributeStore.rows"
      :loading="attributeStore.loading"
      :meta="attributeStore.meta"
      :filters="attributeFilters"
      :actions="attributeActions"
      @query-change="attributeStore.updateQuery"
      @create="createFromTableBtn"
      @refresh="attributeStore.fetchData"
      @bulk-delete="attributeStore.bulkDelete"
    />

    <BaseModal
      v-model="attributeStore.showModal"
      size="md"
      :loading="attributeStore.saving"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpdate"
      @close="closeModal"
      :title="
        attributeStore.mode === 'edit'
          ? 'Update Attribute'
          : 'Add New Attribute'
      "
      :confirmText="
        attributeStore.mode === 'edit' ? 'Update Attributes' : 'Create'
      "
    >
    <!-- attributeFormRef is defineExpose in attributeForm.vue -->
      <AttributeForm
        ref="attributeFormRef"
        :model="attributeStore.selectedItem || {}"
        :errors="attributeStore.errors || {}"
      />
    </BaseModal>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { attributeFilters } from './attributeFilters';
import { getAttributeActions } from './attributeActions';
import { useAttributeStore } from '../store';
import BaseModal from '@kit/components/ui/BaseModal.vue';
import AttributeForm from './attributeForm.vue';
import { ATTRIBUTE_ENDPOINTS } from '@/data/endpoint';
import { ref } from 'vue';

const attributeStore = useAttributeStore();

onMounted(() => {
  attributeStore.fetchData();
});

const attributeActions = getAttributeActions(attributeStore);

const columns = [
  { name: 'id', label: 'ID', sortable: true },
  {
    name: 'name',
    label: 'Name',
    sortable: true,
    custom: (row) => `<span class="badge bg-success">${row.name}</span>`,
  },
  {
    name: 'values',
    label: 'Values',
    sortable: false,
    custom: (row) =>
      `<span class="text-warning">${row.values?.map((v) => v.value).join(', ') ?? '-'}</span>`,
  },
  {
    name: 'tenant_id',
    label: 'Tenant',
    sortable: true,
    custom: (row) =>
      `<span class="text-secondary">${row.tenant?.name ?? '-'}</span>`,
  },
  {
    name: 'is_active',
    label: 'Active',
    sortable: true,
    custom: (row) =>
      `<span class="text-light badge bg-${row.is_active ? 'success' : 'danger'}">${row.is_active ? 'Active' : 'Inactive'}</span>`,
  },
  {
    name: 'created_at',
    label: 'Created At',
    sortable: true,
    custom: (row) => new Date(row.created_at).toLocaleString(),
  },
];

const attributeFormRef = ref(null); //define in child component
const createOrUpdate = async () => {
  const values = attributeFormRef.value.prepareValues();

  const data = {
    ...attributeStore.selectedItem,
    values: values,
  };

  if (attributeStore.mode === 'edit') {
    await attributeStore.update(
      ATTRIBUTE_ENDPOINTS.update(attributeStore.selectedItem.id),
      data
    );
  } else {
    await attributeStore.create(ATTRIBUTE_ENDPOINTS.store, data);
  }
};

const createFromTableBtn = () => {
  attributeStore.mode = 'create';
  attributeStore.errors = {};
  attributeStore.selectedItem = {};
  attributeStore.attrValues = [];
  attributeStore.showModal = true;
};

const closeModal = () => {
  attributeStore.saving = false;
};
</script>
