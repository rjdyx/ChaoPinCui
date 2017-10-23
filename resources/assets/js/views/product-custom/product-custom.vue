/**
 * @description 列表组件上一层，负责数据操作
 * @author 郭森林
 * @date 2017/09/21
 * 
 */
<template>
    <div id="middle">
        
        <basic-model
            class="basic-model"
            ref="basicModel"
            :modelParam="model"
            @search="search"
            @multiSelect="multiSelect"
        >
        <el-row :gutter="20" slot="tabs-downside">
            <el-col :span="6" v-for="(v, i) in theads" :key="i" class="parent-info" :title="protos[i]">
                <span class="grid-content" >{{v}}: </span>
                {{protos[i]}}
            </el-col>
        </el-row>
            <el-button id="back" slot="tabs-downside" @click="back"> 返回 </el-button>
        </basic-model>
    </div>
</template>

<script>
import { mapMutations } from 'vuex'
import { reInteger } from 'utils/validate'
import BasicModel from '../index-model/components/basic-model'
import Classification from '../expert/classification.vue'
import DateFilter from 'components/form/date-filter'
import inputFile from '../../components/public/inputFile.vue'
export default {
    name: 'CustomCheckPage',
    data () {
        return {
            model: {
                key: 'custom',
                tab: '产品参数管理',
                url: 'custom',
                database: 'Custom',
                theads: ['名称', '内容', '排序'],
                protos: ['name', 'content', 'sort'],
                protosFilter: [],
                widths: [50, 50, 50],
                showDetail: true,
                colComponents: {},
                searchModelComponents: [{component: null, params: {}}],
                topOperateComponents: [{component: null, params: {}}],
                showTabs: false,
                formRows: {
                    name: {
                        label: '参数名称',
                        rules: [
                            { required: true, message: '请输入名称', trigger: 'blur' },
                            { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                        ],
                        value: '',
                        type: 'input',
                        placeholder: '必填'
                    },
                    content: {
                        label: '内容',
                        rules: [
                            { required: true, max: 2000, message: '长度在 2000 个字符以内', trigger: 'blur' }
                        ],
                        value: '',
                        type: 'textarea',
                        placeholder: ''
                    },
                    sort: {
                        label: '排序',
                        rules: [
                            { required: true, message: '请输入排序' },
                            { validator: reInteger }
                        ],
                        value: '',
                        type: 'input',
                        placeholder: ''
                    },
                    product_id: {
                        value: this.$route.params.id,
                        type: 'hidden'
                    }
                }
            },
            id: this.$route.params.id,
            theads: {name: '名称', address: '地址', desc: '描述', meridian: '经度', weft: '维度', heat: '热度', comment: '评分'},
            protos: [],
            total: 0
        }
    },
    mounted () {
        this.SET_NAVBARNAME('产品管理')
        this.SET_SUBNAVBARNAME('参数管理')
        let params = {id: this.id}
        let url = 'custom'
        axios.get(this.$adminUrl(url), {params: params}).then((res) => {
            this.SET_TABLE_DATA(res.data.data)
            this.SET_TOTAL_NUM(res.data.total)
            this.SET_NUM(res.data.last_page)
            this.SET_PAGINATOR(res.data)
        })
        url = 'product/' + this.id
        axios.get(this.$adminUrl(url)).then((res) => {
            this.protos = res.data
        })
    },
    methods: {
        ...mapMutations([
            'SET_TABLE_DATA',
            'SET_TOTAL_NUM',
            'SET_NUM',
            'SET_PAGINATOR',
            'SET_NAVBARNAME',
            'SET_SELECT_DATA',
            'SET_INPUTVALUE',
            'SET_SUBNAVBARNAME'
        ]),
        getTableData (currentPage = 1, inputValue = '') {
            let url = this.model.url
            this.loading = true
            axios.get(this.$adminUrl(url), {params: {params: this.model.urlParams, page: currentPage, query_text: inputValue, id: this.id}})
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
        multiSelect (val) {
            this.SET_SELECT_DATA(val)
        },
        search (inputValue) {
            this.SET_INPUTVALUE(inputValue)
            this.getTableData(1, inputValue)
        },
        back () {
            this.$router.back()
        }
    },
    components: {
        BasicModel
    }
}
</script>
