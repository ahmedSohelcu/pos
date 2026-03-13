import ExpenseCategoryIndex from './views/ExpenseCategoryIndex.vue';

export const ExpenseCategoryRoutes = [
  {
    path: '/expense-categories',
    name: 'expense_categories.index',
    meta: {
      breadcrumb: 'Expense Categories',
      requiresAuth: true,
      layout: 'master',
      access: 'expense_category.view',
    },
    component: ExpenseCategoryIndex,
  },
];
