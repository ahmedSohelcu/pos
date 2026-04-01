import AttributeIndex from './views/attributeIndex.vue';

export const AttributeRoutes = [
  {
    path: '/attribute',
    name: 'attribute.index',
    meta: {
      breadcrumb: 'Attributes',
      layout: 'master',
      requiresAuth: true,
      access: 'attribute.view',
    },
    component: AttributeIndex,
  },
];
