<template>
    <el-dialog :title="title" size="small" :visible.sync="dialogTableVisible" :show-close="false">
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" id="pop-form">
            <template v-for="pro of Object.keys(rows)">
                <!-- 隐藏域 -->
                <el-form-item v-if="rows[pro].type === 'hidden'">
                    <el-input type="hidden" :value="hiddenValue(pro, rows[pro].value)"></el-input>
                </el-form-item>
                <!-- 普通输入框 -->
                <el-form-item v-if="!rows[pro].type && !rows[pro].component || rows[pro].type === 'input'" :label="rows[pro].label" :prop="pro">
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
                    <el-select v-model="ruleForm[pro]" filterable :placeholder="rows[pro].placeholder" id="el-select">
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

                <el-form-item v-else-if="rows[pro].component" :label="rows[pro].label" :prop="pro">
                    <component
                        :is="rows[pro].component"
                        :isEdit="isEdit"
                        :scope="scope"
                        :row="rows[pro]"
                        :pro='pro'
                        :componentParam="rows[pro].componentParam"
                        @emit="returnValue"
                    ></component>
                </el-form-item>
            </template>
        </el-form>
        <div slot="footer">
            <el-button type="primary" @click="submitForm('ruleForm')">
                <template v-if="!isEdit">新建</template>
                <template v-else>保存</template>
            </el-button>
            <el-button @click="handleClose('ruleForm')">取消</el-button>
        </div>
    </el-dialog>
</template>

<script>
    import { mapMutations } from 'vuex'
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
            scope: {
                type: Object,
                default () {
                    return {row: {}}
                }
            },
            isEdit: {
                type: Boolean,
                default: false
            },
            url: {
                type: String,
                default: ''
            }
        },
        data () {
            return {
                dialogTableVisible: true,
                ruleForm: {},
                rules: {},
                defaultImg: '',
                title: this.isEdit ? '编辑' : '新增'
            }
        },
        mounted () {
            let ruleForm = {}
            let rules = {}
            for (let pro in this.rows) {
                if (this.rows[pro].rules) {
                    rules[pro] = this.rows[pro].rules
                }
                if (!this.isEdit) {
                    ruleForm[pro] = ''
                } else {
                    ruleForm[pro] = this.scope.row[pro]
                }
            }
            // 编辑继续传值
            if (this.isEdit) {
                for (let i in this.scope.row) {
                    ruleForm[i] = this.scope.row[i]
                }
                if (ruleForm.img !== undefined) {
                    this.defaultImg = ruleForm.img
                }
            }
            if (JSON.stringify(rules) !== '{}') {
                this.$set(this, 'rules', rules)
            }
            this.$set(this, 'ruleForm', ruleForm)
        },
        methods: {
            ...mapMutations([
                'PUSH_TABLE_DATA',
                'UPDATE_TABLE_DATA'
            ]),
            hiddenValue (k, v) {
                this.ruleForm[k] = v
                return v
            },
            // 改变为表单数据格式
            formDataCl () {
                let form = new FormData()
                for (let key of Object.keys(this.ruleForm)) {
                    if (this.ruleForm[key] === '' || this.ruleForm[key] === null) {
                        this.ruleForm[key] = ''
                    }
                    form.append(key, this.ruleForm[key])
                }
                return form
            },
            submitForm (formName) {
                console.dir(this.ruleForm)
                let headers = {headers: {'Content-Type': 'multipart/form-data'}}
                let form = this.formDataCl()
                this.$refs[formName].validate(async (valid) => {
                    if (valid) {
                        if (!this.isEdit) {
                            await this.$ACT_ADDACTIVE({vm: this, id: this.ruleForm.id, obj: this.ruleForm})
                            axios.post(this.$adminUrl(this.url), form, headers)
                                .then(async (responce) => {
                                    if (responce.data) {
                                        let tmp = await this.$ACT_ADDEDACTIVE({vm: this, id: this.ruleForm.id, obj: this.ruleForm, res: responce})
                                        let newOne = this.$deepClone(tmp ? tmp : this.ruleForm)
                                        newOne = this.$changeObj(newOne, responce.data)
                                        this.PUSH_TABLE_DATA(newOne)
                                        this.$message({
                                            message: '新增成功',
                                            type: 'success'
                                        })
                                        this.handleClose()
                                    }
                                })
                        } else {
                            let id = this.scope.row.id
                            form.append('_method', 'PUT')
                            await this.$ACT_EDITACTIVE({vm: this, id: id, obj: this.ruleForm})
                            axios.post(this.$adminUrl(this.url) + '/' + id, form, headers)
                                .then(async (responce) => {
                                    if (responce.data) {
                                        let tmp = await this.$ACT_EDITEDACTIVE({vm: this, id: this.ruleForm.id, obj: this.ruleForm, res: responce})
                                        let newOne = this.$deepClone(tmp ? tmp : this.ruleForm)
                                        newOne = this.$changeObj(newOne, responce.data)
                                        this.UPDATE_TABLE_DATA({index: this.scope.$index, newOne: newOne})
                                        this.$message({
                                            message: '修改成功',
                                            type: 'success'
                                        })
                                        this.$refs['ruleForm'].resetFields()
                                        this.handleClose()
                                    }
                                })
                        }
                    } else {
                        this.$message({
                            type: 'error',
                            message: '提交错误'
                        })
                        return false
                    }
                })
            },
            handleClose () {
                this.ruleForm = {}
                this.$emit('handleClose')
            },
            returnValue ({pro, val}) {
                if (pro === 'img' || pro === 'ico') {
                    if (val.name !== undefined) {
                        this.ruleForm[pro + 's'] = val
                        if (this.url === 'turn' || this.url === 'img') {
                            this.ruleForm[pro] = this.defaultImg ? this.defaultImg : val.name
                        }
                    } else if (val === 'del') {
                        this.ruleForm[pro + 's'] = 'del'
                        if (this.url === 'turn' || this.url === 'img') {
                            this.ruleForm[pro] = ''
                        }
                    } else {
                        this.ruleForm[pro] = val
                    }
                } else {
                    this.ruleForm[pro] = val
                }
            }
        }
    }
</script>
<style scope>
    #pop-form {
        margin: auto;
        width: 618px;
    }

    #el-select {
        display: block;
    }
</style>
