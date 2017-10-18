<template>
    <el-menu
        :router="true" 
        class="left-menu">
        <template v-for="(menu, index) in menus">
            <el-submenu v-if="menu.children.length" :index="menu.name" :key="index">
                <template slot="title">{{menu.name}}</template>
                <el-menu-item 
                    v-for="(subMenu, subIndex) in menu.children" 
                    :index="subMenu.path" @click="clickEvent(menu, subMenu)"  :key="subIndex" exact>
                    {{subMenu.name}}
                </el-menu-item>
            </el-submenu>
            <el-menu-item 
                v-else
                :index="menu.path"
                 :key="index"
                @click="clickEvent(menu, {name: ''})" exact>
                {{menu.name}}
            </el-menu-item>
        </template>
        
    </el-menu>
</template>

<script>
    import {mapMutations} from 'vuex'
    export default {
        name: 'SliderBar',
        props: {
            // 左菜单栏数组
            menus: {
                type: Array,
                default () {
                    return []
                }
            }
        },
        mounted () {
            if (localStorage.navbarName) {
                this.SET_NAVBARNAME(localStorage.navbarName)
                this.SET_SUBNAVBARNAME(localStorage.subNavBarName)
            }
        },
        methods: {
            ...mapMutations([
                'SET_NAVBARNAME',
                'SET_SUBNAVBARNAME'
            ]),
            clickEvent (menu, subMenu) {
                let navbarName = menu.name
                let subNavBarName = subMenu.name
                localStorage.navbarName = navbarName
                localStorage.subNavBarName = subNavBarName
                this.SET_NAVBARNAME(navbarName)
                this.SET_SUBNAVBARNAME(subNavBarName)
            }
        }
    }
</script>

<style lang="sass" scoped>
    @import "../../../sass/function";
    
    .left-menu {
        width: pxToRem(180);
        height: 100%;
        padding-top: pxToRem(48);
        float: left;
    }

    .subMenu {
        display: inline-block;
        width: 100%;
    }
</style>
