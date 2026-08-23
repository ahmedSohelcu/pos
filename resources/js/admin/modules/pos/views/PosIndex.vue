<template>
  <div class="pos-shell">
    <div class="pos-left">
      <div class="pos-toolbar">
        <div class="search-box">
          <i class="fas fa-barcode"></i>
          <input
            ref="searchRef"
            v-model="store.search"
            type="text"
            class="form-control"
            placeholder="Scan barcode or search products..."
            @keydown.enter="onSearchEnter"
            @input="debouncedFetch"
          />
          <kbd class="search-kbd">F2</kbd>
        </div>

        <div class="customer-box">
          <BaseSelect
            v-model="store.customerId"
            name="customer"
            :options="customerOptions"
            optionKeyName="name"
            optionValueName="id"
            placeholder="Walk-in Customer"
            customClass="form-control-sm pos-select"
          />
        </div>
      </div>

      <div class="category-chips">
        <button
          class="chip"
          :class="{ active: !store.categoryId }"
          @click="selectCategory(null)"
        >
          All Products
        </button>
        <button
          v-for="cat in store.categories"
          :key="cat.id"
          class="chip"
          :class="{ active: store.categoryId === cat.id }"
          @click="selectCategory(cat.id)"
        >
          {{ cat.name }}
        </button>
      </div>

      <div v-if="store.loading" class="product-grid-loading">
        <BaseLoader />
      </div>

      <div v-else class="product-grid">
        <div
          v-for="variant in store.variants"
          :key="variant.id"
          class="product-card"
          :class="{ 'out-of-stock': isOutOfStock(variant) }"
          @click="store.addToCart(variant)"
        >
          <div class="thumb">
            <img
              :src="variant.thumbnail ?? variant.product?.thumbnail ?? FALLBACK_IMG"
              alt=""
              loading="lazy"
            />
            <div class="thumb-overlay">
              <span class="add-circle"><i class="fas fa-plus"></i></span>
            </div>
            <span v-if="isOutOfStock(variant)" class="stock-badge bg-danger">Out</span>
            <span
              v-else-if="isLowStock(variant)"
              class="stock-badge bg-warning text-dark"
            >
              {{ variant.stock }} left
            </span>
          </div>
          <div class="info">
            <p class="name" :title="variant.product?.name">
              {{ variant.product?.name }}
            </p>
            <p class="variant-name">{{ variant.name }}</p>
            <div class="meta">
              <span class="price">{{ formatMoney(variant.sale_price) }}</span>
              <small v-if="variant.product?.track_stock" class="stock">
                {{ variant.stock }} {{ variant.product?.unit?.name ?? '' }}
              </small>
            </div>
          </div>
        </div>

        <div v-if="!store.variants.length" class="empty-state">
          <i class="fas fa-box-open"></i>
          <p>No products found</p>
          <small>Try a different search or category</small>
        </div>
      </div>
    </div>

    <div class="pos-cart">
      <div class="cart-header">
        <h5><i class="fas fa-shopping-cart me-2"></i>Current Sale</h5>
        <span class="count-pill">{{ store.itemCount }}</span>

        <div class="dropdown ms-auto">
          <button
            class="icon-btn"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            title="Parked sales"
          >
            <i class="fas fa-pause"></i>
            <span v-if="store.heldOrders.length" class="held-badge">{{
              store.heldOrders.length
            }}</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end held-menu shadow">
            <li class="dropdown-header px-3 pt-2 pb-1">Parked Sales</li>
            <li v-if="!store.heldOrders.length" class="px-3 py-2 small text-body-secondary">
              Nothing parked yet
            </li>
            <li v-for="order in store.heldOrders" :key="order.id">
              <div class="held-item d-flex align-items-center gap-2 px-3 py-2">
                <div class="flex-grow-1 min-w-0">
                  <div class="d-flex align-items-center gap-2">
                    <strong>{{ order.ref }}</strong>
                    <small class="text-body-secondary">{{ order.heldAt }}</small>
                  </div>
                  <small class="text-body-secondary d-block text-truncate">
                    {{ order.itemCount }} items · {{ formatMoney(order.total) }}
                  </small>
                </div>
                <button
                  class="btn btn-sm btn-primary"
                  title="Recall"
                  @click="store.recallSale(order)"
                >
                  <i class="fas fa-rotate-left"></i>
                </button>
                <button
                  class="btn btn-sm btn-outline-danger"
                  title="Discard"
                  @click="store.discardHeld(order)"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </li>
          </ul>
        </div>

        <button
          class="icon-btn danger"
          :class="{ armed: confirmClear }"
          :disabled="!store.cart.length"
          :title="confirmClear ? 'Click again to confirm' : 'Clear cart'"
          @click="onClearClick"
        >
          <i :class="confirmClear ? 'fas fa-check' : 'fas fa-trash'"></i>
        </button>
      </div>

      <div class="cart-lines">
        <TransitionGroup v-if="store.cart.length" name="line" tag="div">
          <div v-for="line in store.cart" :key="line.variant_id" class="cart-line">
            <img class="line-thumb" :src="line.thumbnail ?? FALLBACK_IMG" alt="" />
            <div class="line-info">
              <p class="line-name" :title="line.name">{{ line.name }}</p>
              <small>{{ line.variant_name }} · {{ formatMoney(line.price) }}</small>
            </div>
            <div class="qty-stepper">
              <button @click="store.decrement(line)" tabindex="-1">
                <i class="fas fa-minus"></i>
              </button>
              <input
                type="number"
                min="1"
                :value="line.qty"
                @change="store.setQty(line, $event.target.value)"
              />
              <button @click="store.increment(line)" tabindex="-1">
                <i class="fas fa-plus"></i>
              </button>
            </div>
            <div class="line-total">
              <span>{{ formatMoney(line.price * line.qty) }}</span>
              <button class="line-remove" title="Remove" @click="store.removeLine(line)">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </TransitionGroup>

        <div v-else class="empty-cart">
          <div class="empty-icon"><i class="fas fa-cart-arrow-down"></i></div>
          <p>Cart is empty</p>
          <small>Click a product to add it to the sale</small>
        </div>
      </div>

      <div class="cart-summary">
        <div class="summary-row">
          <span>Subtotal</span>
          <strong>{{ formatMoney(store.subtotal) }}</strong>
        </div>

        <div class="summary-row discount-row">
          <span>Discount</span>
          <div class="discount-input">
            <input
              type="number"
              min="0"
              :max="store.discountType === 'percent' ? 100 : store.subtotal"
              v-model.number="store.discount"
            />
            <div class="seg">
              <button
                :class="{ active: store.discountType === 'fixed' }"
                title="Fixed amount"
                @click="store.discountType = 'fixed'"
              >
                {{ currencySymbol }}
              </button>
              <button
                :class="{ active: store.discountType === 'percent' }"
                title="Percentage"
                @click="store.discountType = 'percent'"
              >
                %
              </button>
            </div>
          </div>
        </div>

        <div class="summary-row total">
          <span>Total</span>
          <strong>{{ formatMoney(store.total) }}</strong>
        </div>

        <div class="payment-methods">
          <button
            v-for="method in methods"
            :key="method.value"
            class="method-btn"
            :class="{ active: store.paymentMethod === method.value }"
            @click="store.paymentMethod = method.value"
          >
            <i :class="method.icon"></i>{{ method.label }}
          </button>
        </div>

        <button
          class="charge-btn"
          :disabled="!store.cart.length"
          @click="store.openCheckout()"
        >
          <i class="fas fa-bolt me-2"></i>Charge {{ formatMoney(store.total) }}
          <kbd class="charge-kbd">F9</kbd>
        </button>
      </div>
    </div>

    <!-- ==================== Payment Modal ==================== -->
    <BaseModal
      v-model="store.showPaymentModal"
      title="Complete Payment"
      icon="fas fa-cash-register"
      size="md"
      :loading="store.checkoutLoading"
      confirmText="Confirm Sale"
      confirmVariant="success"
      cancelText="Back"
      @confirm="store.confirmCheckout()"
    >
      <div class="payment-body">
        <div class="due-panel mb-3">
          <small>Amount Due</small>
          <strong>{{ formatMoney(store.total) }}</strong>
        </div>

        <template v-if="store.paymentMethod === 'cash'">
          <label class="form-label fw-semibold">Cash Tendered</label>
          <input
            type="number"
            min="0"
            v-model.number="store.amountTendered"
            class="form-control form-control-lg text-end fw-bold mb-2"
          />

          <div class="tender-chips mb-3">
            <button
              v-for="amount in tenderSuggestions"
              :key="amount"
              type="button"
              class="chip"
              @click="store.amountTendered = amount"
            >
              {{ formatMoney(amount) }}
            </button>
          </div>

          <div class="change-panel" :class="{ short: isShort }">
            <span>Change Due</span>
            <strong>{{ formatMoney(isShort ? 0 : store.changeDue) }}</strong>
          </div>
          <div v-if="isShort" class="text-danger small mt-2 text-center">
            <i class="fas fa-triangle-exclamation me-1"></i>
            Still owed: {{ formatMoney(store.total - (Number(store.amountTendered) || 0)) }}
          </div>
        </template>

        <div v-else class="alert alert-info d-flex align-items-center gap-2 mb-0">
          <i :class="activeMethodIcon"></i>
          {{ activeMethodLabel }} payment — confirm on the terminal, then press
          <strong>Confirm Sale</strong>.
        </div>
      </div>
    </BaseModal>

    <!-- ==================== Receipt / Invoice Modal ==================== -->
    <BaseModal
      v-model="store.showReceiptModal"
      title="Sale Completed"
      icon="fas fa-circle-check"
      size="sm"
      @update:modelValue="(v) => !v && store.startNewSale()"
    >
      <template #footer>
        <button class="btn btn-light px-4" @click="store.startNewSale()">
          <i class="fas fa-plus me-2"></i>New Sale
        </button>
        <button class="btn btn-primary px-4" @click="printInvoice()">
          <i class="fas fa-print me-2"></i>Print Invoice
        </button>
      </template>

      <ReceiptPrint :sale="store.lastSale" />
    </BaseModal>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue';
