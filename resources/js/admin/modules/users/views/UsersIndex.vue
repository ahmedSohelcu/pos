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

    <BaseModal
      v-model="userStore.showModal"
      size="lg"
      :loading="userStore.loading"
      confirmVariant="outline-success"
      cancelVariant="outline-danger"
      :centered="true"
      @confirm="createOrUpate"
      @close="closeModal"
      :title="userStore.mode === 'edit' ? '' : 'Create Tenant'"
      :confirmText="userStore.mode === 'edit' ? 'Update' : 'Create'"
    >
      <UserForm :model="userStore.selectedItem" :errors="userStore.errors" />
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
const userStore = useUserStore();

onMounted(() => {
  userStore.fetchData();
});

const closeModal = () => {
  userStore.loading = false;
};
//---------------------------
// load tenant action buttons
//---------------------------
const userActions = getUserActions(userStore);

//-----------------------
//Table Column
//-----------------------
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
  userStore.errors = {};
  if (userStore.mode === 'edit') {
    await userStore.update(
      route('api.users.update', userStore.selectedItem.id),
      userStore.selectedItem
    );
  } else {
    await userStore.create(
      route('api.users.store'),
      userStore.selectedItem
    );
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
