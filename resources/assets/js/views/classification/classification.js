// 中间列表的数据
export default {
    classification: [
        {
            key: 'classification',
            tab: '分类',
            url: 'classification',
            theads: ['分类名称', '备注信息'],
            protos: ['name', 'memo'],
            widths: [50, 50],
            formRows: {
                name: {
                    label: '分类名',
                    rules: [
                        { required: true, message: '请输入分类名称', trigger: 'blur' },
                        { max: 50, message: '长度在 50 个字符以内', trigger: 'blur' }
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
            }
        }
    ]
}
