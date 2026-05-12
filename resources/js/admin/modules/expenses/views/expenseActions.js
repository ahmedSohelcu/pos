// tenantActions.js
import { confirmDelete } from '@kit/composables/useDelete';
import { EXPENSE_ENDPOINTS } from '@/data/endpoint';

export const getExpenseActions = (expenseStore) => [
  {
    label: (row) => {
      return `<i class="fas fa-plus-circle text-success me-2"></i>Create`;
    },
    handler: (row) => {
      expenseStore.mode = 'create';
      expenseStore.errors = {};
      expenseStore.selectedItem = {}; // reset form
      expenseStore.showModal = true;
    },
  },
  {
    label: '<i class="fas fa-edit text-warning me-2"></i> Edit',
    handler: async (row) => {
      expenseStore.showModal = true;
      expenseStore.errors = {};
      expenseStore.mode = 'edit';
      await expenseStore.show(EXPENSE_ENDPOINTS.show(row.id));
    },
  },
  {
    label: '<i class="fas fa-trash text-danger me-2"></i> Delete',
    handler: async (row) => {
      await confirmDelete({
        apiUrl: EXPENSE_ENDPOINTS.destroy(row.id),
        confirmTitle: `Delete ${row.name}?`,
        onSuccess: () => {
          expenseStore.fetchData(); // 🔥 correct refresh
        },
      });
    },
  },
];
