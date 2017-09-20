/**
 * 路由
 */
import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import index from '../views/index/index.vue'
import middle from '../views/index-model/components/middle.vue'
import spotCheckPage from '../views/spot-check-page/spot-check-page.vue'
import productImg from '../views/product-img/product-img.vue'
import spotCheckResultPage from '../views/spot-check-result-page/spot-check-result-page.vue'
import login from '../views/login/login.vue'
import notFound from '@/components/error/404.vue'

const routes = [
    {
        path: '/',
        name: 'index',
        component: index,
        meta: { requiresAuth: true }
    },
    {
        path: '/index',
        component: index,
        meta: { requiresAuth: true },
        children: [
            {
                path: 'user/:model',
                alias: [
                    'category/:model',
                    'log/:model',
                    'feedback/:model',
                    'product/:model',
                    'spot-check-result/:model',
                    'spot-check-application-form/:model',
                    'expert/:model', 'system/:model'
                ],
                component: middle,
                meta: { requiresAuth: true }
            },
            {
                path: 'product-img/:id',
                component: productImg,
                meta: { requiresAuth: true }
            },
            {
                path: 'spot-check-page/:id/:count',
                component: spotCheckPage,
                meta: { requiresAuth: true }
            },
            {
                path: 'spot-check-result-page/:id/:count',
                component: spotCheckResultPage,
                meta: { requiresAuth: true }
            }
        ]
    },
    {
        path: '/login',
        name: 'login',
        component: login
    },
    {
        path: '/404',
        name: 'notFound',
        component: notFound
    }
]

export default new Router({
    routes
})
