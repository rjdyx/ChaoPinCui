/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		<el-radio-group v-model="type" @change="change">
            <el-radio-button :label="0">审批</el-radio-button>
            <el-radio-button :label="1">验收</el-radio-button>
        </el-radio-group>
	</div>
</template>

<script>
export default {
    name: 'TypeRadio',
    props: {
        scope: {
            type: Object,
            default () {
                return {}
            }
        },
        row: {
            type: Object,
            default () {
                return {}
            }
        },
        dialogTableVisible: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            type: 0
        }
    },
    mounted () {
        this.type = this.row.value
    },
    watch: {
        dialogTableVisible () {
            this.type = this.row.value === '' ? '' : this.row.value
        }
    },
    methods: {
        change () {
            this.$emit('emit', {pro: 'type', val: this.type})
        }
    }
}
</script>

<style lang="scss">
.btn {
    span {
        border-left: 1px solid #a7bad6;
        padding: 0px 5px 0px 8px;
    }
}
</style>
