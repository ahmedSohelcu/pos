import { useResourceStore } from '@kit/stores/useResourceStore';
import { EXPENSE_ENDPOINTS } from '../../../data/endpoint';

// if specific extra need outside of the useResourceStore.
//parent will get priority
export const useExpenseStore = useResourceStore(
  'expenseStore',
  EXPENSE_ENDPOINTS.index,
  {}
); // relative to VITE_API_URL;
