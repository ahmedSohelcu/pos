import { defineStore } from 'pinia';
import api from '../../../ahmed-vue-kit/api/api';
import { notify } from '../../../ahmed-vue-kit/composables/useNotify';
import { INVENTORY_ENDPOINTS, POS_ENDPOINTS } from '../../../data/endpoint';

export const useInventoryStore = defineStore('inventoryStore', {
  state: () => ({
    rows: [],
    loading: false,
    saving: false,

    search: '',
    type: '',

    stats: {
      tracked_skus: 0,
      low_stock: 0,
      out_of_stock: 0,
      movements_today: 0,
    },
    lowStockItems: [],
    variantCache: [],

    showAdjustModal: false,
    adjust: {
      variantId: null,
      mode: 'add',
      value: null,
      note: '',
    },

    meta: {
      current_page: 1,
      last_page: 1,
      per_page: 15,
      total: 0,
    },
  }),

  getters: {
    variantOptions: (state) => state.variantCache,

    selectedVariant(state) {
      return state.variantCache.find((v) => v.id === Number(state.adjust.variantId)) ?? null;
    },
  },

  actions: {
    async fetchMovements(page) {
      this.loading = true;
      try {
        if (page) this.meta.current_page = page;
        const res = await api.get(INVENTORY_ENDPOINTS.movements, {
          params: {
            page: this.meta.current_page,
            per_page: this.meta.per_page,
            search: this.search || undefined,
            type: this.type || undefined,
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
        notify.error(e.response?.data?.message ?? 'Failed to load movements');
      } finally {
        this.loading = false;
      }
    },

    async fetchOverview() {
      try {
        const [statsRes, lowRes] = await Promise.all([
          api.get(INVENTORY_ENDPOINTS.stats),
          api.get(INVENTORY_ENDPOINTS.lowStock),
        ]);
        this.stats = statsRes.data.data;
        this.lowStockItems = lowRes.data.data ?? [];
      } catch {
        /* non-critical */
      }
    },

    setType(type) {
      this.type = type;
      this.fetchMovements(1);
    },

    openAdjust(variant = null) {
      this.adjust = { variantId: variant?.id ?? null, mode: 'add', value: null, note: '' };
      this.showAdjustModal = true;
      this.loadVariants();
    },

    async loadVariants() {
      if (this.variantCache.length) return;
      try {
        const res = await api.get(POS_ENDPOINTS.products);
        this.variantCache = (res.data.data ?? []).map((v) => ({
          id: v.id,
          name: `${v.product?.name ?? ''}${v.name && v.name !== v.product?.name ? ` — ${v.name}` : ''}${v.sku ? ` (${v.sku})` : ''}`,
          stock: v.stock,
          track_stock: !!v.product?.track_stock,
        }));
      } catch (e) {
        notify.error('Failed to load products');
      }
    },

    async submitAdjust() {
      if (!this.adjust.variantId) return notify.warning('Select a product');
      if (!this.adjust.value || Number(this.adjust.value) <= 0)
        return notify.warning('Enter a quantity');

      this.saving = true;
      try {
        await api.post(INVENTORY_ENDPOINTS.adjust, {
          product_variant_id: this.adjust.variantId,
          mode: this.adjust.mode,
          value: Number(this.adjust.value),
          note: this.adjust.note || null,
        });
        notify.success('Stock adjusted successfully');
        this.showAdjustModal = false;
        this.fetchMovements();
        this.fetchOverview();
      } catch (e) {
        notify.error(e.response?.data?.message ?? 'Adjustment failed');
      } finally {
        this.saving = false;
      }
    },
  },
});
