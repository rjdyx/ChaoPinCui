/**
 * @description 列表组件上一层，负责数据操作
 * @author 郭森林
 * @date 2017/09/28
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
import BasicModel from '../index-model/components/basic-model'
import Classification from '../expert/classification.vue'
import DateFilter from 'components/form/date-filter'
import inputFile from '../../components/public/inputFile.vue'
import Img from './img.vue'
import LookImg from './look-img.vue'
export default {
    name: 'CustomCheckPage',
    data () {
        return {
            model: {
                key: 'comment',
                tab: '产品参数管理',
                url: 'comment',
                database: 'Comment',
                theads: ['用户', '内容', '评分', '日期时间', '图片'],
                protos: ['user_name', 'content', 'level', 'created_at', 'img'],
                protosFilter: [],
                colComponents: {img: Img},
                widths: [50, 50, 50, 50, 50],
                showDetail: true,
                searchModelComponents: [{component: null, params: {}}],
                topOperateComponents: [{component: null, params: {}}],
                operateComponents: [{component: LookImg, params: {}}],
                showTabs: false,
                showNewBuild: false,
                showEdit: false,
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
                            { required: true, trigger: 'blur' }
                        ],
                        value: '',
                        type: 'input',
                        placeholder: ''
                    },
                    product_id: {
                        value: localStorage.getItem('detailId'),
                        type: 'hidden'
                    }
                }
            },
            id: localStorage.getItem('detailId'),
            theads: {name: '名称', address: '地址', desc: '描述', meridian: '经度', weft: '维度', heat: '热度', comment: '评分'},
            protos: [],
            total: 0
        }
    },
    mounted () {
        this.SET_NAVBARNAME('产品管理')
        this.SET_SUBNAVBARNAME('评论管理')
        let params = {id: this.id}
        let url = 'comment'
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
