<template>
    <el-dialog title="新增" size="tiny" :visible.sync="dialogTableVisible" :show-close="false">
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" id="pop-form">
            <template v-for="pro of Object.keys(rows)">
                <!-- 普通输入框 -->
                <el-form-item v-if="!rows[pro].type || rows[pro].type === 'input'" :label="rows[pro].label" :prop="pro">
                    <el-input
                        v-model="ruleForm[pro]"
                        :placeholder="rows[pro].placeholder"
                    ></el-input>
                </el-form-item>
                <!-- 密码输入框 -->
                <el-form-item v-else-if="rows[pro].type === 'password'" :label="rows[pro].label" :prop="pro">
                    <el-input
                        v-model="ruleForm[pro]"
                        type="password"
                    ></el-input>
                </el-form-item>
                <!-- 下拉框 -->
                <el-form-item v-else-if="rows[pro].type === 'select'" :label="rows[pro].label" :prop="pro">
                    <el-select v-model="ruleForm[pro]" :placeholder="rows[pro].placeholder" id="el-select">
                        <el-option 
                            v-for="(option, index) in rows[pro].options" 
                            :label="option[rows[pro].optionLabel]" 
                            :value="option[rows[pro].optionValue]"
                            :key="index">
                        </el-option>
                    </el-select>
                </el-form-item>
                <!-- 文本框 -->
                <el-form-item v-else-if="rows[pro].type === 'textarea'" :label="rows[pro].label" :prop="pro">
                    <el-input type="textarea" v-model="ruleForm[pro]"></el-input>
                </el-form-item>
            </template>
            
            
            <el-form-item>
                <el-button type="primary" @click="submitForm('ruleForm')">新建</el-button>
                <el-button @click="handleClose">取消</el-button>
            </el-form-item>
        </el-form>
    </el-dialog>
</template>

<script>
    export default {
        props: {
            isNewShow: {
                type: Boolean,
                default: false
            },
            rows: {
                type: Object,
                default () {
                    return {
                        name: {
                            label: '预案名称',
                            rules: [
                                { required: true, message: '请输入活动名称', trigger: 'blur' },
                                { min: 3, max: 5, message: '长度在 3 到 5 个字符', trigger: 'blur' }
                            ],
                            value: '',
                            type: 'input',
                            placeholder: '必填'
                        },
                        password: {
                            label: '密码',
                            rules: [
                                { required: true, message: '请输入密码', trigger: 'blur' },
                                { min: 6, max: 15, message: '长度在 6 到 15 个字符', trigger: 'blur' }
                            ],
                            value: '',
                            type: 'password'
                        },
                        type: {
                            label: '事件类型',
                            rules: [
                                { required: true, type: 'number', message: '请选择类型', trigger: 'change' }
                            ],
                            options: [{id: 1, name: '预警事件'}, {id: 2, name: '突发事件'}],
                            optionLabel: 'name',
                            optionValue: 'id',
                            value: '',
                            type: 'select',
                            placeholder: '请选择事件类型'
                        },
                        memo: {
                            label: '备注',
                            rules: [
                                { required: false }
                            ],
                            value: '',
                            type: 'textarea'
                        }
                    }
                }
            },
            isEdit: {
                type: Boolean,
                default: false
            }
        },
        data () {
            let ruleForm = {}
            let rules = {}
            for (let pro in this.rows) {
                ruleForm[pro] = this.rows[pro].value
                if (this.rows[pro].rules) {
                    rules[pro] = this.rows[pro].rules
                }
            }
            return {
                ruleForm: ruleForm,
                rules: rules
            }
        },
        computed: {
            dialogTableVisible () {
                return this.isNewShow
            }
        },
        methods: {
            submitForm (formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        alert('submit!')
                    } else {
                        console.log('error submit!!')
                        return false
                    }
                })
            },
            handleClose (done) {
                this.$emit('handleClose', done)
            }
        }
    }
</script>

<style scope>
    #pop-form {
        width: 355px;
    }

    #el-select {
        width: 100%
    }
</style>