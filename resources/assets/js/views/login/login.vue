/**
 * 
 * 登录组件
 * @description 
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <el-form :model="form" :rules="rules" ref="form" label-width="80px" id="login">
        <el-form-item label="用户名" prop="name">
            <el-input v-model="form.name" :disabled="true"></el-input>
        </el-form-item>
        <el-form-item label="密码" prop="password">
            <el-input v-model="form.password" type="password"></el-input>
        </el-form-item>
        <div id="login-btn">
            <el-button type="primary" @click="onSubmit">登录</el-button>
        </div>
    </el-form>
</template>

<script>
    import { mapMutations } from 'vuex'
    export default{
        name: 'Login',
        data () {
            var password = (rule, value, callback) => {
                if (value !== '123456') {
                    callback(new Error('密码错误'))
                } else {
                    callback()
                }
            }
            return {
                form: {
                    name: 'admin',
                    password: ''
                },
                rules: {
                    name: [
                        { required: true, message: '请输入密码', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请输入密码', trigger: 'blur' },
                        { min: 6, max: 15, message: '长度在 6 到 15 个字符', trigger: 'blur' },
                        { validator: password, trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            ...mapMutations([
                'SET_IS_LOGIN'
            ]),
            onSubmit () {
                this.$refs['form'].validate((valid) => {
                    if (valid) {
                        if (this.form.password === '123456') {
                            this.SET_IS_LOGIN(true)
                            this.$router.push('/')
                        }
                    }
                })
            }
        }
    }
</script>

<style lang="sass" scope>
    #login {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 300px;
        height: 152px;
        margin: auto;

        #login-btn {
            width: 60px;
            margin: auto;
        }
    }
</style>
