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
        methods: {
            ...mapMutations([
                'SET_NAVBARNAME',
                'SET_SUBNAVBARNAME'
            ]),
            clickEvent (menu, subMenu) {
                this.SET_NAVBARNAME(menu.name)
                this.SET_SUBNAVBARNAME(subMenu.name)
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
        z-index: 101;
    }

    .subMenu {
        display: inline-block;
        width: 100%;
    }
</style>