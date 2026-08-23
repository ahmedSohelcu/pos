<template>
  <div class="receipt-wrap">
    <div v-if="sale" id="receipt-area" class="receipt-print">
      <div class="receipt-store">GroceryPharma</div>
      <div class="receipt-sub">Point of Sale Receipt</div>

      <div class="receipt-divider"></div>

      <div class="receipt-grid">
        <span>Invoice</span><strong>{{ sale.ref }}</strong>
        <span>Date</span><span>{{ sale.datetime }}</span>
        <span>Cashier</span><span>{{ sale.cashier }}</span>
        <span>Customer</span><span>{{ sale.customerName }}</span>
      </div>

      <div class="receipt-divider"></div>

      <table class="receipt-items">
        <thead>
          <tr>
            <th class="text-start">Item</th>
            <th class="text-center">Qty</th>
            <th class="text-end">Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(line, i) in sale.lines" :key="i">
            <td class="text-start">
              {{ line.name }}
              <small v-if="line.variant_name" class="d-block">
                {{ line.variant_name }} · {{ formatMoney(line.price) }}
              </small>
            </td>
            <td class="text-center">{{ line.qty }}</td>
            <td class="text-end">{{ formatMoney(line.price * line.qty) }}</td>
          </tr>
        </tbody>
      </table>

      <div class="receipt-divider"></div>

      <div class="receipt-grid totals">
        <span>Subtotal</span><span>{{ formatMoney(sale.subtotal) }}</span>
        <span>Discount</span><span>-{{ formatMoney(sale.discount) }}</span>
        <span class="grand">TOTAL</span>
        <span class="grand">{{ formatMoney(sale.total) }}</span>
        <span>Paid ({{ methodLabel }})</span>
        <span>{{ formatMoney(sale.tendered) }}</span>
        <template v-if="sale.changeDue > 0">
          <span>Change</span>
          <span>{{ formatMoney(sale.changeDue) }}</span>
        </template>
      </div>

      <div class="receipt-divider"></div>

      <div class="receipt-barcode"></div>
      <div class="receipt-ref">{{ sale.ref }}</div>

      <p class="receipt-thanks">Thank you for shopping with us!</p>
      <p class="receipt-note">Returns accepted within 7 days with this receipt.</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  sale: { type: Object, default: null },
});

const METHOD_LABELS = {
  cash: 'Cash',
  card: 'Card',
  mobile: 'Mobile',
};

const methodLabel = computed(
  () => METHOD_LABELS[props.sale?.paymentMethod] ?? props.sale?.paymentMethod ?? ''
);

const formatMoney = (value) =>
  Number(value ?? 0).toLocaleString(undefined, {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });
</script>

<style>
.receipt-wrap {
  display: flex;
  justify-content: center;
}

.receipt-print {
  width: 300px;
  max-width: 100%;
  background: #fff;
  color: #111;
  font-family: 'Courier New', ui-monospace, monospace;
  font-size: 12px;
  line-height: 1.45;
  padding: 18px 16px;
  border: 1px dashed #cbd5e1;
  border-radius: 10px;
}

.receipt-store {
  text-align: center;
  font-size: 19px;
  font-weight: 800;
  letter-spacing: 0.06em;
  text-transform: uppercase;
}

.receipt-sub {
  text-align: center;
  font-size: 11px;
  color: #555;
  margin-bottom: 8px;
}

.receipt-divider {
  border-top: 1px dashed #999;
  margin: 8px 0;
}

.receipt-grid {
  display: grid;
  grid-template-columns: auto 1fr;
  column-gap: 10px;
  row-gap: 2px;
}

.receipt-grid span:nth-child(odd) {
  color: #555;
}

.receipt-grid span:last-child,
.receipt-grid strong:last-child {
  text-align: right;
}

.receipt-grid.totals .grand {
  font-size: 15px;
  font-weight: 800;
  color: #000;
  border-top: 1px solid #000;
  padding-top: 3px;
  margin-top: 3px;
}

.receipt-items {
  width: 100%;
  border-collapse: collapse;
  font-size: 11.5px;
}

.receipt-items th {
  font-size: 10.5px;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  border-bottom: 1px solid #bbb;
  padding-bottom: 3px;
}

.receipt-items td {
  padding: 4px 0;
  vertical-align: top;
}

.receipt-items small {
  color: #666;
  font-size: 10px;
}

.receipt-barcode {
  height: 34px;
  margin: 4px auto 2px;
  width: 82%;
  background: repeating-linear-gradient(
    90deg,
    #000 0 2px,
    transparent 2px 4px,
    #000 4px 5px,
    transparent 5px 9px,
    #000 9px 12px,
    transparent 12px 14px,
    #000 14px 15px,
    transparent 15px 20px
  );
}

.receipt-ref {
  text-align: center;
  letter-spacing: 0.18em;
  font-weight: 700;
  margin-bottom: 8px;
}

.receipt-thanks {
  text-align: center;
  font-weight: 700;
  margin: 6px 0 0;
}

.receipt-note {
  text-align: center;
  font-size: 10px;
  color: #666;
  margin: 2px 0 0;
}

/* ================= print ================= */

@media print {
  @page {
    size: 80mm auto;
    margin: 4mm;
  }

  html,
  body {
    background: #fff !important;
    height: auto !important;
  }

  body * {
    visibility: hidden !important;
  }

  #receipt-area,
  #receipt-area * {
    visibility: visible !important;
  }

  #receipt-area {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 72mm !important;
    max-width: none !important;
    border: none !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    padding: 0 !important;
    margin: 0 !important;
    print-color-adjust: exact;
    -webkit-print-color-adjust: exact;
  }
}
</style>
