// resources/js/router.js (like web or api.php)
import { createWebHistory, createRouter } from 'vue-router';

// Import tenant module routes
import TenantRoutes from './admin/modules/tenants/router.js';
import UserRoutes from './admin/modules/users/router.js';
import BrandRoutes from './admin/modules/brands/router.js';
import ProductRoutes from './admin/modules/product/router.js';
import CategoryRoutes from './admin/modules/categories/router.js';
import UnitRoutes from './admin/modules/units/router.js';
import SubscriptionRoutes from './admin/modules/subscriptions/router.js';
import PlanRoutes from './admin/modules/plans/router.js';
import CustomerRoutes from './admin/modules/customers/router.js';
import Login from './admin/pages/auth/Login.vue';

const baseRoutes = [
  // Login Route
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { guest: true, layout: 'blank' }, // layout blank = no sidebar
  },
  {
    path: '/component',
    name: 'component',
    meta: { breadcrumb: 'Component', layout: 'master', requiresAuth: false },
    component: () => import('./admin/pages/lib/dashboard/Component.vue'),
  },
  {
    path: '/select2',
    name: 'select2',
    meta: {
      breadcrumb: 'Create & Update',
      layout: 'master',
      requiresAuth: false,
    },
    component: () => import('./admin/pages/lib/dashboard/select2Test.vue'),
  },
  {
    path: '/create-edit',
    name: 'create-edit',
    meta: {
      breadcrumb: 'Create & Update',
      layout: 'master',
      requiresAuth: false,
    },
    component: () => import('./admin/pages/lib/dashboard/CreateEdit.vue'),
  },
  {
    path: '/',
    name: 'dashboard',
    meta: { breadcrumb: 'Dashboard', layout: 'master', requiresAuth: true },
    component: () => import('./admin/pages/lib/dashboard/Dashboard.vue'),
  },
  {
    path: '/dashboard-2',
    name: 'dashboard-2',
    meta: { breadcrumb: 'Dashboard 2', layout: 'master' },
    component: () => import('./admin/pages/lib/dashboard/Dashboard2.vue'),
  },
  {
    path: '/dashboard-3',
    name: 'dashboard-3',
    meta: { breadcrumb: 'Dashboard 3', layout: 'master' },
    component: () => import('./admin/pages/lib/dashboard/Dashboard3.vue'),
  },
  {
    path: '/table-component',
    name: 'table-component',
    meta: { breadcrumb: 'Table Example', layout: 'master' },
    component: () => import('./admin/pages/TableComponent.vue'),
  },
  {
    path: '/sample-tables',
    name: 'sample-tables',
    meta: { breadcrumb: 'Sample Tables', layout: 'master' },
    component: () => import('./admin/pages/SampleTables.vue'),
  },
  //Widget
  {
    path: '/cards',
    name: 'cards',
    meta: { breadcrumb: 'Cards', layout: 'master' },
    component: () => import('./admin/pages/lib/widget/Cards.vue'),
  },
  {
    path: '/info-box',
    name: 'info-box',
    meta: { breadcrumb: 'Info Box', layout: 'master' },
    component: () => import('./admin/pages/lib/widget/InfoBox.vue'),
  },
  {
    path: '/small-box',
    name: 'small-box',
    meta: { breadcrumb: 'Small Box', layout: 'master' },
    component: () => import('./admin/pages/lib/widget/SmallBox.vue'),
  },

  // Form
  {
    path: '/form',
    name: 'form',
    meta: { breadcrumb: 'Form', layout: 'master' },
    component: () => import('./admin/pages/lib/form/Form.vue'),
  },

  // Ui Elements
  {
    path: '/general-ui',
    name: 'general-ui',
    meta: { breadcrumb: 'General UI', layout: 'master' },
    component: () => import('./admin/pages/lib/ui/General.vue'),
  },
  {
    path: '/icon',
    name: 'icon',
    meta: { breadcrumb: 'Icon', layout: 'master' },
    component: () => import('./admin/pages/lib/ui/Icon.vue'),
  },
  {
    path: '/timeline',
    name: 'timeline',
    meta: { breadcrumb: 'Timeline', layout: 'master' },
    component: () => import('./admin/pages/lib/ui/Timeline.vue'),
  },

  {
    path: '/:pathMatch(.*)*',
    name: 'notFound',
    meta: { breadcrumb: '', layout: 'master' },
    component: () => import('./admin/pages/PageNotFound.vue'),
  },
];

// Merge all routes dynamically
const routes = [
  ...baseRoutes,
  ...TenantRoutes,
  ...UserRoutes,
  ...BrandRoutes,
  ...CategoryRoutes,
  ...UnitRoutes,
  ...ProductRoutes,
  ...PlanRoutes,
  ...SubscriptionRoutes,
  ...CustomerRoutes,
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation Guard
import { useAuthStore } from './ahmed-vue-kit/stores/authStore.js';

router.beforeEach((to, from, next) => {
  const auth = useAuthStore();

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return next({ name: 'Login' });
  }

  if (to.meta.guest && auth.isAuthenticated) {
    return next({ name: 'dashboard' });
  }

  next();
});

// Navigation Guard
// router.beforeEach((to, from, next) => {
//   const token = localStorage.getItem('auth_token'); // or your auth state
//   if (to.meta.requiresAuth && !token) {
//     next({ name: 'Login' });
//   } else if (to.meta.guest && token) {
//     next({ name: 'Dashboard' });
//   } else {
//     next();
//   }
// });

// role based
// const user = JSON.parse(localStorage.getItem('user'))
// router.beforeEach((to, from, next) => {
//     if (to.meta.requiresAuth && !user) return next('/login')

//     if (to.meta.role && user.role !== to.meta.role) return next('/403') // Forbidden page

//     next()
// })

export default router;
