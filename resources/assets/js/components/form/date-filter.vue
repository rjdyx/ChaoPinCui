/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		{{date}}
	</div>
</template>

<script>
export default {
    name: 'Date',
    props: {
        scope: {
            type: Object,
            default () {
                return {}
            }
        },
        prop: {
            type: String,
            default: ''
        }
    },
    computed: {
        date () {
            let date = new Date(this.scope.row[this.prop] * 1000)
            let year = date.getFullYear()
            let month = date.getMonth() + 1
            let day = date.getDate()
            return year + '-' + month + '-' + day
        }
    }
}
</script>
