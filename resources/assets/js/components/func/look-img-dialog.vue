/**
 *  图片查看组件
 *  
 * 	components
 * 		|-BasicDialog 基本对话框组件
 *
 * 	props
 * 		|-title     对话框标题
 * 		|-visible   对话框显示控制
 * 		|-imgUrl    当前行的图片路径字符串，多个图片时默认用逗号分隔
 * 
 * 	data
 * 		|-visible   对话看显示控制
 *  
 *  methods
 * 		|-close 关闭对话框方法
 * 	
 * 	add by suzhihao (2017.10.20)
 */
<template>
	<BasicDialog
		:title="title"
		:visible="visible"
		:size="'full'"
		v-on:close="close"
		class="dialog">
		<div slot="basicDialogMain" class="look_img">
			<i v-if="imgs.length > 1" class="look_img_control el-icon-caret-left" @click="left"></i>
			<img :src="imgs[idx]" alt="">
			<i v-if="imgs.length > 1" class="look_img_control el-icon-caret-right" @click="right"></i>
		</div>
	</BasicDialog>
</template>
<script>
	import BasicDialog from 'components/dialog/basic-dialog.vue'
	export default {
		name: 'LookImgDialog',
		components: {
			BasicDialog
		},
		props: {
			title: {
				type: String,
				default: '图片查看'
			},
			visible: {
				type: Boolean,
				default: false
			},
			imgUrl: String
		},
		data () {
			return {
				imgs: [],
				idx: 0
			}
		},
		mounted () {
			if (this.imgUrl !== null && this.imgUrl !== '') {
				this.imgs = this.imgUrl.split(',')
			}
		},
		methods: {
			close () {
				this.$emit('close')
			},
			left () {
				if (this.idx) {
					this.idx -= 1
				} else {
					this.idx = this.imgs.length - 1
				}
			},
			right () {
				if (this.idx === (this.imgs.length - 1)) {
					this.idx = 0
				} else {
					this.idx += 1
				}
			}
		},
		watch: {
			imgUrl () {
				if (this.imgUrl !== null && this.imgUrl !== '') {
					this.imgs = this.imgUrl.split(',')
				}
			}
		}
	}
</script>
<style lang="sass">
	@import "../../../sass/mixins/_maxScreen.scss";

	.dialog {
		cursor: default;
		.el-dialog__body {
			height: auto;
			max-height: 100%;
		}
		@include maxScreen(1920px) {
			.look_img {
				width: 1800px;
				height: 700px;
			}
		}

		@include maxScreen(1600px) {
			.look_img {
				width: 1500px;
				height: 600px;
			}
		}

		@include maxScreen(1366px) {
			.look_img {
				width: 1200px;
				height: 500px;
			}
		}
		.look_img {
			position: relative;
			margin: 0 auto;
			text-align: center;
			.look_img_control {
				position: absolute;
				top: 50%;
				display: block;
				font-size: 28px;
				cursor: pointer;
			}
			.look_img_control.el-icon-caret-left {
				left: 0;
			}
			.look_img_control.el-icon-caret-right {
				right: 0;
			}
			img {
				display: block;
				margin: 0 auto;
				user-select: none;
			}
		}
	}
	
</style>