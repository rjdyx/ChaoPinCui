/**
 * 
 * 基础模块组件
 * @author 舒丹彤 
 * @date 2017/03/14
 * 
 * 重构
 * @author 苏锐佳 
 * @date 2017/06/08
 * 
 */
<template>
    <div class="middle">
        <!-- 导航条模块 -->
        <el-breadcrumb separator="/" id="nav">
            <el-breadcrumb-item>{{navbarName}}</el-breadcrumb-item>
            <el-breadcrumb-item>{{subNavBarName}}</el-breadcrumb-item>
        </el-breadcrumb>

        <!-- tab栏 --> 
        <el-tabs v-model="activeName" id="tabs" type="card" @tab-click="tabClick">
            <el-tab-pane 
                v-for="(tab, index) in tabsName" 
                :label="tab" 
                :name="'index'+index" 
                :key="index">
            </el-tab-pane>
        </el-tabs>

        <!-- 操作模块 -->
        <div id="operate">
            <div id="inputs">
                <!-- 左边自定义搜索模块 -->
                <custom-component
                    :components="searchModelComponents"
                    :model="model"
                ></custom-component>

                <!-- 默认搜索框 -->
                <div v-if="showSearchModel" class="searchOp">
                    <el-input
                        :placeholder="searchPlaceholder"
                        icon="search"
                        v-model="inputValue"
                        :on-icon-click="search">
                    </el-input>
                </div>

                <!-- 右边自定义搜索模块 -->
                <custom-component
                    position="right"
                    :components="searchModelComponents"
                    :model="model"
                ></custom-component>
            </div>
            <div id="btns">
                <!-- 左边自定义操作按钮 -->
                <custom-component
                    :components="topOperateComponents"
                    :model="model"
                ></custom-component>

                <!-- 操作按钮 -->
                <new-build
                    class="fr rightBtn"
                ></new-build>

                <!-- 右边自定义操作按钮 -->
                <custom-component
                    position="right"
                    :components="topOperateComponents"
                    :model="model"
                ></custom-component>
            </div>
        </div>

        <!-- 列表模块 -->
        <el-table 
            id="table"
            :data="tableData"  
            @selection-change="handleSelectionChange">

            <!-- checkbox -->
            <el-table-column v-if="showCheckbox" width="50" type="selection"></el-table-column> 
            <!-- 序号 --> 
            <el-table-column v-if="showNumber" width="80" label="序号" type="index" id="test-id"></el-table-column>

            <!-- 中间列表模块 -->
            <template v-for="(item, index) in theads">
                <el-table-column
                    v-if="colComponents[protos[index]] === undefined"
                    :prop="protos[index]"
                    :label="item"
                    :min-width="widths[index]"
                    show-overflow-tooltip>
                </el-table-column>
                <el-table-column
                    v-else
                    :label="item"
                    :min-width="widths[index]"
                    show-overflow-tooltip>
                    <template scope="scope">
                        <component
                            :is="colComponents[protos[index]]"
                            :scope="scope"
                        ></component>
                    </template>
                </el-table-column>
            </template>

            <!-- 列表操作模块 -->
            <el-table-column 
                label="操作" v-if="showOperateCol" width="180">
                <template scope="scope">
                    <template>
                        <!-- 左边自定义操作按钮 -->
                        <custom-col-component
                            :components="operateComponents" 
                            :scope="scope" 
                            :model="model"
                        ></custom-col-component>
                        <edit
                            v-if="showEdit" 
                            :scope="scope" 
                            :model="model"
                        ></edit>
                        <delete
                            v-if="showDelete" 
                            :scope="scope" 
                            :model="model"
                        ></delete>
                        <!-- 右边自定义操作按钮 -->
                        <custom-col-component
                            position="right"
                            :components="operateComponents" 
                            :scope="scope" 
                            :model="model"
                        ></custom-col-component>
                    </template>
                </template>
            </el-table-column>
        </el-table>

        <div class="footer">
            <p class="record">共有<span class="record_num">{{num}}</span>页，<span class="record_num">{{totalNum}}</span>条记录</p>

            <el-pagination
                v-if="paginator!=0"
                layout="prev, pager, next, jumper"
                :total="paginator.total"
                :page-size="paginator.per_page"
                class="pager"
                @current-change="pageChange">
            </el-pagination>
        </div>
    </div>
</template>

<script>
import { tableStoreFactory } from '../table-store'
import computed from '../computed'
import ContainTitle from './contain-title'
import NewBuild from './newbuild'
import Edit from './edit'
import Delete from './delete'
import Operate from './operate'
import CustomComponent from './custom-component'
import CustomColComponent from './custom-col-component'
export default {
    name: 'BasicModel',
    props: {
        modelParam: {
            type: Object,
            default () {
                return tableStoreFactory()
            }
        },
        tabsName: {
            type: Array,
            default () {
                return []
            }
        }
    },
    data () {
        return {
            settitle: '',
            // tab模块选择标志
            modelIndex: 0,
            activeName: 'index0',
            // 被选中的列表项数组
            multipleSelection: [],
            // 默认搜索框的值
            inputValue: ''
        }
    },
    // 混合
    mixins: [computed],
    methods: {
        handleSelectionChange () {},
        tabClick (tab, event) {
            this.modelIndex = tab.$data.index
            this.$emit('tabClick', tab.$data)
        },
        search () {}
    },
    components: {
        ContainTitle,
        NewBuild,
        Edit,
        Delete,
        Operate,
        CustomComponent,
        CustomColComponent
    }
}
</script>

<style lang="sass" scoped>
    @import "../../../../sass/function";
    #nav {
        height: pxToRem(62);
        line-height: pxToRem(62);
        font-size: pxToRem(20);
    }

    #tabs {
        height: pxToRem(62);
        line-height: pxToRem(62);
    }

    #operate {
        height: pxToRem(62);
        line-height: pxToRem(62);
        margin-top: pxToRem(10);

        #btns {
            float: right;

            .operateBtns {
                display: inline-block;
                margin: 0 pxToRem(10);
            }
        }

        #inputs {
            float: left;
        }
    }

    .pagination {
        position: absolute;
        bottom: 35px;
        left: 0;
        right: 0;
        text-align: center;
    }
</style>
