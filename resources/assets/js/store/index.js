import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import getters from './getters'
import mutations from './mutations'
import basicModel from './modules/basic-model'
import spotCheck from './modules/spot-check'
import user from './modules/user'
const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    actions,
    getters,
    mutations,
    modules: {
        basicModel,
        spotCheck,
        user
    },
    strict: debug
})
