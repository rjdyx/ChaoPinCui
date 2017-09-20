/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		<el-select v-model="select" id="el-select" @change="change" placeholder="请选择分类">
            <el-option 
                v-for="(classification, index) in classifications" 
                :label="classification.name" 
                :value="classification.id"
                :key="index">
            </el-option>
        </el-select>
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
            classifications: [],
            select: ''
        }
    },
    mounted () {
        this.select = this.scope.row.classification
        this.classifications = this.db.get('classification')
            .sortBy('created_at')
            .reverse()
            .cloneDeep()
            .value()
    },
    watch: {
        dialogTableVisible () {
            this.select = this.scope.row.classification === '' ? '' : this.scope.row.classification
        }
    },
    methods: {
        change () {
            this.$emit('emit', {pro: 'classification', val: this.select})
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
