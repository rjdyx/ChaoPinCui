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
 * 修改
 * (1)所有的动态组件component绑定的属性scope修改为scope.row (2017.10.18 suzhihao)
 * (2)新增setOption方法用于下拉框异步赋值给option(2017.10.19 suzhihao)
 * (2)新增extraDialog插口(2017.10.23 suzhihao)
 */
<template>
    <div class="middleInner">
        <!-- 导航条模块 -->
        <el-breadcrumb separator="/" id="nav">
            <el-breadcrumb-item>{{navbarName}}</el-breadcrumb-item>
            <el-breadcrumb-item>{{subNavBarName}}</el-breadcrumb-item>
        </el-breadcrumb>

        <slot name="tabs-upside"></slot>

        <!-- tab栏 --> 
        <el-tabs v-if="showTabs" v-model="activeName" id="tabs" type="card" @tab-click="tabClick">
            <el-tab-pane 
                v-for="(tab, index) in tabsName" 
                :label="tab" 
                :name="'index'+index" 
                :key="index">
            </el-tab-pane>
        </el-tabs>

        <slot name="tabs-downside"></slot>

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
                <!-- 右边自定义操作按钮 -->
                <custom-component
                    class="rightBtn"
                    position="right"
                    :components="topOperateComponents"
                    :model="model"
                ></custom-component>

                <multi-delete
                    v-if="showDelete"
                    class="rightBtn"
                    :model="model"
                ></multi-delete>

                <!-- 操作按钮 -->
                <div v-if="showNewBuild" class="rightBtn" >
                    <el-button
                        type="primary" 
                        icon="plus" 
                        @click="showPopNew"
                    >新增</el-button>
                </div>
                
                <!-- 左边自定义操作按钮 -->
                <custom-component
                    class="rightBtn"
                    :components="topOperateComponents"
                    :model="model"
                ></custom-component>
            </div>
        </div>

        <!-- 列表模块 -->
        <el-table 
            id="table"
            :data="tableData" 
            v-loading.body="loading"
            @selection-change="handleSelectionChange">
            

            <!-- checkbox -->
            <el-table-column v-if="showCheckbox" type="selection" width="50" :selectable="checkboxDis"></el-table-column> 

            <el-table-column v-if="showDetail" type="expand">
                <template scope="scope">
                    <el-form label-position="left" inline class="table-expand">
                        <template v-for="(item, index) in theads">
                            <el-form-item 
                                v-if="colComponents[protos[index]]"
                                :label="item">
                                <component
                                    v-if="colComponents[protos[index]]"
                                    :is="colComponents[protos[index]]"
                                    :scope="scope.row"
                                    :prop="protos[index]"
                                ></component>
                            </el-form-item>
                            <el-form-item 
                                v-else
                                :label="item">
                                <span>{{ scope.row[protos[index]] }}</span>
                            </el-form-item>
                        </template>
                    </el-form>
                </template>
            </el-table-column>

            <!-- 中间列表模块 -->
            <template v-for="(item, index) in theadsShort">
                <el-table-column
                    :prop="protosShort[index]"
                    :label="item"
                    :min-width="widths[index]"
                    :key="index">
                    <template scope="scope">
                        <component
                            v-if="colComponents[protosShort[index]]"
                            :is="colComponents[protosShort[index]]"
                            :scope="scope.row"
                            :prop="protosShort[index]"
                            :isEdit="isEdit"
                        ></component>
                        <div v-else>{{scope.row[protosShort[index]]}}</div>
                    </template>
                </el-table-column>
            </template>

            <!-- 列表操作模块 -->
            <el-table-column 
                label="操作" v-if="showOperateCol" :min-width="70">
                <template scope="scope">
                    <template>
                        <!-- 左边自定义操作按钮 -->
                        <custom-col-component
                            class="line-operate"
                            :components="operateComponents" 
                            :scope="scope.row" 
                            :model="model"
                        ></custom-col-component>
                        <el-button 
                            class="line-operate"
                            v-if="showEdit"
                            type="text" 
                            size="small"
                            @click="showPopEdit(scope)"
                        >编辑</el-button>
                        <delete
                            class="line-operate"
                            v-if="showDelete" 
                            :scope="scope" 
                            :model="model"
                        ></delete>
                        <!-- 右边自定义操作按钮 -->
                        <custom-col-component
                            class="line-operate"
                            position="right"
                            :components="operateComponents" 
                            :scope="scope.row" 
                            :model="model"
                        ></custom-col-component>
                        <!-- 右边自定义more -->
                        <el-dropdown v-if="isOperateMores">
                            <span class="el-dropdown-link">
                                更多<i class="el-icon-caret-bottom el-icon--right"></i>
                            </span>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item v-for="(operateBuntton, index) in operateMoreComponents" :key="index">       
                                    <component
                                        :is="operateBuntton.component" 
                                        :params="operateBuntton.params" 
                                        :scope="scope.row" 
                                        :model="model"
                                        :key="index"
                                    ></component>
                                </el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
                    </template>
                </template>
            </el-table-column>
        </el-table>

        <div class="footer" v-if="showFooter">
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

        <pop-form 
            v-if="isShowPopNew"
            :isEdit="false"
            :url="url"
            :rows="formRows"
            @handleClose="isShowPopNew=false"
        ></pop-form>

        <pop-form 
            v-if="isShowPopEdit"
            :isEdit="true"
            :url="url"
            :rows="formRows"
            :scope="editScope"
            @handleClose="isShowPopEdit=false"
        ></pop-form>

        <slot name="extraDialog"></slot>
    </div>
