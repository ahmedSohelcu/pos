// resources/js/router.js
import { createWebHistory, createRouter } from 'vue-router'

const routes = [
    {
        path: '/',
        name: 'dashboard',
        meta: { breadcrumb: 'Dashboard', layout: 'master' },
        component: () => import('./admin/pages/lib/dashboard/Dashboard.vue')
    },
    {
        path: '/',
        name: 'dashboard-2',
        meta: { breadcrumb: 'Dashboard 2', layout: 'master' },
        component: () => import('./admin/pages/lib/dashboard/Dashboard2.vue')
    },
    {
        path: '/',
        name: 'dashboard-3',
        meta: { breadcrumb: 'Dashboard 3', layout: 'master' },
        component: () => import('./admin/pages/lib/dashboard/Dashboard3.vue')
    },
    {
        path: '/table-component',
        name: 'table-component',
        meta: { breadcrumb: 'Table Example' },
        component: () => import('./admin/pages/TableComponent.vue')
    },
    {
        path: '/sample-tables',
        name: 'sample-tables',
        meta: { breadcrumb: 'Sample Tables' },
        component: () => import('./admin/pages/SampleTables.vue')
    },
    //Widget

    {
        path: '/cards',
        name: 'cards',
        meta: { breadcrumb: 'Cards' },
        component: () => import('./admin/pages/lib/widget/Cards.vue')
    },
    {
        path: '/info-box',
        name: 'info-box',
        meta: { breadcrumb: 'Info Box' },
        component: () => import('./admin/pages/lib/widget/InfoBox.vue')
    },
    {
        path: '/small-box',
        name: 'small-box',
        meta: { breadcrumb: 'Small Box' },
        component: () => import('./admin/pages/lib/widget/SmallBox.vue')
    },

    // Form
    {
        path: '/form',
        name: 'form',
        meta: { breadcrumb: 'Form' },
        component: () => import('./admin/pages/lib/form/Form.vue')
    },

    // Ui Elements
    {
        path: '/general-ui',
        name: 'general-ui',
        meta: { breadcrumb: 'General UI' },
        component: () => import('./admin/pages/lib/ui/General.vue')
    },
    {
        path: '/icon',
        name: 'icon',
        meta: { breadcrumb: 'Icon' },
        component: () => import('./admin/pages/lib/ui/Icon.vue')
    },
    {
        path: '/timeline',
        name: 'timeline',
        meta: { breadcrumb: 'Timeline' },
        component: () => import('./admin/pages/lib/ui/Timeline.vue')
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