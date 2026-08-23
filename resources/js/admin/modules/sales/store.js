import { defineStore } from 'pinia';
import api from '../../../ahmed-vue-kit/api/api';
import { notify } from '../../../ahmed-vue-kit/composables/useNotify';
import { SALES_ENDPOINTS } from '../../../data/endpoint';

export const useSalesStore = defineStore('salesStore', {
  state: () => ({
    rows: [],
    loading: false,
    refunding: false,

    search: '',
    status: '',
    range: 'all',

    selectedItem: null,
    detailsLoading: false,
    showDetailsModal: false,
    refundArmId: null,

    stats: {
      today_total: 0,
      today_count: 0,
      avg_basket: 0,
      month_total: 0,
      week_series: [],
    },

    meta: {
      current_page: 1,
      last_page: 1,
      per_page: 10,
      total: 0,
    },
  }),

  getters: {
    dateFrom(state) {
      const now = new Date();
      if (state.range === 'today') return now.toISOString().slice(0, 10);
      if (state.range === '7d') {
        const d = new Date(now);
        d.setDate(d.getDate() - 6);
        return d.toISOString().slice(0, 10);
      }
      if (state.range === '30d') {
        const d = new Date(now);
        d.setDate(d.getDate() - 29);
        return d.toISOString().slice(0, 10);
      }
      return null;
    },
  },

  actions: {
    async fetchSales(page) {
      this.loading = true;
      try {
        if (page) this.meta.current_page = page;
        const res = await api.get(SALES_ENDPOINTS.index, {
          params: {
            page: this.meta.current_page,
            per_page: this.meta.per_page,
            search: this.search || undefined,
            status: this.status || undefined,
            date_from: this.dateFrom || undefined,
          },
        });
        const data = res.data.data;
        this.rows = data.data;
        this.meta = {
          current_page: data.current_page,
          last_page: data.last_page,
          per_page: data.per_page,
          total: data.total,
        };
      } catch (e) {
        notify.error(e.response?.data?.message ?? 'Failed to load sales');
      } finally {
        this.loading = false;
      }
    },

    async fetchStats() {
      try {
        const res = await api.get(SALES_ENDPOINTS.stats);
        this.stats = res.data.data;
      } catch {
        /* non-critical */
      }
    },

    async openDetails(sale) {
      this.detailsLoading = true;
      this.showDetailsModal = true;
      try {
        const res = await api.get(SALES_ENDPOINTS.show(sale.id));
        this.selectedItem = res.data.data;
      } catch (e) {
        notify.error('Failed to load sale details');
        this.showDetailsModal = false;
      } finally {
        this.detailsLoading = false;
      }
    },

    armRefund(sale) {
      if (this.refundArmId !== sale.id) {
        this.refundArmId = sale.id;
        setTimeout(() => {
          if (this.refundArmId === sale.id) this.refundArmId = null;
        }, 3000);
        return;
      }
      this.refund(sale);
    },

    async refund(sale) {
      this.refunding = true;
      try {
        await api.post(SALES_ENDPOINTS.refund(sale.id));
        notify.success(`Sale ${sale.reference} refunded & restocked`);
        this.showDetailsModal = false;
        this.refundArmId = null;
        this.fetchSales();
        this.fetchStats();
      } catch (e) {
        notify.error(e.response?.data?.message ?? 'Refund failed');
      } finally {
        this.refunding = false;
      }
    },
  },
});
