/**
 * 路由
 */
import Router from 'vue-router'

const index = () => import('../views/index/index.vue')
const middle = () => import('../views/index-model/components/middle.vue')
const login = () => import('../views/login/login.vue')
const notFound = () => import('components/error/404.vue')

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
                alias: ['unit/:model', 'classification/:model', 'system/:model'],
                component: middle,
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
