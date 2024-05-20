<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"/www/wwwroot/xbt.com/pubic/../application/seller/view/goods/goods.html";i:1593439628;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="/static/seller/node_modules/element-ui/lib/theme-chalk/index.css" rel="stylesheet" type="text/css" />
		<script src="/static/seller/js/jquery.min.js"></script>
		<script charset="utf-8" src="/static/seller/js/vue.js" type="text/javascript"></script>
		<script src="/static/seller/node_modules/element-ui/lib/index.js"></script>
		<link href="/static/seller/css/new_goods.css" rel="stylesheet" type="text/css" />
		<script charset="utf-8" src="/static/seller/layer/layer.js" type="text/javascript"></script>
		<script src="/static/seller/js/axios.min.js"></script>
		<title></title>
	</head>
	<body>
		<div id="menu">
			<el-form :model="goods" class="demo-ruleForm" inline-message='false' label-width="100px" ref="ruleForm">
				<el-form-item label="宝贝链接:" prop="link" style='width:600px;'>
					<el-input placeholder="请输入内容" v-model="goods.link"></el-input>
				</el-form-item>
				<el-form-item label="店铺名称:" prop="region">
					<el-select placeholder="请选择" v-model="goods.shop_id">
						<el-option :disabled='true' label="请选择" value="0"></el-option>
						<el-option :label="item.shop_name" :value="item.id" v-for="(item,a) in shops" :key="a"></el-option>
					</el-select>
				</el-form-item>
				<el-form-item label="宝贝名称:" prop="name" style='width:600px;'>
					<el-input placeholder="请输入内容" v-model="goods.name"></el-input>
				</el-form-item>
				<el-form-item label="核对数字:" prop="pass" v-if="state">
					<el-input placeholder="请输入6位纯数字" style='width: 216px;' v-model="goods.number"></el-input>
				</el-form-item>
				<el-form-item label="宝贝主图">
					<el-upload
							action="<?php echo url('goods/goodsImg'); ?>"
							list-type="picture-card"
							:on-preview="handlePictureCardPreview"
							:on-remove="handleRemove"
							:on-success="imgSuccress"
							:before-upload="beforeUploads">
						<i class="el-icon-plus"></i>
					</el-upload>
					<el-dialog :visible.sync="showImg" width="500px">
						<img width="100%" :src="imgUrl" alt="">
					</el-dialog>
				</el-form-item>
				<el-form-item class='show' label="搜索页面展示价格：" prop="show">
					<el-input-number :min="0" v-model="goods.show_price"></el-input-number>&nbsp;&nbsp;元
					<b>非必填，如该商品有满减、促销、多规格等情况，请填写此金额</b>
				</el-form-item>
			</el-form>
			<div class="el">
				<el-button @click='storage()' style='width: 198px;' type="danger">保存</el-button>
			</div>
		</div>
	</body>
	<script>
		var name = new Vue({
			el: "#menu",
			data: function() {
				return {
					state:"<?php echo $state; ?>",
					goods:{
						link:'',
						shop_id:'',
						name:'',
						number:'',
						show_price:'',
						pc_img:[],
					},
                    shops:[],
                    imgUrl:'',
                    showImg:false,
				}
			},
			mounted:function(){
				that = this;
				this.getData();
			},
			methods: {
                imgSuccress:function(res){
                    if(res.code==1){
                        this.goods.pc_img.push(res.data);
                    }else{
                        layer.alert(res.msg);
                    }
                },
                handleRemove:function(file, fileList) {
                    var i = 0;
                    this.goods.pc_img = [];
                    for(i;i<fileList.length;i++){
                        this.goods.pc_img.push(fileList[i].response.data);
                    }
                },
                handlePictureCardPreview:function(file) {
                    this.imgUrl = file.url;
                    this.showImg = true;
                },
                beforeUploads:function(file){
                    const isJPEG = file.type === 'image/jpeg';
                    const isPNG = file.type === 'image/png';
                    const isJPG = file.type === 'image/jpg';
                    const isLt2M = file.size / 1024 / 1024 < 5;

                    if (!isJPEG && !isPNG && !isJPG) {
                        return layer.msg('上传图片格式错误!',{icon:2});
                    }
                    if (!isLt2M) {
                        return layer.msg('上传头像图片大小不能超过 5MB!',{icon:2});
                    }
                },
				getData:function(){
					var that = this;
					$.post("<?php echo url('goods/goods'); ?>",{},function(res){
						if(res.code==1){
							that.shops = res.data.shop;
                            console.log(that.shops);
                        }else{
							layer.msg('网络错误',{icon:2});
						}
					})
				},
				// 整个保存判断
				storage(){
					if(this.state==1){
						if(!this.goods.number)return layer.msg('请填写核对数字',{icon:2,time:2000});
					}
					$.post("<?php echo url('goods/goodsAdd'); ?>",this.goods,function(res){
						if(res.code==1){
							layer.msg(res.msg,{icon:1,time:2000},function(){
								window.parent.location.reload();
							});
						}else{
							return layer.msg(res.msg,{icon:2,time:2000});
						}
					})
				},
			},
			//默认显示买家下单添加小数两位
			created: function() {
			}
		});
	</script>
</html>
