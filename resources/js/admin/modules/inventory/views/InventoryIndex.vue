<template>
  <div class="inv-page container-fluid">
    <!-- ==================== KPI Cards ==================== -->
    <div class="kpi-row">
      <div class="kpi-card accent-indigo">
        <div class="kpi-icon"><i class="fas fa-cubes"></i></div>
        <div class="kpi-body">
          <small>SKUs Tracked</small>
          <strong>{{ store.stats.tracked_skus }}</strong>
        </div>
      </div>

      <button class="kpi-card accent-amber text-start" @click="scrollToLowStock">
        <div class="kpi-icon"><i class="fas fa-triangle-exclamation"></i></div>
        <div class="kpi-body">
          <small>Low Stock</small>
          <strong>{{ store.stats.low_stock }}</strong>
        </div>
      </button>

      <button class="kpi-card accent-red text-start" @click="setType('damage')">
        <div class="kpi-icon"><i class="fas fa-circle-xmark"></i></div>
        <div class="kpi-body">
          <small>Out of Stock</small>
          <strong>{{ store.stats.out_of_stock }}</strong>
        </div>
      </button>

      <div class="kpi-card accent-emerald">
        <div class="kpi-icon"><i class="fas fa-arrows-rotate"></i></div>
        <div class="kpi-body">
          <small>Movements Today</small>
          <strong>{{ store.stats.movements_today }}</strong>
        </div>
      </div>
    </div>

    <div class="row g-3">
      <!-- ==================== Ledger ==================== -->
      <div class="col-lg-8">
        <div class="panel h-100 d-flex flex-column">
          <div class="ledger-toolbar">
            <div class="search-box">
              <i class="fas fa-search"></i>
              <input
                v-model="store.search"
                type="text"
                class="form-control form-control-sm"
                placeholder="Search product / sku / note..."
                @input="debouncedFetch"
              />
            </div>

            <div class="type-chips">
              <button
                v-for="t in types"
                :key="t.value"
                class="chip"
                :class="{ active: store.type === t.value }"
                @click="store.setType(t.value)"
              >
                <span v-if="t.dot" class="dot" :style="{ background: t.dot }"></span>
                {{ t.label }}
              </button>
            </div>

            <button class="btn btn-primary btn-sm px-3 adjust-btn" @click="store.openAdjust()">
              <i class="fas fa-sliders me-1"></i>Adjust Stock
            </button>
          </div>

          <table class="ledger-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Product</th>
                <th>Type</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Stock</th>
                <th>Note</th>
              </tr>
            </thead>

            <tbody v-if="!store.loading">
              <tr v-for="mv in store.rows" :key="mv.id">
                <td class="text-body-secondary nowrap">{{ formatDate(mv.created_at) }}</td>
                <td>
                  <div class="prod-cell">
                    <img
                      :src="mv.variant?.thumbnail ?? mv.variant?.product?.thumbnail ?? FALLBACK_IMG"
                      alt=""
                    />
                    <div class="min-w-0">
                      <p class="prod-name">{{ mv.variant?.product?.name ?? '-' }}</p>
                      <small>{{ mv.variant?.name }}<template v-if="mv.variant?.sku"> · {{ mv.variant.sku }}</template></small>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="type-pill" :class="mv.type">{{ mv.type }}</span>
                </td>
                <td class="text-center">
                  <span class="qty-badge" :class="Number(mv.quantity) >= 0 ? 'pos' : 'neg'">
                    {{ Number(mv.quantity) >= 0 ? '+' : '' }}{{ Number(mv.quantity) }}
                  </span>
                </td>
                <td class="text-center nowrap">
                  <span class="stock-flow">
                    {{ Number(mv.stock_before) }}
                    <i class="fas fa-arrow-right-long"></i>
                    <strong :class="{ zero: Number(mv.stock_after) <= 0 }">{{ Number(mv.stock_after) }}</strong>
                  </span>
                </td>
                <td><small class="text-body-secondary note-cell">{{ mv.note ?? '-' }}</small></td>
              </tr>

              <tr v-if="!store.rows.length">
                <td colspan="6" class="empty-row">
                  <i class="fas fa-clipboard-list"></i>
                  <p>No stock movements found</p>
                </td>
              </tr>
            </tbody>
          </table>

          <div v-if="store.loading" class="loading-state"><BaseLoader /></div>

          <div class="table-footer" v-if="store.meta.last_page > 1">
            <small>Page {{ store.meta.current_page }} of {{ store.meta.last_page }} · {{ store.meta.total }} movements</small>
            <div class="pager">
              <button :disabled="store.meta.current_page <= 1" @click="goPage(store.meta.current_page - 1)">
                <i class="fas fa-chevron-left"></i>
              </button>
              <button
                :disabled="store.meta.current_page >= store.meta.last_page"
                @click="goPage(store.meta.current_page + 1)"
              >
                <i class="fas fa-chevron-right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- ==================== Low Stock Panel ==================== -->
      <div class="col-lg-4" ref="lowStockEl">
        <div class="panel low-panel h-100">
          <h6 class="panel-title">
            <i class="fas fa-triangle-exclamation text-warning me-1"></i>
            Low Stock Alerts
            <span class="count-badge">{{ store.lowStockItems.length }}</span>
          </h6>

          <div v-if="!store.lowStockItems.length" class="all-good">
            <i class="fas fa-circle-check"></i>
            <p>All stocked up!</p>
            <small>No products at or below alert level</small>
          </div>

          <div v-else class="low-list">
            <div v-for="item in store.lowStockItems" :key="item.id" class="low-item">
              <img :src="item.thumbnail ?? item.product?.thumbnail ?? FALLBACK_IMG" alt="" />
              <div class="min-w-0 flex-grow-1">
                <p class="prod-name">{{ item.product?.name }}</p>
                <small>{{ item.name }}</small>
              </div>
              <span class="stock-tag" :class="{ out: Number(item.stock) <= 0 }">
                {{ Number(item.stock) <= 0 ? 'OUT' : `${Number(item.stock)} left` }}
              </span>
              <button class="restock-btn" title="Restock" @click="store.openAdjust({ id: item.id })">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ==================== Adjust Modal ==================== -->
    <BaseModal
      v-model="store.showAdjustModal"
      title="Adjust Stock"
      icon="fas fa-sliders"
      size="md"
      :loading="store.saving"
      confirmText="Apply Adjustment"
      confirmVariant="primary"
      @confirm="store.submitAdjust()"
    >
      <div class="adjust-body">
        <label class="form-label fw-semibold">Product</label>
        <BaseSelect
          v-model="store.adjust.variantId"
          name="variant"
          :options="store.variantOptions"
          optionKeyName="name"
          optionValueName="id"
          placeholder="Search and select a variant..."
          customClass="form-control-sm pos-select mb-1"
        />

        <div v-if="store.selectedVariant" class="current-stock mb-3">
          <i class="fas fa-boxes-stacked me-2"></i>
          Current stock:
          <strong>{{ store.selectedVariant.stock }}</strong>
          <template v-if="!store.selectedVariant.track_stock">
            <span class="text-warning ms-2 small">(stock tracking is off for this product)</span>
          </template>
        </div>

        <label class="form-label fw-semibold">Mode</label>
        <div class="mode-seg mb-3">
          <button :class="{ active: store.adjust.mode === 'add' }" @click="store.adjust.mode = 'add'">
            <i class="fas fa-plus me-1"></i>Add / Subtract (delta)
          </button>
          <button :class="{ active: store.adjust.mode === 'set' }" @click="store.adjust.mode = 'set'">
            <i class="fas fa-equals me-1"></i>Set Exact Count
          </button>
        </div>

        <label class="form-label fw-semibold">
          {{ store.adjust.mode === 'add' ? 'Quantity (+ to add, − to subtract)' : 'New Stock Count' }}
        </label>
        <input
          type="number"
          class="form-control mb-3"
          :min="store.adjust.mode === 'add' ? undefined : 0"
          v-model.number="store.adjust.value"
          placeholder="0"
        />
        <small v-if="store.adjust.mode === 'set'" class="text-body-secondary d-block mb-3">
          Movement recorded: {{ setDelta }} from current stock
        </small>

        <label class="form-label fw-semibold">Reason / Note</label>
        <input
          type="text"
          class="form-control"
          maxlength="255"
          v-model="store.adjust.note"
          placeholder="e.g. damaged goods, cycle count, supplier delivery..."
        />
      </div>
    </BaseModal>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import BaseModal from '../../../../ahmed-vue-kit/components/ui/BaseModal.vue';
