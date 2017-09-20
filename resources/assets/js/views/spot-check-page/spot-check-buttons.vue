/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
        <el-button type="primary" @click="spotCheck">随机抽取</el-button>
        <el-button type="warning" @click="resect">重置结果</el-button>
        <el-button type="success" @click="submit">提交结果</el-button>
        <el-button type="danger" icon="delete" @click="handelDel">批量删除</el-button>
	</div>
</template>

<script>
import { mapMutations } from 'vuex'
export default {
    name: 'SpotCheckButtons',
    data () {
        return {
            id: this.$route.params.id,
            count: this.$route.params.count,
            recycle: []
        }
    },
    computed: {
        flag () {
            return this.$store.state.spotCheck.isFilter
        },
        selects () {
            return this.$store.state.spotCheck.selects
        }
    },
    mounted () {
        // console.log(this.id)
        // console.log(this.count)
    },
    methods: {
        ...mapMutations([
            'SET_TABLE_DATA',
            'PUSH_TABLE_DATA'
        ]),
        getRandam (max, total) {
            let result = []
            for (let i = 0; i < total; i++) {
                let tmp = Math.round(Math.random() * (max - 1) + 1)
                if (result.includes(tmp)) {
                    i--
                    continue
                } else {
                    result.push(tmp)
                }
            }
            return result
        },
        spotCheck () {
            this.SET_TABLE_DATA([])
            let db = this.db.get('expert')
                .filter(item => {
                    if (!this.selects.length) {
                        return true
                    } else if (item.classification) {
                        return !this.flag ? this.selects.includes(item.classification) : !this.selects.includes(item.classification)
                    } else {
                        return false
                    }
                })
                .sortBy('created_at')
                .reverse()
                .cloneDeep()
            let max = db.size()
            let selectExperts = db.value()
            if (selectExperts.length) {
                this.$deleteArrayWith(selectExperts, this.recycle, 'id')
                let ramdamNumbers = this.getRandam(max, this.count)
                for (let index of ramdamNumbers) {
                    this.PUSH_TABLE_DATA(selectExperts[index - 1])
                }
            }
        },
        resect () {
            this.SET_TABLE_DATA([])
            this.$set(this, 'recycle', [])
        },
        submit () {
            let tableData = this.$deepClone(this.$store.state.basicModel.tableData)
            if (!tableData.length) {
                this.$message({
                    type: 'info',
                    message: '请先随机抽取'
                })
                return
            }
            this.$confirm('提交后无法修改，确认提交抽取结果？', '信息', {
                cancelButtonText: '取消',
                confirmButtonText: '确定',
                type: 'error'
            }).then(() => {
                // 修改申请表状态
                let spotCheckDB = this.db.get('spot-check-application-form')
                    .find({ id: this.id })
                    .assign({status: 1})
                    .write()
                let experts = []
                for (let item of tableData) {
                    experts.push(item.id)
                }
                let spotResult = {}
                let timestamp = Math.round(new Date().getTime() / 1000)
                spotResult['id'] = this.uuid()
                spotResult['created_at'] = timestamp
                spotResult['spot_check_application_form'] = this.id
                spotResult['experts'] = experts
                this.db.get('spot-check-result')
                    .push(spotResult)
                    .write()
                this.$message({
                    type: 'success',
                    message: '提交成功'
                })
                this.$router.push('/index/spot-check-result/spot-check-result')
            })
        },
        handelDel () {
            let select = this.$deepClone(this.$store.state.basicModel.selectData)
            if (!select.length) {
                this.$message({
                    type: 'info',
                    message: '请选择删除对象'
                })
                return
            }
            this.$confirm('被删除的数据不会再出现在这轮抽取中，确定删除?（重置结果后删除的数据才能继续参与抽取）', '信息', {
                cancelButtonText: '取消',
                confirmButtonText: '确定',
                type: 'error'
            }).then(() => {
                this.$set(this, 'recycle', select)
                let target = this.$deepClone(this.$store.state.basicModel.tableData)
                let result = this.$deleteArrayWith(target, select, 'id')
                this.SET_TABLE_DATA(this.$reverseObj(result, 'created_at'))
                this.$message({
                    type: 'success',
                    message: '删除成功'
                })
            })
        }
    }
}
</script>
