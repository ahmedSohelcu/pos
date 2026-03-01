<template>
  <div class="container-fluid">
    <BaseTable
      label="Role Management"
      :columns="columns"
      :rows="roleStore.rows"
      :loading="roleStore.loading"
      :meta="roleStore.meta"
      :filters="roleFilters"
      :actions="tenantActions"
      @query-change="roleStore.updateQuery"
      @create="createFromTableBtn"
      @refresh="roleStore.fetchData"
      @bulk-delete="roleStore.bulkDelete"
    />

    <BaseModal
      v-model="roleStore.showModal"
      size="md"
      :loading="roleStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="roleStore.mode === 'edit' ? 'Edit Role' : 'Create Role'"
      :confirmText="roleStore.mode === 'edit' ? 'Update' : 'Create'"
    >
      <RoleForm :model="roleStore.selectedItem" :errors="roleStore.errors" />
    </BaseModal>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { roleFilters } from './RoleFilters';
import { getRoleActions } from './RoleActions';
const showModal = ref(false);
// store
import { useRoleStore } from '../store';
import BaseModal from '@kit/components/ui/BaseModal.vue';
import { route } from 'ziggy-js';
import RoleForm from './RoleForm.vue';

const roleStore = useRoleStore();

const closeModal = () => {
  roleStore.loading = false;
};
// fetch data
onMounted(() => {
  roleStore.fetchData();
});

//-------------------------
//load table actions button
//-------------------------
const tenantActions = getRoleActions(roleStore);

const columns = [
  { name: 'id', label: 'ID', sortable: true },
  {
    name: 'name',
    label: 'Role',
    sortable: true,
    custom: (row) => `<span class="badge bg-success">${row.name}</span>`,
  },
  { name: 'guard_name', label: 'Guard Name', sortable: true },
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
  roleStore.errors = {};
  if (roleStore.mode === 'edit') {
    await roleStore.update(
      route('api.roles.update', roleStore.selectedItem.id),
      roleStore.selectedItem
    );
  } else {
    await roleStore.create(route('api.roles.store'), roleStore.selectedItem);
  }
};

const createFromTableBtn = () => {
  roleStore.mode = 'create';
  roleStore.errors = {};
  roleStore.selectedItem = {};
  roleStore.showModal = true;
};
</script>

<style scoped></style>
