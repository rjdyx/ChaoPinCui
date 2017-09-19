/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
        <el-select 
            v-if="!flag"
            v-model="select" 
            filterable 
            multiple 
            placeholder="请选择专家分类">
            <el-option
            v-for="item in experts"
            :key="item.value"
            :label="item.name"
            :value="item.id">
            </el-option>
        </el-select>
        <el-select 
            v-else
            v-model="filter" 
            filterable 
            multiple 
            placeholder="请选择过滤的分类">
            <el-option
            v-for="item in experts"
            :key="item.value"
            :label="item.name"
            :value="item.id">
            </el-option>
        </el-select>
        <el-button @click="triggle">
            <span v-if="!flag">切换为过滤</span>
            <span v-else>切换为选中</span>
        </el-button>
	</div>
</template>

<script>
import { mapMutations } from 'vuex'
export default {
    name: 'FilterSelect',
    data () {
        return {
            select: [],
            filter: [],
            experts: []
        }
    },
    computed: {
        flag () {
            return this.$store.state.spotCheck.isFilter
        }
    },
    watch: {
        select () {
            this.SET_SELECTS(this.select)
        },
        filter () {
            this.SET_SELECTS(this.filter)
        }
    },
    mounted () {
        this.experts = this.db.get('classification').cloneDeep().value()
    },
    methods: {
        ...mapMutations([
            'SET_SELECTS',
            'SET_IS_FILTER'
        ]),
        triggle () {
            this.SET_IS_FILTER(!this.flag)
            if (!this.flag) {
                this.SET_SELECTS(this.select)
            } else {
                this.SET_SELECTS(this.filter)
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
