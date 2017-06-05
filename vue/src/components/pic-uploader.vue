<style scoped>

	.img-area{
		width:100%;
		height:auto;
		font-size:0;
		text-align:center;
	}

	.img-area .image{
		display:inline-block;
		vertical-align:middle;
		width:22%;
		padding-top:22%;
		margin-right:3%;
		border:#D6D5D5 solid 1px;
		background-image:url('../images/camera.png');
		background-position:center;
		background-size:40%;
		background-repeat:no-repeat;
		position:relative;
		z-index:2;
		box-sizing:border-box;
		-webkit-box-sizing:border-box;
	}

	.img-area .image:first-child{
		/*margin-left:1.5%;*/
	}

	.img-area .image:last-child{
		margin-right:1.5%;
	}

	.img-area .image.unupload{
		transition:all 300ms;
		transform:scale(0);
	}

	.img-area .image.unupload.active{
		transform:scale(1);
	}

	.img-area .image.unupload.active:active{
		background-size:30%;
		background-color:#F9F9F9;
	}

	.img-area .image.uploaded{
		background-size:cover;
	}

	.img-area .image.loading{
		background-image:none;
		background-color:rgba(0,0,0,0.5);
	}

	.img-area .image>.vux-spinner{
		display:none;
	}

	.img-area .image.loading>.vux-spinner{
		display:inline-block;
	}

	.img-area .image>.cross{
		width:1.4rem;
		height:1.4rem;
		font-size:1.3rem;
		color:#ccc;
		line-height:1.2rem;
		position:absolute;
		top:-0.7rem;
		right:-0.7rem;
		background-color:rgba(0,0,0,0.5);
		border-radius:0.7rem;
		display:none;
	}

	.img-area .image.uploaded>.cross{
		display:block;
	}

	.img-area .image>input[type='file']{
		display:none;
	}

	.white-spinner.vux-spinner{
		stroke:#ccc;
		fill:#ccc;
		margin-top:-100%;
		z-index:1;
	}

</style>

<template>
	<div class="img-area">
		<div class="image" @click="addPic($index)"
			 :class="{'unupload':img.state===0,'loading':img.state===1,'uploaded':img.state===2,'active':img.active===1}"
			 :style="{backgroundImage:img.url.length>0 ? 'url('+img.url+')' : ''}"
			 v-for="img in imgs">
			<spinner type="bubbles" class="white-spinner"></spinner>
			<input type="file" id="img{{ pid }}{{ $index }}" name="imgs[]" @click="fileClick($index)" @change="getImage($index)" accept="image/jpeg,image/png,image/gif" />
			<div class="cross" @click="delPic($index)">×</div>
		</div>
	</div>
</template>

<script>
	import Spinner from 'vux/src/components/spinner'

	export default{
		props: {
			pid: {
				type: [String,Number],
				default: 0
			},
			imgs: {
				type: Array,
				required: true,
				twoWay: true
			},
			toastMessage: {
				type: String,
				default: '',
				twoWay: true
			},
			toastShow: {
				type: Boolean,
				default: false,
				twoWay: true
			},
			ftype: {
				type: String,
				default: 'file'
			}
		},
		components: {
			Spinner
		},
		data() {
			return {

			}
		},
		methods: {
			addPic: function(index){
				if(this.imgs[index].state!==0){
					return true;
				}
				document.getElementById('img'+this.pid+index).click();
			},
			delPic: function(index){
				let hideTag = false;
				let evt = window.event;
				evt.stopPropagation();
				this.imgs[index].state = 0;
				this.imgs[index].url = '';
				document.getElementById('img'+this.pid+index).value = '';
				for(let i=0;i<this.imgs.length;i++){
					if(hideTag===false&&this.imgs[i].state===0){
						hideTag = true;
						this.imgs[i].active = 1;
					}else if(hideTag===true&&this.imgs[i].state===0){
						this.imgs[i].active = 0;
					}
				}
			},
			fileClick: function(index){
				let evt = window.event;
				evt.stopPropagation();
				document.getElementById('img'+this.pid+index).value = '';
			},
			getImage: function(index){
				let file = document.getElementById('img'+this.pid+index);
				this.imgs[index].state = 1;
				if(this.handleFiles(file.files[0],index)===false){
					this.imgs[index].state = 0;
					file.value = '';
					return false;
				}
			},
			handleFiles: function(file,index){
				if(!this.checkImg(file.type)){
					this.toastMessage = '上传文件类型不是图片';
					this.toastShow = true;
					return false;
				}
				this.getUpInfo(file,index);
			},
			checkImg: function(getType=''){
				if(getType==='' || typeof getType !== 'string'){
					return false;
				}
				let exts = ['jpg','jpeg','gif','png'];
				let tarr = getType.split('/')[1];
				return exts.indexOf(tarr)>=0 ? true : false;
			},
			getUpInfo: function(file,index){
				if(typeof file === 'undefined' || file === null){
					return false;
				}
				let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
				ustore = JSON.parse(ustore);
				this.$http.put(localStorage.apiDomain+'/public/index/user/makeInfoForUpyun',{'allow-file-type':'jpg,jpeg,gif,png','ext-param':this.ftype+','+ustore.id+',1','ftype':file.type}).then((response)=>{
					let resdata = response.data;
					if(resdata.status===1){
						this.uploadImgToUpyun(resdata.url,file,resdata.policy,resdata.signature,index,resdata.domain,resdata.notify,resdata.param,resdata.thumb);
					}else{
						this.toastMessage = resdata.info;
						this.toastShow = true;
						this.uploadFailed(index);
					}
				},(response)=>{
					this.toastMessage = "网络开小差啦~";
					this.toastShow = true;
					this.uploadFailed(index);
				});
			},
			uploadImgToUpyun: function(url,file,policy,signature,index,domain,notify,params,thumb='') {
				let formData = new FormData();
				formData.append('file',file);
				formData.append('policy',policy);
				formData.append('signature',signature);
				formData.append('notify-url',notify);
				formData.append('ext-param',params);
				formData.append('x-gmkerl-thumb',thumb);
				let context = this;
				this.$http.post(url,formData).then((response)=>{
				    console.log(response.data);
					let gdata = response.data;
					let upurl = domain + gdata.url;
					context.imgs[index].state = 2;
					context.imgs[index].url = upurl;
					context.imgs[index].w = gdata['image-width'];
					context.imgs[index].h = gdata['image-height'];
					if(index < 3) {
						context.imgs[index+1].active = 1;
					}
				},(response)=>{
					this.toastMessage = "网络开小差啦~";
					this.toastShow = true;
					this.uploadFailed(index);
				});
			},
			uploadFailed: function(index){
				this.imgs[index].state = 0;
				document.getElementById('img' + this.pid + index).value = '';
			}
		}
	}
</script>