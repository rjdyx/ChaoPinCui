/**
 * 编辑表格按钮和编辑表单弹窗组件
 * @description 
 * @author 苏锐佳
 * @date 2017/6/8
 * 
 */
<template>
	<div>
		<div v-if="position === 'left' && !(components[0] instanceof Array)" class="operate">
            <component
                v-for="(searchModel, index) in components" 
                :is="searchModel.component" 
                :params="searchModel.params" 
                :model="model"
                :key="index"
            ></component>
        </div>
        <div v-if="position === 'left' && (components[0] instanceof Array)" class="operate">
            <component
                v-for="(searchModel, index) in components[0]" 
                :is="searchModel.component" 
                :params="searchModel.params" 
                :model="model"
                :key="index"
            ></component>
        </div>
        <div v-if="position === 'right' && (components[1] instanceof Array)" class="operate">
            <component
                v-for="(searchModel, index) in components[1]" 
                :is="searchModel.component" 
                :params="searchModel.params" 
                :model="model"
                :key="index"
            ></component>
        </div>
	</div>
</template>

<script>
export default {
    name: 'CustomComponent',
    props: {
        position: {
            type: String,
            default: 'left'
        },
        components: {
            type: Array,
            default () {
                return [{component: null, params: {}}]
            }
        },
        model: {
            type: Object,
            default () {
                return {}
            }
        }
    }
}
</script>
