//Admin sidebar

import { CustomerMenus } from '../admin/modules/customers/sidebar';
import { ProductMenus } from '../admin/modules/product/sidebar';
import { SubscriptionMenus } from '../admin/modules/subscriptions/sidebar';
import { TenantMenus } from '../admin/modules/tenants/sidebar';
import { UsersMenus } from '../admin/modules/users/sidebar';

export const AdminMenus = [
  // Tenants module
  ...TenantMenus,

  //------------------------------------------------
  // Product Module (product, brand, unit, category)
  //------------------------------------------------
  ...ProductMenus,

  // {
  //   key: 'inventory',
  //   label: 'Inventory',
  //   icon: 'fas fa-warehouse',
  //   items: [
  //     { name: 'component', label: 'Stock List' },
  //     { name: 'component', label: 'Low Stock Alerts' },
  //     { name: 'component', label: 'Expired Items' },
  //   ]
  // },
  // {
  //   key: 'orders',
  //   label: 'Orders',
  //   icon: 'fas fa-shopping-cart',
  //   items: [
  //     { name: 'component', label: 'All Orders' },
  //     { name: 'component', label: 'Pending Orders' },
  //     { name: 'component', label: 'Completed Orders' },
  //     { name: 'component', label: 'Cancelled Orders' }
  //   ]
  // },

  //------------------------------------------------
  // customers
  //------------------------------------------------
  ...CustomerMenus,

  //------------------------------------------------
  // User Module
  //------------------------------------------------
  ...UsersMenus,

  {
    key: 'suppliers',
    label: 'Suppliers',
    icon: 'bi bi-truck',
    items: [
      { name: 'component', label: 'Add Supplier' },
      { name: 'component', label: 'Supplier Contacts' },
    ],
  },
  //------------------------------------------------
  // Subscription Module
  //------------------------------------------------
  ...SubscriptionMenus,

  {
    key: 'expenses',
    label: 'Expenses',
    icon: 'fas fa-wallet',
    items: [
      { name: 'component', label: 'Manage Expenses' },
      { name: 'component', label: 'Expense Categories' },

      // { name: 'expenses.report', label: 'Expense Report' },
    ],
  },
  // {
  //   key: 'reports',
  //   label: 'Reports',
  //   icon: 'fas fa-chart-line',
  //   items: [
  //     { name: 'component', label: 'Sales Report' },
  //     { name: 'component', label: 'Stock Report' },
  //     { name: 'component', label: 'Profit Report' },
  //     { name: 'component', label: 'Customer Report' }
  //   ]
  // },
  // {
  //   key: 'tables',
  //   label: 'Tables',
  //   icon: 'bi bi-table',
  //   items: [
  //     { name: 'table-component', label: 'Table Component Example' },
  //     { name: 'sample-tables', label: 'Sample Tables' }
  //   ]
  // },

  {
    key: 'settings',
    label: 'Settings',
    icon: 'bi bi-gear-fill',
    items: [
      { name: 'component', label: 'General' },
      { name: 'component', label: 'Notifications' },
      { name: 'component', label: 'Payment Options' },
      { name: 'component', label: 'Tax Configuration' },
    ],
  },

  // {
  //   key: 'login',
  //   label: 'Login',
  //   icon: 'bi bi-door-open-fill',
  //   items: [{ name: 'Login', label: 'Login' }],
  // },

  {
    key: 'Example',
    label: 'Example',
    icon: 'bi bi-door-open-fill',
    items: [
      { name: 'dashboard', label: 'Dashboard' },
      { name: 'dashboard-2', label: 'Dashboard 2' },
      { name: 'dashboard-3', label: 'Dashboard 3' },
      { name: 'info-box', label: 'info-box' },
      { name: 'create-edit', label: 'Create / Update' },
      { name: 'select2', label: 'Shop Page' },
      { name: 'sample-tables', label: 'sample-tables' },
      { name: 'small-box', label: 'small-box' },
      { name: 'table-component', label: 'table-component' },
      { name: 'general-ui', label: 'general-ui' },
      { name: 'cards', label: 'cards' },
      { name: 'timeline', label: 'timeline' },
      { name: 'notFound', label: '404 Page' },
    ],
  },
];
