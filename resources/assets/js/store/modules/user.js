import Vue from 'vue'
const { fetchTableData } = require('api')

const state = {
    isLogin: false
}

// getters
const getters = {
    // recorddo: state => state.number
}

// actions
const actions = {}

// mutations
const mutations = {
    SET_IS_LOGIN (state, login) {
        state.isLogin = login
        sessionStorage.loginStatus = login
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
