import 'es6-promise/auto'
import Vue from 'vue'
import App from './App.vue'
import store from './vuex/index.js'
import router from './route/routers.js'
import env from 'projectRoot/env.js'

require('./config/config')

const app = new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
