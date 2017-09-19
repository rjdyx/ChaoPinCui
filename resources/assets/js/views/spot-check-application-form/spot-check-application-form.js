// 中间列表的数据
import { phones, count } from 'utils/validate'
import TypeRadio from './type-radio.vue'
import Type from './type.vue'
import Status from './status.vue'
import Count from './count.vue'
import DatePicker from 'components/form/date-picker'
import DateFilter from 'components/form/date-filter'
import SpotCheck from './spot-check'
import { addStatus } from './add-status'
export default {
    'spot-check-application-form': [
        {
            key: 'spot-check-application-form',
            tab: '申请管理',
            url: 'spot-check-application-form',
            urlParams: {status: 0},
            theads: ['申请单位', '申请时间', '项目名称', '项目类型', '开始时间', '结束时间', '专家人数', '文件依据', '专家报告时间', '报告地点', '评审单位名称', '申请单位联系人', '联系电话', '状态', '备注信息'],
            protos: ['application_unit', 'application_time', 'name', 'type', 'start_time', 'end_time', 'count', 'gist_file', 'report_time', 'address', 'review_unit', 'application_unit_contacts', 'phone', 'status', 'memo'],
            protosFilter: ['gist_file', 'report_time', 'address', 'review_unit', 'application_unit_contacts', 'phone', 'status'],
            widths: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50],
            showDetail: true,
            colComponents: {status: Status, type: Type, application_time: DateFilter, start_time: DateFilter, end_time: DateFilter, report_time: DateFilter},
            operateComponents: [{component: SpotCheck, params: {}}],
            formRows: {
                application_unit: {
                    label: '申请单位',
                    rules: [
                        { required: true, message: '请输入申请单位', trigger: 'blur' },
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                application_time: {
                    label: '申请时间',
                    component: DatePicker,
                    componentParam: {type: 'application_time', nowDate: true}
                },
                name: {
                    label: '项目名称',
                    rules: [
                        { required: true, message: '请输入项目名称', trigger: 'blur' },
                        { max: 140, message: '长度在 140 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                type: {
                    label: '项目类型',
                    rules: [
                        { type: 'number', required: true, message: '请选择项目类型', trigger: 'change' }
                    ],
                    value: '',
                    component: TypeRadio
                },
                start_time: {
                    label: '开始时间',
                    component: DatePicker,
                    componentParam: {type: 'start_time', nowDate: true}
                },
                end_time: {
                    label: '结束时间',
                    component: DatePicker,
                    componentParam: {type: 'end_time', nowDate: true}
                },
                count: {
                    label: '专家人数',
                    rules: [
                        { type: 'number', required: true, message: '请输入专家人数', trigger: 'change' },
                        { validator: count }
                    ],
                    value: 1,
                    component: Count
                },
                gist_file: {
                    label: '文件依据',
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                report_time: {
                    label: '专家报告时间',
                    component: DatePicker,
                    componentParam: {type: 'report_time', nowDate: true}
                },
                address: {
                    label: '报告地址',
                    rules: [
                        { required: true, message: '请输入报告地址', trigger: 'blur' },
                        { max: 140, message: '长度在 140 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                review_unit: {
                    label: '评审单位名称',
                    rules: [
                        { required: true, message: '请输入评审单位名称', trigger: 'blur' },
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                application_unit_contacts: {
                    label: '申请单位联系人',
                    rules: [
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input'
                },
                phone: {
                    label: '联系电话',
                    rules: [
                        { validator: phones }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                memo: {
                    label: '备注信息',
                    rules: [
                        { max: 255, message: '长度在 255 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'textarea',
                    placeholder: '必填'
                }
            },
            addActive: addStatus
        }
    ]
}
