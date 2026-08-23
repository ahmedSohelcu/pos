import { defineStore } from 'pinia';
import api from '../../../ahmed-vue-kit/api/api';
import { notify } from '../../../ahmed-vue-kit/composables/useNotify';
import { REPORTS_ENDPOINTS } from '../../../data/endpoint';

const emptyOverview = {
  kpis: {
    revenue: 0,
    profit: 0,
    margin_pct: 0,
    transactions: 0,
    items_sold: 0,
    avg_basket: 0,
    discounts: 0,
  },
  daily_series: [],
  top_products: [],
  by_cashier: [],
  by_category: [],
  range: { from: null, to: null },
};

export const useReportsStore = defineStore('reportsStore', {
  state: () => ({
    loading: false,
    overview: emptyOverview,
    preset: '7d',
    customFrom: '',
    customTo: '',
  }),

  getters: {
    rangeParams(state) {
      if (state.preset === 'custom') {
        return {
          date_from: state.customFrom || undefined,
          date_to: state.customTo || undefined,
        };
      }
      const now = new Date();
      const fmt = (d) => d.toISOString().slice(0, 10);
      const today = fmt(now);
      if (state.preset === 'today') return { date_from: today, date_to: today };
      if (state.preset === '30d') {
        const d = new Date(now);
        d.setDate(d.getDate() - 29);
        return { date_from: fmt(d), date_to: today };
      }
      if (state.preset === 'month') {
        return { date_from: today.slice(0, 8) + '01', date_to: today };
      }
      // default 7d
      const d = new Date(now);
      d.setDate(d.getDate() - 6);
      return { date_from: fmt(d), date_to: today };
    },

    maxTopRevenue(state) {
      return Math.max(...state.overview.top_products.map((p) => p.revenue), 1);
    },
  },

  actions: {
    async fetchOverview() {
      this.loading = true;
      try {
        const res = await api.get(REPORTS_ENDPOINTS.overview, { params: this.rangeParams });
        this.overview = res.data.data;
      } catch (e) {
        notify.error(e.response?.data?.message ?? 'Failed to load reports');
      } finally {
        this.loading = false;
      }
    },

    setPreset(preset) {
      this.preset = preset;
      if (preset !== 'custom') this.fetchOverview();
    },

    applyCustom() {
      if (!this.customFrom || !this.customTo) return;
      this.fetchOverview();
    },
  },
});