import BaseSelect from '../../../../ahmed-vue-kit/components/form/BaseSelect.vue';
import BaseModal from '../../../../ahmed-vue-kit/components/ui/BaseModal.vue';
import BaseLoader from '../../../../ahmed-vue-kit/components/ui/BaseLoader.vue';
import ReceiptPrint from '../../../components/ReceiptPrint.vue';
import { notify } from '../../../../ahmed-vue-kit/composables/useNotify';
import { usePosStore } from '../store';

const FALLBACK_IMG =
  'data:image/svg+xml;utf8,' +
  encodeURIComponent(
    '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"><rect width="100%" height="100%" fill="#e9ecef"/><text x="50%" y="55%" font-size="28" text-anchor="middle" fill="#adb5bd">?</text></svg>'
  );

const store = usePosStore();
const searchRef = ref(null);

const currencySymbol = '';
const methods = [
  { value: 'cash', label: 'Cash', icon: 'fas fa-money-bill-wave me-1' },
  { value: 'card', label: 'Card', icon: 'fas fa-credit-card me-1' },
  { value: 'mobile', label: 'Mobile', icon: 'fas fa-mobile-screen me-1' },
];

const customerOptions = computed(() => [
  { id: '', name: 'Walk-in Customer' },
  ...store.customers,
]);

