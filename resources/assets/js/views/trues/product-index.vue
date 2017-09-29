/**
 * 产品列表替换
 * @description 
 * @author 李明村
 * @date 2017/9/29
 * 
 */
<template>
    <div>
        {{product_name}}
    </div>
</template>

<script>
export default {
    name: 'Type',
    props: {
        scope: {
            type: Object,
            default () {
                return {}
            }
        }
    },
    data () {
        return {
            product_name: '',
            flag: ''
        }
    },
    methods: {
        changeName () {
            let id = this.scope.row.product_id
            axios.get('api/admin/product/' + id).then((response) => {
                if (response.status === 200) {
                    if (response.data.name !== undefined) {
                        this.product_name = response.data.name
                        this.flag = response.data.name
                    } else {
                        this.product_name = this.flag
                    }
                }
            })
        }
    },
    mounted () {
    },
    watch: {
        scope () {
            this.changeName()
        }
    }
}
</script>
