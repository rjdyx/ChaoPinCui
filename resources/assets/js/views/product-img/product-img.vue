/**
 * @description 列表组件上一层，负责数据操作
 * @author 郭森林
 * @date 2017/09/20
 * 
 */
<template>
    <div>
        
        <basic-model
            class="basic-model"
            ref="basicModel"
            :modelParam="model"
            @multiSelect="multiSelect"
        >
        <el-row :gutter="20" slot="tabs-downside">
            <el-col :span="6" v-for="(v, i) in theads" :key="i" class="parent-info">
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
export default {
    name: 'ImgCheckPage',
    data () {
        return {
            model: {
                key: 'img',
                tab: '图片管理',
                url: 'img',
                theads: ['名称', '描述', '图片', '排序'],
                protos: ['name', 'desc', 'thumb', 'sort'],
                protosFilter: [],
                widths: [50],
                showDetail: true,
                colComponents: {},
                searchModelComponents: [{component: null, params: {}}],
                topOperateComponents: [{component: null, params: {}}],
                showTabs: false,
                formRows: {
                    name: {
                        label: '图片名称',
                        rules: [
                            { required: true, message: '请输入产品名称', trigger: 'blur' },
                            { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                        ],
                        value: '',
                        type: 'input',
                        placeholder: '必填'
                    },
                    desc: {
                        label: '描述',
                        rules: [
                            { required: true, max: 255, message: '长度在 255 个字符以内', trigger: 'blur' }
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
                    img: {
                        label: '图片',
                        rules: [],
                        value: '',
                        component: inputFile,
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
        this.SET_SUBNAVBARNAME('图片管理')
        let params = {id: this.id}
        let url = 'img'
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
            'SET_SUBNAVBARNAME'
        ]),
        multiSelect (val) {
            this.SET_SELECT_DATA(val)
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

<style lang="sass">
    .basic-model > div#operate {
        margin-top: 1rem !important;
    }
    .parent-info{
        color:#999999;
        height: 40px;
    }
    .numbers {
        margin-top: 20px;
        margin-bottom: -60px;

        span {
            font-size: 2rem;
            margin-right: 50px;
        }
    }

    .basic-model>div#operate {
        margin-top: 6rem;
    }

    #back {
        position: absolute;
        top: 16px;
        right: 26px;
    }
</style>
