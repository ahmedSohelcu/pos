<template>
  <!-- Compact POS-style Filter Card -->
  <div v-if="filters.length" class="filter-pos-card">
    <!-- Header: Filter title + toggle chevron -->
    <div
      class="filter-card-header d-flex justify-content-between align-items-center"
      @click="toggleCollapse"
    >
      <h5 class="mb-0 fw-bold">Filters</h5>
      <i :class="['fas', collapsed ? 'fa-chevron-down' : 'fa-chevron-up']"></i>
    </div>

    <!-- Body: Filters, Actions, Active Chips -->
    <div v-show="!collapsed" class="filter-card-body">
      <!-- Filters Row -->
      <div class="row g-2 align-items-end">
        <div
          v-for="(filter, index) in filters"
          :key="index"
          :class="filters.length > 3 ? 'col' : 'col-md-4'"
        >
          <!-- Select Filter -->
          <BaseSelect
            v-if="filter.type === 'select'"
            v-model="form[filter.name]"
            :name="filter.name"
            :getApiRoute="filter.getApiRoute"
            :options="filter.options"
            :optionKeyName="filter.optionKeyName" 
            :optionValueName="filter.optionValueName"
            :label="filter.label"
            :placeholder="`Choose ${filter.label}`"
            :select2="filter.select2 || false"
            :multiple="filter.multiple || false"
          />

          <!-- Date / Time / Datetime / Datetimerange -->
          <BaseDatePicker
            v-else
            v-model="form[filter.name]"
            :label="filter.label"
            :placeholder="`Select ${filter.label}`"
            :type="filter.type"
            :name="filter.name"
          />
        </div>

        <!-- Buttons always right -->
        <div class="col d-flex justify-content-end gap-2 mt-2 mt-md-0">
          <button class="btn btn-primary btn-sm" @click="emitFilter">
            <i class="fas fa-filter me-1"></i> Apply
          </button>
          <button
            class="btn btn-outline-secondary btn-sm"
            @click="resetFilters"
          >
            <i class="fas fa-undo me-1"></i> Reset
          </button>
        </div>
      </div>

      <!-- Active Filters Chips -->
      <div class="mt-2">
        <span
          v-for="(value, key) in activeFilters"
          :key="key"
          class="badge bg-primary text-white me-2 mb-2 cursor-pointer"
          @click="removeFilter(key)"
        >
          {{ getFilterLabel(key) }}: {{ formatFilterValue(key, value) }}
          <i class="fas fa-times ms-1"></i>
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch, ref, computed } from 'vue';

const props = defineProps({
  filters: { type: Array, required: true },
});

const emit = defineEmits(['filter-change']);

const form = reactive({});
const collapsed = ref(false);
const toggleCollapse = () => (collapsed.value = !collapsed.value);

// Initialize filter form with defaults
watch(
  () => props.filters,
  (newFilters) => {
    newFilters.forEach((f) => {
      form[f.name] = f.multiple ? f.default || [] : f.default || '';
    });
  },
  { immediate: true }
);

// Auto emit on form changes
watch(
  () => JSON.stringify(form),
  () => emit('filter-change', { ...form })
);

// Manual apply
const emitFilter = () => emit('filter-change', { ...form });

// Reset all filters
const resetFilters = () => {
  props.filters.forEach((f) => {
    form[f.name] = f.multiple ? [] : '';
  });

  // emit filters + reset flag
  emit('filter-change', { ...form }, true);
};

// Active filters for chips
const activeFilters = computed(() => {
  const actives = {};
  Object.keys(form).forEach((key) => {
    if (form[key] !== '' && form[key] !== null && form[key] !== undefined) {
      if (Array.isArray(form[key]) && form[key].length === 0) return;
      actives[key] = form[key];
    }
  });
  return actives;
});

// Remove individual filter
const removeFilter = (key) => {
  const filter = props.filters.find((f) => f.name === key);
  form[key] = filter?.multiple ? [] : '';
  emitFilter();
};

// Helper to get filter label
const getFilterLabel = (key) => {
  const filter = props.filters.find((f) => f.name === key);
  return filter?.label || key;
};

// Helper to format filter value for display
// const formatFilterValue = (key, value) => {
//   if (Array.isArray(value)) return value.join(', ');
//   return value;
// };
const formatFilterValue = (key, value) => {
  const filter = props.filters.find((f) => f.name === key);

  if (!filter) return value;

  // static select options
  if (filter.type === 'select' && filter.options) {
    const option = filter.options.find(
      (o) => o[filter.optionValueName || 'value'] == value
    );
    if (option) return option[filter.optionKeyName || 'name'];
  }

  if (Array.isArray(value)) return value.join(', ');

  return value;
};
</script>

<style scoped>
.filter-pos-card {
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  background-color: var(--bs-white);
  transition: all 0.2s ease;
}

.filter-card-header {
  padding: 0.65rem 1rem;
  font-size: 14px;
  letter-spacing: 0.3px;
  user-select: none;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #e5e7eb;
}

.filter-card-header h5 {
  margin: 0;
}

.filter-card-body {
  padding: 0.75rem 1rem;
  transition: all 0.3s ease;
}

.badge {
  font-size: 12px;
  padding: 0.35em 0.6em;
  cursor: pointer;
  user-select: none;
  transition: all 0.2s;
}

.badge:hover {
  opacity: 0.85;
}

.cursor-pointer {
  cursor: pointer;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
  .filter-pos-card {
    background-color: #1f2937;
    color: #f9fafb;
  }
  .filter-card-header {
    border-bottom: 1px solid #374151;
  }
  .badge.bg-primary {
    background-color: #3b82f6;
    color: #ffffff;
  }
}
</style>
