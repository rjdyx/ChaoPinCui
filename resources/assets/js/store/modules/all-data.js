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
    GET_ALL_DATAS ({commit, state}, type) {
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
    SET_CATEGORY (state, category) {
        state.category = category
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
