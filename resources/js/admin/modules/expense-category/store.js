import { useResourceStore } from '@kit/stores/useResourceStore';
import { EXPENSE_CATEGORY_ENDPOINTS } from '../../../data/endpoint';

// if specific extra need outside of the useResourceStore.
//parent will get priority
export const useExpenseCategoryStore = useResourceStore(
  'expenseCategoryStore',
  EXPENSE_CATEGORY_ENDPOINTS.index,
  {}
); // relative to VITE_API_URL;
