// 中间列表的数据
import { cellphone } from 'utils/validate'
import SexRadio from './sex-radio.vue'
import Sex from './sex.vue'
import Type from './type.vue'
import Img from '../../components/public/img.vue'
import { editCallBack } from './edit-callback'
import DatePicker from 'components/form/date-picker'
import inputFile from 'components/public/inputFile.vue'
export default {
    user: [
        {
            key: 'user',
            tab: '用户',
            url: 'user',
            database: 'User',
            theads: ['用户名', '姓名', '性别', '出生年月日', '用户类型', '邮箱', '手机', '住址', '头像'],
            protos: ['name', 'real_name', 'sex', 'age', 'type', 'email', 'phone', 'address', 'img'],
            widths: [50, 50, 50, 50, 50, 50, 50, 50, 50],
            colComponents: {sex: Sex, type: Type, img: Img},
            formRows: {
                name: {
                    label: '用户名',
                    rules: [
                        { required: true, message: '请输入用户名', trigger: 'blur' },
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                real_name: {
                    label: '姓名',
                    rules: [
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: ''
                },
                sex: {
                    label: '性别',
                    rules: [
                        { type: 'number', required: true, message: '请选择性别', trigger: 'change' }
                    ],
                    value: '',
                    component: SexRadio
                },
                age: {
                    label: '出生年月日',
                    component: DatePicker,
                    componentParam: {type: 'age', nowDate: true}
                },
                type: {
                    label: '用户类型',
                    rules: [
                        { required: true, message: '请选择用户类型', trigger: 'blur', type: 'number' },
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur', type: 'number' }
                    ],
                    options: [{name: '普通用户', num: 0}, {name: '管理员', num: 1}],
                    optionLabel: 'name',
                    optionValue: 'num',
                    type: 'select'
                },
                email: {
                    label: '邮箱',
                    rules: [
                        { required: true, message: '请输入邮箱', trigger: 'blur' },
                        { type: 'email', message: '请输入正确邮箱格式', trigger: 'blur' },
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: ''
                },
                phone: {
                    label: '手机',
                    rules: [
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' },
                        { validator: cellphone }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: ''
                },
                address: {
                    label: '住址',
                    rules: [
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: ''
                },
                img: {
                    label: '头像',
                    rules: [],
                    value: '',
                    component: inputFile,
                    placeholder: ''
                }
            },
            editedActive: editCallBack
        }
    ]
}
