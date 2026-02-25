<script setup>
import { ref, reactive, computed, onMounted } from 'vue';

// Define props
defineProps({});

const loading = ref(true);

const query = ref({
  search: '',
  filters: {},
  perPage: 10,
  page: 1,
  category_id: null,
});

const columns = [
  { name: 'id', label: 'ID', sortable: true },
  { name: 'name', label: 'Name', sortable: true },
  { name: 'email', label: 'Email', sortable: true },
  { name: 'role', label: 'Role', sortable: true },
  { name: 'status', label: 'Status', sortable: true },
];

const users = [
  {
    id: 1,
    name: (row) => {
      return "<button class='btn btn-sm btn-primary'>Ahmed Sohel</button>";
    },
    email: 'ahmed@example.com',
    role: 'Admin',
    status: 'Active',
  },
  {
    id: 2,
    name: 'Rayan Khan',
    email: 'rayan@example.com',
    role: 'User',
    status: 'Inactive',
  },
  {
    id: 3,
    name: 'Sara Ali',
    email: 'sara@example.com',
    role: 'Moderator',
    status: 'Active',
  },
  {
    id: 4,
    name: 'John Doe',
    email: 'john@example.com',
    role: 'User',
    status: 'Active',
  },
  {
    id: 5,
    name: 'Jane Smith',
    email: 'jane@example.com',
    role: 'User',
    status: 'Inactive',
  },
];

const filters = [
  {
    name: 'status_id',
    label: 'Status',
    type: 'select',
    select2: true, // 🔥 enable select2
    multiple: false, // single select
    options: [
      { id: 1, type: 'active' },
      { id: 2, type: 'inactive' },
    ],
    getApiRoute: route('selectable_statuses'),
    optionKeyName: 'type',
    // optionValueName: 'label'
  },
  {
    name: 'created_at',
    label: 'Created At',
    type: 'date',
  },
  // {
  //     name: 'time',
  //     label: 'Time',
  //     type: 'time'
  // },
  // {
  //     name: 'Date',
  //     label: 'created At',
  //     type: 'datetime'
  // },
  // {
  //     name: 'date_range',
  //     label: 'Date Range',
  //     type: 'datetimerange'
  // },
  // Support types: date, time, datetime, datetimerange
];

const handleQuery = (value) => {
  // 🔥 IMPORTANT: replace full query
  query.value = value;
  console.log('Updated Query:', query.value);
  // fetchUsers()
};

onMounted(() => {});
</script>

<template>
  <div class="container-fluid">
    <BaseTable
      label="User Management"
      :columns="columns"
      :rows="users"
      :show-search="true"
      :filters="filters"
      @query-change="handleQuery"
    />
  </div>
</template>

<style scoped></style>
