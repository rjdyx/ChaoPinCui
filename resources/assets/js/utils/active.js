import Vue from 'vue'

/**
 * 全局注册通用方法
 */
export default {
    install () {
        Vue.prototype.$ACT_ADDACTIVE = ({vm, id, obj}) => {
            if (vm.$store.state.basicModel.addActive) {
                return vm.$store.state.basicModel.addActive(id, obj)
            }
        }

        Vue.prototype.$ACT_EDITACTIVE = ({vm, id, obj}) => {
            if (vm.$store.state.basicModel.editActive) {
                return vm.$store.state.basicModel.editActive(id, obj)
            }
        }
        
        Vue.prototype.$ACT_ADDEDACTIVE = ({vm, id, obj, res}) => {
            if (vm.$store.state.basicModel.addedActive) {
                return vm.$store.state.basicModel.addedActive(id, obj, res)
            }
        }

        Vue.prototype.$ACT_EDITEDACTIVE = ({vm, id, obj, res}) => {
            if (vm.$store.state.basicModel.editedActive) {
                return vm.$store.state.basicModel.editedActive(id, obj, res)
            }
        }

        Vue.prototype.$ACT_DELETEACTIVE = ({vm, id}) => {
            if (vm.$store.state.basicModel.deleteActive) {
                return vm.$store.state.basicModel.deleteActive(id)
            }
        }
    }
}