import BaseSelect from '../../../../ahmed-vue-kit/components/form/BaseSelect.vue';
import BaseLoader from '../../../../ahmed-vue-kit/components/ui/BaseLoader.vue';
import { useInventoryStore } from '../store';

const FALLBACK_IMG =
  'data:image/svg+xml;utf8,' +
  encodeURIComponent(
    '<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60"><rect width="100%" height="100%" fill="#e9ecef"/><text x="50%" y="55%" font-size="22" text-anchor="middle" fill="#adb5bd">?</text></svg>'
  );

const store = useInventoryStore();
const lowStockEl = ref(null);
let debounceTimer = null;

const types = [
  { value: '', label: 'All' },
  { value: 'purchase', label: 'Purchase', dot: '#16a34a' },
  { value: 'sale', label: 'Sale', dot: '#6366f1' },
  { value: 'return', label: 'Return', dot: '#0ea5e9' },
  { value: 'adjustment', label: 'Adjustment', dot: '#f59e0b' },
];

const setDelta = computed(() => {
  if (!store.selectedVariant || store.adjust.mode !== 'set') return '';
  const delta = Number(store.adjust.value) - Number(store.selectedVariant.stock);
  return `${delta >= 0 ? '+' : ''}${delta}`;
});

const formatDate = (value) =>
  new Date(String(value).replace(' ', 'T')).toLocaleString(undefined, {
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });

