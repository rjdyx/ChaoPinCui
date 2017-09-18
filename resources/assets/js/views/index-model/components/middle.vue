/**
 * 
 * 
 * @description 列表组件上一层，负责数据操作
 * @author 苏锐佳
 * @date 2017/07/13
 * 
 */
<template>
    <div>
        <basic-model
            ref="basicModel"
            :modelParam="model"
            :tabsName="tabsName"
            @tabClick="changeIndex"
        ></basic-model>
    </div>
</template>

<script>
import { mapMutations } from 'vuex'
import BasicModel from './basic-model'
import unit from '../unit/unit'
import classification from '../classification/classification'
export default {
    name: 'Message',
    data () {
        let modelObj = {}
        Object.assign(modelObj, unit, classification)
        return {
            modelObj: modelObj,
            model: {}
        }
    },
    computed: {
        type () {
            return this.$route.params.model
        },
        tabsName () {
            let names = []
            for (let model of this.modelObj[this.type]) {
                names.push(model.tab)
            }
            return names
        }
    },
    beforeRouteUpdate (to, from, next) {
        this.$set(this, 'model', this.modelObj[this.type][0])
        this.getTableData()
        next()
    },
    mounted () {
        this.$set(this, 'model', this.modelObj[this.type][0])
    },
    methods: {
        ...mapMutations([
            'SET_TABLE_DATA',
            'SET_TOTAL_NUM',
            'SET_NUM',
            'SET_PAGINATOR'
        ]),
        changeIndex (data) {
            this.$set(this, 'model', modelObj[type][data.index])
            this.SET_TABLE_DATA([])
            this.getTableData()
        },
        getTableData () {
            // this.$dataGet(this, this.url, {params: this.urlParams})
            //     .then((response) => {
            //         if (response.status === 200) {
            //             if (response.data.data.length !== 0) {
            //                 this.SET_TABLE_DATA(response.data.data)
            //                 this.SET_TOTAL_NUM(response.data.total)
            //                 this.SET_NUM(response.data.last_page)
            //                 this.SET_PAGINATOR(response.data)
            //             } else {
            //                 this.SET_TABLE_DATA(response.data.data)
            //                 this.SET_TOTAL_NUM(0)
            //                 this.SET_NUM(0)
            //                 this.SET_PAGINATOR(0)
            //             }
            //         }
            //     })
        }
    },
    components: {
        BasicModel
    }
}
</script>
