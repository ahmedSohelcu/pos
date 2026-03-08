// store/planStore.js
import { useResourceStore } from '@kit/stores/useResourceStore';
import { notify } from '@kit/composables/useNotify';
import api from '../../../ahmed-vue-kit/api/api';
import { PLAN_ENDPOINTS } from '../../../data/endpoint';
export const usePlanStore = useResourceStore(
  'planStore',
  PLAN_ENDPOINTS.index,
  {
    state: {
      featuresModal: false,
      // all features list
      features: [], //all
      planId: null,
      planName: '',
      currentFeatures: [],
    },

    getters: {
      // tenantCount: (state) => state.rows.length,
      // activeTenants: (state) => state.rows.filter((t) => t.active),
    },

    actions: {
      async fetchFeatures() {
        const { data } = await api.get(PLAN_ENDPOINTS.features);
        this.features = data.data;
        console.log('this features', this.features);
      },

      async fetchFeaturesByPlan(planId) {
        const { data } = await api.get(PLAN_ENDPOINTS.featuresByPlan(planId));
        this.planId = planId;
        this.currentFeatures = data.data;
      },

      async updateFeaturesByPlan(planId, featureIDs) {
        try {
          const { data } = await api.post(
            PLAN_ENDPOINTS.updateFeaturesByPlan(planId), // pass roleId in URL
            {
              currentFeatures: featureIDs, // send array of features IDs
            }
          );
          console.log('update feature  response', data);
          // Update local store if needed
          this.featuresModal = false;
          this.currentFeatures = data;
          notify.success(data.message || 'Updated successfully.');
        } catch (error) {
          console.error(error);
        }
      },
    },
  }
); // relative to VITE_API_URL;
