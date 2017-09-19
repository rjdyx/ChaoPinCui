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
            :loading="loading"
            @tabClick="changeIndex"
            @search="search"
            @multiSelect="multiSelect"
            @pageChange="pageChange"
        >
            <el-button
                id="flash"
                slot="tabs-upside"
                @click="flash"
            >
                刷新
            </el-button>
        </basic-model>
    </div>
</template>

<script>
import { mapMutations } from 'vuex'
import BasicModel from './basic-model'
import expert from '../../expert/expert'
import category from '../../category/category'
import product from '../../product/product'
import spotCheckApplicationForm from '../../spot-check-application-form/spot-check-application-form'
import spotCheckResult from '../../spot-check-result/spot-check-result'
export default {
    name: 'Message',
    data () {
        let modelObj = {}
        Object.assign(modelObj, category, product, expert, spotCheckApplicationForm, spotCheckResult)
        return {
            modelObj: modelObj,
            model: {},
            loading: false
        }
    },
    computed: {
        tabsName () {
            let names = []
            for (let model of this.modelObj[this.type]) {
                names.push(model.tab)
            }
            return names
        },
        type () {
            return this.$route.params.model
        }
    },
    watch: {
        type () {
            this.getTableData([])
            this.$set(this, 'model', this.modelObj[this.type][0])
            this.SET_ADDACTIVE(this.model.addActive)
            this.SET_EDITACTIVE(this.model.editActive)
            this.SET_DELETEACTIVE(this.model.deleteActive)
            this.getTableData()
        }
    },
    mounted () {
        this.$set(this, 'model', this.modelObj[this.type][0])
        this.SET_ADDACTIVE(this.model.addActive)
        this.SET_EDITACTIVE(this.model.editActive)
        this.SET_DELETEACTIVE(this.model.deleteActive)
        this.getTableData()
    },
    methods: {
        ...mapMutations([
            'SET_TABLE_DATA',
            'SET_TOTAL_NUM',
            'SET_NUM',
            'SET_PAGINATOR',
            'SET_CURRENTPAGE',
            'SET_SELECT_DATA',
            'SET_INPUTVALUE',
            'SET_ADDACTIVE',
            'SET_EDITACTIVE',
            'SET_DELETEACTIVE'
        ]),
        changeIndex (data) {
            this.$set(this, 'model', this.modelObj[this.type][data.index])
            this.SET_ADDACTIVE(this.model.addActive)
            this.SET_EDITACTIVE(this.model.editActive)
            this.SET_DELETEACTIVE(this.model.deleteActive)
            this.SET_TABLE_DATA([])
            this.getTableData()
        },
        getTableData (currentPage = 1, inputValue = '') {
            let url = this.modelObj[this.type][0].url
            this.loading = true
            axios.get(this.$adminUrl(url), {params: {params: this.model.urlParams, page: currentPage}})
                .then((response) => {
                    if (response.status === 200) {
                        if (response.data.data.length !== 0) {
                            this.SET_TABLE_DATA(response.data.data)
                            this.SET_TOTAL_NUM(response.data.total)
                            this.SET_NUM(response.data.last_page)
                            this.SET_PAGINATOR(response.data)
                        } else {
                            this.SET_TABLE_DATA(response.data.data)
                            this.SET_TOTAL_NUM(0)
                            this.SET_NUM(0)
                            this.SET_PAGINATOR(0)
                        }
                    }
                    this.loading = false
                })
        },
        pageChange (currentPage) {
            console.log(123)
            this.getTableData(currentPage, this.$store.state.basicModel.inputValue)
            this.SET_CURRENTPAGE(currentPage)
        },
        multiSelect (val) {
            this.SET_SELECT_DATA(val)
        },
        search (inputValue) {
            this.SET_INPUTVALUE(inputValue)
            this.getTableData(1, inputValue)
        },
        flash () {
            this.loading = true
            this.getTableData(this.$store.state.basicModel.currentPage, this.$store.state.basicModel.inputValue)
        }
    },
    components: {
        BasicModel
    }
}
</script>

<style scoped>
    #flash {
        position: absolute;
        top: 16px;
        right: 26px;
    }
</style>
