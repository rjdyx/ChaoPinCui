/**
 * 修改
 * (1)在动态组件处新增ruleForm属性 (2017/10/19)
 */
<template>
    <el-dialog :title="title" size="small" :visible.sync="dialogTableVisible" :show-close="false" :close-on-click-modal="false">
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
                        :ruleForm='ruleForm'
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
            <el-button @click="cancelClose()">取消</el-button>
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
                    return {}
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
                    ruleForm[pro] = this.rows[pro].value != undefined ? this.rows[pro].value : ''
                } else {
                    ruleForm[pro] = this.scope.row[pro]
                }
            }
            // 编辑继续传值
            if (this.isEdit) {
                for (let i in this.scope.row) {
                    // 下拉选择类型的数据_id需要把字符串类型转换成数字类型
                    ruleForm[i] = i.indexOf('_id') > -1 ? parseInt(this.scope.row[i]) : this.scope.row[i]
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
                                        this.handleClose('new')
                                    }
                                })
                        } else {
                            let id = this.scope.row.id
                            form.append('_method', 'PUT')
                            await this.$ACT_EDITACTIVE({vm: this, id: id, obj: this.ruleForm})
                            axios.post(this.$adminUrl(this.url) + '/' + id, form, headers)
                                .then(async (responce) => {
                                    if (responce.data) {
                                        if (responce.data === 'notallow') {
                                            this.$message('同级用户，没有权限对其进行编辑操作')
                                            return false
                                        }
                                        let tmp = await this.$ACT_EDITEDACTIVE({vm: this, id: this.ruleForm.id, obj: this.ruleForm, res: responce})
                                        let newOne = this.$deepClone(tmp ? tmp : this.ruleForm)
                                        newOne = this.$changeObj(newOne, responce.data)
                                        this.UPDATE_TABLE_DATA({index: this.scope.$index, newOne: newOne})
                                        this.$message({
                                            message: '修改成功',
                                            type: 'success'
                                        })
                                        this.$refs['ruleForm'].resetFields()
                                        this.handleClose('edit')
                                    }
                                })
                        }
                    } else {
                        this.$message('请正确填写输入框信息')
                        return false
                    }
                })
            },
            cancelClose () {
                if (this.isEdit) {
                    this.handleClose('edit')
                } else {
                    this.handleClose('new')
                }
            },
            handleClose (val) {
                // 在分类或者分类子类改变后对分类缓存进行更新
                if (this.url === 'category' || this.url === 'category_child') {
                    this.$store.dispatch('GET_ALL_DATAS', {type: 'category', refresh: true})
                }
                this.ruleForm = {}
                this.$emit('handleClose', val)
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
