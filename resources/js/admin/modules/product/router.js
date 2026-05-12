import ProductIndex from './views/ProductIndex.vue';
import ProductCreate from './views/ProductCreate.vue';
// import ProductEdit from './views/ProductEdit.vue';


export default [
  {
    path: '/product',
    name: 'product.index',
    meta: {
      breadcrumb: 'All Product',
      requiresAuth: true,
      layout: 'master',
      access: 'product.view',
    },
    component: ProductIndex,
  },
  {
    path: '/product/create',
    name: 'product.create',
    meta: {
      breadcrumb: 'Add Product',
      requiresAuth: true,
      layout: 'master',
      access: 'product.create',
    },
    component: ProductCreate,
  },
];
