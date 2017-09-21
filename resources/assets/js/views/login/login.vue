/**
 * 
 * 登录组件
 * @description 
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <div class='login-bg'>
        <div class="admin-title">潮品萃后台</div>
        <el-form :model="form" :rules="rules" ref="form" label-width="80px" id="login">
            <el-form-item label="账号" prop="name">
                <el-input v-model="form.name" placeholder="请输入用户名/邮箱/手机号"></el-input>
            </el-form-item>
            <el-form-item label="密码" prop="password">
                <el-input v-model="form.password" type="password"  placeholder="请输入密码"></el-input>
            </el-form-item>
            <div id="login-btn">
                <el-button type="primary" @click="onSubmit">登录</el-button>
            </div>
        </el-form>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex'
    export default{
        name: 'Login',
        data () {
            var password = (rule, value, callback) => {
                callback(new Error('密码错误'))
            }
            return {
                form: {
                    name: '',
                    password: ''
                },
                rules: {
                    name: [
                        { required: true, message: '请输入密码', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请输入密码', trigger: 'blur' },
                        { min: 4, max: 15, message: '长度在 4 到 15 个字符', trigger: 'blur' }
                        // { validator: password, trigger: 'blur' }
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
                        let url = 'login'
                        let params = {user: this.form.name, password: this.form.password}
                        axios.post(url, params).then((res) => {
                            if (res.data === 200) {
                                this.$message('登录成功')
                                this.SET_IS_LOGIN(true)
                                this.$router.push('/')
                            } else {
                                this.$message('账号或密码错误')
                            }
                        })
                    }
                })
            }
        }
    }
</script>

<style lang="scss" scope>
    .admin-title {
        width: 100%;
        height: 100px;
        line-height: 100px;
        font-size: 30px;
        color: white;
        text-align: center;
        position: fixed;
        top: 24%;
        left: 1%;
    }
    .el-form-item__label{
        color: white !important;
    }
    .login-bg{background: #666;width: 100%;height:100%;}
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
