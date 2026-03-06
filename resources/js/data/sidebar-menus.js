//Admin sidebar

import { CustomerMenus } from '../admin/modules/customers/sidebar';
import { ProductMenus } from '../admin/modules/product/sidebar';
import { SubscriptionMenus } from '../admin/modules/subscriptions/sidebar';
import { TenantMenus } from '../admin/modules/tenants/sidebar';
import { UsersMenus } from '../admin/modules/users/sidebar';

export const AdminMenus = [
  // Tenants module
  ...TenantMenus,

  // {
  //   key: 'dashboard',
  //   label: 'Dashboard',
  //   icon: 'fas fa-tachometer-alt',
  //   items: [
  //     { name: 'component', label: 'Manage Data' },
  //     { name: 'create-edit', label: 'Create / Update' },
  //     { name: 'select2', label: 'Select2' },
  //     { name: 'dashboard', label: 'Dashboard' },
  //     { name: 'dashboard-2', label: 'Dashboard 2' },
  //     { name: 'dashboard-3', label: 'Dashboard 3' },
  //     // { name: 'dashboard', label: 'Overview' },
  //     // { name: 'dashboard-2', label: 'Sales Summary' },
  //     // { name: 'dashboard', label: 'Stock Overview' },
  //     // { name: 'dashboard-2', label: 'Customer Insights' },
  //   ],
  // },

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
      { name: 'component', label: 'All Suppliers' },
      { name: 'component', label: 'Add Supplier' },
      { name: 'component', label: 'Supplier Contacts' },
    ],
  },
  //------------------------------------------------
  // Subscription Module
  //------------------------------------------------
  ...SubscriptionMenus,
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
  // {
  //   key: 'settings',
  //   label: 'Settings',
  //   icon: 'bi bi-gear-fill',
  //   items: [
  //     { name: 'component', label: 'General' },
  //     { name: 'component', label: 'Users & Roles' },
  //     { name: 'component', label: 'Notifications' },
  //     { name: 'component', label: 'Payment Options' },
  //     { name: 'component', label: 'Tax Configuration' }
  //   ]
  // }
];
