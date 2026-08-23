<template>
  <div class="register-page">
    <div class="page-head">
      <div>
        <h4 class="mb-1 fw-bold">Cash Register</h4>
        <p class="text-body-secondary mb-0 small">Open, manage &amp; close your cash drawer shifts</p>
      </div>
      <button
        v-if="store.isOpen"
        class="btn btn-danger d-flex align-items-center gap-2"
        @click="openCloseModal"
      >
        <i class="bi bi-stop-circle"></i> Close Register
      </button>
    </div>

    <div v-if="store.loading" class="text-center py-5">
      <div class="spinner-border text-primary"></div>
    </div>

    <!-- ==================== NO OPEN SHIFT ==================== -->
    <div v-else-if="!store.isOpen" class="closed-hero panel text-center py-5 px-4">
      <div class="hero-icon mx-auto mb-3"><i class="bi bi-vault fs-2"></i></div>
      <h5 class="fw-bold mb-1">Register is Closed</h5>
      <p class="text-body-secondary small mb-4">
        Open a shift to start tracking cash flow, sales &amp; drawer accuracy.
      </p>
      <button class="btn btn-primary btn-lg px-4 d-inline-flex align-items-center gap-2" @click="store.showOpenModal = true">
        <i class="bi bi-play-circle"></i> Open Register
      </button>
    </div>

    <!-- ==================== OPEN SHIFT ==================== -->
    <template v-else>
      <!-- Drawer summary -->
      <div class="row g-3 mb-3">
        <div class="col-lg-4">
          <div class="panel drawer-panel h-100">
            <div class="text-body-secondary small fw-semibold text-uppercase mb-1" style="font-size: 11px; letter-spacing: 0.06em;">
              Expected in Drawer
            </div>
            <div class="drawer-amount">{{ fmt(store.expectedCash) }}</div>
            <div class="small text-body-secondary mt-2">
              <i class="bi bi-clock-history me-1"></i>
              Opened {{ sinceLabel }} by
              <strong>{{ store.shift?.cashier?.name ?? '—' }}</strong>
            </div>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="row g-3 h-100">
            <div class="col-sm-6 col-xl-3" v-for="m in mixCards" :key="m.label">
              <div class="mix-card h-100" :class="m.cls">
                <div class="d-flex justify-content-between align-items-start">
                  <span class="mix-label">{{ m.label }}</span>
                  <i :class="m.icon"></i>
                </div>
                <div class="mix-value">{{ fmt(m.value) }}</div>
                <div class="mix-sub">{{ m.sub }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Movements + actions -->
      <div class="row g-3">
        <div class="col-lg-7">
          <div class="panel h-100">
            <div class="panel-head">
              <h6 class="mb-0 fw-semibold"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Cash Movements</h6>
              <div class="d-flex gap-2">
                <button class="btn btn-sm btn-success px-3" @click="startMovement('cash_in')">
                  <i class="bi bi-plus-lg me-1"></i> Cash In
                </button>
                <button class="btn btn-sm btn-outline-danger px-3" @click="startMovement('cash_out')">
                  <i class="bi bi-dash-lg me-1"></i> Cash Out
                </button>
              </div>
            </div>

            <div v-if="!store.movements.length" class="text-body-secondary small py-4 text-center">
              No manual cash movements this shift
            </div>

            <ul v-else class="movements list-unstyled mb-0">
              <li v-for="mv in store.movements" :key="mv.id">
                <div class="mv-icon" :class="mv.type === 'cash_in' ? 'in' : 'out'">
                  <i :class="mv.type === 'cash_in' ? 'bi bi-arrow-down-right' : 'bi bi-arrow-up-right'"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                  <div class="fw-medium small">{{ mv.reason || (mv.type === 'cash_in' ? 'Cash in' : 'Cash out') }}</div>
                  <div class="text-body-secondary" style="font-size: 11.5px;">
                    {{ mv.user?.name ?? 'System' }} · {{ shortTime(mv.created_at) }}
                  </div>
                </div>
                <span class="fw-semibold small" :class="mv.type === 'cash_in' ? 'text-success' : 'text-danger'">
                  {{ mv.type === 'cash_in' ? '+' : '−' }}{{ fmt(mv.amount) }}
                </span>
              </li>
            </ul>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="panel h-100">
            <div class="panel-head">
              <h6 class="mb-0 fw-semibold"><i class="bi bi-calculator me-2 text-primary"></i>Drawer Reconciliation</h6>
            </div>
            <ul class="calc list-unstyled mb-3">
              <li><span>Opening float</span><strong>{{ fmt(store.shift.opening_float) }}</strong></li>
              <li class="pos"><span>Cash sales</span><strong>+{{ fmt(store.stats.cash_sales) }}</strong></li>
              <li v-if="store.stats.cash_refunds > 0" class="neg">
                <span>Cash refunds</span><strong>−{{ fmt(store.stats.cash_refunds) }}</strong>
              </li>
              <li v-if="cashInTotal > 0" class="pos"><span>Cash in</span><strong>+{{ fmt(cashInTotal) }}</strong></li>
              <li v-if="cashOutTotal > 0" class="neg"><span>Cash out</span><strong>−{{ fmt(cashOutTotal) }}</strong></li>
              <li class="total">
                <span>Expected now</span><strong>{{ fmt(store.expectedCash) }}</strong>
              </li>
            </ul>
            <div class="alert alert-light border small mb-0 d-flex gap-2">
              <i class="bi bi-info-circle mt-1"></i>
              <span>When closing, count the physical cash and enter it — we'll calculate any over/short automatically.</span>
            </div>
          </div>
        </div>
      </div>
    </template>

    <!-- ==================== SHIFT HISTORY ==================== -->
    <div class="panel mt-3">
      <div class="panel-head">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-clock-history me-2 text-primary"></i>Shift History</h6>
        <span class="text-body-secondary small">{{ store.historyMeta.total }} shifts</span>
      </div>

      <div v-if="!store.historyRows.length" class="text-body-secondary small py-4 text-center">
        No shifts recorded yet
      </div>

      <div v-else class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th class="ps-3">Opened</th>
              <th>Cashier</th>
              <th>Duration</th>
              <th class="text-end">Float</th>
              <th class="text-end">Expected</th>
              <th class="text-end">Counted</th>
              <th class="text-end pe-3">Difference</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="s in store.historyRows" :key="s.id">
              <td class="ps-3">
                <div class="fw-medium small">{{ fmtDate(s.opened_at) }}</div>
                <div class="text-body-secondary" style="font-size: 11.5px;">{{ s.register_name }}</div>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="avatar-initial">{{ (s.cashier?.name ?? '?').charAt(0).toUpperCase() }}</div>
                  <span class="small">{{ s.cashier?.name ?? '—' }}</span>
                </div>
              </td>
              <td class="small text-body-secondary">{{ duration(s.opened_at, s.closed_at) }}</td>
              <td class="text-end small">{{ fmt(s.opening_float) }}</td>
              <td class="text-end small">{{ s.expected_cash != null ? fmt(s.expected_cash) : '—' }}</td>
              <td class="text-end small">{{ s.closing_counted != null ? fmt(s.closing_counted) : '—' }}</td>
              <td class="text-end pe-3">
                <span v-if="s.difference == null" class="badge open-pill">OPEN</span>
                <span v-else-if="Math.abs(s.difference) < 0.01" class="badge even-pill">Exact</span>
                <span v-else-if="s.difference > 0" class="badge over-pill">
                  +{{ fmt(s.difference) }} over
                </span>
                <span v-else class="badge short-pill">
                  −{{ fmt(Math.abs(s.difference)) }} short
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="store.historyMeta.last_page > 1" class="p-3 d-flex justify-content-center">
        <ul class="pagination pagination-sm mb-0">
          <li class="page-item" :class="{ disabled: store.historyMeta.current_page === 1 }">
            <button class="page-link" @click="goPage(store.historyMeta.current_page - 1)">«</button>
          </li>
          <li
            v-for="p in store.historyMeta.last_page"
            :key="p"
            class="page-item"
            :class="{ active: p === store.historyMeta.current_page }"
          >
            <button class="page-link" @click="goPage(p)">{{ p }}</button>
          </li>
          <li class="page-item" :class="{ disabled: store.historyMeta.current_page === store.historyMeta.last_page }">
            <button class="page-link" @click="goPage(store.historyMeta.current_page + 1)">»</button>
          </li>
        </ul>
      </div>
    </div>

    <!-- ==================== Open Modal ==================== -->
    <BaseModal v-model="store.showOpenModal" title="Open Register" icon="bi bi-play-circle" size="sm"
      :loading="store.actionLoading" confirm-text="Open Register" @confirm="store.openRegister()">
      <label class="form-label small fw-semibold">Opening Float (cash in drawer)</label>
      <input
        v-model="store.openForm.opening_float"
        type="number"
        min="0"
        step="0.01"
        class="form-control form-control-lg mb-3"
        placeholder="0.00"
        autofocus
      />
      <label class="form-label small fw-semibold">Register Name</label>
      <input v-model="store.openForm.register_name" type="text" class="form-control" placeholder="Main Register" />
    </BaseModal>

    <!-- ==================== Close Modal ==================== -->
    <BaseModal v-model="store.showCloseModal" title="Close Register" icon="bi bi-stop-circle" size="sm"
      :loading="store.actionLoading" confirm-text="Close Shift" @confirm="store.closeRegister()">
      <div class="expected-hint mb-3">
        <span class="text-body-secondary small">Expected in drawer</span>
        <strong class="ms-2">{{ fmt(store.expectedCash) }}</strong>
      </div>

      <label class="form-label small fw-semibold">Counted Cash</label>
      <input
        v-model="store.closeForm.closing_counted"
        type="number"
        min="0"
        step="0.01"
        class="form-control form-control-lg mb-2"
        placeholder="0.00"
      />
      <div class="small mb-3" :class="closeDiffClass">
        <i class="bi" :class="closeDiffIcon"></i>
        {{ closeDiffText }}
      </div>

      <label class="form-label small fw-semibold">Note (optional)</label>
      <textarea v-model="store.closeForm.note" class="form-control" rows="2" placeholder="Any remarks about this shift…"></textarea>
    </BaseModal>

    <!-- ==================== Movement Modal ==================== -->
    <BaseModal v-model="store.showMovementModal" :title="store.movementType === 'cash_in' ? 'Add Cash to Drawer' : 'Remove Cash from Drawer'"
      icon="bi bi-cash-coin" size="sm" :loading="store.actionLoading" :confirm-text="store.movementType === 'cash_in' ? 'Add Cash' : 'Remove Cash'"
      @confirm="store.addMovement()">
      <label class="form-label small fw-semibold">Amount</label>
      <input v-model="store.movementForm.amount" type="number" min="0.01" step="0.01" class="form-control form-control-lg mb-3" placeholder="0.00" />
      <label class="form-label small fw-semibold">Reason</label>
      <input v-model="store.movementForm.reason" type="text" class="form-control" placeholder="e.g. Bank deposit, supplies purchase…" />
    </BaseModal>

    <!-- ==================== Closed Result ==================== -->
    <BaseModal v-model="store.showClosedResult" title="Shift Closed" icon="bi bi-check2-circle" size="sm"
      confirm-text="Done" @confirm="store.showClosedResult = false">
      <template #footer>
        <button class="btn btn-primary px-4 w-100" @click="store.showClosedResult = false">Done</button>
      </template>

      <div v-if="store.closedResult" class="text-center py-2">
        <div class="result-icon mx-auto mb-3" :class="(store.closedResult.difference ?? 0) >= 0 ? 'ok' : 'bad'">
          <i class="bi" :class="Math.abs(store.closedResult.difference ?? 0) < 0.01 ? 'bi-check-lg' : (store.closedResult.difference >= 0 ? 'bi-graph-up-arrow' : 'bi-exclamation-triangle')"></i>
        </div>
        <h5 class="fw-bold mb-1">{{ closeResultTitle }}</h5>
        <p class="text-body-secondary small mb-4">Shift closed at {{ fmtDate(store.closedResult.closed_at) }}</p>

        <div class="recon-box">
          <div class="row g-0">
            <div class="col-4">
              <div class="text-body-secondary small">Expected</div>
              <div class="fw-bold">{{ fmt(store.closedResult.expected_cash) }}</div>
            </div>
            <div class="col-4 border-start border-end">
              <div class="text-body-secondary small">Counted</div>
              <div class="fw-bold">{{ fmt(store.closedResult.closing_counted) }}</div>
            </div>
            <div class="col-4">
              <div class="text-body-secondary small">Difference</div>
              <div class="fw-bold" :class="(store.closedResult.difference ?? 0) >= 0 ? 'text-success' : 'text-danger'">
                {{ store.closedResult.difference >= 0 ? '+' : '−' }}{{ fmt(Math.abs(store.closedResult.difference)) }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </BaseModal>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import BaseModal from '../../../../ahmed-vue-kit/components/ui/BaseModal.vue';
import { useRegisterStore } from '../store';

const store = useRegisterStore();

const fmt = (n) =>
  new Intl.NumberFormat('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(n ?? 0);

const fmtDate = (d) => {
  if (!d) return '—';
  const date = new Date(d);
  return date.toLocaleString(undefined, {
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};

const shortTime = (d) => {
  if (!d) return '';
  return new Date(d).toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' });
};

const sinceLabel = computed(() => fmtDate(store.shift?.opened_at));

const duration = (from, to) => {
  if (!from) return '—';
  const end = to ? new Date(to) : new Date();
  const mins = Math.max(0, Math.round((end - new Date(from)) / 60000));
  const h = Math.floor(mins / 60);
  const m = mins % 60;
  return h > 0 ? `${h}h ${m}m` : `${m}m`;
};

const mixCards = computed(() => [
  { label: 'Cash', value: store.stats?.cash_sales ?? 0, sub: `${store.stats?.cash_count ?? 0} sales`, icon: 'bi bi-cash-coin', cls: 'green' },
  { label: 'Card', value: store.stats?.card_total ?? 0, sub: `${store.stats?.card_count ?? 0} sales`, icon: 'bi bi-credit-card', cls: 'blue' },
  { label: 'Mobile', value: store.stats?.mobile_total ?? 0, sub: `${store.stats?.mobile_count ?? 0} sales`, icon: 'bi bi-phone', cls: 'purple' },
  { label: 'Refunds', value: store.stats?.cash_refunds ?? 0, sub: 'cash returned', icon: 'bi bi-arrow-counterclockwise', cls: 'red' },
]);

const cashInTotal = computed(() =>
  (store.movements ?? []).filter((m) => m.type === 'cash_in').reduce((s, m) => s + Number(m.amount), 0)
);

const cashOutTotal = computed(() =>
  (store.movements ?? []).filter((m) => m.type === 'cash_out').reduce((s, m) => s + Number(m.amount), 0)
);

const closeDiff = computed(() => {
  if (store.closeForm.closing_counted === '' || store.closeForm.closing_counted === null) return null;
  return Number(store.closeForm.closing_counted) - store.expectedCash;
});

const closeDiffText = computed(() => {
  if (closeDiff.value === null) return 'Enter counted cash to see the difference';
  if (Math.abs(closeDiff.value) < 0.01) return 'Perfect — drawer matches exactly';
  return closeDiff.value > 0
    ? `Over by ${fmt(closeDiff.value)}`
    : `Short by ${fmt(Math.abs(closeDiff.value))}`;
});

const closeDiffClass = computed(() => {
  if (closeDiff.value === null) return 'text-body-secondary';
  if (Math.abs(closeDiff.value) < 0.01) return 'text-success';
  return closeDiff.value > 0 ? 'text-warning' : 'text-danger';
});

const closeDiffIcon = computed(() => {
  if (closeDiff.value === null) return 'bi-info-circle';
  if (Math.abs(closeDiff.value) < 0.01) return 'bi-check-circle';
  return closeDiff.value > 0 ? 'bi-plus-circle' : 'bi-dash-circle';
});

const closeResultTitle = computed(() => {
  const d = store.closedResult?.difference ?? 0;
  if (Math.abs(d) < 0.01) return 'Drawer Balanced!';
  return d > 0 ? `Drawer Over by ${fmt(d)}` : `Drawer Short by ${fmt(Math.abs(d))}`;
});

const openCloseModal = () => {
  store.closeForm.closing_counted = String(store.expectedCash);
  store.showCloseModal = true;
};

const startMovement = (type) => {
  store.movementType = type;
  store.showMovementModal = true;
};

const goPage = (page) => store.fetchHistory(page);

onMounted(async () => {
  await Promise.all([store.fetchCurrent(), store.fetchHistory()]);
});
</script>

<style scoped>
.register-page {
  --accent: #6366f1;
  padding-top: 6px;
}

.page-head {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 18px;
}

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
  margin-bottom: 12px;
}

/* ================= Hero ================= */

.closed-hero .hero-icon {
  width: 74px;
  height: 74px;
  border-radius: 22px;
  display: grid;
  place-items: center;
  color: #fff;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  box-shadow: 0 10px 30px rgba(99, 102, 241, 0.35);
}

/* ================= Drawer ================= */

.drawer-panel {
  background:
    radial-gradient(120% 140% at 100% 0%, rgba(99, 102, 241, 0.16), transparent 55%),
    var(--bs-body-bg);
}

.drawer-amount {
  font-size: clamp(30px, 4vw, 42px);
  font-weight: 800;
  letter-spacing: -0.02em;
  line-height: 1.15;
}

.mix-card {
  background: var(--bs-body-bg);
  border: 1px solid var(--bs-border-color);
  border-radius: 14px;
  padding: 14px 16px;
  transition: transform 0.18s ease, box-shadow 0.18s ease;
}

.mix-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07);
}

.mix-card i {
  opacity: 0.65;
}

.mix-card.green i { color: #10b981; }
.mix-card.blue i { color: #0ea5e9; }
.mix-card.purple i { color: #8b5cf6; }
.mix-card.red i { color: #ef4444; }

.mix-label {
  font-size: 11.5px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: var(--bs-secondary-color);
}

.mix-value {
  font-size: 19px;
  font-weight: 700;
  margin-top: 4px;
}

.mix-sub {
  font-size: 11.5px;
  color: var(--bs-secondary-color);
}

/* ================= Movements ================= */

.movements li {
  display: flex;
  align-items: center;
  padding: 10px 0;
  border-bottom: 1px dashed var(--bs-border-color);
}

.movements li:last-child {
  border-bottom: none;
}

.mv-icon {
  width: 34px;
  height: 34px;
  border-radius: 10px;
  display: grid;
  place-items: center;
  flex-shrink: 0;
}

.mv-icon.in {
  background: rgba(16, 185, 129, 0.12);
  color: #10b981;
}

.mv-icon.out {
  background: rgba(239, 68, 68, 0.12);
  color: #ef4444;
}

/* ================= Calc ================= */

.calc li {
  display: flex;
  justify-content: space-between;
  padding: 7px 0;
  font-size: 13.5px;
  border-bottom: 1px dashed var(--bs-border-color);
}

.calc li.total {
  border-bottom: none;
  border-top: 1px solid var(--bs-border-color);
  margin-top: 4px;
  padding-top: 10px;
  font-size: 15px;
  font-weight: 700;
}

.calc li.pos strong { color: #10b981; }
.calc li.neg strong { color: #ef4444; }

.expected-hint {
  background: rgba(99, 102, 241, 0.08);
  border: 1px dashed rgba(99, 102, 241, 0.35);
  border-radius: 10px;
  padding: 10px 14px;
  text-align: center;
}

/* ================= History ================= */

.avatar-initial {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  display: grid;
  place-items: center;
  font-size: 11.5px;
  font-weight: 700;
  color: #fff;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  flex-shrink: 0;
}

.badge.even-pill { background: rgba(16, 185, 129, 0.12); color: #059669; }
.badge.over-pill { background: rgba(245, 158, 11, 0.14); color: #b45309; }
.badge.short-pill { background: rgba(239, 68, 68, 0.12); color: #dc2626; }
.badge.open-pill { background: rgba(99, 102, 241, 0.12); color: #6366f1; letter-spacing: 0.04em; }

/* ================= Result modal ================= */

.result-icon {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  display: grid;
  place-items: center;
  font-size: 28px;
}

.result-icon.ok {
  background: rgba(16, 185, 129, 0.12);
  color: #10b981;
}

.result-icon.bad {
  background: rgba(239, 68, 68, 0.12);
  color: #ef4444;
}

.recon-box {
  border: 1px solid var(--bs-border-color);
  border-radius: 12px;
  padding: 14px 8px;
}
</style>
