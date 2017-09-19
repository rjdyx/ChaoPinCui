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
                v-for="(category, index) in categories" 
                :label="category.name" 
                :value="category.id"
                :key="index">
            </el-option>
        </el-select>
	</div>
</template>

<script>
export default {
    name: 'CategorySelect',
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
            categories: [],
            select: ''
        }
    },
    mounted () {
        this.select = this.scope.row.category_id
        axios.get(this.$adminUrl('category'))
            .then((response) => {
                if (response.status === 200) {
                    this.$set(this, 'categories', response.data.data)
                }
            })
    },
    watch: {
        dialogTableVisible () {
            this.select = this.scope.row.category_id === '' ? '' : this.scope.row.category_id
        }
    },
    methods: {
        change () {
            this.$emit('emit', {pro: 'category_id', val: this.select})
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
