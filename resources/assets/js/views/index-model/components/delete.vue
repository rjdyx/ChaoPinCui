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
            type="text" 
            size="small" 
            @click="handelDel(scope.$index, scope.row)"
        >删除</el-button>
	</div>
</template>

<script>
import { mapMutations } from 'vuex'
export default {
    name: 'Edit',
    props: {
        scope: {
            type: Object,
            default () {
                return {}
            }
        },
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
            'SPLICE_TABLE_DATA',
            'SET_TOTAL_NUM',
            'SET_NUM',
            'SET_PAGINATOR'
        ]),
        // 点击删除
        handelDel (index, row) {
            let id = row.id
            let url = this.model.url
            this.$confirm('你确定要删除该信息吗?', '信息', {
                cancelButtonText: '取消',
                confirmButtonText: '确定',
                type: 'error'
            }).then(async () => {
                await this.$ACT_DELETEACTIVE({vm: this, id: id})
                axios.delete(this.$adminUrl(url) + '/' + id)
                    .then((response) => {
                        if (response.data === 0) {
                            this.$message({
                                message: '删除失败',
                                type: 'error'
                            })
                        } else if (response.data === -1) {
                            this.$message({
                                type: 'error',
                                message: '已被使用，无法删除'
                            })
                        } else if (response.data === 'self') {
                            this.$message({
                                type: 'error',
                                message: '无法删除自身用户数据'
                            })
                        } else if (response.data === 'notallow') {
                            this.$message({
                                type: 'error',
                                message: '同级用户，没有删除操作权限'
                            })
                        } else {
                            this.$message({
                                message: '删除成功',
                                type: 'success'
                            })
                            this.SPLICE_TABLE_DATA(index)
                        }
                    })
            }).catch((e) => {
                this.$message({
                    type: 'info',
                    message: '已取消删除'
                })
            })
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
