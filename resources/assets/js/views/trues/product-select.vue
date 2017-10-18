/**
 * 产品组件
 * @description 
 * @author 郭森林
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		<el-select v-model="select" filterable id="el-select" @change="change" placeholder="请搜索选择产品">
            <el-option 
                v-for="(product, index) in products" 
                :label="product.name" 
                :value="product.id"
                :key="index">
            </el-option>
        </el-select>
	</div>
</template>

<script>
export default {
    name: 'ProductSelect',
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
            products: [],
            select: ''
        }
    },
    mounted () {
        this.select = this.scope.product_id
        let params = {tname: 'products'}
        axios.get('api/get/tables', {params: params}).then((response) => {
            if (response.status === 200) {
                this.$set(this, 'products', response.data)
            }
        })
    },
    methods: {
        change () {
            this.$emit('emit', {pro: 'product_id', val: this.select})
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
