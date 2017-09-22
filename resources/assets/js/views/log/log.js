// 中间列表的数据
export default {
    log: [
        {
            key: 'log',
            tab: '操作日志',
            url: 'log',
            database: 'Log',
            theads: ['模块名称', '操作行为', '操作用户', '客户端ip地址', '操作时间'],
            protos: ['name', 'operate', 'user_name', 'ip', 'created_at'],
            widths: [50, 50, 50, 50, 50],
            showNewBuild: false,
            showEdit: false,
            searchPlaceholder: '请输入操作模块搜索'
        }
    ]
}
