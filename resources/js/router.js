// resources/js/router.js
import { createWebHistory, createRouter } from 'vue-router'

const routes = [
    {
        path: '/',
        name: 'dashboard',
        meta: { breadcrumb: 'Dashboard', layout: 'master' },
        component: () => import('./admin/pages/Dashboard.vue')
    },
    {
        path: '/',
        name: 'dashboard-2',
        meta: { breadcrumb: 'Dashboard 2', layout: 'master' },
        component: () => import('./admin/pages/Dashboard2.vue')
    },
    {
        path: '/',
        name: 'dashboard-3',
        meta: { breadcrumb: 'Dashboard 3', layout: 'master' },
        component: () => import('./admin/pages/Dashboard3.vue')
    },
    {
        path: '/test',
        name: 'test',
        meta: { breadcrumb: 'Test' },
        component: () => import('./admin/pages/Test.vue')
    },
    {
        path: '/sample-tables',
        name: 'sample-tables',
        meta: { breadcrumb: 'Sample Tables' },
        component: () => import('./admin/pages/SampleTables.vue')
    },
    {
        path: '/:pathMatch(.*)*',
        component: () => import('./admin/pages/PageNotFound.vue')
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;