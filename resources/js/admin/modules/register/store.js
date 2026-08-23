import { defineStore } from 'pinia';
import api from '../../../ahmed-vue-kit/api/api';
import { notify } from '../../../ahmed-vue-kit/composables/useNotify';
import { REGISTER_ENDPOINTS } from '../../../data/endpoint';

export const useRegisterStore = defineStore('registerStore', {
  state: () => ({
    loading: false,
    actionLoading: false,

    shift: null,
    stats: null,
    movements: [],

    historyRows: [],
    historyMeta: {
      current_page: 1,
      last_page: 1,
      per_page: 10,
      total: 0,
    },

    // modals
    showOpenModal: false,
    openForm: { opening_float: '', register_name: 'Main Register' },

    showCloseModal: false,
    closeForm: { closing_counted: '', note: '' },
    closedResult: null,
    showClosedResult: false,

    showMovementModal: false,
    movementType: 'cash_in',
    movementForm: { amount: '', reason: '' },
  }),

  getters: {
    isOpen(state) {
      return !!state.shift && state.shift.status === 'open';
    },

    expectedCash(state) {
      return state.stats?.expected_cash ?? 0;
    },
  },

  actions: {
    async fetchCurrent() {
      this.loading = true;
      try {
        const res = await api.get(REGISTER_ENDPOINTS.current);
        this.shift = res.data.data.shift;
        this.stats = res.data.data.stats;
        this.movements = res.data.data.movements ?? [];
      } catch (e) {
        notify.error(e.response?.data?.message ?? 'Failed to load register state');
      } finally {
        this.loading = false;
      }
    },

    async fetchHistory(page) {
      try {
        if (page) this.historyMeta.current_page = page;
        const res = await api.get(REGISTER_ENDPOINTS.history, {
          params: { page: this.historyMeta.current_page, per_page: this.historyMeta.per_page },
        });
        const data = res.data.data;
        this.historyRows = data.data;
        this.historyMeta = {
          current_page: data.current_page,
          last_page: data.last_page,
          per_page: data.per_page,
          total: data.total,
        };
      } catch {
        /* non-critical */
      }
    },

    async openRegister() {
      this.actionLoading = true;
      try {
        await api.post(REGISTER_ENDPOINTS.open, {
          opening_float: Number(this.openForm.opening_float || 0),
          register_name: this.openForm.register_name || undefined,
        });
        notify.success('Register opened — have a great shift!');
        this.showOpenModal = false;
        this.openForm = { opening_float: '', register_name: 'Main Register' };
        await this.fetchCurrent();
      } catch (e) {
        notify.error(e.response?.data?.message ?? 'Failed to open register');
      } finally {
        this.actionLoading = false;
      }
    },

    async closeRegister() {
      this.actionLoading = true;
      try {
        const res = await api.post(REGISTER_ENDPOINTS.close, {
          closing_counted: Number(this.closeForm.closing_counted || 0),
          note: this.closeForm.note || undefined,
        });
        this.closedResult = res.data.data.shift;
        this.showCloseModal = false;
        this.showClosedResult = true;
        this.closeForm = { closing_counted: '', note: '' };
        await Promise.all([this.fetchCurrent(), this.fetchHistory(1)]);
      } catch (e) {
        notify.error(e.response?.data?.message ?? 'Failed to close register');
      } finally {
        this.actionLoading = false;
      }
    },

    async addMovement() {
      this.actionLoading = true;
      try {
        const res = await api.post(REGISTER_ENDPOINTS.movements, {
          type: this.movementType,
          amount: Number(this.movementForm.amount),
          reason: this.movementForm.reason || undefined,
        });
        notify.success(this.movementType === 'cash_in' ? 'Cash added to drawer' : 'Cash removed from drawer');
        this.stats = res.data.data.stats;
        this.movements = res.data.data.movements ?? [];
        this.showMovementModal = false;
        this.movementForm = { amount: '', reason: '' };
      } catch (e) {
        notify.error(e.response?.data?.message ?? 'Failed to record movement');
      } finally {
        this.actionLoading = false;
      }
    },
  },
});