const activeMethodLabel = computed(
  () => methods.find((m) => m.value === store.paymentMethod)?.label ?? ''
);
const activeMethodIcon = computed(() => {
  const m = methods.find((x) => x.value === store.paymentMethod);
  return `${m?.icon.replace(' me-1', '')} fs-5`;
});

const isShort = computed(
  () =>
    store.paymentMethod === 'cash' &&
    (Number(store.amountTendered) || 0) < store.total
);

const tenderSuggestions = computed(() => {
  const total = Math.ceil(Number(store.total) || 0);
  if (!total) return [];
  const suggestions = [total];
  [5, 10, 20, 50, 100].forEach((step) => {
    const rounded = Math.ceil(total / step) * step;
    if (rounded > total && !suggestions.includes(rounded)) {
      suggestions.push(rounded);
    }
  });
  return suggestions.slice(0, 4);
});

const formatMoney = (value) =>
  Number(value ?? 0).toLocaleString(undefined, {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });

const isOutOfStock = (variant) =>
  !!variant.product?.track_stock && Number(variant.stock) <= 0;

const isLowStock = (variant) =>
  !!variant.product?.track_stock &&
  Number(variant.stock) > 0 &&
  Number(variant.stock) <= Number(variant.product?.alert_quantity ?? 0);

