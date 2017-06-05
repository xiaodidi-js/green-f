<style scoped>

	.img-area{
		width:100%;
		height:auto;
		font-size:0;
		text-align:left;
	}

	.img-area .image{
		display:inline-block;
		vertical-align:middle;
		width:22%;
		padding-top:22%;
		margin-right:3%;
		border:#D6D5D5 solid 0.1rem;
		background-color:#EFEFEF;
		background-position:center;
		background-size:cover;
		background-repeat:no-repeat;
		position:relative;
		z-index:2;
		text-align:center;
		box-sizing:border-box;
		-webkit-box-sizing:border-box;
	}

	.img-area .image:first-child{
		margin-left:1.5%;
	}

	.img-area .image:last-child{
		margin-right:1.5%;
	}

	.img-area .image.uploaded{
		background-size:cover;
	}

</style>

<template>
	<div class="img-area">
		<div class="image" class="uploaded" v-for="img in imgs" v-lazy:background-image="img.src" @click="$refs.previewer.show($index)">
		</div>
	</div>
	<previewer :list="imgs" v-ref:previewer :options="options"></previewer>
</template>

<script>
	import Previewer from 'vux/src/components/previewer' 

	export default{
		props: {
			imgs: {
				type: Array,
				default() {
					return []
				}
			}
		},
		components: {
			Previewer
		},
		data() {
			return {
				options: {
					getThumbBoundsFn (index) {
			          // find thumbnail element
			          let thumbnail = document.querySelectorAll('.image')[index]
			          // get window scroll Y
			          let pageYScroll = window.pageYOffset || document.documentElement.scrollTop
			          // optionally get horizontal scroll
			          // get position of element relative to viewport
			          let rect = thumbnail.getBoundingClientRect()
			          // w = width
			          return {x: rect.left, y: rect.top + pageYScroll, w: rect.width}
			          // Good guide on how to get element coordinates:
			          // http://javascript.info/tutorial/coordinates
			        }
				}
			}
		}
	}
</script>