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
        >
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
                showTabs: false,
                showSearchModel: false,
                showNewBuild: false,
                showDelete: false,
                showEdit: false,
                showOperateCol: false,
                showCheckbox: false
            }
        }
    },
    mounted () {
        this.SET_NAVBARNAME('抽取结果')
        this.SET_SUBNAVBARNAME('已抽专家')
        let spotCheckId = this.$route.params.id
        console.log(spotCheckId)
        let spotCheckResult = this.db.get('spot-check-result')
            .filter({'spot_check_application_form': spotCheckId})
            .cloneDeep()
            .value()
        let experts = []
        for (let id of spotCheckResult[0]['experts']) {
            let expert = this.db.get('expert')
                .filter({id: id})
                .cloneDeep()
                .value()
            experts.push(expert[0])
        }
        this.SET_TABLE_DATA(experts)
    },
    methods: {
        ...mapMutations([
            'SET_NAVBARNAME',
            'SET_SUBNAVBARNAME',
            'SET_TABLE_DATA'
        ]),
        back () {
            this.$router.back()
        }
    },
    components: {
        BasicModel
    }
}
</script>

<style scoped>
    #back {
        position: absolute;
        top: 16px;
        right: 26px;
    }
</style>
