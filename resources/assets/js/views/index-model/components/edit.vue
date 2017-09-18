/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		<el-button 
            type="text" 
            size="small" 
            :class="{'btn':hiddeRole}"
        >编辑</el-button>
        <!-- 编辑模块 -->
        <transition name="fade">
        </transition>
	</div>
</template>

<script>
export default {
    name: 'Edit',
    props: {
        scope: {
            type: Object,
            default () {
                return {}
            }
        },
        hiddeRole: {
            type: Boolean,
            default: false
        },
        editComponent: {
            type: Array,
            default () {
                return []
            }
        },
        roleId: {
            type: Object,
            default () {
                return null
            }
        },
        checkboxShow: {
            type: Boolean,
            default: false
        },
        url: {
            type: String,
            default: ''
        },
        editForm: {
            type: Object,
            default () {
                return {}
            }
        }
    },
    data () {
        return {
            isEditShow: false
        }
    },
    methods: {
        showPopNew () {
            this.isEditShow = !this.isEditShow
        }
    },
    components: {

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
