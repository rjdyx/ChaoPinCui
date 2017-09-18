/**
 * 左菜单栏数据
 */
export default [
    {
        name: '账户管理',
        role: 'user',
        children: [
            {
                path: '/index/user/user',
                name: '账户管理'
            }
        ]
    },
    {
        name: '单位管理',
        role: 'unit',
        children: [
            {
                path: '/index/unit/unit',
                name: '单位管理'
            }
        ]
    },
    {
        name: '分类管理',
        role: 'classification',
        isEvent: false,
        children: [
            {
                path: '/index/classification/classification',
                name: '分类管理'
            }
        ]
    },
    {
        name: '系统管理',
        role: 'system',
        isEvent: false,
        children: [
            {
                path: '/index/system/system',
                name: '系统管理'
            }
        ]
    }
]
