/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		{{this.select}}
	</div>
</template>

<script>
export default {
    name: 'Category',
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
            select: '',
            flag: ''
        }
    },
    mounted () {
        this.update()
    },
    watch: {
        scope () {
            this.update()
        }
    },
    methods: {
        update () {
            axios.get(this.$adminUrl('category/' + this.scope.row.category_id))
                .then((response) => {
                    if (response.status === 200) {
                        if (response.data.name !== undefined) {
                            this.select = response.data.name
                            this.flag = response.data.name
                        } else {
                            this.select = this.flag
                        }
                    }
                })
        }
    }
}
</script>
