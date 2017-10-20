/**
 *  对话框基本组件
 * 	props
 * 		|-title          对话框标题
 * 		|-visible        对话框显示
 * 		|-size           对话框大小详情参考elementUI文档，参数tiny/small/large/full
 * 	
 * 	slot
 * 		|-basicDialogMain   对话框主体插口
 * 		|-basicDialogFooter 对话框脚部插口
 *  
 *  methods
 * 		|-close 默认关闭对话框通讯方法
 * 	
 * 	add by suzhihao (2017.10.20)
 */
<template>
	<el-dialog :title="title" :size="size" :visible.sync="visible" :show-close="false" :close-on-click-modal="false">
		<slot name="basicDialogMain"></slot>
		<div slot="footer">
			<slot name="basicDialogFooter"></slot>
			<el-button type="primary" @click="close">关闭</el-button>
		</div>
	</el-dialog>
</template>
<script>
	export default {
		name: 'basicdialog',
		props: {
			title: {
				type: String,
				default: '对话框'
			},
			visible: {
				type: Boolean,
				default: false
			},
			size: {
				type: String, 
				default: 'small'
			}
		},
		methods: {
			close () {
				this.$emit('close')
			}
		}
	}
</script>
