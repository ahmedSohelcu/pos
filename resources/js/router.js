import { createWebHistory, createRouter } from 'vue-router';
import { useAuthStore } from './ahmed-vue-kit/stores/authStore.js';

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
import NotAllow from './admin/pages/NotAllow.vue';

const baseRoutes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { guest: true, layout: 'blank' },
  },
  {
    path: '/not-allow',
    name: 'NotAllow',
    component: NotAllow,
    meta: { requiresAuth: true, layout: 'master' },
  },
  {
    path: '/',
    name: 'dashboard',
    meta: { breadcrumb: 'Dashboard', layout: 'master', requiresAuth: true },
    component: () => import('./admin/pages/lib/dashboard/Dashboard.vue'),
  },
  {
    path: '/subscription-expired',
    name: 'SubscriptionExpired',
    component: () => import('./admin/pages/SubscriptionExpired.vue'),
    meta: { requiresAuth: true, layout: 'blank' },
  },
  {
    path: '/component',
    name: 'component',
    meta: { breadcrumb: 'Component', layout: 'master', requiresAuth: false },
    component: () => import('./admin/pages/lib/dashboard/Component.vue'),
  },
  {
    path: '/dashboard-2',
    name: 'dashboard-2',
    meta: { breadcrumb: 'Dashboard 2', layout: 'master' },
    component: () => import('./admin/pages/lib/dashboard/Dashboard2.vue'),
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

router.beforeEach(async (to, from, next) => {
  const auth = useAuthStore();
  //--------------------------------
  // refresh user on route change
  //--------------------------------
  if (auth.token) {
    await auth.fetchMe();
  }

  //--------------------------------
  // auth check
  //--------------------------------
  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return next({ name: 'Login' });
  }

  //--------------------------------
  // guest check
  //--------------------------------
  if (to.meta.guest && auth.isAuthenticated) {
    return next({ name: 'dashboard' });
  }

  //--------------------------------
  // subscription check
  //--------------------------------
  if (auth.subscriptionExpired && to.name !== 'SubscriptionExpired') {
    return next({ name: 'SubscriptionExpired' });
  }

  //--------------------------------
  // permission / feature check
  //--------------------------------
  if (to.meta.access && !auth.hasAccess(to.meta.access)) {
    return next({ name: 'NotAllow' });
  }

  next();
});

export default router;
