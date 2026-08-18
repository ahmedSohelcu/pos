<template>
  <div class="permissions-wrapper">
    <!-- HEADER -->
    <div class="permissions-header">
      <div class="title">
        <i class="fas fa-user-shield"></i>
        <h5>Role Permissions</h5>
        <span class="count">{{ selectedPermissions.length }} selected</span>
      </div>

      <div class="actions">
        <input v-model="search" class="search" placeholder="Search module..." />

        <label class="toggle">
          <input
            type="checkbox"
            :checked="allPermissionsSelected"
            @change="toggleAllPermissions"
          />
          Select All
        </label>
      </div>
    </div>

    <!-- MODULES -->
    <div class="modules-grid">
      <div
        v-for="module in filteredModules"
        :key="module.module"
        class="module-card"
      >
        <!-- MODULE HEADER -->
        <div class="module-header">
          <div class="module-name">
            <i class="fas fa-layer-group"></i>
            {{ module.module }}
          </div>

          <input
            type="checkbox"
            :checked="isModuleSelected(module)"
            @change="toggleModule(module)"
          />
        </div>

        <!-- ACTION GRID -->
        <div class="action-grid">
          <template v-for="action in actions" :key="action">
            <div class="action-cell" v-if="getPermission(module, action)">
              <span class="action-label">
                {{ action }}
              </span>

              <input
                type="checkbox"
                :value="getPermission(module, action).id"
                v-model="selectedPermissions"
              />
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';

const props = defineProps({
  permissions: Array,
  modelValue: Array,
});

const emit = defineEmits(['update:modelValue']);

const selectedPermissions = ref([]);
const search = ref('');

const actions = ['view', 'create', 'update', 'delete', 'export', 'import'];

watch(
  () => props.modelValue,
  (val) => {
    selectedPermissions.value = val || [];
  },
  { immediate: true }
);

watch(selectedPermissions, (val) => {
  emit('update:modelValue', [...new Set(val)]);
});

function getPermission(module, action) {
  return module.permissions.find((p) => p.name.endsWith(`.${action}`));
}

function getModulePermissionIds(module) {
  return module.permissions.map((p) => p.id);
}

function isModuleSelected(module) {
  const ids = getModulePermissionIds(module);
  return ids.every((id) => selectedPermissions.value.includes(id));
}

function toggleModule(module) {
  const ids = getModulePermissionIds(module);

  const allSelected = ids.every((id) => selectedPermissions.value.includes(id));

  selectedPermissions.value = allSelected
    ? selectedPermissions.value.filter((id) => !ids.includes(id))
    : [...new Set([...selectedPermissions.value, ...ids])];
}

function getAllPermissionIds() {
  return props.permissions.flatMap((m) => m.permissions.map((p) => p.id));
}

const allPermissionsSelected = computed(() => {
  const ids = getAllPermissionIds();
  return (
    ids.length && ids.every((id) => selectedPermissions.value.includes(id))
  );
});

function toggleAllPermissions() {
  const ids = getAllPermissionIds();
  selectedPermissions.value = allPermissionsSelected.value ? [] : [...ids];
}

const filteredModules = computed(() => {
  if (!search.value) return props.permissions;
  return props.permissions.filter((m) =>
    m.module.toLowerCase().includes(search.value.toLowerCase())
  );
});
</script>

<style scoped>
.permissions-wrapper {
  font-family: Inter;
}

/* HEADER */

.permissions-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.title {
  display: flex;
  align-items: center;
  gap: 10px;
}

.count {
  background: #0d6efd;
  color: white;
  padding: 4px 8px;
  border-radius: 6px;
  font-size: 12px;
}

.actions {
  display: flex;
  align-items: center;
  gap: 15px;
}

.search {
  border: 1px solid #ddd;
  padding: 6px 10px;
  border-radius: 6px;
}

/* GRID */

.modules-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 15px;
}

/* CARD */

.module-card {
  background: var(--app-surface);
  border-radius: 12px;
  padding: 15px;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
  transition: 0.2s;
}

.module-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

/* HEADER */

.module-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
  font-weight: 600;
}

/* ACTION GRID */

.action-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 8px;
}

.action-cell {
  background: var(--app-surface-muted);
  padding: 6px 8px;
  border-radius: 6px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 12px;
  text-transform: capitalize;
}
.action-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 8px;
}

.action-cell{
  background: var(--app-surface-muted);
  padding:8px 10px;
  border-radius:8px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  font-size:13px;
  text-transform:capitalize;
  transition:0.2s;
}

.action-cell:hover{
background: var(--sidebar-submenu-active-bg);
}
</style>
