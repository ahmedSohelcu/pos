<template>
  <div class="reports-page">
    <!-- Header -->
    <div class="page-head">
      <div>
        <h4 class="mb-1 fw-bold">Reports &amp; Analytics</h4>
        <p class="text-body-secondary mb-0 small">
          Sales performance, profit &amp; team insights
          <span v-if="rangeLabel" class="ms-2 badge text-bg-light border">{{ rangeLabel }}</span>
        </p>
      </div>

      <div class="d-flex flex-wrap align-items-center gap-2">
        <div class="chip-group">
          <button
            v-for="p in presets"
            :key="p.key"
            class="chip"
            :class="{ active: store.preset === p.key }"
            @click="store.setPreset(p.key)"
          >
            {{ p.label }}
          </button>
        </div>
        <template v-if="store.preset === 'custom'">
          <input v-model="store.customFrom" type="date" class="form-control form-control-sm date-input" />
          <span class="text-body-secondary small">→</span>
          <input v-model="store.customTo" type="date" class="form-control form-control-sm date-input" />
          <button class="btn btn-sm btn-primary px-3" :disabled="!store.customFrom || !store.customTo || store.loading" @click="store.applyCustom()">
            Apply
          </button>
        </template>
      </div>
    </div>

    <div v-if="store.loading && !loadedOnce" class="text-center py-5">
      <div class="spinner-border text-primary"></div>
    </div>

    <template v-else>
      <!-- KPI cards -->
      <div class="kpi-row">
        <div class="kpi-card">
          <div class="icon-tile indigo"><i class="bi bi-cash-stack fs-5"></i></div>
          <div>
            <div class="kpi-label">Revenue</div>
            <div class="kpi-value">{{ fmt(kpis.revenue) }}</div>
          </div>
        </div>

        <div class="kpi-card">
          <div class="icon-tile emerald"><i class="bi bi-graph-up-arrow fs-5"></i></div>
          <div>
            <div class="kpi-label">Profit</div>
            <div class="kpi-value">{{ fmt(kpis.profit) }}</div>
            <span class="mini-badge" :class="kpis.margin_pct >= 0 ? 'up' : 'down'">
              {{ kpis.margin_pct }}% margin
            </span>
          </div>
        </div>

        <div class="kpi-card">
          <div class="icon-tile sky"><i class="bi bi-bag-check fs-5"></i></div>
          <div>
            <div class="kpi-label">Transactions</div>
            <div class="kpi-value">{{ kpis.transactions }}</div>
            <span class="text-body-secondary mini-text">{{ fmt(kpis.items_sold) }} items sold</span>
          </div>
        </div>

        <div class="kpi-card">
          <div class="icon-tile amber"><i class="bi bi-basket2 fs-5"></i></div>
          <div>
            <div class="kpi-label">Avg Basket</div>
            <div class="kpi-value">{{ fmt(kpis.avg_basket) }}</div>
          </div>
        </div>

        <div class="kpi-card">
          <div class="icon-tile rose"><i class="bi bi-percent fs-5"></i></div>
          <div>
            <div class="kpi-label">Discounts Given</div>
            <div class="kpi-value">{{ fmt(kpis.discounts) }}</div>
          </div>
        </div>
      </div>

      <!-- Charts row -->
      <div class="row g-3 mb-3">
        <div class="col-lg-8">
          <div class="panel h-100">
            <div class="panel-head">
              <h6 class="mb-0 fw-semibold">Revenue vs Profit</h6>
              <span class="legend">
                <span class="dot" style="background:#6366f1"></span> Revenue
                <span class="dot ms-2" style="background:#10b981"></span> Profit
              </span>
            </div>
            <div ref="mainChartEl" class="chart-box"></div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="panel h-100">
            <div class="panel-head">
              <h6 class="mb-0 fw-semibold">Sales by Category</h6>
            </div>
            <div v-if="!store.overview.by_category.length" class="text-body-secondary small py-5 text-center">
              No category data for this range
            </div>
            <div v-show="store.overview.by_category.length" ref="donutEl" class="chart-box donut"></div>
          </div>
        </div>
      </div>

      <!-- Bottom row -->
      <div class="row g-3">
        <!-- Top products -->
        <div class="col-lg-6">
          <div class="panel h-100">
            <div class="panel-head">
              <h6 class="mb-0 fw-semibold"><i class="bi bi-trophy me-2 text-warning"></i>Top Products</h6>
            </div>

            <div v-if="!store.overview.top_products.length" class="text-body-secondary small py-5 text-center">
              No sales recorded in this range
            </div>

            <ul v-else class="top-products list-unstyled mb-0">
              <li v-for="(p, i) in store.overview.top_products" :key="i">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="tp-name">
                    <span class="rank" :class="'r' + (i + 1)">{{ i + 1 }}</span>
                    {{ p.label }}
                  </span>
                  <span class="tp-meta">
                    <small class="text-body-secondary me-2">x{{ p.qty }}</small>
                    <strong>{{ fmt(p.revenue) }}</strong>
                  </span>
                </div>
                <div class="tp-bar">
                  <div class="tp-fill" :style="{ width: (p.revenue / store.maxTopRevenue * 100) + '%' }"></div>
                </div>
              </li>
            </ul>
          </div>
        </div>

        <!-- Cashier performance -->
        <div class="col-lg-6">
          <div class="panel h-100">
            <div class="panel-head">
              <h6 class="mb-0 fw-semibold"><i class="bi bi-person-badge me-2 text-primary"></i>Cashier Performance</h6>
            </div>

            <div v-if="!store.overview.by_cashier.length" class="text-body-secondary small py-5 text-center">
              No cashier activity in this range
            </div>

            <div v-else class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead>
                  <tr>
                    <th class="ps-3">Cashier</th>
                    <th class="text-end">Transactions</th>
                    <th class="text-end">Revenue</th>
                    <th class="text-end pe-3">Avg Basket</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(c, i) in store.overview.by_cashier" :key="i">
                    <td class="ps-3">
                      <div class="d-flex align-items-center gap-2">
                        <div class="avatar-initial">{{ c.cashier.charAt(0).toUpperCase() }}</div>
                        <span class="fw-medium">{{ c.cashier }}</span>
                      </div>
                    </td>
                    <td class="text-end">{{ c.transactions }}</td>
                    <td class="text-end fw-semibold">{{ fmt(c.revenue) }}</td>
                    <td class="text-end pe-3 text-body-secondary">{{ fmt(c.avg_basket) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { useReportsStore } from '../store';

const store = useReportsStore();

const loadedOnce = ref(false);
const mainChartEl = ref(null);
const donutEl = ref(null);
let mainChart = null;
let donutChart = null;

const presets = [
  { key: 'today', label: 'Today' },
  { key: '7d', label: '7 Days' },
  { key: '30d', label: '30 Days' },
  { key: 'month', label: 'This Month' },
  { key: 'custom', label: 'Custom' },
];

const kpis = computed(() => store.overview.kpis);

const rangeLabel = computed(() => {
  const r = store.overview.range;
  return r?.from && r?.to ? `${r.from} → ${r.to}` : '';
});

const isDark = () => document.documentElement.getAttribute('data-bs-theme') === 'dark';

const fmt = (n) =>
  new Intl.NumberFormat('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(n ?? 0);

const renderCharts = () => {
  if (!window.ApexCharts) return;

  mainChart?.destroy();
  donutChart?.destroy();

  const series = store.overview.daily_series ?? [];
  const cats = store.overview.by_category ?? [];

  if (series.length && mainChartEl.value) {
    mainChart = new window.ApexCharts(mainChartEl.value, {
      chart: { type: 'area', height: 300, fontFamily: 'inherit', toolbar: { show: false }, animations: { speed: 450 } },
      series: [
        { name: 'Revenue', data: series.map((p) => p.revenue) },
        { name: 'Profit', data: series.map((p) => p.profit) },
      ],
      colors: ['#6366f1', '#10b981'],
      stroke: { curve: 'smooth', width: 2.5 },
      fill: {
        type: 'gradient',
        gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.03, stops: [0, 95] },
      },
      dataLabels: { enabled: false },
      xaxis: {
        categories: series.map((p) => p.date),
        axisBorder: { show: false },
        axisTicks: { show: false },
        labels: { style: { colors: isDark() ? '#9aa0ac' : '#6c757d' } },
      },
      yaxis: {
        labels: {
          formatter: (v) => (v >= 1000 ? (v / 1000).toFixed(1) + 'k' : v),
          style: { colors: isDark() ? '#9aa0ac' : '#6c757d' },
        },
      },
      grid: { borderColor: isDark() ? 'rgba(255,255,255,.08)' : 'rgba(0,0,0,.06)', strokeDashArray: 4 },
      tooltip: {
        theme: isDark() ? 'dark' : 'light',
        y: { formatter: (val) => Number(val).toLocaleString() },
      },
      legend: { show: false },
    });
    mainChart.render();
  }

  if (cats.length && donutEl.value) {
    donutChart = new window.ApexCharts(donutEl.value, {
      chart: { type: 'donut', height: 300, fontFamily: 'inherit', animations: { speed: 450 } },
      series: cats.map((c) => c.revenue),
      labels: cats.map((c) => c.category),
      colors: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#0ea5e9', '#8b5cf6', '#ec4899', '#14b8a6'],
      stroke: { width: 2, colors: [isDark() ? '#1a1d21' : '#fff'] },
      legend: {
        position: 'bottom',
        labels: { colors: isDark() ? '#9aa0ac' : '#495057' },
      },
      dataLabels: {
        enabled: true,
        formatter: (val) => val.toFixed(0) + '%',
        style: { fontSize: '11px' },
      },
      tooltip: { theme: isDark() ? 'dark' : 'light', y: { formatter: (v) => Number(v).toLocaleString() } },
    });
    donutChart.render();
  }
};

watch(
  () => store.overview,
  () => {
    loadedOnce.value = true;
    requestAnimationFrame(renderCharts);
  }
);

onMounted(async () => {
  await store.fetchOverview();
});

onBeforeUnmount(() => {
  mainChart?.destroy();
  donutChart?.destroy();
});
</script>

<style scoped>
.reports-page {
  --accent: #6366f1;
  padding-top: 6px;
}

/* ================= Header ================= */

.page-head {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 18px;
}

.chip-group {
  display: inline-flex;
  background: var(--bs-body-bg);
  border: 1px solid var(--bs-border-color);
  border-radius: 10px;
  padding: 3px;
  gap: 2px;
}

.chip {
  border: none;
  background: transparent;
  color: var(--bs-body-color);
  font-size: 12.5px;
  font-weight: 500;
  padding: 6px 12px;
  border-radius: 8px;
  transition: all 0.15s ease;
}

.chip:hover {
  background: var(--bs-tertiary-bg);
}

.chip.active {
  background: var(--accent);
  color: #fff;
  box-shadow: 0 2px 8px rgba(99, 102, 241, 0.4);
}

.date-input {
  max-width: 150px;
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
  transition: transform 0.18s ease, box-shadow 0.18s ease;
}

.kpi-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 22px rgba(0, 0, 0, 0.07);
}

.icon-tile {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: grid;
  place-items: center;
  color: #fff;
  flex-shrink: 0;
}

.icon-tile.indigo { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
.icon-tile.emerald { background: linear-gradient(135deg, #10b981, #34d399); }
.icon-tile.sky { background: linear-gradient(135deg, #0ea5e9, #38bdf8); }
.icon-tile.amber { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
.icon-tile.rose { background: linear-gradient(135deg, #f43f5e, #fb7185); }

.kpi-label {
  font-size: 11.5px;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: var(--bs-secondary-color);
  font-weight: 600;
}

.kpi-value {
  font-size: 20px;
  font-weight: 700;
  line-height: 1.25;
}

.mini-badge {
  font-size: 10.5px;
  font-weight: 600;
  padding: 1px 7px;
  border-radius: 20px;
}

.mini-badge.up { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.mini-badge.down { background: rgba(239, 68, 68, 0.12); color: #ef4444; }

.mini-text {
  font-size: 11px;
  display: block;
}

/* ================= Panels ================= */

.panel {
  background: var(--bs-body-bg);
  border: 1px solid var(--bs-border-color);
  border-radius: 14px;
  padding: 18px;
}

.panel-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}

.legend {
  font-size: 12px;
  color: var(--bs-secondary-color);
  display: inline-flex;
  align-items: center;
}

.dot {
  display: inline-block;
  width: 9px;
  height: 9px;
  border-radius: 50%;
  margin-right: 5px;
}

.chart-box {
  min-height: 300px;
}

.chart-box.donut {
  min-height: 300px;
}

/* ================= Top products ================= */

.top-products li {
  padding: 9px 0;
  border-bottom: 1px dashed var(--bs-border-color);
}

.top-products li:last-child {
  border-bottom: none;
}

.tp-name {
  font-size: 13.5px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 8px;
}

.rank {
  width: 20px;
  height: 20px;
  border-radius: 6px;
  display: inline-grid;
  place-items: center;
  font-size: 11px;
  font-weight: 700;
  background: var(--bs-tertiary-bg);
  color: var(--bs-secondary-color);
  flex-shrink: 0;
}

.rank.r1 { background: #fef3c7; color: #b45309; }
.rank.r2 { background: #e5e7eb; color: #374151; }
.rank.r3 { background: #ffedd5; color: #c2410c; }

.tp-meta {
  white-space: nowrap;
  font-size: 13px;
}

.tp-bar {
  height: 5px;
  background: var(--bs-tertiary-bg);
  border-radius: 4px;
  overflow: hidden;
}

.tp-fill {
  height: 100%;
  border-radius: 4px;
  background: linear-gradient(90deg, #6366f1, #8b5cf6);
  transition: width 0.5s ease;
}

/* ================= Cashier table ================= */

.avatar-initial {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  display: grid;
  place-items: center;
  font-size: 12.5px;
  font-weight: 700;
  color: #fff;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  flex-shrink: 0;
}
</style>
