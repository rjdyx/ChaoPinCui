/**
 * 新建表格按钮和新建表单弹窗组件
 * @description 
 * @author 舒丹彤
 * @date 2017/3/16
 * 
 */
<template>
	<div class="new-build">
		<el-button type="primary" icon="plus" @click="showPopNew">新增</el-button>
        <!-- 新建模块 --> 
        <transition name="fade">
            <pop-form :isNewShow="isNewShow" @handleClose="isNewShow=false"></pop-form>
        </transition>
	</div>
</template>

<script>
import PopForm from 'components/form/pop-form/pop-form'
export default {
    name: 'NewBuild',
    props: {
        newComponent: {
            type: Array,
            default () {
                return []
            }
        },
        checkboxShow: {
            type: Boolean,
            default: false
        },
        url: {
            type: String,
            default: ''
        }
    },
    data () {
        return {
            isNewShow: false
        }
    },
    methods: {
        showPopNew () {
            this.isNewShow = !this.isNewShow
        }
    },
    components: {
        PopForm
    }
}
</script>

<style lang="sass">
.new-build{
    .btn-change{
        color: #fff;
    }
}
</style>
