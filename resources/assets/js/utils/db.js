import Vue from 'vue'
const num = require('projectRoot/env.js').num

/**
 * 全局注册通用方法
 */
export default {
    install () {
        Vue.prototype.$paginator = (db, page = 1) => {
            let total = db.size().value()
            return db.slice((page - 1) * num, page * num).value()
        }
    }
}
