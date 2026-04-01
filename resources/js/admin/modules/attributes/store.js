import { useResourceStore } from '@kit/stores/useResourceStore';
import { ATTRIBUTE_ENDPOINTS } from '@/data/endpoint';

// if specific extra need outside of the useResourceStore.
//parent will get priority
export const useAttributeStore = useResourceStore(
  'attributeStore',
  ATTRIBUTE_ENDPOINTS.index,
  {
    state: {
      attrValues: [], //
    },
  }
); // relative to VITE_API_URL;
