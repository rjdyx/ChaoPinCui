import Vue from 'vue'
const { fetchTableData } = require('api')

const state = {
    tableData: [],
    selectData: [],
    totalNum: 0,
    num: 0,
    paginator: 0,
    currentPage: 1,
    navbarName: '',
    subNavBarName: '',
    inputValue: '',
    addActive: null,
    addedActive: null,
    editActive: null,
    editedActive: null,
    deleteActive: null
}

// getters
const getters = {
    // recorddo: state => state.number
}

// actions
const actions = {
    FETCH_TABLE_DATA ({ commit, state }, { store, route: { query: { url = '' } } }) {
        let cookies = store.state.auth.cookies
        // 刷新页面或在浏览器进行路由跳转时会调用到此action
        // 在浏览器端跳转时，无需设置headers的cookie
        // 而刷新页面时是在服务器端进行调用，此时需要设置cookie以保持登录状态
        return fetchTableData(url, cookies)
            .then((responce) => {
                // 在浏览器端调用此action后获取到的数据是对象
                // 而在服务器端获取到的数据是json字符串，需转换成json对象
                let tableData = typeof window === 'undefined'
                    ? eval('(' + responce.data + ')')
                    : responce.data
                // 数据转换
                if (tableData.data.length !== 0) {
                    commit('SET_TABLE_DATA', tableData.data)
                    commit('SET_TOTAL_NUM', tableData.total)
                    commit('SET_NUM', tableData.last_page)
                    commit('SET_PAGINATOR', tableData)
                } else {
                    commit('SET_TABLE_DATA', tableData.data)
                    commit('SET_TOTAL_NUM', 0)
                    commit('SET_NUM', 0)
                    commit('SET_PAGINATOR', 0)
                }
            })
            .catch((error) => {
                console.log(error.response.data)
            })
    }
}

// mutations
const mutations = {
    SET_TABLE_DATA (state, tableData) {
        let newOne = Vue.prototype.$deepClone(tableData)
        state.tableData = newOne
    },
    PUSH_TABLE_DATA (state, tableData) {
        state.tableData.splice(0, 0, tableData)
    },
    SPLICE_TABLE_DATA (state, index) {
        state.tableData.splice(index, 1)
    },
    UPDATE_TABLE_DATA (state, {index, newOne}) {
        state.tableData.splice(index, 1, newOne)
    },
    SET_SELECT_DATA (state, selectData) {
        let newOne = Vue.prototype.$deepClone(selectData)
        state.selectData = newOne
    },
    SET_TOTAL_NUM (state, totalNum) {
        state.totalNum = totalNum
    },
    SET_NUM (state, num) {
        state.num = num
    },
    SET_PAGINATOR (state, paginator) {
        state.paginator = paginator
    },
    SET_CURRENTPAGE (state, currentPage) {
        state.currentPage = currentPage
    },
    SET_NAVBARNAME (state, navbarName) {
        state.navbarName = navbarName
    },
    SET_SUBNAVBARNAME (state, subNavBarName) {
        state.subNavBarName = subNavBarName
    },
    SET_INPUTVALUE (state, inputValue) {
        state.inputValue = inputValue
    },
    SET_ADDACTIVE (state, addActive) {
        state.addActive = addActive
    },
    SET_EDITACTIVE (state, editActive) {
        state.editActive = editActive
    },
    SET_ADDEDACTIVE (state, addedActive) {
        state.addedActive = addedActive
    },
    SET_EDITEDACTIVE (state, editedActive) {
        state.editedActive = editedActive
    },
    SET_DELETEACTIVE (state, deleteActive) {
        state.deleteActive = deleteActive
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
