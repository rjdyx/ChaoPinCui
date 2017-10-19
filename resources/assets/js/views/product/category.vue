/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 * 修改：
 * (1)新增allCategory,获取categoryname时不再使用异步请求
 */
<template>
	<div>
		{{category_name}}
	</div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    name: 'Category',
    props: {
        scope: {
            type: Object,
            default () {
                return {}
            }
        }
    },
    computed: {
        ...mapGetters(['allCategory'])
    },
    data () {
        return {
            category_name: ''
        }
    },
    mounted () {
        this.update()
    },
    watch: {
        scope () {
            this.update()
        },
        allCategory () {
            this.update()
        }
    },
    methods: {
        update () {
            this.allCategory.forEach(cate => {
                for (let child in cate.children) {
                    if (cate.children[child].id === this.scope.category_id) {
                        this.category_name = cate.children[child].name
                    }
                }
            })
        }
    }
}
</script>
