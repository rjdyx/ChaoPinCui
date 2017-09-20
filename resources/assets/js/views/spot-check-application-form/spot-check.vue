/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		<el-button 
            type="text" 
            size="small"
            @click="SpotCheck"
        >抽取</el-button>
	</div>
</template>

<script>
import { mapMutations } from 'vuex'
export default {
    name: 'SpotCheck',
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
            this.$router.push('/index/spot-check-page/' + this.scope.row.id + '/' + this.scope.row.count)
        }
    }
}
</script>
