/**
 * js库初始化
 */
require('babel-polyfill')
require('animate.css') // 动画css插件
// 路由插件
import VueRouter from 'vue-router'
Vue.use(VueRouter)// 注册element-ui全局组件
import enLocale from 'element-ui/lib/locale/lang/en'
import zhLocale from 'element-ui/lib/locale/lang/zh-CN'
import locale from 'element-ui/lib/locale'
import 'element-ui/lib/theme-default/index.css'
// 设置语言
switch (require('projectRoot/env.js').app_lang) {
case 'zh-CN':
    locale.use(zhLocale)
    break
case 'en':
    locale.use(enLocale)
    break
default:
    locale.use(zhLocale)
}
import * as elementComponent from './element-ui.js'
/**
 * 饿了么组件按需引用组件有两种方式，其中Vue.use可能会导致属性冲突，故不推荐使用
 */
Object.keys(elementComponent).forEach(function (component) {
    Vue.component(elementComponent[component].name, elementComponent[component])
})
Vue.prototype.$confirm = elementComponent['MessageBox'].confirm
Vue.prototype.$message = elementComponent['Message']
import {Loading} from 'element-ui'
Vue.prototype.$loading = Loading.service
Vue.use(Loading.directive)
/**
 * css库
 */
require('sass/index.scss')

// 注册全局组件
// Vue.component('passport-clients', require('components/passport/Clients.vue'))

// 注册自定义指令
import directive from '../directive/directive.js'
Object.keys(directive).forEach(k => Vue.directive(k, directive[k]()))

// 注册全局方法
import utils from '../utils/utils'
Vue.use(utils)

// 实例化Vue的filter
import filters from '../filters/filters.js'
Object.keys(filters).forEach(k => Vue.filter(k, filters[k]))

/**
 * http请求过滤
 */

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
}

// axios
axios.interceptors.request.use(function (config) {
    return config
}, function (error) {
    return Promise.reject(error)
})

axios.interceptors.response.use(function (response) {
    return response
}, function (error) {
    return Promise.reject(error)
})