let debounceTimer = null;
const debouncedFetch = () => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => store.fetchProducts(), 300);
};

const selectCategory = (id) => {
  store.categoryId = id;
  store.fetchProducts();
};

const onSearchEnter = () => {
  const term = (store.search ?? '').trim();
  if (!term) return;

  const exact = store.variants.find(
    (v) =>
      (v.sku && v.sku.toLowerCase() === term.toLowerCase()) ||
      (v.barcode && String(v.barcode).toLowerCase() === term.toLowerCase())
  );

  if (exact) {
    store.addToCart(exact);
    store.search = '';
    store.fetchProducts();
    searchRef.value?.focus();
  } else {
    notify.warning('No product matched that barcode/SKU');
  }
};

const confirmClear = ref(false);
let clearTimer = null;
const onClearClick = () => {
  if (!store.cart.length) return;

  if (confirmClear.value) {
    store.clearCart();
    confirmClear.value = false;
    clearTimeout(clearTimer);
  } else {
    confirmClear.value = true;
    clearTimer = setTimeout(() => (confirmClear.value = false), 2500);
  }
};

const printInvoice = () => window.print();

const onKeydown = (e) => {
  if (store.showPaymentModal) return;
  if (e.key === 'F2') {
    e.preventDefault();
    searchRef.value?.focus();
  } else if (e.key === 'F9') {
    e.preventDefault();
    store.openCheckout();
  }
};

watch(
  () => store.showReceiptModal,
  (open) => {
    if (!open) setTimeout(() => searchRef.value?.focus(), 200);
  }
);

onMounted(async () => {
  window.addEventListener('keydown', onKeydown);
  await Promise.all([
    store.fetchProducts(),
    store.fetchCategories(),
    store.fetchCustomers(),
  ]);
  searchRef.value?.focus();
});

onBeforeUnmount(() => window.removeEventListener('keydown', onKeydown));
</script>

<style scoped>
.pos-shell {
  --pos-accent: #6366f1;
  --pos-accent-strong: #4f46e5;
  --pos-success: #16a34a;
  --pos-radius: 14px;

  display: flex;
  gap: 14px;
  height: calc(100vh - 150px);
  min-height: 520px;
  padding: 4px 2px;
}

/* ================= left side ================= */

.pos-left {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 10px;
  min-width: 0;
}

.pos-toolbar {
  display: flex;
  gap: 12px;
  align-items: center;
  padding: 10px 14px;
  background: var(--bs-body-bg);
  border: 1px solid var(--bs-border-color);
  border-radius: var(--pos-radius);
}

.search-box {
  position: relative;
  flex: 1;
}

.search-box > i {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--bs-secondary-color);
  font-size: 15px;
}

.search-box .form-control {
  padding-left: 36px;
  padding-right: 42px;
  border-radius: 10px;
}

.search-kbd {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  opacity: 0.55;
  pointer-events: none;
}

.customer-box {
  width: 230px;
}

.customer-box > div {
  margin: 0 !important;
}

.customer-box :deep(select) {
  border-radius: 10px !important;
  height: 38px;
  font-size: 13.5px;
}

.category-chips {
  display: flex;
  gap: 8px;
  overflow-x: auto;
  scrollbar-width: thin;
  padding-bottom: 2px;
}

.chip {
  flex-shrink: 0;
  border: 1px solid var(--bs-border-color);
  background: var(--bs-body-bg);
  color: var(--bs-body-color);
  border-radius: 999px;
  padding: 6px 16px;
  font-size: 13px;
  font-weight: 600;
  transition: all 0.15s ease;
}

.chip:hover {
  border-color: var(--pos-accent);
  color: var(--pos-accent);
}

.chip.active {
  background: linear-gradient(135deg, var(--pos-accent-strong), var(--pos-accent));
  color: #fff;
  border-color: transparent;
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
}

.product-grid {
  flex: 1;
  overflow-y: auto;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(148px, 1fr));
  gap: 12px;
  align-content: start;
  padding-right: 4px;
  scrollbar-width: thin;
}

