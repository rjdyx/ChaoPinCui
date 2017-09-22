/**
 * 左菜单栏数据
 */
export default [
    {
        name: '用户管理',
        role: 'user',
        // isEvent: false,
        children: [
            {
                path: '/index/user/user',
                name: '用户管理'
            }
        ]
    },
    {
        name: '特色管理',
        role: 'category',
        // isEvent: false,
        children: [
            {
                path: '/index/category/category',
                name: '分类管理'
            },
            {
                path: '/index/product/product',
                name: '产品管理'
            }
        ]
    },
    {
        name: '系统管理',
        role: 'system',
        children: [
            {
                path: '/index/system/system',
                name: '系统配置'
            },
            {
                path: '/index/feedback/feedback',
                name: '意见反馈'
            },
            {
                path: '/index/log/log',
                name: '操作日志'
            }
        ]
    }
]
