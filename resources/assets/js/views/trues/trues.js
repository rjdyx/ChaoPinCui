// 中间列表的数据
import Img from '../../components/public/img.vue'
import inputFile from 'components/public/inputFile.vue'
import productSelect from './product-select.vue'
export default {
    trues: [
        {
            key: 'trues',
            tab: '广告图',
            url: 'turn',
            database: 'True',
            theads: ['链接产品', '链接', '状态', '图片', '排序'],
            protos: ['product_name', 'url', 'state', 'img', 'sort'],
            protosFilter: ['url'],
            widths: [50, 50, 50, 50],
            colComponents: {img: Img},
            searchPlaceholder: '请输入用户名搜索',
            formRows: {
                product_id: {
                    label: '产品',
                    rules: [{required: true, message: '请选择产品'}],
                    placeholder: '请选择产品',
                    component: productSelect 
                },
                url: {
                    label: '外链URL',
                    rules: [{required: false, message: '请输入链接', trigger: 'blur'}],
                    value: '',
                    type: 'input',
                    placeholder: '请输入链接'
                },
                sort: {
                    label: '排序',
                    rules: [{required: true, message: '请输入正整数', trigger: 'blur'}],
                    value: '100',
                    type: 'input',
                    placeholder: '请输入正整数'
                },
                state: {
                    label: '状态',
                    rules: [
                        { required: true, message: '请选择状态', trigger: 'blur', type: 'number' },
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur', type: 'number' }
                    ],
                    options: [{name: '开启', num: 1}, {name: '关闭', num: 0}],
                    optionLabel: 'name',
                    optionValue: 'num',
                    type: 'select'
                },
                img: {
                    label: '图片',
                    rules: [{required: false, message: '请上传图片', trigger: 'blur'}],
                    value: '',
                    component: inputFile,
                    placeholder: '请上传图片'
                }
            }
        }
    ]
}
