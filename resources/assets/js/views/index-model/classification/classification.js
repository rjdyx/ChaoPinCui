// 中间列表的数据
export default {
    classification: [
        {
            key: 'plantation',
            tab: '种植场',
            url: 'plantation',
            theads: ['种植场名称', '种植面积', '负责人', '联系电话', '详细地址', '图片', '备注信息'],
            protos: ['name', 'area', 'director', 'phone', 'address', 'img', 'memo'],
            widths: [50, 50, 50, 50, 50, 50, 50]
        },
        {
            key: 'planta',
            tab: '种植区',
            url: 'planta',
            theads: ['种植场名称', '种植区名称', '种植面积', '负责人', '联系电话', '地址', '图片', '备注'],
            protos: ['plantation_name', 'name', 'area', 'director', 'phone', 'address', 'img', 'memo'],
            widths: [50, 50, 50, 50, 50, 50, 50, 50]
        }
    ]
}
