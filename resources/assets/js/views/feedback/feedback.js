// 中间列表的数据
export default {
    system: [
        {
            key: 'feedback',
            tab: '日志',
            url: 'feedback',
            database: 'Feedback',
            theads: ['分类名称', '描述', '图标', '图片'],
            protos: ['name', 'desc', 'ico', 'img'],
            widths: [50, 50, 50, 50],
            formRows: {
                name: {
                    label: '分类名称',
                    rules: [
                        { required: true, message: '请输入分类名称', trigger: 'blur' },
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: '必填'
                },
                desc: {
                    label: '描述',
                    rules: [
                        { max: 255, message: '长度在 255 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'textarea',
                    placeholder: ''
                },
                ico: {
                    label: '图标',
                    rules: [
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: ''
                },
                img: {
                    label: '图片',
                    rules: [
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
                    ],
                    value: '',
                    type: 'input',
                    placeholder: ''
                }
            }
        }
    ]
}
