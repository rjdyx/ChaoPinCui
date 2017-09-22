import 'es6-promise/auto'
import Vue from 'vue'
import App from './App.vue'
import store from './store/index.js'
import router from './router/index.js'
import env from 'projectRoot/env.js'

require('./config/config')

router.beforeEach(async (to, from, next) => {
    let res = false
    if (!window.Auth) {
        await axios.get('/auth').then(responce => {
            if (responce.data.name === undefined) {
                res = true
                window.Auth = responce.data
                return false
            }
        })
    }
    if (res) {
        if (to.path !== '/login') {
            next('/login')
        } else {
            next()
        }
    } else {
        if (to.path === '/') {
            next('/index/home')
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
