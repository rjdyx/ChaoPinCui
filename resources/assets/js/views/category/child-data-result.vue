/**
 * 跳转子类详情页组件
 * @description 
 * @author 郭森林
 * @date 2017/09/20
 * 
 */

<script>
export default {
    name: 'childDataResult',
    props: {
        scope: {
            type: Object,
            default () {
                return {}
            }
        }
    },
    methods: {
    },
    mounted () {
        let url = 'api/get/table'
        let params = {tname: 'categories', pid: this.scope.id}
        axios.get(url, params).then((res) => {
            if (res.data.length > 0) {
                return true
            } else {
                return false
            }
        })
    }
}
</script>
