/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <div id="head">
        <h1 id="title">潮品萃</h1>
        <div id="content">
            <ul class="left">
                <li style="float: left;"><router-link to="/index/home">首页</router-link></li>
                <div style="float: left;">登录账户：</div>
            </ul>
            <ul class="right">
                <li>
                    <el-button @click="logout">退出</el-button>
                </li>
            </ul>
            <div style="float: right;margin-right: 30px;">
                {{date}}
            </div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
    @import "../../../sass/function";
    #head {
        position: absolute;
        top: 0;
        left: 0;
        height: 3rem;
        width: 100%;
        height: pxToRem(48);
        font-size: pxToRem(14);
        background-color: #2F3847;
        color: white;
        z-index: 102;

        #title {
            float: left;
            height: pxToRem(48);
            line-height: pxToRem(48);
            width: 100px;
            text-align: center;
            font-size: 20px;
        }

        #content {
            height: pxToRem(48);
            line-height: pxToRem(48);

            ul.left {
                float: left;
                // margin-left: 39px;

                li {
                    width: pxToRem(85);
                    text-align: center;
                    cursor: pointer;
                    a{ color:white; }
                }
            }

            ul.right {
                float: right;
                margin-right: 30px;

                li {
                    display: inline-block;
                    width: pxToRem(85);
                    text-align: center;
                    cursor: pointer;

                    button {
                        color: white;
                        background: #2f3847;
                    }
                }
            }
            
            li:hover {
                background: black;
            }
        }
    }
</style>

<script>
    import { mapMutations } from 'vuex'
    export default{
        name: 'MyHeader',
        data () {
            return {
                date: ''
            }
        },
        mounted () {
            let _this = this
            setInterval(function(){
                let myDate = new Date()
                _this.date = myDate.toLocaleDateString() + '  ' + myDate.toLocaleTimeString()
            }, 1000)
        },
        methods: {
            ...mapMutations([
                'SET_IS_LOGIN'
            ]),
            logout () {
                this.$confirm('你是否要退出后台?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    let url = 'logout'
                    axios.get(url).then((res) => {
                        if (res.data === 200) {
                            this.$message({
                                type: 'success',
                                message: '退出成功!'
                            })
                            var _this = this
                            setInterval(function () {
                                _this.SET_IS_LOGIN(false)
                                _this.$router.push('/login')
                            }, 500)
                        }
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消退出'
                    })        
                })
            }
        }
    }
</script>
