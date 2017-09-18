/**
 * 
 * 登录组件
 * @description 
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <div>
        <button @click="store">store</button>
    </div>
</template>
<style lang="sass" scoped>
    @import "../../../sass/function";
</style>
<script>
    export default{
        name: 'Login',
        methods: {
            store () {
                let params = {
                    name: '潮州农业局',
                    address: '潮州',
                    memo: '123'
                }
                axios.post('admin/unit', params)
                    .then((response) => {
                        console.log(response.data)
                    })
            }
        }
    }
</script>
