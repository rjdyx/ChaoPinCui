/**
 * 左菜单栏数据
 */
export default [
    {
        name: '分类管理',
        role: 'category',
        isEvent: false,
        children: [
            {
                path: '/index/category/category',
                name: '分类管理'
            }
        ]
    },
    {
        name: '产品管理',
        role: 'product',
        children: [
            {
                path: '/index/product/product',
                name: '产品管理'
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
    // {
    //     name: '系统管理',
    //     role: 'system',
    //     isEvent: false,
    //     children: [
    //         {
    //             path: '/index/system/system',
    //             name: '系统管理'
    //         }
    //     ]
    // }
]
