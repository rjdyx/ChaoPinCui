/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		<el-input
            v-model="count"
            placeholder="请输入专家人数"
            @blur="change"
        ></el-input>
	</div>
</template>

<script>
export default {
    name: 'Count',
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
            experts: 0,
            count: ''
        }
    },
    mounted () {
        this.count = this.row.value
        this.experts = this.db.get('expert').cloneDeep().size().value()
    },
    watch: {
        dialogTableVisible () {
            this.count = ''
        }
    },
    methods: {
        change () {
            if (this.count > this.experts) {
                this.$emit('emit', {pro: 'count', val: 'error'})
            } else {
                this.$emit('emit', {pro: 'count', val: parseInt(this.count)})
            }
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
