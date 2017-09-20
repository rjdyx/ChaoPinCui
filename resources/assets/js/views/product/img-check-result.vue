/**
 * 跳转图片详情页组件
 * @description 
 * @author 郭森林
 * @date 2017/09/20
 * 
 */
<template>
	<div>
		<el-button 
            type="text" 
            size="small"
            @click="SpotCheck"
        >图片</el-button>
	</div>
</template>

<script>
import { mapMutations } from 'vuex'
export default {
    name: 'ImgCheckResult',
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
            this.$router.push('/index/product-img/' + this.scope.row.id)
        }
    }
}
</script>
