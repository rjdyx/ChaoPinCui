/**
 * 查看图片按钮组件
 * @description 
 * @author suzhihao
 * @date 2017/10/20
 * 
 */
<template>
    <div>
	   <el-button type="text" size="small" @click="lookImg">查看图片</el-button>
        <LookImgDialog
            :title="'反馈图片查看'"
            :visible="visible"
            :imgUrl="scope.img"
            v-on:close="close">
        </LookImgDialog>
    </div>
</template>

<script>
import LookImgDialog from 'components/func/look-img-dialog.vue'
export default {
    name: 'LookImg',
    components: {
        LookImgDialog
    },
    props: {
        scope: {
            type: Object,
            default () {
                return {}
            }
        },
        model: {
            type: Object,
            default () {
                return {}
            }
        }
    },
    data () {
        return {
            visible: false
        }
    },
    methods: {
        lookImg () {
            this.visible = true
        },
        close () {
            this.visible = false
        }
    }
}
</script>