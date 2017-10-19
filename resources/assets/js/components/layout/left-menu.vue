<template>
    <el-menu
        :router="true"
        :default-openeds="defaultOpen"
        :default-active="defaultActive"
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
        data () {
            return {
                defaultOpen: [],
                defaultActive: ''
            }
        },
        mounted () {
            if (localStorage.navbarName) {
                this.SET_NAVBARNAME(localStorage.navbarName)
                this.SET_SUBNAVBARNAME(localStorage.subNavBarName)
                // 动态设置当前的导航栏
                this.menus.forEach(menu => {
                    if (menu.name === localStorage.navbarName) {
                        this.defaultOpen.push(menu.name)
                    }
                    menu.children.forEach((child, i) => {
                        if (child.name === localStorage.subNavBarName) {
                            this.defaultActive = child.path
                        }
                    })
                })
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
