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
    name: 'Sex',
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
            select: ''
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
            axios.get(this.$adminUrl('category'))
                .then((response) => {
                    if (response.status === 200) {
                        for (let category of response.data.data) {
                            if (category.id === this.scope.row.category_id) {
                                this.select = category.name
                            }
                        }
                    }
                })
        }
    }
}
</script>
