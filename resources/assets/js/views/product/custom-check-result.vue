/**
 * 跳转参数详情页组件
 * @description 
 * @author 郭森林
 * @date 2017/09/21
 * 
 */
<template>
	<div @click="SpotCheck">
		<el-button 
            type="text" 
            size="small"
        >参数</el-button>
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
            this.$router.push('/index/product-custom')
            localStorage.setItem('detailId', this.scope.id)
        }
    }
}
</script>
