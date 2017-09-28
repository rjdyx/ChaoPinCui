/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
        <img :src="imgOk">
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
            imgOk: ''
        }
    },
    methods: {
        changeImg () {
            if (this.scope.row.img !== null && this.scope.row.img !== '') {
                this.imgOk = 'img/ok.png'
            } else {
                this.imgOk = 'img/no.png'
            }
        }
    },
    mounted () {
        this.changeImg()
    },
    watch: {
        scope () {
            this.changeImg()
        }
    }
}
</script>
