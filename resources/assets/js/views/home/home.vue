/**
 * 首页组件
 * @description 
 * @author 郭森林
 * @date 2017/09/21
 * 
 */
<template>
    <div id="indexHome">
        <h1>个人信息与编辑</h1>
        <template>
            <el-form :model="ruleForm" ref="ruleForm" id="pop-form">
                <el-form-item label="头像" prop="img">
                    <inputFile v-if="showfile" :row="userImg"pro="img" @emit="returnValue" :isEdit="true"></inputFile>
                </el-form-item>
                <el-form-item label="用户名" prop="name">
                    <el-input type="text" v-model="ruleForm.name"></el-input>
                </el-form-item>
                <el-form-item label="邮箱" prop="email">
                    <el-input type="text" v-model="ruleForm.email"></el-input>
                </el-form-item>
                <el-form-item label="手机号" prop="phone">
                    <el-input type="text" v-model="ruleForm.phone"></el-input>
                </el-form-item>
                <el-form-item label="地址" prop="address">
                    <el-input type="text" v-model="ruleForm.address"></el-input>
                </el-form-item>
                <el-form-item label="性别" prop="sex">
                    <el-radio-group v-model="ruleForm.sex">
                        <el-radio-button :label="0">保密</el-radio-button>
                        <el-radio-button :label="1">男</el-radio-button>
                        <el-radio-button :label="2">女</el-radio-button>
                    </el-radio-group>
                </el-form-item>

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
            </el-form>
            <div slot="footer" class="formStore">
                <el-button type="primary" @click="submitForm">保存</el-button>
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
    h1{
        margin-bottom: 20px;
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
            }
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
                    console.log(res.data.img)
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
            if (1) {
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