</template>

<script>
import { tableStoreFactory } from '../table-store'
import computed from '../computed'
import Delete from './delete'
import MultiDelete from './multi-delete'
import CustomComponent from './custom-component'
import CustomColComponent from './custom-col-component'
import PopForm from 'components/form/pop-form/pop-form'
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
        },
        loading: {
            type: Boolean,
            default: false
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
            inputValue: '',
            operateMoreShow: false,
            isShowPopNew: false,
            isShowPopEdit: false,
            editScope: {row: {}},
            isEdit: false
        }
    },
    // 混合
    mixins: [computed],
    mounted () {
    },
    methods: {
        checkboxDis (row, index) {
            if (row.dels !== undefined && row.dels !== null) {
                return false
            } else {
                return true
            }
        },
        showPopNew () {
            this.setOption()
            this.isShowPopNew = true
        },
        handleSelectionChange (val) {
            this.$emit('multiSelect', val)
        },
        tabClick (tab, event) {
            this.modelIndex = tab.$data.index
            this.$emit('tabClick', tab.$data)
        },
        search () {
            this.$emit('search', this.inputValue)
            this.inputValue = ''
        },
        pageChange (currentPage) {
            this.$emit('pageChange', currentPage)
        },
        showPopEdit (scope) {
            for (let pro in this.model.formRows) {
                this.model.formRows[pro].value = scope.row[pro]
            }
            this.$set(this, 'editScope', scope)
            this.setOption()
            this.isShowPopEdit = true
        },
        // 获取当前表单行的options
        setOption () {
            for (let pro in this.model.formRows) {
                if (this.model.formRows[pro].options && this.model.formRows[pro].options.length === 0) {
                    this.$store.dispatch('GET_ALL_DATAS', pro.split('_')[0])
                    .then(data => {
                        this.model.formRows[pro].options = data
                    })
                }
            }
        }
    },
    components: {
        Delete,
        MultiDelete,
        CustomComponent,
        CustomColComponent,
        PopForm
    }
}
</script>

<style lang="sass" scoped>
    @import "../../../../sass/function";
    .middleInner{
        width:100%;
        min-width:800px;
        height:100%;
        overflow-y: auto;
        padding-right:1rem;
        box-sizing:border-box;
         #nav {
            height: pxToRem(62);
            line-height: pxToRem(62);
            font-size: pxToRem(20);
        }

        #tabs {
            height: pxToRem(62);
        }
        tbody .cell div{
            overflow: hidden; 
            text-overflow:ellipsis;
            white-space: nowrap;
            cursor: pointer;
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

                .rightBtn {
                    float: right;
                    margin-right: 10px;
                }

                .rightBtn:nth-child(1) {
                    margin-right: 0px;
                }
            }

            #inputs {
                float: left;
            }
        }

        .line-operate {
            float: left;
            margin-right: 10px;
        }

        .footer {
            width: 99.9%;
            height: 50px;
            border: 1px solid #dfe6ec;
            border-top: none;

            .record {
                float: right;
                padding: 16px 26px;
                font-size: 13px;
            }

            .pager {
                display: inline-block;
                float: right;
                vertical-align: middle;
                padding-top: 12px;
            }
        }
    }
       
</style>
