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
        name: '产品分类管理',
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
                path: '/index/feedback/feedback',
                name: '操作日志'
            }
        ]
    },
    {
        name: '专家管理',
        role: 'expert',
        children: [
            {
                path: '/index/expert/expert',
                name: '专家管理'
            }
        ]
    },
    {
        name: '申请管理',
        role: 'spot-check-application-form',
        children: [
            {
                path: '/index/spot-check-application-form/spot-check-application-form',
                name: '申请管理'
            }
        ]
    },
    {
        name: '抽取结果',
        role: 'spot-check-result',
        children: [
            {
                path: '/index/spot-check-result/spot-check-result',
                name: '抽取结果'
            }
        ]
    }
]
