// 中间列表的数据
import { reInteger } from 'utils/validate'
import State from './state.vue'
import productSelect from './product-select.vue'
import productIndex from './product-index'
export default {
    trues: [
        {
            key: 'trues',
            tab: '广告图',
            url: 'turn',
            database: 'Turn',
            theads: ['链接产品', '状态', '排序'],
            protos: ['product_name', 'state', 'sort'],
            showDetail: true,
            widths: [120, 120, 120],
            colComponents: {state: State},
            searchPlaceholder: '请输入链接产品搜索',
            formRows: {
                product_id: {
                    label: '产品',
                    rules: [{required: true, message: '请选择产品'}],
                    placeholder: '请选择产品',
                    component: productSelect 
                },
                sort: {
                    label: '排序',
                    rules: [
                        {required: true, message: '请输入排序'},
                        {validator: reInteger}
                    ],
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
                }
            }
        }
    ]
}
