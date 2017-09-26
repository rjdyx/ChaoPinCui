/**
 * 跳转评论详情页组件
 * @description 
 * @author 郭森林
 * @date 2017/09/26
 * 
 */
<template>
	<div>
		<el-button 
            type="text" 
            size="small"
            @click="SpotCheck"
        >评论</el-button>
	</div>
</template>

<script>
import { mapMutations } from 'vuex'
export default {
    name: 'CommentCheckResult',
    props: {
        scope: {
            type: Object,
            default () {
                return {}
            }
        },
        model: {
            type: Object,
            default () {
                return {}
            }
        }
    },
    methods: {
        ...mapMutations([
            'SET_TABLE_DATA'
        ]),
        SpotCheck () {
            this.SET_TABLE_DATA([])
            this.$router.push('/index/product-comment/' + this.scope.row.id)
        }
    }
}
</script>
