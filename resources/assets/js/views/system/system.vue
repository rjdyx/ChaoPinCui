/**
 * 首页组件
 * @description 
 * @author 郭森林
 * @date 2017/09/21
 * 
 */
<template>
    <div id="indexHome">
    <h1>系统设置</h1>
        <template>
            <el-form :model="ruleForm" :rules="rulesValite" ref="ruleForm" id="pop-form">
                <el-form-item label="网站名称" prop="name">
                    <el-input type="text" v-model="ruleForm.name"></el-input>
                </el-form-item>
                <el-form-item label="关键字" prop="keywords">
                    <el-input type="text" v-model="ruleForm.keywords"></el-input>
                </el-form-item>
                <el-form-item label="备案号" prop="icp">
                    <el-input type="text" v-model="ruleForm.icp"></el-input>
                </el-form-item>
                <el-form-item label="copyright" prop="copy">
                    <el-input type="text" v-model="ruleForm.copy"></el-input>
                </el-form-item>
                <el-form-item label="地址" prop="address">
                    <el-input type="text" v-model="ruleForm.address"></el-input>
                </el-form-item>
                <el-form-item label="邮箱" prop="email">
                    <el-input type="text" v-model="ruleForm.email"></el-input>
                </el-form-item>
                <el-form-item label="手机" prop="phone">
                    <el-input type="text" v-model="ruleForm.phone"></el-input>
                </el-form-item>
                <div>logo图片</div>
                <inputFile v-if="showfile" :row="logoVal" pro="logo" @emit="returnValue" :isEdit="true"></inputFile>
            </el-form>
            <div slot="footer" class="formStore">
                <el-button type="primary" @click="submitForm('ruleForm')">保存</el-button>
            </div>
        </template>
    </div>
</template>

<style scoped>
    #indexHome {
        position: absolute;
        top: 6rem;
        left: 11rem;
        padding: 20px;
    }
    .el-form-item__label{
        color: #666 !important;
    }
    .formStore {
        text-align: center;
        button{
            width: 50%;
        }
    }
    #pop-form {
        margin: auto;
        width: 618px;
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
            }
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
