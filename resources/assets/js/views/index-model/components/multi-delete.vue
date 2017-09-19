/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		<el-button 
            type="danger" 
            icon="delete" 
            @click="handelDel"
        >批量删除</el-button>
	</div>
</template>

<script>
import { mapMutations } from 'vuex'
export default {
    name: 'Edit',
    props: {
        model: {
            type: Object,
            default () {
                return {}
            }
        }
    },
    methods: {
        ...mapMutations([
            'SET_TABLE_DATA',
            'SET_SELECT_DATA',
            'SPLICE_TABLE_DATA',
            'SET_TOTAL_NUM',
            'SET_NUM',
            'SET_PAGINATOR',
            'ACT_DELETEACTIVE'
        ]),
        // 点击删除
        handelDel () {
            let database = this.model.database
            let select = this.$deepClone(this.$store.state.basicModel.selectData)
            if (!select.length) {
                this.$message({
                    type: 'info',
                    message: '请选择删除项目'
                })
            } else {
                this.$confirm('你确定要批量删除选中信息吗?', '信息', {
                    cancelButtonText: '取消',
                    confirmButtonText: '确定',
                    type: 'error'
                }).then(async () => {
                    for (let item of select) {
                        await this.ACT_DELETEACTIVE(item.id)
                    }
                    let ids = []
                    for (let item of select) {
                        ids.push(item.id)
                    }
                    console.log(ids)
                    axios.delete(this.$adminUrl('deletes'), {data: {tname: database, ids: ids}})
                        .then((response) => {
                            if (response.data) {
                                this.$message({
                                    message: '删除成功',
                                    type: 'success'
                                })
                                let target = this.$deepClone(this.$store.state.basicModel.tableData)
                                let result = this.$deleteArrayWith(target, select, 'id')
                                this.SET_TABLE_DATA(result)
                            }
                        })
                }).catch((e) => {
                    if (e.message === '被引用') {
                        this.$message({
                            type: 'error',
                            message: '分类被使用，无法删除'
                        })
                    } else {
                        this.$message({
                            type: 'info',
                            message: '已取消删除'
                        })
                    }
                })
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
