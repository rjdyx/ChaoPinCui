/**
 * 首页组件
 * @description 
 * @author 郭森林
 * @date 2017/09/21
 * 
 */
<template>
    <div id="system">
        <div class="systemInner">
            <!-- <h1>系统设置</h1> -->
            <!-- <h1>个人信息与编辑</h1> -->
            <!-- 导航条模块 -->
            <el-breadcrumb separator="/" id="nav">
                <el-breadcrumb-item>系统管理</el-breadcrumb-item>
                <el-breadcrumb-item>系统配置</el-breadcrumb-item>
            </el-breadcrumb>

            <slot name="tabs-upside"></slot>

            <!-- tab栏 --> 
            <el-tabs v-model="activeName" id="tabs" type="card">
                <el-tab-pane label="系统配置" name="info"></el-tab-pane>
            </el-tabs>
            <template>
                <el-form :model="ruleForm" :rules="rulesValite" ref="ruleForm" id="pop-form">
                    <el-row>
                        <el-col :span="12">
                            <el-form-item label="网站名称" prop="name">
                                <el-input type="text" v-model="ruleForm.name"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="12">
                            <el-form-item label="关键字" prop="keywords">
                                <el-input type="text" v-model="ruleForm.keywords"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="12">
                            <el-form-item label="备案号" prop="icp">
                                <el-input type="text" v-model="ruleForm.icp"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="12">
                            <el-form-item label="copyright" prop="copy">
                                <el-input type="text" v-model="ruleForm.copy"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="12">
                            <el-form-item label="地址" prop="address">
                                <el-input type="text" v-model="ruleForm.address"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="12">
                            <el-form-item label="邮箱" prop="email">
                                <el-input type="text" v-model="ruleForm.email"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="12">
                            <el-form-item label="logo图片">
                                <inputFile v-if="showfile" :row="logoVal" pro="logo" @emit="returnValue" :isEdit="true"></inputFile>
                            </el-form-item>
                        </el-col>
                        <el-col :span="12">
                            <el-form-item label="手机" prop="phone">
                                <el-input type="text" v-model="ruleForm.phone"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-form>
                <div slot="footer" class="formStore">
                    <el-button type="primary" @click="submitForm('ruleForm')">保存</el-button>
                </div>
            </template>
        </div>
    </div>
</template>

<style lang="sass">
    @import "../../../sass/function";
    #system{
        height: 100%;
        overflow:hidden;
        padding: 3rem 0rem 0rem 1.5625rem;
        box-sizing:border-box;
        #nav {
            height: pxToRem(62);
            line-height: pxToRem(62);
            font-size: pxToRem(20);
        }
        .systemInner {
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
            width: 100px;
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
import { cellphone } from 'utils/validate'
export default {
    data () {
        return {
            select: '',
            ruleForm: {},
            logoVal: {},
            showfile: false,
            flag: '',
            rulesValite: {
                name: [
                    { required: true, message: '请输入网站名称', trigger: 'blur' },
                    { max: 50, message: '长度在50个字符以内', trigger: 'blur'}
                ],
                email: [ { type: 'email', message: '请输入正确的邮箱格式', trigger: 'blur'} ],
                phone: [ { validator: cellphone } ]
            },
            activeName: 'info'
        }
    },
    mounted () {
        this.userInfo()
    },
    methods: {
        userInfo () {
            axios.get('/api/admin/system/2').then((res) => {
                if (res.data) {
                    this.ruleForm = res.data
                    this.logoVal['value'] = res.data.logo
                    this.flag = 'edit'
                } else {
                    this.logoVal['value'] = ''
                    this.flag = 'new'
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
        submitForm (formName) {
            this.$refs[formName].validate(async (valid) => {
                if (valid) {
                    let headers = {headers: {'Content-Type': 'multipart/form-data'}}
                    let form = this.formDataCl(this.ruleForm)
                    var url
                    if (this.flag !== 'new') {
                        form.append('_method', 'PUT')
                        url = 'system/' + this.ruleForm.id
                    } else {
                        url = 'system'
                    }
                    axios.post(this.$adminUrl(url), form, headers)
                        .then((responce) => {
                            if (responce.data) {
                                this.$message({
                                    message: '操作数据成功',
                                    type: 'success'
                                })
                            } else {
                                this.$message('操作数据失败')
                            }
                        })
                }
            })
        }
    },
    components: {
        inputFile
    }
}
</script>
