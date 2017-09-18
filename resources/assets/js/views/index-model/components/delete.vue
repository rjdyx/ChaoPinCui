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
            :class="{'btn':hiddeRole}" 
            @click="handelDel(scope.$index,scope.row)"
        >删除</el-button>
	</div>
</template>

<script>
export default {
    name: 'Edit',
    props: {
        scope: {
            type: Object,
            default () {
                return {}
            }
        },
        hiddeRole: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        // 点击删除
        handelDel (index, row) {
            this.$confirm('你确定要删除该信息吗?', '信息', {
                cancelButtonText: '取消',
                confirmButtonText: '确定',
                type: 'error'
            }).then(() => {
                axios.delete(this.$adminUrl(this.url + '/' + row.id))
                    .then((responce) => {
                        if (responce.data === 'true') {
                            this.$message({
                                type: 'success',
                                message: '删除成功'
                            })
                        } else if (responce.data === 'state') {
                            this.$message('该数据已被使用，无法删除')
                        }
                    })
            }).catch(() => {
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
