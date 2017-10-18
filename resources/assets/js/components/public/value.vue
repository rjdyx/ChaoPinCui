/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		{{scope[prop]}}
	</div>
</template>

<script>
export default {
    name: 'Sex',
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
    }
}
</script>
