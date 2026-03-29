import ExpenseIndex from './views/ExpenseIndex.vue';

export const ExpenseRoutes = [
  {
    path: '/expenses',
    name: 'expenses.index',
    meta: {
      breadcrumb: 'Expenses',
      requiresAuth: true,
      layout: 'master',
      access: 'expense.view',
    },
    component: ExpenseIndex,
  },
];