const debouncedFetch = () => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => store.fetchMovements(1), 350);
};

const goPage = (page) => {
  store.fetchMovements(page);
  window.scrollTo({ top: 0, behavior: 'smooth' });
};

const scrollToLowStock = () => {
  lowStockEl.value?.scrollIntoView({ behavior: 'smooth', block: 'start' });
};

onMounted(() => {
  store.fetchMovements();
  store.fetchOverview();
});
</script>

<style scoped>
.inv-page {
  --accent: #6366f1;
  padding-top: 6px;
}

.min-w-0 {
  min-width: 0;
}

/* ================= KPI ================= */

.kpi-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 14px;
  margin-bottom: 16px;
}

.kpi-card {
  display: flex;
  align-items: center;
  gap: 14px;
  background: var(--bs-body-bg);
  border: 1px solid var(--bs-border-color);
  border-radius: 14px;
  padding: 16px 18px;
  transition: all 0.15s ease;
}

button.kpi-card:hover,
.kpi-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
}

.kpi-icon {
  width: 46px;
  height: 46px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 19px;
  color: #fff;
  flex-shrink: 0;
}

.accent-indigo .kpi-icon { background: linear-gradient(135deg, #4f46e5, #6366f1); }
.accent-emerald .kpi-icon { background: linear-gradient(135deg, #059669, #10b981); }
.accent-amber .kpi-icon { background: linear-gradient(135deg, #d97706, #f59e0b); }
.accent-red .kpi-icon { background: linear-gradient(135deg, #dc2626, #ef4444); }

.kpi-body small {
  display: block;
  color: var(--bs-secondary-color);
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.03em;
}

.kpi-body strong {
  font-size: 21px;
  font-weight: 800;
  font-variant-numeric: tabular-nums;
}

/* ================= panels ================= */

.panel {
  background: var(--bs-body-bg);
  border: 1px solid var(--bs-border-color);
  border-radius: 14px;
  padding: 16px;
}

.panel-title {
  margin: 0 0 12px;
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  color: var(--bs-secondary-color);
  display: flex;
  align-items: center;
  gap: 6px;
}

.count-badge {
  background: rgba(245, 158, 11, 0.15);
  color: #b45309;
  border: 1px solid rgba(245, 158, 11, 0.4);
  font-size: 11px;
  padding: 1px 9px;
  border-radius: 999px;
}

/* ================= toolbar ================= */

.ledger-toolbar {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 12px;
}

.search-box {
  position: relative;
  width: 240px;
}

.search-box > i {
  position: absolute;
  left: 11px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--bs-secondary-color);
  font-size: 12px;
}

.search-box .form-control {
  padding-left: 32px;
  border-radius: 9px;
}

.type-chips {
  display: flex;
  gap: 6px;
  overflow-x: auto;
  flex: 1;
  scrollbar-width: thin;
}

.chip {
  flex-shrink: 0;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border: 1px solid var(--bs-border-color);
  background: var(--bs-body-bg);
  color: var(--bs-body-color);
  border-radius: 999px;
  padding: 5px 13px;
  font-size: 12px;
  font-weight: 600;
  transition: all 0.15s ease;
}

.chip:hover {
  border-color: var(--accent);
  color: var(--accent);
}

.chip.active {
  background: var(--accent);
  color: #fff;
  border-color: transparent;
}

.dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
}

.adjust-btn {
  border-radius: 9px;
  white-space: nowrap;
}

/* ================= ledger ================= */

.ledger-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

.ledger-table th {
  text-align: left;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: var(--bs-secondary-color);
  padding: 10px 12px;
  border-bottom: 1px solid var(--bs-border-color);
  background: var(--bs-tertiary-bg);
  white-space: nowrap;
}

.ledger-table td {
  padding: 10px 12px;
  border-bottom: 1px solid var(--bs-border-color);
  vertical-align: middle;
}

.ledger-table tbody tr:hover {
  background: var(--bs-tertiary-bg);
}

.nowrap {
  white-space: nowrap;
}

.prod-cell {
  display: flex;
  align-items: center;
  gap: 10px;
  max-width: 280px;
}

.prod-cell img {
  width: 38px;
  height: 38px;
  border-radius: 9px;
  object-fit: cover;
  background: var(--bs-tertiary-bg);
  flex-shrink: 0;
}

.prod-name {
  margin: 0;
  font-size: 13px;
  font-weight: 600;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.prod-cell small {
  color: var(--bs-secondary-color);
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.type-pill {
  display: inline-block;
  font-size: 11px;
  font-weight: 700;
  text-transform: capitalize;
  padding: 2px 10px;
  border-radius: 999px;
}

.type-pill.purchase { color: #15803d; background: rgba(22, 163, 74, 0.12); border: 1px solid rgba(22,163,74,.35); }
.type-pill.sale { color: #4338ca; background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99,102,241,.35); }
.type-pill.return { color: #0369a1; background: rgba(14, 165, 233, 0.1); border: 1px solid rgba(14,165,233,.35); }
.type-pill.adjustment { color: #b45309; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245,158,11,.4); }
.type-pill.damage { color: #b91c1c; background: rgba(220, 38, 38, 0.1); border: 1px solid rgba(220,38,38,.35); }
.type-pill.opening { color: #475569; background: rgba(100, 116, 139, 0.12); border: 1px solid rgba(100,116,139,.35); }

.qty-badge {
  display: inline-block;
  min-width: 52px;
  font-weight: 800;
  font-size: 12.5px;
  font-variant-numeric: tabular-nums;
  padding: 2px 10px;
  border-radius: 7px;
}

.qty-badge.pos {
  color: #15803d;
  background: rgba(22, 163, 74, 0.1);
}

.qty-badge.neg {
  color: #b91c1c;
  background: rgba(220, 38, 38, 0.09);
}

.stock-flow {
  font-variant-numeric: tabular-nums;
  color: var(--bs-secondary-color);
  font-size: 12.5px;
}

.stock-flow i {
  font-size: 9px;
  margin: 0 5px;
  opacity: 0.55;
}

.stock-flow strong.zero {
  color: #dc3545;
}

.note-cell {
  display: inline-block;
  max-width: 180px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.empty-row {
  text-align: center;
  color: var(--bs-secondary-color);
  padding: 44px 0 !important;
}

.empty-row i {
  font-size: 30px;
  opacity: 0.4;
  display: block;
  margin-bottom: 8px;
}

.loading-state {
  padding: 36px 0;
  display: flex;
  justify-content: center;
}

.table-footer {
  margin-top: auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 12px;
}

.pager {
  display: flex;
  gap: 6px;
}

.pager button {
  width: 28px;
  height: 28px;
  border: 1px solid var(--bs-border-color);
  background: var(--bs-body-bg);
  color: var(--bs-body-color);
  border-radius: 8px;
  font-size: 10px;
  transition: all 0.12s ease;
}

.pager button:hover:not(:disabled) {
  border-color: var(--accent);
  color: var(--accent);
}

.pager button:disabled {
  opacity: 0.35;
}

/* ================= low stock ================= */

.all-good {
  text-align: center;
  color: var(--bs-secondary-color);
  padding: 48px 0;
}

.all-good i {
  font-size: 40px;
  color: #16a34a;
  margin-bottom: 10px;
}

.all-good p {
  font-weight: 700;
  margin: 0 0 2px;
}

.low-list {
  display: flex;
  flex-direction: column;
}

.low-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 2px;
  border-bottom: 1px dashed var(--bs-border-color);
}

.low-item:last-child {
  border-bottom: none;
}

.low-item img {
  width: 40px;
  height: 40px;
  border-radius: 9px;
  object-fit: cover;
  background: var(--bs-tertiary-bg);
  flex-shrink: 0;
}

.low-item .prod-name {
  font-size: 12.5px;
}

.low-item small {
  color: var(--bs-secondary-color);
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.stock-tag {
  flex-shrink: 0;
  font-size: 11px;
  font-weight: 800;
  padding: 3px 10px;
  border-radius: 999px;
  color: #b45309;
  background: rgba(245, 158, 11, 0.12);
  border: 1px solid rgba(245, 158, 11, 0.4);
}

.stock-tag.out {
  color: #b91c1c;
  background: rgba(220, 38, 38, 0.1);
  border-color: rgba(220, 38, 38, 0.4);
}

.restock-btn {
  width: 30px;
  height: 30px;
  flex-shrink: 0;
  border: 1px solid rgba(99, 102, 241, 0.4);
  background: rgba(99, 102, 241, 0.08);
  color: var(--accent);
  border-radius: 8px;
  font-size: 12px;
  transition: all 0.12s ease;
}

.restock-btn:hover {
  background: var(--accent);
  color: #fff;
}

/* ================= adjust modal ================= */

.current-stock {
  display: inline-flex;
  align-items: center;
  background: var(--bs-tertiary-bg);
  border: 1px dashed var(--bs-border-color);
  border-radius: 9px;
  padding: 7px 13px;
  font-size: 13.5px;
  color: var(--bs-secondary-color);
}

.current-stock strong {
  color: var(--bs-body-color);
  margin-left: 4px;
}

.mode-seg {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
}

.mode-seg button {
  border: 1px solid var(--bs-border-color);
  background: var(--bs-body-bg);
  color: var(--bs-body-color);
  border-radius: 10px;
  padding: 9px;
  font-size: 13px;
  font-weight: 600;
  transition: all 0.15s ease;
}

.mode-seg button.active {
  background: linear-gradient(135deg, #4f46e5, #6366f1);
  border-color: transparent;
  color: #fff;
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
}

@media (max-width: 767.98px) {
  .search-box {
    width: 100%;
  }

  .note-cell,
  .ledger-table th:nth-child(6),
  .ledger-table td:nth-child(6) {
    display: none;
  }
}
</style>
