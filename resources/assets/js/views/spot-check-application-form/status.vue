/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		{{scope.row.status === 1?'已抽取':'未抽取'}}
	</div>
</template>

<script>
export default {
    name: 'Status',
    props: {
        scope: {
            type: Object,
            default () {
                return {}
            }
        }
    }
}
</script>