.product-grid-loading {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

.product-card {
  position: relative;
  background: var(--bs-body-bg);
  border: 1px solid var(--bs-border-color);
  border-radius: var(--pos-radius);
  padding: 10px;
  cursor: pointer;
  transition: all 0.15s ease;
  user-select: none;
}

.product-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 24px rgba(79, 70, 229, 0.16);
  border-color: var(--pos-accent);
}

.product-card:active {
  transform: scale(0.97);
}

.product-card.out-of-stock {
  opacity: 0.45;
  pointer-events: none;
}

.thumb {
  position: relative;
  aspect-ratio: 1;
  border-radius: 10px;
  overflow: hidden;
  background: var(--bs-tertiary-bg);
  margin-bottom: 8px;
}

.thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.thumb-overlay {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(79, 70, 229, 0.35);
  backdrop-filter: blur(1px);
  opacity: 0;
  transition: opacity 0.15s ease;
}

.add-circle {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--pos-accent-strong), var(--pos-accent));
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 15px;
  transform: scale(0.6);
  transition: transform 0.15s ease;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
}

.product-card:hover .thumb-overlay {
  opacity: 1;
}

.product-card:hover .add-circle {
  transform: scale(1);
}

.stock-badge {
  position: absolute;
  top: 6px;
  right: 6px;
  z-index: 1;
  font-size: 11px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 999px;
}

.info .name {
  font-size: 13px;
  font-weight: 600;
  color: var(--bs-body-color);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  margin-bottom: 2px;
}

.info .variant-name {
  font-size: 11px;
  color: var(--bs-secondary-color);
  margin-bottom: 6px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.meta {
  display: flex;
  justify-content: space-between;
  align-items: baseline;
  gap: 6px;
}

.meta .price {
  font-size: 14px;
  font-weight: 700;
  color: var(--pos-accent-strong);
}

.meta .stock {
  color: var(--bs-secondary-color);
  white-space: nowrap;
}

.empty-state {
  grid-column: 1 / -1;
  text-align: center;
  color: var(--bs-secondary-color);
  padding: 60px 0;
}

.empty-state i {
  font-size: 42px;
  margin-bottom: 10px;
  opacity: 0.5;
}

.empty-state p {
  margin-bottom: 2px;
  font-weight: 600;
}

/* ================= cart ================= */

.pos-cart {
  width: 390px;
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  background: var(--bs-body-bg);
  border: 1px solid var(--bs-border-color);
  border-radius: var(--pos-radius);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
}

.cart-header {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 13px 16px;
  border-bottom: 1px solid var(--bs-border-color);
  border-radius: var(--pos-radius) var(--pos-radius) 0 0;
}

.cart-header h5 {
  margin: 0;
  font-size: 15px;
  font-weight: 700;
}

.count-pill {
  background: linear-gradient(135deg, var(--pos-accent-strong), var(--pos-accent));
  color: #fff;
  font-size: 12px;
  font-weight: 700;
  min-width: 24px;
  text-align: center;
  padding: 2px 8px;
  border-radius: 999px;
}

.icon-btn {
  position: relative;
  border: 1px solid var(--bs-border-color);
  background: transparent;
  color: var(--bs-secondary-color);
  width: 32px;
  height: 32px;
  border-radius: 9px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
  transition: all 0.15s ease;
}

.icon-btn:hover:not(:disabled) {
  color: var(--pos-accent);
  border-color: var(--pos-accent);
}

.icon-btn.danger:hover:not(:disabled),
.icon-btn.danger.armed {
  color: #dc3545;
  border-color: #dc3545;
}

.icon-btn.danger.armed {
  background: rgba(220, 53, 69, 0.1);
  animation: arm-pulse 1s ease infinite;
}

@keyframes arm-pulse {
  50% {
    box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.12);
  }
}

.icon-btn:disabled {
  opacity: 0.4;
}

.held-badge {
  position: absolute;
  top: -6px;
  right: -6px;
  min-width: 16px;
  height: 16px;
  padding: 0 4px;
  border-radius: 999px;
  background: #f59e0b;
  color: #fff;
  font-size: 10px;
  font-weight: 800;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid var(--bs-body-bg);
}

