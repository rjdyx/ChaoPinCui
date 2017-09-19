import Vue from 'vue'

/**
 * 全局注册通用方法
 */
export default {
    install () {
        /**
         * 自动生成完整的后台url
         *
         * @param url {string}
         * @returns {string}
         */
        Vue.prototype.$adminUrl = (url) => {
            let regx = /^\/{1,}/g
            url = url.replace(regx, '')
            return host + '/admin/' + url
        }

        Vue.prototype.$deepClone = (obj) => {
            let str
            let newobj = obj.constructor === Array ? [] : {}
            if (typeof obj !== 'object') {
                return
            } else if (window.JSON) {
                str = JSON.stringify(obj)
                newobj = JSON.parse(str)
            } else {
                for (let i in obj) {
                    newobj[i] = typeof obj[i] === 'object' ? Vue.prototype.$deepClone(obj[i]) : obj[i]
                }
            }
            return newobj
        }

        /**
         * 比较器
         * @param proto
         * @returns {function()}
         */
        function compare (proto) {
            return (ob1, ob2) => {
                return ob1[proto] - ob2[proto]
            }
        }

        /**
         * 根据传过来的属性参数对对象数组继续逆序排序
         * @param arrObj 对象数组
         * @param proto 对象的属性
         * @returns {Array.<T>}
         */
        Vue.prototype.$reverseObj = (arrObj, proto) => {
            return arrObj.sort(compare(proto)).reverse()
        }

        /**
         * 根据传过来的属性参数对对象数组继续正序排序
         * @param arrObj 对象数组
         * @param proto 对象的属性
         * @returns {Array.<T>}
         */
        Vue.prototype.$sortObj = (arrObj, proto) => {
            return arrObj.sort(compare(proto))
        }

        /**
         * 删除数组的指定项
         * targetArr和seletedArr数组正序排序
         * 连续使用splice方法删除targetArr数组里的某一项必须从尾部开始，否则会删错
         * 此方法虽然使用两个循环，但时间复杂度是O(multipleSelection.length + tableData.length) + k
         * 而不是O(multipleSelection.length * tableData.length) + k
         * @param  {Array} targetArr  目标数组
         * @param  {Array} seletedArr 删除数组
         * @param  {String} proto      比较属性
         * @return {Array}            删除指定项后的新数组
         */
        Vue.prototype.$deleteArrayWith = (targetArr, seletedArr, proto, sortProto = 'created_at') => {
            if (proto) {
                targetArr = Vue.prototype.$sortObj(targetArr, sortProto)
                seletedArr = Vue.prototype.$sortObj(seletedArr, sortProto)
            }
            let targetArrLength = targetArr.length - 1
            let seletedArrLength = seletedArr.length - 1
            for (; seletedArrLength >= 0; seletedArrLength--) {
                for (; targetArrLength >= 0; targetArrLength--) {
                    if (proto) {
                        if (seletedArr[seletedArrLength][proto] === targetArr[targetArrLength][proto]) {
                            targetArr.splice(targetArrLength, 1)
                            targetArrLength--
                            break
                        }
                    } else {
                        if (seletedArr[seletedArrLength] === targetArr[targetArrLength]) {
                            targetArr.splice(targetArrLength, 1)
                            targetArrLength--
                            break
                        }
                    }
                }
            }
            return targetArr
        }
    }
}
