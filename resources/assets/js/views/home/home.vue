/**
 * 首页组件
 * @description 
 * @author 郭森林
 * @date 2017/09/21
 * 
 */
<template>
    <div id="indexHome">
        <div class="indexHomeInner">
            <!-- <h1>个人信息与编辑</h1> -->
            <!-- 导航条模块 -->
            <el-breadcrumb separator="/" id="nav">
                <el-breadcrumb-item>首页</el-breadcrumb-item>
                <el-breadcrumb-item>个人信息</el-breadcrumb-item>
            </el-breadcrumb>

            <slot name="tabs-upside"></slot>

            <!-- tab栏 --> 
            <el-tabs v-model="activeName" id="tabs" type="card">
                <el-tab-pane label="个人信息与编辑" name="info"></el-tab-pane>
            </el-tabs>
            <div class="userForm">
                <template>
                    <el-form :model="ruleForm" ref="ruleForm" id="pop-form">
                        <el-row>
                            <el-col :span="12">
                                <el-form-item label="用户名" prop="name">
                                    <el-input type="text" v-model="ruleForm.name"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="邮箱" prop="email">
                                    <el-input type="text" v-model="ruleForm.email"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="手机号" prop="phone">
                                    <el-input type="text" v-model="ruleForm.phone"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="地址" prop="address">
                                    <el-input type="text" v-model="ruleForm.address"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="性别" prop="sex">
                                    <el-radio-group v-model="ruleForm.sex">
                                        <el-radio-button :label="0">保密</el-radio-button>
                                        <el-radio-button :label="1">男</el-radio-button>
                                        <el-radio-button :label="2">女</el-radio-button>
                                    </el-radio-group>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item label="出生日期" prop="age">
                                    <el-form-item prop="age">
                                        <el-date-picker
                                          v-model="ruleForm.age"
                                          type="date"
                                          placeholder="出生年月日"
                                          :picker-options="pickerOptions0"
                                          @change="GMTToStr">
                                        </el-date-picker>
                                    </el-form-item>
                                </el-form-item>
                            </el-col>
                            <el-col :span="24">
                                <el-form-item label="头像" prop="img">
                                    <inputFile v-if="showfile" :row="userImg"pro="img" @emit="returnValue" :isEdit="true"></inputFile>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                    <div slot="footer" class="formStore">
                        <el-button type="primary" @click="submitForm">保存</el-button>
                    </div>
                </template>  
            </div>
            
        </div>
    </div>
</template>

<style lang="sass">
    @import "../../../sass/function";
    #indexHome{
        height: 100%;
        overflow:hidden;
        padding: 3rem 0rem 0rem 1.5625rem;
        box-sizing:border-box;
        #nav {
            height: pxToRem(62);
            line-height: pxToRem(62);
            font-size: pxToRem(20);
        }
        .indexHomeInner {
            width: 100%;
            min-width: 800px;
            height: 100%;
            overflow-y: auto;
            padding-right:1rem;
            box-sizing:border-box;
        }
        h1{
            margin-bottom: 20px;
        }
        .el-form-item__label{
            color: #666 !important;
            width:100px;
        }
        .el-form-item__content {
            overflow:hidden;
        }
        .formStore {
            text-align: center;
            margin-bottom:50px;
            button{
                width: 50%;
            }
        }
        .userForm{
            width: 100%;
        }
        #pop-form {
            width: 618px;
            margin-left:0px;
        }
    }
        
</style>

<script>
import inputFile from 'components/public/inputFile.vue'
export default {
    data () {
        return {
            select: '',
            ruleForm: {
                name: '',
                password: '',
                sex: '',
                age: '',
                email: '',
                phone: '',
                address: ''
            },
            userImg: {value: ''},
            id: '',
            showfile: false,
            pickerOptions0: {
                disabledDate (time) {
                    return time.getTime() > Date.now() - 8.64e7
                }
            },
            activeName: 'info'
        }
    },
    mounted () {
        this.userInfo()
    },
    methods: {
        userInfo () {
            axios.get('auth').then((res) => {
                if (res.data) {
                    this.ruleForm = res.data
                    this.userImg.value = res.data.img
                    this.id = res.data.id
                }
                this.showfile = true
            })
        },
        returnValue ({pro, val}) {
            if (val.name !== undefined) {
                this.ruleForm[pro + 's'] = val
            } else if (val === 'del') {
                this.ruleForm[pro + 's'] = 'del'
            } else {
                this.ruleForm[pro] = val
            }
        },
        // 改变为表单数据格式
        formDataCl (val) {
            let form = new FormData()
            for (let key of Object.keys(val)) {
                if (val[key] === '' || val[key] === null) {
                    val[key] = ''
                }
                form.append(key, val[key])
            }
            return form
        },
        GMTToStr (v) {
            this.ruleForm.age = v
        },
        submitForm () {
            if (this.ruleForm.age === undefined) {
                this.ruleForm.age = null
            }
            let rule = true
            if (rule) {
                let headers = {headers: {'Content-Type': 'multipart/form-data'}}
                let form = this.formDataCl(this.ruleForm)
                form.append('_method', 'PUT')
                let url = 'api/admin/user/' + this.id
                axios.post(url, form, headers).then((res) => {
                    if (res.data) {
                        this.$message({
                            message: '操作数据成功',
                            type: 'success'
                        })
                    } else {
                        this.$message({
                            message: '操作数据失败',
                            type: 'error'
                        })
                    }
                })
            }
        }
    },
    components: {
        inputFile
    }
}
</script>
