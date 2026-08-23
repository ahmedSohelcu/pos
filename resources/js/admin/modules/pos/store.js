import { defineStore } from 'pinia';
import api from '../../../ahmed-vue-kit/api/api';
import { notify } from '../../../ahmed-vue-kit/composables/useNotify';
import { POS_ENDPOINTS, CUSTOMER_ENDPOINTS, CATEGORY_ENDPOINTS, SALES_ENDPOINTS } from '../../../data/endpoint';
import { useAuthStore } from '../../../ahmed-vue-kit/stores/authStore';

const cashierName = () => {
  try {
    const auth = useAuthStore();
    return auth.user?.name ?? auth.user?.user?.name ?? 'Cashier';
  } catch {
    return 'Cashier';
  }
};

export const usePosStore = defineStore('posStore', {
  state: () => ({
    variants: [],
    categories: [],
    customers: [],
    loading: false,
    checkoutLoading: false,

    search: '',
    categoryId: null,
    customerId: null,
    discount: 0,
    discountType: 'fixed',
    paymentMethod: 'cash',

    cart: [],
    heldOrders: [],
    lastSale: null,
    showPaymentModal: false,
    showReceiptModal: false,
    amountTendered: 0,
  }),

  getters: {
    itemCount: (state) => state.cart.reduce((sum, line) => sum + line.qty, 0),

    subtotal: (state) =>
      state.cart.reduce((sum, line) => sum + line.price * line.qty, 0),

    discountAmount() {
      const raw = Number(this.discount) || 0;
      const value =
        this.discountType === 'percent'
          ? (this.subtotal * Math.min(Math.max(raw, 0), 100)) / 100
          : raw;
      return Math.min(Math.max(value, 0), this.subtotal);
    },

    total() {
      return Math.max(this.subtotal - this.discountAmount, 0);
    },

    changeDue() {
      if (this.paymentMethod !== 'cash') return 0;
      return Math.max((Number(this.amountTendered) || 0) - this.total, 0);
    },
  },

  actions: {
    async fetchProducts() {
      this.loading = true;
      try {
        const res = await api.get(POS_ENDPOINTS.products, {
          params: {
            search: this.search || undefined,
            category_id: this.categoryId || undefined,
          },
        });
        this.variants = res.data.data;
      } catch (e) {
        notify.error(e.response?.data?.message ?? 'Failed to load products');
      } finally {
        this.loading = false;
      }
    },

    async fetchCategories() {
      const res = await api.get(CATEGORY_ENDPOINTS.selectable);
      this.categories = res.data.data ?? res.data;
    },

    async fetchCustomers() {
      const res = await api.get(CUSTOMER_ENDPOINTS.selectable);
      this.customers = res.data.data ?? res.data;
    },

    addToCart(variant) {
      const product = variant.product ?? {};
      const outOfStock = product.track_stock && Number(variant.stock) <= 0;

      if (outOfStock) {
        notify.warning(`${variant.name} is out of stock`);
        return;
      }

      const existing = this.cart.find((line) => line.variant_id === variant.id);

      if (existing) {
        if (product.track_stock && existing.qty + 1 > Number(variant.stock)) {
          notify.warning(`Only ${variant.stock} in stock`);
          return;
        }
        existing.qty += 1;
      } else {
        this.cart.push({
          variant_id: variant.id,
          product_id: product.id,
          name: product.name,
          variant_name: variant.name,
          sku: variant.sku,
          price: Number(variant.sale_price),
          stock: Number(variant.stock),
          track_stock: !!product.track_stock,
          thumbnail: variant.thumbnail ?? product.thumbnail,
          unit: product.unit?.name,
          qty: 1,
        });
      }

      notify.success(`${variant.name} added to cart`);
    },

    setQty(line, qty) {
      const value = Math.max(1, Math.trunc(Number(qty)) || 1);
      if (line.track_stock && value > line.stock) {
        notify.warning(`Only ${line.stock} in stock`);
        line.qty = line.stock;
        return;
      }
      line.qty = value;
    },

    increment(line) {
      this.setQty(line, line.qty + 1);
    },

    decrement(line) {
      if (line.qty <= 1) {
        this.removeLine(line);
        return;
      }
      this.setQty(line, line.qty - 1);
    },

    removeLine(line) {
      this.cart = this.cart.filter((l) => l.variant_id !== line.variant_id);
    },

    clearCart() {
      this.cart = [];
      this.customerId = null;
      this.discount = 0;
      this.discountType = 'fixed';
      this.amountTendered = 0;
      this.showPaymentModal = false;
    },

    holdSale() {
      if (!this.cart.length) {
        notify.warning('Cart is empty');
        return;
      }

      this.heldOrders.unshift({
        id: Date.now(),
        ref: `#${String(this.heldOrders.length + 1).padStart(3, '0')}`,
        customerId: this.customerId,
        lines: this.cart,
        discount: this.discount,
        discountType: this.discountType,
        itemCount: this.itemCount,
        total: this.total,
        heldAt: new Date().toLocaleTimeString([], {
          hour: '2-digit',
          minute: '2-digit',
        }),
      });

      this.cart = [];
      this.customerId = null;
      this.discount = 0;
      this.discountType = 'fixed';

      notify.success('Sale parked');
    },

    recallSale(order) {
      if (this.cart.length) {
        notify.warning('Hold or clear the current sale first');
        return;
      }

      this.cart = order.lines;
      this.customerId = order.customerId;
      this.discount = order.discount;
      this.discountType = order.discountType;
      this.heldOrders = this.heldOrders.filter((o) => o.id !== order.id);

      notify.success(`Sale ${order.ref} recalled`);
    },

    discardHeld(order) {
      this.heldOrders = this.heldOrders.filter((o) => o.id !== order.id);
    },

    openCheckout() {
      if (!this.cart.length) {
        notify.warning('Cart is empty');
        return;
      }
      this.amountTendered = this.total;
      this.showPaymentModal = true;
    },

    async confirmCheckout() {
      if (this.paymentMethod === 'cash' && (Number(this.amountTendered) || 0) < this.total) {
        notify.error('Insufficient amount tendered');
        return;
      }

      this.checkoutLoading = true;
      try {
        const res = await api.post(SALES_ENDPOINTS.store, {
          items: this.cart.map((line) => ({
            product_variant_id: line.variant_id,
            quantity: line.qty,
          })),
          customer_id: this.customerId || null,
          discount_value: Number(this.discount) || 0,
          discount_type: this.discountType,
          payment_method: this.paymentMethod,
          amount_tendered: Number(this.amountTendered) || 0,
        });

        this.lastSale = this.buildSaleSnapshot(res.data.data);
        this.showPaymentModal = false;
        this.showReceiptModal = true;

        notify.success('Sale completed successfully');

        this.cart = [];
        this.customerId = null;
        this.discount = 0;
        this.discountType = 'fixed';
        this.amountTendered = 0;

        this.fetchProducts();
      } catch (e) {
        notify.error(e.response?.data?.message ?? 'Checkout failed');
      } finally {
        this.checkoutLoading = false;
      }
    },

    buildSaleSnapshot(sale) {
      const created = sale?.created_at ? new Date(sale.created_at.replace(' ', 'T')) : new Date();

      return {
        ref: sale?.reference ?? `INV-${Date.now()}`,
        datetime: created.toLocaleString(undefined, {
          dateStyle: 'medium',
          timeStyle: 'short',
        }),
        customerName:
          sale?.customer?.name ??
          this.customers.find((c) => String(c.id) === String(this.customerId))?.name ??
          'Walk-in Customer',
        cashier: sale?.cashier?.name ?? cashierName(),
        lines: (sale?.items ?? []).map((item) => ({
          variant_id: item.product_variant_id,
          name: item.product_name,
          variant_name: item.variant_name,
          price: Number(item.unit_price),
          qty: Number(item.quantity),
        })),
        itemCount: (sale?.items ?? []).reduce((sum, i) => sum + Number(i.quantity), 0),
        subtotal: Number(sale?.subtotal ?? 0),
        discount: Number(sale?.discount_amount ?? 0),
        total: Number(sale?.total ?? 0),
        paymentMethod: sale?.payment_method ?? this.paymentMethod,
        tendered: Number(sale?.amount_tendered ?? 0),
        changeDue: Number(sale?.change_due ?? 0),
      };
    },

    startNewSale() {
      this.showReceiptModal = false;
      this.lastSale = null;
    },
  },
});
