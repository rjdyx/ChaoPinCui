/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		<el-radio-group v-model="sex" @change="change">
            <el-radio-button :label="1">男</el-radio-button>
            <el-radio-button :label="0">女</el-radio-button>
        </el-radio-group>
	</div>
</template>

<script>
export default {
    name: 'SexRadio',
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
            sex: ''
        }
    },
    mounted () {
        this.sex = this.row.value
    },
    watch: {
        dialogTableVisible () {
            this.sex = this.row.value === '' ? '' : this.row.value
        }
    },
    methods: {
        change () {
            this.$emit('emit', {pro: 'sex', val: this.sex})
        }
    }
}
</script>

<style lang="sass">
.btn {
    span {
        border-left: 1px solid #a7bad6;
        padding: 0px 5px 0px 8px;
    }
}
</style>
