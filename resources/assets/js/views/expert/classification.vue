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
            let classifications = this.db.get('classification')
                .sortBy('created_at')
                .reverse()
                .cloneDeep()
                .value()
            for (let classification of classifications) {
                if (classification.id === this.scope.row.classification) {
                    this.select = classification.name
                }
            }
        }
    }
}
</script>
