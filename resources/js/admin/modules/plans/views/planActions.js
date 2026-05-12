// tenantActions.js
import { confirmDelete } from '@kit/composables/useDelete';
import { PLAN_ENDPOINTS } from '@/data/endpoint';

export const getPlanActions = (planStore) => [
  {
    label: '<i class="fas fa-layer-group text-primary"></i> Features',
    handler: (row) => {
      planStore.featuresModal = true;
      planStore.planId = row.id;
      planStore.fetchFeatures();
      planStore.fetchFeaturesByPlan(row.id);
      planStore.planName = row.name ?? '';
    },
  },
  {
    label: (row) => {
      return `<i class="fas fa-plus-circle text-success me-2"></i>Create`;
    },
    handler: (row) => {
      planStore.mode = 'create';
      planStore.errors = {};
      planStore.selectedItem = {}; // reset form
      planStore.showModal = true;
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit',
    handler: async (row) => {
      planStore.showModal = true;
      planStore.errors = {};
      planStore.mode = 'edit';
      await planStore.show(PLAN_ENDPOINTS.show(row.id));
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: PLAN_ENDPOINTS.destroy(row.id),
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          planStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
