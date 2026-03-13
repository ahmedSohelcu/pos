// tenantActions.js
import { confirmDelete } from '@kit/composables/useDelete';
import { EXPENSE_CATEGORY_ENDPOINTS } from '@/data/endpoint';

export const getExpenseCategoryActions = (expenseCategoryStore) => [
  {
    label: (row) => {
      return `<i class="fas fa-plus-circle text-success me-2"></i>Create`;
    },
    handler: (row) => {
      expenseCategoryStore.mode = 'create';
      expenseCategoryStore.errors = {};
      expenseCategoryStore.selectedItem = {}; // reset form
      expenseCategoryStore.showModal = true;
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit',
    handler: async (row) => {
      expenseCategoryStore.showModal = true;
      expenseCategoryStore.errors = {};
      expenseCategoryStore.mode = 'edit';
      await expenseCategoryStore.show(EXPENSE_CATEGORY_ENDPOINTS.show(row.id));
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: EXPENSE_CATEGORY_ENDPOINTS.destroy(row.id),
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          expenseCategoryStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
