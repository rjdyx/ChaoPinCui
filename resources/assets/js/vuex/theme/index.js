import * as func from '../function.js'
import actions from './actions.js'
import mutations from './mutations.js'
import getters from './getters.js'
const state = {
    theme: func.themeLocal.get() || {theme: 'blue'},
    font: func.fontLocal.get() || {font: 'middle'},
    record: func.modelLocal.get() || {record: ''},
    siderBar: func.siderBarLocal.get() || {siderBar: false}
}
export default{
    state,
    actions,
    mutations,
    getters
}
