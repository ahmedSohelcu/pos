import ProductIndex from './views/ProductIndex.vue';
// import ProductCreate from './views/ProductCreate.vue';
// import ProductEdit from './views/ProductEdit.vue';
import { productPermissions } from './permissions';

export default [
  {
    path: '/product',
    name: 'product.index',
    meta: {
      breadcrumb: 'All Product',
      requiresAuth: true,
      layout: 'master',
      // permission: 'product_view',
    },
    component: ProductIndex,
  },
  // {
  //   path: '/product/create',
  //   name: 'product.create',
  //   meta: {
  //     breadcrumb: 'Add Product',
  //     requiresAuth: true,
  //     permission: 'product_create',
  //   },
  //   component: ProductCreate,
  // },
];
