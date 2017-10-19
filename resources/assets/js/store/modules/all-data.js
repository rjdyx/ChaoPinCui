/**
 * 作用：获取全部需要缓存的数据
 * 2017/10/19 by suzhihao
 */
import Vue from 'vue'

const state = {
    category: []
}

const getters = {
    allCategory: state => state.category
}

const actions = {
    GET_ALL_DATAS ({commit, state}, {type, refresh = false}) {
        if (refresh) {
            axios.get(Vue.prototype.$adminUrl(`${type}/all`))
            .then(response => {
                if (response.status === 200) {
                    commit(`SET_${type.toLocaleUpperCase()}`, response.data)
                }
            })
            return
        }
        if (state[type].length) {
            return state[type]
        } else {
            axios.get(Vue.prototype.$adminUrl(`${type}/all`))
            .then(response => {
                if (response.status === 200) {
                    commit(`SET_${type.toLocaleUpperCase()}`, response.data)
                }
            })
        }
    }
}

const mutations = {
    // 获取产品分类的数据
    SET_CATEGORY (state, category) {
        let arr = []
        category.forEach(cate => {
            if (cate.pid === null) {
                let obj = {
                    id: cate.id,
                    name: cate.name,
                    children: []
                }
                category.forEach(child => {
                    if (child.pid === cate.id) {
                        obj.children.push(child)
                    }
                })
                arr.push(obj)
            }
        })
        state.category = arr
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
