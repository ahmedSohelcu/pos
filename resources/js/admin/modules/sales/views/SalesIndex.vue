<template>
  <div class="sales-page container-fluid">
    <!-- ==================== KPI Cards ==================== -->
    <div class="kpi-row">
      <div class="kpi-card accent-indigo">
        <div class="kpi-icon"><i class="fas fa-sack-dollar"></i></div>
        <div class="kpi-body">
          <small>Today's Revenue</small>
          <strong>{{ formatMoney(store.stats.today_total) }}</strong>
        </div>
      </div>

      <div class="kpi-card accent-emerald">
        <div class="kpi-icon"><i class="fas fa-receipt"></i></div>
        <div class="kpi-body">
          <small>Transactions Today</small>
          <strong>{{ store.stats.today_count }}</strong>
        </div>
      </div>

      <div class="kpi-card accent-amber">
        <div class="kpi-icon"><i class="fas fa-chart-simple"></i></div>
        <div class="kpi-body">
          <small>Avg Basket Value</small>
          <strong>{{ formatMoney(store.stats.avg_basket) }}</strong>
        </div>
      </div>

      <div class="kpi-card accent-sky">
        <div class="kpi-icon"><i class="fas fa-calendar-days"></i></div>
        <div class="kpi-body">
          <small>This Month</small>
          <strong>{{ formatMoney(store.stats.month_total) }}</strong>
        </div>
      </div>
    </div>

    <!-- ==================== Chart + Filters ==================== -->
    <div class="row g-3 mb-3">
      <div class="col-lg-5" v-if="chartReady">
        <div class="panel h-100">
          <h6 class="panel-title">Last 7 Days Revenue</h6>
          <div ref="chartEl" class="week-chart"></div>
        </div>
      </div>

      <div :class="chartReady ? 'col-lg-7' : 'col-12'">
        <div class="panel h-100 d-flex flex-column justify-content-center gap-2">
          <div class="d-flex align-items-center flex-wrap gap-2">
            <div class="search-box flex-grow-1">
              <i class="fas fa-search"></i>
              <input
                v-model="store.search"
                type="text"
                class="form-control"
                placeholder="Search invoice # or customer..."
                @input="debouncedFetch"
              />
            </div>

            <div class="seg-pills">
              <button
                v-for="r in ranges"
                :key="r.value"
                :class="{ active: store.range === r.value }"
                @click="setRange(r.value)"
              >
                {{ r.label }}
              </button>
            </div>
          </div>

          <div class="status-chips">
            <button
              v-for="s in statuses"
              :key="s.value"
              class="chip"
              :class="{ active: store.status === s.value }"
              @click="setStatus(s.value)"
            >
              <span v-if="s.dot" class="dot" :style="{ background: s.dot }"></span>
              {{ s.label }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- ==================== Table ==================== -->
    <div class="panel table-panel">
      <table class="sales-table">
        <thead>
          <tr>
            <th>Invoice</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Cashier</th>
            <th class="text-center">Items</th>
            <th>Payment</th>
            <th class="text-end">Total</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>

        <tbody v-if="!store.loading">
          <tr v-for="sale in store.rows" :key="sale.id">
            <td>
              <span class="ref-badge">{{ sale.reference }}</span>
            </td>
            <td class="text-body-secondary">{{ formatDate(sale.created_at) }}</td>
            <td>{{ sale.customer?.name ?? 'Walk-in' }}</td>
            <td class="text-body-secondary">{{ sale.cashier?.name ?? '-' }}</td>
            <td class="text-center">{{ sale.items_count }}</td>
            <td>
              <span class="pay-tag">
                <i :class="methodIcon(sale.payment_method)"></i>
                {{ methodLabel(sale.payment_method) }}
              </span>
            </td>
            <td class="text-end fw-bold num">{{ formatMoney(sale.total) }}</td>
            <td>
              <span class="status-pill" :class="sale.status">
                {{ sale.status }}
              </span>
            </td>
            <td class="text-end actions-cell">
              <button class="act-btn" title="View & Print" @click="store.openDetails(sale)">
                <i class="far fa-eye"></i>
              </button>
              <button
                v-if="sale.status === 'completed'"
                class="act-btn refund"
                :class="{ armed: store.refundArmId === sale.id }"
                :title="store.refundArmId === sale.id ? 'Click again to confirm' : 'Refund'"
                @click="store.armRefund(sale)"
              >
                <i class="fas fa-rotate-left"></i>
              </button>
            </td>
          </tr>

          <tr v-if="!store.rows.length">
            <td colspan="9" class="empty-row">
              <i class="fas fa-inbox"></i>
              <p>No sales found for this filter</p>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="store.loading" class="loading-state">
        <BaseLoader />
      </div>

      <div class="table-footer" v-if="store.meta.last_page > 1">
        <small class="text-body-secondary">
          Showing {{ store.meta.current_page }} of {{ store.meta.last_page }} pages · {{ store.meta.total }} sales
        </small>
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

    <!-- ==================== Details Modal ==================== -->
    <BaseModal
      v-model="store.showDetailsModal"
      title="Sale Details"
      icon="fas fa-file-invoice"
      size="sm"
    >
      <template #footer>
        <button class="btn btn-light px-4" @click="store.showDetailsModal = false">
          Close
        </button>
        <button class="btn btn-primary px-4" @click="printInvoice()">
          <i class="fas fa-print me-2"></i>Print Invoice
        </button>
      </template>

      <div v-if="store.detailsLoading" class="py-4 text-center">
        <BaseLoader />
      </div>
      <ReceiptPrint v-else :sale="detailSale" />
    </BaseModal>
  </div>
</template>

<script setup>
import { computed, onMounted, onBeforeUnmount, ref } from 'vue';
import BaseModal from '../../../../ahmed-vue-kit/components/ui/BaseModal.vue';
import BaseLoader from '../../../../ahmed-vue-kit/components/ui/BaseLoader.vue';
import ReceiptPrint from '../../../components/ReceiptPrint.vue';
import { useSalesStore } from '../store';

const store = useSalesStore();
const chartEl = ref(null);
const chartReady = ref(false);
let chartInstance = null;
let debounceTimer = null;

const ranges = [
  { value: 'today', label: 'Today' },
  { value: '7d', label: '7 Days' },
  { value: '30d', label: '30 Days' },
  { value: 'all', label: 'All Time' },
];

const statuses = [
  { value: '', label: 'All' },
  { value: 'completed', label: 'Completed', dot: '#16a34a' },
  { value: 'refunded', label: 'Refunded', dot: '#ef4444' },
];

const METHOD_ICONS = {
  cash: 'fas fa-money-bill-wave',
  card: 'fas fa-credit-card',
  mobile: 'fas fa-mobile-screen',
};

const METHOD_LABELS = {
  cash: 'Cash',
  card: 'Card',
  mobile: 'Mobile',
};

const methodIcon = (v) => METHOD_ICONS[v] ?? 'fas fa-money-check';
const methodLabel = (v) => METHOD_LABELS[v] ?? v;

const detailSale = computed(() => {
  const s = store.selectedItem;
  if (!s) return null;

  return {
    ref: s.reference,
    datetime: new Date(String(s.created_at).replace(' ', 'T')).toLocaleString(undefined, {
      dateStyle: 'medium',
      timeStyle: 'short',
    }),
    cashier: s.cashier?.name ?? '-',
    customerName: s.customer?.name ?? 'Walk-in Customer',
    lines: (s.items ?? []).map((item) => ({
      name: item.product_name,
      variant_name: item.variant_name,
      price: Number(item.unit_price),
      qty: Number(item.quantity),
    })),
    subtotal: Number(s.subtotal),
    discount: Number(s.discount_amount),
    total: Number(s.total),
    paymentMethod: s.payment_method,
    tendered: Number(s.amount_tendered),
    changeDue: Number(s.change_due),
  };
});

const formatMoney = (value) =>
  Number(value ?? 0).toLocaleString(undefined, {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });

const formatDate = (value) =>
  new Date(String(value).replace(' ', 'T')).toLocaleDateString(undefined, {
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });

const debouncedFetch = () => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    store.fetchSales(1);
    store.fetchStats();
  }, 350);
};

