/**
 * 中间内容标题组件
 * @author 舒丹彤
 * @date 2017/3/15 
 * 
 */ 
<template>
    <div class="title">
        <h2>{{title}} | {{subTitle}}</h2>   
        <a class="back" @click="back" v-if="isShow">
          <span class="back_icon"></span>
          <span class="back_text">返回</span>
        </a>
    </div>
</template> 

<script>
    export default {
        name: 'ContainTitle',
        props: {
            // 大标题
            title: {
                type: String,
                default: ''
            },
            // 小标题
            subTitle: {
                type: String,
                default: ''
            },
            // 是否显示返回按钮
            isShow: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            back () {
                this.$router.go(-1)
            }
        }
    }
</script>

<style lang="sass" scoped>
@import "../../../../sass/function";
.title {
    padding: 0px 8px 14px 0;
    border-bottom: 2px solid #e5e5e5;
    // font-size: 18px;
    margin-bottom: 10px;
    h2 {
        border-radius: 4px;
        padding-left: 14px;
        display: inline-block;
        font-family: YouYuan;
        color: #333;
        font-weight: 400;
    }
    .back{
        display: inline-block;
        float: right;
        border: 1px solid #dcdcdc;
        border-radius: 4px; 
        padding: 0px 10px 2px 0px;
        &:hover{
            cursor: pointer;
            .back_text{
                color: #ccc;
            }
        }
        .back_icon{
            display: inline-block;
            width: 28px;
            height: 15px;
            vertical-align: middle;
            margin-right: 5px;
        }
    }
}
</style>
