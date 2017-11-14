/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
        <img v-if="imgArr" v-for="itImg in imgArr" :src="itImg" width="40" height="40" style="margin-right:5px">
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
            imgArr: []
        }
    },
    methods: {
        changeImg () {
            if (this.scope.img !== null && this.scope.img !== '') {
                this.imgArr = this.scope.img.split(',')
            } else {
                this.imgArr = ''
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