const setRange = (range) => {
  store.range = range;
  store.fetchSales(1);
};

const setStatus = (status) => {
  store.status = status;
  store.fetchSales(1);
};

const goPage = (page) => {
  store.fetchSales(page);
  window.scrollTo({ top: 0, behavior: 'smooth' });
};

const printInvoice = () => window.print();

const renderChart = () => {
  if (!window.ApexCharts || !chartEl.value) return;

  const series = store.stats.week_series ?? [];
  if (!series.length) return;

  const options = {
    chart: { type: 'area', height: 150, sparkline: { enabled: true }, fontFamily: 'inherit' },
    series: [{ name: 'Revenue', data: series.map((p) => p.total) }],
    colors: ['#6366f1'],
    stroke: { curve: 'smooth', width: 2.5 },
    fill: {
      type: 'gradient',
      gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.02, stops: [0, 95] },
    },
    tooltip: {
      theme: document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'dark' : 'light',
      x: { show: true },
      y: { formatter: (val) => Number(val).toLocaleString() },
    },
  };

  chartInstance = new window.ApexCharts(chartEl.value, options);
  chartInstance.render();
  chartReady.value = true;
};

onMounted(async () => {
  await Promise.all([store.fetchSales(), store.fetchStats()]);
  renderChart();
});

onBeforeUnmount(() => {
  chartInstance?.destroy();
});
</script>

<style scoped>
.sales-page {
  --accent: #6366f1;
  padding-top: 6px;
}

/* ================= KPI ================= */

