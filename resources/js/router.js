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
        path: '/test',
        name: 'test',
        meta: { breadcrumb: 'Test' },
        component: () => import('./admin/pages/Test.vue')
    },,
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