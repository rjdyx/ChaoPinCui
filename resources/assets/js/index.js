import 'es6-promise/auto'
import Vue from 'vue'
import App from './App.vue'
import store from './store/index.js'
import router from './router/index.js'
import env from 'projectRoot/env.js'

require('./config/config')

const app = new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