.min-w-0 {
  min-width: 0;
}

.cart-lines {
  position: relative;
  flex: 1;
  overflow-y: auto;
  padding: 6px 12px;
  scrollbar-width: thin;
}

.line-enter-active,
.line-leave-active,
.line-move {
  transition: all 0.18s ease;
}

.line-enter-from {
  opacity: 0;
  transform: translateX(14px);
}

.line-leave-to {
  opacity: 0;
  transform: translateX(-14px);
}

.line-leave-active {
  position: absolute;
  width: 100%;
}

.cart-line {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 2px;
  border-bottom: 1px dashed var(--bs-border-color);
  background: var(--bs-body-bg);
}

.line-thumb {
  width: 44px;
  height: 44px;
  border-radius: 9px;
  object-fit: cover;
  background: var(--bs-tertiary-bg);
  flex-shrink: 0;
}

.line-info {
  flex: 1;
  min-width: 0;
}

.line-info small {
  color: var(--bs-secondary-color);
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.line-name {
  font-size: 13px;
  font-weight: 600;
  margin: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.qty-stepper {
  display: flex;
  align-items: center;
  gap: 3px;
  flex-shrink: 0;
}

.qty-stepper button {
  width: 22px;
  height: 22px;
  border: 1px solid var(--bs-border-color);
  background: var(--bs-tertiary-bg);
  color: var(--bs-body-color);
  border-radius: 6px;
  font-size: 9px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: all 0.12s ease;
}

.qty-stepper button:hover {
  background: var(--pos-accent);
  border-color: var(--pos-accent);
  color: #fff;
}

.qty-stepper input {
  width: 42px;
  text-align: center;
  border: 1px solid var(--bs-border-color);
  background: var(--bs-body-bg);
  color: var(--bs-body-color);
  border-radius: 6px;
  padding: 3px 2px;
  font-size: 13px;
  font-weight: 600;
  -moz-appearance: textfield;
  appearance: textfield;
}

.qty-stepper input::-webkit-outer-spin-button,
.qty-stepper input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}

.line-total {
  width: 86px;
  text-align: right;
  font-weight: 700;
  font-size: 13px;
  position: relative;
  padding-right: 14px;
  flex-shrink: 0;
}

.line-remove {
  position: absolute;
  right: 0;
  top: -2px;
  background: none;
  border: none;
  color: var(--bs-border-color);
  font-size: 12px;
  padding: 0;
  transition: color 0.12s ease;
}

.line-remove:hover {
  color: #ef4444;
}

.empty-cart {
  text-align: center;
  color: var(--bs-secondary-color);
  padding: 56px 0;
}

.empty-icon {
  width: 74px;
  height: 74px;
  margin: 0 auto 14px;
  border-radius: 50%;
  background: var(--bs-tertiary-bg);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
}

.empty-cart p {
  font-weight: 600;
  margin-bottom: 2px;
}

/* ================= summary ================= */

.cart-summary {
  border-top: 1px solid var(--bs-border-color);
  padding: 12px 16px 16px;
  background: var(--bs-tertiary-bg);
  border-radius: 0 0 var(--pos-radius) var(--pos-radius);
}

.summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 4px 0;
  font-size: 14px;
  color: var(--bs-secondary-color);
}

.summary-row strong {
  color: var(--bs-body-color);
  font-variant-numeric: tabular-nums;
}

.discount-row span:first-child {
  flex-shrink: 0;
}

.discount-input {
  display: flex;
  align-items: stretch;
  gap: 0;
}

.discount-input input {
  width: 110px;
  text-align: right;
  border: 1px solid var(--bs-border-color);
  border-right: 0;
  border-radius: 8px 0 0 8px;
  padding: 4px 8px;
  font-size: 13px;
  font-weight: 600;
  background: var(--bs-body-bg);
  color: var(--bs-body-color);
  -moz-appearance: textfield;
  appearance: textfield;
}

.discount-input input::-webkit-outer-spin-button,
.discount-input input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}

.seg {
  display: flex;
  border: 1px solid var(--bs-border-color);
  border-radius: 0 8px 8px 0;
  overflow: hidden;
}

