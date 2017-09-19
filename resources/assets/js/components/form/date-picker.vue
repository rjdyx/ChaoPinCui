/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
    <div>
        <el-date-picker
            v-model="date"
            type="date"
            placeholder="选择日期"
            @change="change">
        </el-date-picker>
    </div>
</template>

<script>
export default {
    name: 'DatePicker',
    props: {
        dialogTableVisible: {
            type: Boolean,
            default: false
        },
        isEdit: {
            type: Boolean,
            default: false
        },
        scope: {
            type: Object,
            default () {
                return {}
            }
        },
        componentParam: {
            type: Object,
            default () {
                return {}
            }
        }
    },
    data () {
        return {
            date: ''
        }
    },
    mounted () {
        this.setTime()
    },
    watch: {
        dialogTableVisible () {
            this.setTime()
        }
    },
    methods: {
        change (val) {
            let timestamp = Math.round(new Date(val).getTime() / 1000)
            this.$emit('emit', {pro: this.componentParam.type, val: timestamp})
        },
        getDate (time) {
            let date = time ? new Date(time) : new Date()
            let year = date.getFullYear()
            let month = date.getMonth() + 1
            let day = date.getDate()
            return year + '-' + month + '-' + day
        },
        setTime () {
            if (!this.dialogTableVisible) return
            let value = this.scope.row[this.componentParam.type]
            if ((this.componentParam.nowDate && !value) || !this.isEdit) {
                this.date = this.getDate()
            } else {
                this.date = this.getDate(value * 1000)
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
