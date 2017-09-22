import Vue from 'vue'
export const editCallBack = (id, obj, res) => {
    let newOne = Vue.prototype.$deepClone(obj)
    newOne.img = res.data.img
    return newOne
}