.seg button {
  border: none;
  background: var(--bs-body-bg);
  color: var(--bs-secondary-color);
  font-size: 12px;
  font-weight: 700;
  padding: 4px 9px;
  transition: all 0.12s ease;
}

.seg button + button {
  border-left: 1px solid var(--bs-border-color);
}

.seg button.active {
  background: var(--pos-accent-strong);
  color: #fff;
}

.summary-row.total {
  font-size: 17px;
  padding-top: 10px;
  border-top: 1px dashed var(--bs-border-color);
  margin-top: 6px;
}

.summary-row.total span {
  color: var(--bs-body-color);
  font-weight: 600;
}

.summary-row.total strong {
  font-size: 21px;
  color: var(--pos-accent-strong);
}

.payment-methods {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 8px;
  margin: 12px 0 10px;
}

.method-btn {
  border: 1px solid var(--bs-border-color);
  background: var(--bs-body-bg);
  border-radius: 10px;
  padding: 8px 4px;
  font-size: 13px;
  font-weight: 600;
  color: var(--bs-body-color);
  transition: all 0.15s ease;
}

.method-btn i {
  margin-right: 5px;
  font-size: 12px;
}

.method-btn:hover {
  border-color: var(--pos-accent);
  color: var(--pos-accent);
}

.method-btn.active {
  background: linear-gradient(135deg, var(--pos-accent-strong), var(--pos-accent));
  border-color: transparent;
  color: #fff;
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
}

.charge-btn {
  position: relative;
  width: 100%;
  padding: 12px;
  border-radius: 12px;
  background: linear-gradient(135deg, var(--pos-success), #22c55e);
  color: #fff;
  font-size: 16px;
  font-weight: 700;
  border: none;
  box-shadow: 0 6px 18px rgba(22, 163, 74, 0.35);
  transition: all 0.15s ease;
}

.charge-btn:hover:not(:disabled) {
  filter: brightness(1.06);
  transform: translateY(-1px);
}

.charge-btn:disabled {
  background: var(--bs-border-color);
  color: var(--bs-secondary-color);
  box-shadow: none;
}

.charge-kbd {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(255, 255, 255, 0.22);
  border-color: rgba(255, 255, 255, 0.35);
  color: #fff;
  opacity: 0.9;
}

/* ================= payment modal ================= */

.due-panel {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border: 2px dashed var(--pos-accent);
  background: rgba(99, 102, 241, 0.07);
  border-radius: 12px;
  padding: 12px 16px;
}

.due-panel small {
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  color: var(--bs-secondary-color);
}

.due-panel strong {
  font-size: 24px;
  color: var(--pos-accent-strong);
  font-variant-numeric: tabular-nums;
}

.tender-chips {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.tender-chips .chip {
  padding: 4px 12px;
  font-size: 12.5px;
}

.change-panel {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-radius: 12px;
  padding: 10px 16px;
  background: rgba(22, 163, 74, 0.1);
  border: 1px solid rgba(22, 163, 74, 0.35);
}

.change-panel span {
  font-weight: 600;
  color: var(--bs-secondary-color);
}

.change-panel strong {
  font-size: 20px;
  color: var(--pos-success);
  font-variant-numeric: tabular-nums;
}

.change-panel.short {
  background: rgba(220, 53, 69, 0.08);
  border-color: rgba(220, 53, 69, 0.35);
}

.change-panel.short strong {
  color: #dc3545;
}

/* ================= responsive ================= */

@media (max-width: 1199.98px) {
  .pos-cart {
    width: 350px;
  }
}

@media (max-width: 991.98px) {
  .pos-shell {
    flex-direction: column;
    height: auto;
    min-height: 0;
  }

  .product-grid {
    max-height: 52vh;
    grid-template-columns: repeat(auto-fill, minmax(128px, 1fr));
  }

  .pos-cart {
    width: 100%;
  }

  .cart-lines {
    max-height: 300px;
  }

  .customer-box {
    width: 180px;
  }
}

@media (max-width: 575.98px) {
  .pos-toolbar {
    flex-direction: column;
    align-items: stretch;
  }

  .customer-box {
    width: 100%;
  }

  .cart-line {
    flex-wrap: wrap;
  }

  .line-total {
    width: auto;
  }
}
</style>
