// 中间列表的数据
import { phones } from 'utils/validate'
import ClassificationSelect from './classification-select.vue'
import Classification from './classification.vue'
import SexRadio from './sex-radio.vue'
import Sex from './sex.vue'
import DatePicker from 'components/form/date-picker'
import DateFilter from 'components/form/date-filter'
export default {
    expert: [
        {
            key: 'expert',
            tab: '专家管理',
            url: 'expert',
            theads: ['分类', '专家姓名', '性别', '出生年月', '籍贯', '民族', '政治面貌', '文化程度', '学位', '毕业学校', '毕业时间', '专业', '职务', '职称', '工作时间', '联系电话', '邮箱', '特长', '专家简历', '专家意见', '备注'],
            protos: ['classification', 'name', 'sex', 'birthday', 'native_place', 'nation', 'political_status', 'education', 'degree', 'graduation_school', 'graduation_time', 'major', 'duty', 'title', 'work_time', 'phone', 'email', 'speciality', 'resume', 'opinion', 'memo'],
            protosFilter: ['birthday', 'native_place', 'nation', 'political_status', 'education', 'degree', 'graduation_school', 'graduation_time', 'work_time', 'resume', 'opinion', 'memo'],
            widths: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50],
            showDetail: true,
            colComponents: {classification: Classification, sex: Sex, birthday: DateFilter, graduation_time: DateFilter, work_time: DateFilter},
            formRows: {
                classification: {
                    label: '分类',
                    rules: [
                        { required: true, message: '请选择分类' }
                    ],
                    component: ClassificationSelect
                },
                name: {
                    label: '专家姓名',
                    rules: [
                        { required: true, message: '请输入专家姓名' },
                        { max: 50, message: '长度在 50 个字符以内' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                sex: {
                    label: '性别',
                    rules: [
                        { type: 'number', required: true, message: '请选择性别', trigger: 'change' }
                    ],
                    value: '',
                    component: SexRadio
                },
                native_place: {
                    label: '籍贯',
                    rules: [
                        { required: true, message: '请输入籍贯' },
                        { max: 140, message: '长度在 140 个字符以内' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                nation: {
                    label: '民族',
                    rules: [
                        { required: true, message: '请输入民族' },
                        { max: 10, message: '长度在 10 个字符以内' }
                    ],
                    value: '汉',
                    type: 'input',
                    placeholder: '必填'
                },
                political_status: {
                    label: '政治面貌',
                    rules: [
                        { required: true, message: '请输入政治面貌' },
                        { max: 10, message: '长度在 10 个字符以内' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                education: {
                    label: '文化程度',
                    rules: [
                        { required: true, message: '请输入文化程度' },
                        { max: 10, message: '长度在 10 个字符以内' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                birthday: {
                    label: '出生年月',
                    component: DatePicker,
                    componentParam: {type: 'birthday', nowDate: true}
                },
                degree: {
                    label: '学位',
                    rules: [
                        { max: 140, message: '长度在 140 个字符以内' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                graduation_school: {
                    label: '毕业学校',
                    rules: [
                        { max: 140, message: '长度在 140 个字符以内' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                graduation_time: {
                    label: '毕业时间',
                    component: DatePicker,
                    componentParam: {type: 'graduation_time', nowDate: false}
                },
                major: {
                    label: '专业',
                    rules: [
                        { max: 140, message: '长度在 140 个字符以内' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                duty: {
                    label: '职务',
                    rules: [
                        { max: 140, message: '长度在 140 个字符以内' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                title: {
                    label: '职称',
                    rules: [
                        { max: 140, message: '长度在 140 个字符以内' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                work_time: {
                    label: '工作时间',
                    component: DatePicker,
                    componentParam: {type: 'work_time', nowDate: false}
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
                email: {
                    label: '邮箱',
                    rules: [
                        { type: 'email', message: '请输入正确的邮箱地址' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                speciality: {
                    label: '特长',
                    rules: [
                        { max: 140, message: '长度在 140 个字符以内' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                resume: {
                    label: '专家简历',
                    rules: [
                        { max: 140, message: '长度在 140 个字符以内' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                opinion: {
                    label: '专家意见',
                    rules: [
                        { max: 140, message: '长度在 140 个字符以内' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                memo: {
                    label: '备注信息',
                    rules: [
                        { max: 255, message: '长度在 255 个字符以内' }
                    ],
                    value: '',
                    type: 'textarea',
                    placeholder: '必填'
                }
            }
        }
    ]
}
