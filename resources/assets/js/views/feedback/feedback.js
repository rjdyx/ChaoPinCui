// 中间列表的数据
import Img from '../../components/public/img.vue'
export default {
    feedback: [
        {
            key: 'feedback',
            tab: '用户反馈',
            url: 'feedback',
            database: 'Feedback',
            theads: ['反馈用户', '反馈内容', '反馈图片'],
            protos: ['user_name', 'content', 'img'],
            widths: [50, 50, 50],
            showNewBuild: false,
            showEdit: false,
            searchPlaceholder: '请输入反馈用户搜索',
            colComponents: {img: Img}
        }
    ]
}
