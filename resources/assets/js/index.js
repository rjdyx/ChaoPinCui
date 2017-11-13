import 'es6-promise/auto'
import Vue from 'vue'
import App from './App.vue'
import store from './store/index.js'
import router from './router/index.js'
import env from 'projectRoot/env.js'

require('./config/config')
// 登录后路由
const pre = '/index'
const adminArr = [pre + '/home', pre + '/user/user', pre + '/category/category', pre + '/product/product', pre + '/system/system', pre + '/trues/trues',
    pre + '/feedback/feedback', pre + '/log/log', pre + '/category-child', pre + '/product-img', pre + '/product-custom', pre + '/product-comment']
router.beforeEach(async (to, from, next) => {
    let res = false
    if (window.flag) {
        await axios.get('/auth').then(responce => {
            if (responce.data.name !== undefined) {
                res = true
                window.Auth = responce.data
                return false
            } else {
                res = false
                window.Auth = {}
                return false
            }
        })
    }
    // 登录状态
    if (res) {
        for (let a in adminArr) {
            if (to.path === adminArr[a]) {
                next()
                return false
            }
        }
        next('/index/home')
    } else {
        if (to.path !== '/login') {
            next('/login')
        } else {
            next()
        }
    }
})

const app = new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
