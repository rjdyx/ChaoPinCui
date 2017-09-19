// 中间列表的数据
import { phones, count } from 'utils/validate'
import Type from './type.vue'
import Status from './status.vue'
import DateFilter from 'components/form/date-filter'
import SpotCheckResult from './spot-check-result.vue'
export default {
    'spot-check-result': [
        {
            key: 'spot-check-result',
            tab: '抽取结果',
            url: 'spot-check-application-form',
            urlParams: {status: 1},
            theads: ['申请单位', '抽取时间', '项目名称', '项目类型', '开始时间', '结束时间', '专家人数', '文件依据', '专家报告时间', '报告地点', '评审单位名称', '申请单位联系人', '联系电话', '状态', '备注信息'],
            protos: ['application_unit', 'created_at', 'name', 'type', 'start_time', 'end_time', 'count', 'gist_file', 'report_time', 'address', 'review_unit', 'application_unit_contacts', 'phone', 'status', 'memo'],
            protosFilter: ['gist_file', 'report_time', 'address', 'review_unit', 'application_unit_contacts', 'phone', 'status'],
            widths: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50],
            showDetail: true,
            colComponents: {status: Status, type: Type, created_at: DateFilter, start_time: DateFilter, end_time: DateFilter, report_time: DateFilter},
            operateComponents: [{component: SpotCheckResult, params: {}}],
            showNewBuild: false,
            showDelete: false,
            showEdit: false
        }
    ]
}
