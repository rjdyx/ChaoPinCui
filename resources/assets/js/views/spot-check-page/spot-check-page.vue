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
            class="basic-model"
            ref="basicModel"
            :modelParam="model"
            @multiSelect="multiSelect"
        >
            <div class="numbers" slot="tabs-upside">
                <span>专家库总人数: {{total}}</span>
                <span>抽取人数: {{$route.params.count}}</span>
            </div>
            <el-button
                id="back"
                slot="tabs-downside"
                @click="back"
            >
                返回
            </el-button>
        </basic-model>
    </div>
</template>

<script>
import { mapMutations } from 'vuex'
import BasicModel from '../index-model/components/basic-model'
import Classification from '../expert/classification.vue'
import Sex from '../expert/sex.vue'
import DateFilter from 'components/form/date-filter'
import FilterSelect from './filter-select'
import SpotCheckButtons from './spot-check-buttons'
export default {
    name: 'SpotCheckPage',
    data () {
        return {
            model: {
                key: 'expert',
                tab: '专家管理',
                url: 'expert',
                theads: ['分类', '专家姓名', '性别', '出生年月', '籍贯', '民族', '政治面貌', '文化程度', '学位', '毕业学校', '毕业时间', '专业', '职务', '职称', '工作时间', '联系电话', '邮箱', '特长', '专家简历', '专家意见', '备注'],
                protos: ['classification', 'name', 'sex', 'birthday', 'native_place', 'nation', 'political_status', 'education', 'degree', 'graduation_school', 'graduation_time', 'major', 'duty', 'title', 'work_time', 'phone', 'email', 'speciality', 'resume', 'opinion', 'memo'],
                protosFilter: ['birthday', 'native_place', 'nation', 'political_status', 'education', 'degree', 'graduation_school', 'graduation_time', 'work_time', 'resume', 'opinion', 'memo'],
                widths: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50],
                showDetail: true,
                colComponents: {classification: Classification, sex: Sex, birthday: DateFilter, graduation_time: DateFilter, work_time: DateFilter},
                searchModelComponents: [{component: FilterSelect, params: {}}],
                topOperateComponents: [{component: SpotCheckButtons, params: {}}],
                showTabs: false,
                showSearchModel: false,
                showNewBuild: false,
                showDelete: false,
                showEdit: false,
                showOperateCol: false
            },
            id: this.$route.params.id,
            total: 0
        }
    },
    mounted () {
        this.SET_NAVBARNAME('申请管理')
        this.SET_SUBNAVBARNAME('抽取专家')
        this.total = this.db.get('expert').size()
    },
    methods: {
        ...mapMutations([
            'SET_NAVBARNAME',
            'SET_SUBNAVBARNAME',
            'SET_SELECT_DATA'
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

<style lang="scss">
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
