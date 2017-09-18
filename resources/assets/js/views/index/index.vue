/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <div id="index">
        <!-- 顶部栏目 -->
        <my-header></my-header>

        <!-- 左栏目 -->
        <left-menu
            :show="show"
            :menus="menus"
        ></left-menu>

        <!-- 路由 -->
        <router-view></router-view>
    </div>
</template>

<style lang="sass" scoped>
    #index {
        height: 100%;
    }
</style>

<script>
    import MyHeader from 'components/layout/header'
    import LeftMenu from 'components/layout/left-menu'
    import menu from './menu.js'
    export default {
        name: 'Index',
        data () {
            return {
                // 是否显示侧边栏
                show: true,
                // 侧边栏数据
                menus: menu
            }
        },
        components: {
            MyHeader,
            LeftMenu
        }
    }
</script>
