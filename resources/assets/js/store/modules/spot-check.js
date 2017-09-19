import Vue from 'vue'
const { fetchTableData } = require('api')

const state = {
    selects: [],
    isFilter: false
}

// getters
const getters = {
    // recorddo: state => state.number
}

// actions
const actions = {}

// mutations
const mutations = {
    SET_SELECTS (state, selects) {
        let newOne = Vue.prototype.$deepClone(selects)
        state.selects = newOne
    },
    SET_IS_FILTER (state, isFilter) {
        state.isFilter = isFilter
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
