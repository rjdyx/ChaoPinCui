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
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" id="pop-form">
                <el-form-item label="用户名" prop="name">
                    用户名 <el-input type="text" v-model="ruleForm.name"></el-input>
                </el-form-item>
                <el-form-item label="邮箱" prop="email">
                    邮箱<el-input type="text" v-model="ruleForm.email"></el-input>
                </el-form-item>
                <el-form-item label="手机号" prop="phone">
                    手机号<el-input type="text" v-model="ruleForm.phone"></el-input>
                </el-form-item>
                <el-form-item label="地址" prop="address">
                    地址<el-input type="text" v-model="ruleForm.address"></el-input>
                </el-form-item>
                <el-form-item prop="sex">
                    <el-radio class="radio" v-model="ruleForm.sex" label="0">未知</el-radio>
                    <el-radio class="radio" v-model="ruleForm.sex" label="1">男</el-radio>
                    <el-radio class="radio" v-model="ruleForm.sex" label="2">女</el-radio>
                </el-form-item>
                <el-form-item prop="sex">
                    <el-date-picker
                      v-model="value1"
                      type="date"
                      placeholder="出生年月日"
                      :picker-options="pickerOptions0">
                    </el-date-picker>
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
            value1: '',
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
                    this.value1 = res.data.age
                }
                console.log(this.ruleForm)
            })
        },
        submitForm () {
        }
    }
}
</script>
