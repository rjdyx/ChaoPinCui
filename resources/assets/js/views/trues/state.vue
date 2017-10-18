/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
        {{scope.state !== 0 ? '开启':'关闭'}}
	</div>
</template>

<script>
export default {
    name: 'Type',
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
