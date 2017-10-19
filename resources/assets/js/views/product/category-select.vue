/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 * 
 * 
 */
<template>
	<div>
        <el-cascader
            :options="allCategory"
            :props="{
                value: 'id',
                label: 'name'
            }"
            v-model="currentCategory"
            @change="change"
        ></el-cascader>
	</div>
</template>

<script>
import { mapGetters } from 'vuex'
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
        }
    },
    computed: {
        ...mapGetters(['allCategory'])
    },
    data () {
        return {
            currentCategory: [],
            select: null
        }
    },
    mounted () {
        if (this.scope.row.category_id) {
            this.allCategory.forEach(cate => {
                cate.children.forEach(child => {
                    if (child.id === this.scope.row.category_id) {
                        this.select = child.id
                        this.currentCategory.push(cate.id)
                        this.currentCategory.push(child.id)
                    }
                })
            })
        }
    },
    methods: {
        change (val) {
            this.select = val[val.length-1]
            this.$emit('emit', {pro: 'category_id', val: this.select})
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
