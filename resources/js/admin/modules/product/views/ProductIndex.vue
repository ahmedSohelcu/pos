<template>
  <div class="container-fluid">
    <BaseTable
      label="Product Management"
      :columns="columns"
      :rows="productStore.rows"
      :loading="productStore.loading"
      :meta="productStore.meta"
      :filters="productFilters"
      :actions="productActions"
      @query-change="productStore.updateQuery"
      @create="goToCreate"
      @refresh="productStore.fetchData"
    />
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { productFilters } from './productFilters';
import { getProductActions } from './productActions';
import { useProductStore } from '../store';

const productStore = useProductStore();
const router = useRouter();

onMounted(() => {
  productStore.fetchData();
});

const productActions = getProductActions(productStore, router);

const goToCreate = () => {
  router.push({ name: 'product.create' });
};

const formatPrice = (value) => {
  if (value === null || value === undefined || value === '') return '-';
  return Number(value).toFixed(2);
};

const columns = [
  {
    label: '#',
    custom: (row, index) => index + 1,
  },
  {
    name: 'thumbnail',
    label: 'Image',
    sortable: false,
    custom: (row) => {
      if (!row.thumbnail) return `<span class="text-muted">-</span>`;
      return `<img src="${row.thumbnail}" alt="thumb" class="rounded" style="width: 40px; height: 40px; object-fit: cover;" />`;
    },
  },
  {
    name: 'name',
    label: 'Product Name',
    sortable: true,
    custom: (row) => `<span class="badge bg-success">${row.name}</span>`,
  },
  {
    name: 'product_type',
    label: 'Type',
    sortable: true,
    custom: (row) => {
      const cls =
        row.product_type === 'variant'
          ? 'info'
          : row.product_type === 'service'
          ? 'warning'
          : 'primary';
      return `<span class="badge bg-${cls}">${row.product_type}</span>`;
    },
  },
  {
    name: 'sku',
    label: 'SKU',
    sortable: true,
    custom: (row) => `<span class="text-primary">${row.sku ?? '-'}</span>`,
  },
  {
    name: 'category_id',
    label: 'Category',
    sortable: true,
    custom: (row) => row.category?.name ?? '-',
  },
  {
    name: 'brand_id',
    label: 'Brand',
    sortable: true,
    custom: (row) => row.brand?.name ?? '-',
  },
  {
    name: 'purchase_price',
    label: 'Purchase Price',
    sortable: true,
    custom: (row) => formatPrice(row.purchase_price),
  },
  {
    name: 'sale_price',
    label: 'Sale Price',
    sortable: true,
    custom: (row) => formatPrice(row.sale_price),
  },
  {
    name: 'stock',
    label: 'Stock',
    sortable: true,
    custom: (row) => {
      if (!row.track_stock) return '<span class="text-muted">N/A</span>';
      return row.stock ?? 0;
    },
  },
  {
    name: 'status_id',
    label: 'Status',
    sortable: true,
    custom: (row) => {
      return `<span class="badge bg-${row.status?.class ?? 'secondary'}">${
        row.status?.name ?? ''
      }</span>`;
    },
  },
  {
    name: 'created_at',
    label: 'Created At',
    sortable: true,
    custom: (row) => new Date(row.created_at).toLocaleString(),
  },
];
</script>

<style scoped></style>