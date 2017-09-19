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
            'SET_PAGINATOR',
            'ACT_DELETEACTIVE'
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
                await this.ACT_DELETEACTIVE(id)
                let result = this.db.get(url).remove({ id: id }).write()
                this.SPLICE_TABLE_DATA(index)
                // 更新记录数
                // 并判断本页数据是否删除光
                let num = require('projectRoot/env.js').num
                let db = this.db.get(url)
                    .filter(item => {
                        return item.name.indexOf(this.$store.state.basicModel.inputValue) > -1
                    })
                    .sortBy('created_at')
                    .reverse()
                    .cloneDeep()
                let total = db.size().value()
                let paginator = {
                    total: total,
                    per_page: require('projectRoot/env.js').num
                }
                if (!this.$store.state.basicModel.tableData.length) {
                    this.SET_TABLE_DATA(this.$paginator(db, this.$store.state.basicModel.currentPage - 1))
                }
                this.SET_TOTAL_NUM(total)
                this.SET_NUM(Math.round(total / num))
                this.SET_PAGINATOR(paginator)
                this.$message({
                    type: 'success',
                    message: '删除成功'
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
</script>

<style lang="scss">
.btn {
    span {
        border-left: 1px solid #a7bad6;
        padding: 0px 5px 0px 8px;
    }
}
</style>
