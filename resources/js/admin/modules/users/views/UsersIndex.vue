<template>
  <div class="container-fluid">
    <BaseTable
      label="User Management"
      :columns="columns"
      :rows="userStore.rows"
      :loading="userStore.loading"
      :meta="userStore.meta"
      :filters="userFilters"
      :actions="userActions"
      @query-change="userStore.updateQuery"
      @create="createFromTableBtn"
      @refresh="userStore.fetchData"
      @bulk-delete="userStore.bulkDelete"
    />

    <!-- ------------------------------------
    Start assign Role Modal
    ------------------------------------- -->
    <BaseModal
      size="md"
      v-model="userStore.showRoleAssignModal"
      :loading="userStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="userStore.updateUserRoles"
      @close="closeModal"
      :title="'Update User Role'"
      :confirmText="'Update'"
    >
      <!-- form ..  -->
      <BaseSelect
        :options="userStore.roles"
        v-model="userStore.existingRoles"
        select2
        multiple
        label=""
        placeholder="Choose Role"
      />
    </BaseModal>

    <!-- ------------------------------------
    End Assigning Role Modal
    ------------------------------------- -->

    <BaseModal
      v-model="userStore.showModal"
      size="lg"
      :loading="userStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="userStore.mode === 'edit' ? '' : ''"
      :confirmText="userStore.mode === 'edit' ? 'Update' : 'Create'"
    >
      <UserForm
        :model="userStore.selectedItem ?? {}"
        :errors="userStore.errors ?? {}"
      />
    </BaseModal>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { useUserStore } from '../store';
import { getUserActions } from './userActions';
import { userFilters } from './userFilters';
import BaseModal from '@kit/components/ui/BaseModal.vue';
import UserForm from './UserForm.vue';
import { USER_ENDPOINTS } from '@/data/endpoint';
const userStore = useUserStore();

onMounted(() => {
  userStore.fetchData();
});
//---------------------------
// load tenant action buttons
//---------------------------
const userActions = getUserActions(userStore);

const closeModal = () => {
  userStore.loading = false;
};
//-----------------------
//Table Column
//-----------------------
const columns = [
  {
    label: '#',
    custom: (row, index) => index + 1,
  },
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
    label: 'Roles',
    custom: (row) => {
      return (
        row?.roles
          .map(
            (role) =>
              `<span class="badge bg-${
                [
                  'primary',
                  'secondary',
                  'success',
                  'danger',
                  'warning',
                  'info',
                ][role.id % 6]
              }">${role.name}</span>`
          )
          .join(' ') ?? ''
      );
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
  {
    name: 'tenant_id',
    label: 'Tenant',
    sortable: true,
    custom: (row) => {
      return row?.tenant?.name ?? '';
    },
  },
  {
    name: 'status_id',
    label: 'Status',
    sortable: true,
    custom: (row) => {
      return row.status
        ? `<span class="badge bg-${row.status?.class ?? 'secondary'}">
          ${row?.status?.name ?? ''}
        </span>`
        : '';
    },
  },
];

const createOrUpate = async () => {
  userStore.errors = {};
  if (userStore.mode === 'edit') {
    await userStore.update(
      USER_ENDPOINTS.update(userStore.selectedItem.id),
      userStore.selectedItem
    );
  } else {
    await userStore.create(USER_ENDPOINTS.store, userStore.selectedItem);
  }
};

const createFromTableBtn = () => {
  userStore.mode = 'create';
  userStore.errors = {};
  userStore.selectedItem = {};
  userStore.showModal = true;
};
</script>

<style scoped></style>
