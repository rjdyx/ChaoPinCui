// 中间列表的数据
import CategorySelect from './category-select.vue'
import Category from './category.vue'
import ImgDetails from './img-check-result.vue'
import inputFile from '../../components/public/inputFile.vue'
export default {
    product: [
        {
            key: 'product',
            tab: '产品',
            url: 'product',
            database: 'Product',
            theads: ['产品名称', '分类', '描述', '图片', '缩略图', '地址', '经度', '纬度', '关注度', '好评率'],
            protos: ['name', 'category_name', 'desc', 'img', 'thumb', 'address', 'meridian', 'weft', 'heat', 'comment'],
            protosFilter: ['img', 'thumb', 'weft', 'heat', 'comment'],
            widths: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50],
            showDetail: true,
            // colComponents: {category_id: Category},
            operateComponents: [{component: ImgDetails, params: {}}],
            formRows: {
                name: {
                    label: '产品名称',
                    rules: [
                        { required: true, message: '请输入产品名称', trigger: 'blur' },
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                category_id: {
                    label: '分类',
                    rules: [
                        { required: true, message: '请选择分类' }
                    ],
                    component: CategorySelect
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
                address: {
                    label: '地址',
                    rules: [
                        { required: true, message: '请输入地址', trigger: 'blur' },
                        { max: 100, message: '长度在 100 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: ''
                },
                meridian: {
                    label: '经度',
                    rules: [
                        { max: 30, message: '长度在 30 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: ''
                },
                weft: {
                    label: '纬度',
                    rules: [
                        { max: 30, message: '长度在 30 个字符以内', trigger: 'blur' }
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
                thumb: {
                    label: '缩略图',
                    rules: [],
                    value: '',
                    component: inputFile,
                    placeholder: ''
                }
            }
        }
    ]
}
