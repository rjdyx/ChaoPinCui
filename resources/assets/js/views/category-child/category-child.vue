/**
 * @description 列表组件上一层，负责数据操作
 * @author 郭森林
 * @date 2017/09/21
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
            <el-col :span="6" v-for="(v, i) in theads" :key="i" class="parent-info"  :title="protos[i]">
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
    name: 'CustomCheckPage',
    data () {
        return {
            model: {
                key: 'category_child',
                tab: '分类子类管理',
                url: 'category_child',
                theads: ['名称', '内容', '图标', '图片'],
                protos: ['name', 'desc', 'ico', 'img'],
                protosFilter: [],
                widths: [50, 50, 50],
                showDetail: true,
                colComponents: {},
                searchModelComponents: [{component: null, params: {}}],
                topOperateComponents: [{component: null, params: {}}],
                showTabs: false,
                formRows: {
                    name: {
                        label: '子类名称',
                        rules: [
                            { required: true, message: '请输入名称', trigger: 'blur' },
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
                    ico: {
                        label: '图标',
                        rules: [],
                        value: '',
                        component: inputFile,
                        placeholder: ''
                    },
                    img: {
                        label: '图片',
                        rules: [],
                        value: '',
                        component: inputFile,
                        placeholder: ''
                    },
                    pid: {
                        value: this.$route.params.id,
                        type: 'hidden'
                    }
                }
            },
            id: this.$route.params.id,
            theads: {name: '名称', desc: '描述', ico: '图标', img: '图片'},
            protos: [],
            total: 0
        }
    },
    mounted () {
        this.SET_NAVBARNAME('分类管理')
        this.SET_SUBNAVBARNAME('子类管理')
        let params = {id: this.id}
        let url = 'category_child'
        axios.get(this.$adminUrl(url), {params: params}).then((res) => {
            this.SET_TABLE_DATA(res.data.data)
            this.SET_TOTAL_NUM(res.data.total)
            this.SET_NUM(res.data.last_page)
            this.SET_PAGINATOR(res.data)
        })
        url = 'category/' + this.id
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
        overflow: hidden; 
        text-overflow:ellipsis;
        white-space: nowrap;
        cursor: pointer;
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
