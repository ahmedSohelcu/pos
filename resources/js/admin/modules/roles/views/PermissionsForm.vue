<template>
  <div class="card shadow-sm border-0 permission-card">
    <!-- HEADER -->
    <div
      class="card-header bg-white d-flex justify-content-between align-items-center"
    >
      <div class="fw-semibold">
        <i class="fas fa-user-shield text-primary me-2"></i>
      </div>
      <div class="d-flex align-items-center gap-3">
        <span class="badge bg-primary">
          {{ selectedPermissions.length }} Selected
        </span>

        <!-- GLOBAL SELECT -->
        <div class="form-check m-0">
          <input
            class="form-check-input"
            type="checkbox"
            :checked="isAllSelected"
            @change="toggleAll"
          />
          <label class="form-check-label small"> Select All </label>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table align-middle text-center permission-table mb-0">
        <!-- TABLE HEADER -->
        <thead>
          <tr>
            <th class="text-start ps-4">Module</th>

            <th v-for="action in actions" :key="action">
              <div class="d-flex flex-column align-items-center gap-1">
                <span :class="'action-badge ' + action">
                  {{ action }}
                </span>

                <!-- COLUMN SELECT -->
                <input
                  type="checkbox"
                  class="form-check-input"
                  :checked="isColumnChecked(action)"
                  @change="toggleColumn(action)"
                />
              </div>
            </th>
          </tr>
        </thead>

        <!-- TABLE BODY -->
        <tbody>
          <tr
            v-for="module in permissions"
            :key="module.module"
            class="permission-row"
          >
            <!-- MODULE -->
            <td class="text-start ps-4 fw-semibold">
              <div class="d-flex align-items-center gap-2">
                <input
                  type="checkbox"
                  class="form-check-input module-checkbox"
                  :checked="isModuleChecked(module)"
                  @change="toggleModule(module)"
                />

                {{ module.module }}
              </div>
            </td>

            <!-- PERMISSIONS -->
            <td v-for="action in actions" :key="action">
              <div
                v-if="getPermission(module, action)"
                class="form-check d-flex justify-content-center"
              >
                <input
                  type="checkbox"
                  class="form-check-input permission-checkbox"
                  :value="getPermission(module, action).id"
                  v-model="selectedPermissions"
                />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { useRoleStore } from '../store';
const roleStore = useRoleStore();
/* --------------------------------
PROPS
-------------------------------- */

const props = defineProps({
  permissions: {
    type: Array,
    default: () => [],
  },
  modelValue: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(['update:modelValue']);

/* --------------------------------
STATE
-------------------------------- */

const selectedPermissions = ref([]);

const actions = ['view', 'create', 'update', 'delete', 'export', 'import'];

/* --------------------------------
SYNC WITH PARENT
-------------------------------- */

// when parent updates modelValue
watch(
  () => props.modelValue,
  (val) => {
    selectedPermissions.value = Array.isArray(val) ? [...val] : [];
  },
  { immediate: true }
);

// emit to parent
watch(
  selectedPermissions,
  (val) => {
    emit('update:modelValue', [...new Set(val)]);
  },
  { deep: true }
);

/* --------------------------------
HELPERS
-------------------------------- */

function getPermission(module, action) {
  return module.permissions.find((p) => p.name.endsWith(`.${action}`));
}

function getModulePermissionIds(module) {
  return module.permissions.map((p) => p.id);
}

function getAllPermissionIds() {
  return props.permissions.flatMap((module) =>
    module.permissions.map((p) => p.id)
  );
}

/* --------------------------------
MODULE SELECT
-------------------------------- */

function isModuleChecked(module) {
  const ids = getModulePermissionIds(module);

  return ids.every((id) => selectedPermissions.value.includes(id));
}

function toggleModule(module) {
  const ids = getModulePermissionIds(module);

  const allSelected = ids.every((id) => selectedPermissions.value.includes(id));

  if (allSelected) {
    selectedPermissions.value = selectedPermissions.value.filter(
      (id) => !ids.includes(id)
    );
  } else {
    selectedPermissions.value = [
      ...new Set([...selectedPermissions.value, ...ids]),
    ];
  }
}

/* --------------------------------
COLUMN SELECT
-------------------------------- */

function getColumnPermissionIds(action) {
  return props.permissions.flatMap((module) => {
    const permission = getPermission(module, action);
    return permission ? [permission.id] : [];
  });
}

function isColumnChecked(action) {
  const ids = getColumnPermissionIds(action);

  return (
    ids.length && ids.every((id) => selectedPermissions.value.includes(id))
  );
}

function toggleColumn(action) {
  const ids = getColumnPermissionIds(action);

  const allSelected = ids.every((id) => selectedPermissions.value.includes(id));

  if (allSelected) {
    selectedPermissions.value = selectedPermissions.value.filter(
      (id) => !ids.includes(id)
    );
  } else {
    selectedPermissions.value = [
      ...new Set([...selectedPermissions.value, ...ids]),
    ];
  }
}

/* --------------------------------
GLOBAL SELECT
-------------------------------- */

const isAllSelected = computed(() => {
  const ids = getAllPermissionIds();

  return (
    ids.length && ids.every((id) => selectedPermissions.value.includes(id))
  );
});

function toggleAll() {
  const ids = getAllPermissionIds();

  if (isAllSelected.value) {
    selectedPermissions.value = [];
  } else {
    selectedPermissions.value = [...ids];
  }
}
</script>

<style scoped>
.permission-card {
  border-radius: 10px;
}

.permission-table thead {
  background: #f8fafc;
  position: sticky;
  top: 0;
  z-index: 5;
}

.permission-row:hover {
  background: #f9fbfd;
}

.module-checkbox {
  transform: scale(1.2);
}

.permission-checkbox {
  transform: scale(1.1);
}

/* ACTION BADGES */

.action-badge {
  font-size: 11px;
  padding: 5px 10px;
  border-radius: 6px;
  text-transform: uppercase;
}

.action-badge.view {
  background: #e7f1ff;
  color: #0d6efd;
}

.action-badge.create {
  background: #e8f8f0;
  color: #198754;
}

.action-badge.update {
  background: #fff3cd;
  color: #b8860b;
}

.action-badge.delete {
  background: #fde8e8;
  color: #dc3545;
}

.action-badge.export {
  background: #eef2ff;
  color: #6366f1;
}

.action-badge.import {
  background: #63c250;
  color: #ffffff;
}
</style>
