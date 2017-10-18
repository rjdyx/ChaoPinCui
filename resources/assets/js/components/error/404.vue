/**
 * 
 * 404组件
 * @description 访问不存在的路由都会定向到这个组件页面
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <div>
        你所访问的页面不存在
        <el-button @click="back">返回</el-button>
    </div>
</template>
<script>
    export default{
        name: 'NotFound',
        methods: {
        	back () {
        		this.$router.go(-1)
        	}
        }
    }
</script>
