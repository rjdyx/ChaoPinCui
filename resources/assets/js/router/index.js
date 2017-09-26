/**
 * 路由
 */
import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import index from '../views/index/index.vue'
import home from '../views/home/home.vue'
import system from '../views/system/system.vue'
import middle from '../views/index-model/components/middle.vue'
import spotCheckPage from '../views/spot-check-page/spot-check-page.vue'
import productImg from '../views/product-img/product-img.vue'
import productComment from '../views/product-comment/product-comment.vue'
import categoryChild from '../views/category-child/category-child.vue'
import productCustom from '../views/product-custom/product-custom.vue'
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
                path: 'home',
                component: home,
                meta: { requiresAuth: true }
            },
            {
                path: 'user/:model',
                alias: [
                    'category/:model',
                    'log/:model',
                    'feedback/:model',
                    'product/:model'
                ],
                component: middle,
                meta: { requiresAuth: true }
            },
            {
                path: 'category-child/:id',
                component: categoryChild,
                meta: { requiresAuth: true }
            },
            {
                path: 'product-img/:id',
                component: productImg,
                meta: { requiresAuth: true }
            },
            {
                path: 'product-custom/:id',
                component: productCustom,
                meta: { requiresAuth: true }
            },
            {
                path: 'product-comment/:id',
                component: productComment,
                meta: { requiresAuth: true }
            },
            {
                path: 'system/system',
                component: system,
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
