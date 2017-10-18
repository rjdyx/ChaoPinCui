/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		{{sex}}
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
        }
    },
    data () {
        return {
            sex: ''
        }
    },
    methods: {
        getRow () {
            if (this.scope.sex === 0) {
                this.sex = '保密'
            } else if (this.scope.sex === 1) {
                this.sex = '男'
            } else {
                this.sex = '女'
            }
        }
    },
    mounted () {
        this.getRow()
    },
    watch: {
        scope () {
            this.getRow()
        }
    }
}
</script>