.kpi-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
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
.accent-sky .kpi-icon { background: linear-gradient(135deg, #0284c7, #0ea5e9); }

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
  margin: 0 0 8px;
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  color: var(--bs-secondary-color);
}

.week-chart {
  min-height: 150px;
}

/* ================= filters ================= */

.search-box {
  position: relative;
  max-width: 420px;
}

.search-box > i {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--bs-secondary-color);
  font-size: 13px;
}

.search-box .form-control {
  padding-left: 34px;
  border-radius: 10px;
}

.seg-pills {
  display: flex;
  border: 1px solid var(--bs-border-color);
  border-radius: 10px;
  overflow: hidden;
}

.seg-pills button {
  border: none;
  background: var(--bs-body-bg);
  color: var(--bs-secondary-color);
  font-size: 12.5px;
  font-weight: 600;
  padding: 7px 14px;
  transition: all 0.12s ease;
}

.seg-pills button + button {
  border-left: 1px solid var(--bs-border-color);
}

.seg-pills button.active {
  background: var(--accent);
  color: #fff;
}

.status-chips {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.chip {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border: 1px solid var(--bs-border-color);
  background: var(--bs-body-bg);
  color: var(--bs-body-color);
  border-radius: 999px;
  padding: 5px 14px;
  font-size: 12.5px;
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
  width: 8px;
  height: 8px;
  border-radius: 50%;
}

/* ================= table ================= */

.table-panel {
  padding: 0;
  overflow: hidden;
}

.sales-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13.5px;
}

.sales-table th {
  text-align: left;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: var(--bs-secondary-color);
  padding: 12px 16px;
  border-bottom: 1px solid var(--bs-border-color);
  background: var(--bs-tertiary-bg);
  white-space: nowrap;
}

.sales-table td {
  padding: 11px 16px;
  border-bottom: 1px solid var(--bs-border-color);
  vertical-align: middle;
}

.sales-table tbody tr {
  transition: background 0.12s ease;
}

.sales-table tbody tr:hover {
  background: var(--bs-tertiary-bg);
}

.num {
  font-variant-numeric: tabular-nums;
}

.ref-badge {
  font-family: ui-monospace, monospace;
  font-size: 12px;
  font-weight: 700;
  color: var(--accent);
  background: rgba(99, 102, 241, 0.09);
  border: 1px solid rgba(99, 102, 241, 0.25);
  padding: 3px 9px;
  border-radius: 7px;
}

.pay-tag {
  white-space: nowrap;
  color: var(--bs-body-color);
  font-weight: 600;
  font-size: 12.5px;
}

.pay-tag i {
  color: var(--secondary-color, var(--bs-secondary-color));
  margin-right: 6px;
  font-size: 11px;
}

.status-pill {
  display: inline-block;
  font-size: 11px;
  font-weight: 700;
  text-transform: capitalize;
  padding: 3px 11px;
  border-radius: 999px;
}

.status-pill.completed {
  color: #15803d;
  background: rgba(22, 163, 74, 0.12);
  border: 1px solid rgba(22, 163, 74, 0.35);
}

.status-pill.refunded,
.status-pill.voided {
  color: #b91c1c;
  background: rgba(220, 38, 38, 0.1);
  border: 1px solid rgba(220, 38, 38, 0.35);
}

.actions-cell {
  white-space: nowrap;
}

.act-btn {
  width: 30px;
  height: 30px;
  border: 1px solid var(--bs-border-color);
  border-radius: 8px;
  background: transparent;
  color: var(--bs-secondary-color);
  font-size: 12px;
  margin-left: 6px;
  transition: all 0.12s ease;
}

.act-btn:hover {
  color: var(--accent);
  border-color: var(--accent);
}

.act-btn.refund:hover,
.act-btn.refund.armed {
  color: #dc3545;
  border-color: #dc3545;
}

.act-btn.refund.armed {
  background: rgba(220, 53, 69, 0.1);
  animation: arm-pulse 1s ease infinite;
}

@keyframes arm-pulse {
  50% {
    box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.12);
  }
}

.empty-row {
  text-align: center;
  color: var(--bs-secondary-color);
  padding: 48px 0 !important;
}

.empty-row i {
  font-size: 32px;
  opacity: 0.4;
  display: block;
  margin-bottom: 8px;
}

.loading-state {
  padding: 40px 0;
  display: flex;
  justify-content: center;
}

.table-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
}

.pager {
  display: flex;
  gap: 6px;
}

.pager button {
  width: 30px;
  height: 30px;
  border: 1px solid var(--bs-border-color);
  background: var(--bs-body-bg);
  color: var(--bs-body-color);
  border-radius: 8px;
  font-size: 11px;
  transition: all 0.12s ease;
}

.pager button:hover:not(:disabled) {
  border-color: var(--accent);
  color: var(--accent);
}

.pager button:disabled {
  opacity: 0.35;
}

@media (max-width: 767.98px) {
  .sales-table th:nth-child(4),
  .sales-table td:nth-child(4),
  .sales-table th:nth-child(5),
  .sales-table td:nth-child(5) {
    display: none;
  }
}
</style>
