<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"/www/wwwroot/xbt.com/pubic/../application/admin/view/finance/presentation_audit.html";i:1572254538;}*/ ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>提现审核</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="/admin_style/layui/css/layui.css" media="all" />
	<link rel="stylesheet" href="//at.alicdn.com/t/font_1308190_7kttvg3l5i.css" media="all" />
    <!-- 提示 -->
	<style>
		.text-danger{
			color: red!important;
		}
		.text-success{
			color: green!important;
		}
	</style>
	<style>
		.layui-table-cell {
			font-size:16px;
			padding:0 5px;
			height:auto;
			overflow:visible;
			text-overflow:inherit;
			white-space:normal;
			word-break: break-all;
		}
		.layui-table-fixed {
			display: none!important;
		}
		.layui-table-fixed-r{
			display: none!important;
		}
		/*.layui-table-cell {*/
		/*	display: table;*/
		/*}*/
		/*#userList::-webkit-scrollbar { width: 0 !important }*/
		/*#userList { -ms-overflow-style: none; }*/
		/*#userList { overflow: -moz-scrollbars-none; }*/
	</style>
</head>

<body class="childrenBody">
	<form class="layui-form">
		<blockquote class="layui-elem-quote quoteBox">
			<form class="layui-form">
				<div class="layui-inline">
					<label class="layui-form-label">用户名：</label>
					<div class="layui-input-inline">
						<input type="tel" name="name" lay-verify="name" autocomplete="off" class="layui-input name"
							placeholder="请输入用户名">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">手机号：</label>
					<div class="layui-input-inline">
						<input type="tel" name="phone" lay-verify="phone" autocomplete="off" class="layui-input phone"
							placeholder="请输入手机号">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">申请时间：</label>
					<div class="layui-input-inline">
						<input type="text" name="time" lay-verify="time" class="layui-input time" id="application-Time"
							placeholder="请选择申请日期时间段">
					</div>

				</div>
				<div class="layui-inline">
					<label class="layui-form-label">身份：</label>
					<div class="layui-input-inline" style="width: 100px;">
						<select name="type" id="type" lay-verify="">
							<option value="1" selected>买手</option><!-- 默认选中 -->
							<option value="2" >商家</option><!-- 禁用 -->
						</select>
					</div>
				</div>

				<div class="layui-inline">
					<label class="layui-form-label">状态：</label>
					<div class="layui-input-inline" style="width: 100px;">
						<select name="state" id="state1" lay-verify="">
							<option value="" >全部</option><!-- 默认选中 -->
							<option value="0" >待审核</option><!-- 禁用 -->
							<option value="1" selected>已审核待转账</option>
							<option value="2">拒绝</option>
							<option value="3">转账成功</option>
						</select>
					</div>
				</div>
				<p style="margin-top: 10px;"></p>
				<br >
				<div class="layui-inline">
					<label class="layui-form-label">提现账户：</label>
					<div class="layui-input-inline">
						<input type="tel" name="account" lay-verify="account" autocomplete="off"
							class="layui-input account" placeholder="请输入银行卡号">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">收款人：</label>
					<div class="layui-input-inline">
						<input type="tel" name="bank_seller" lay-verify="bank_seller" autocomplete="off"
							   class="layui-input account" placeholder="请输入收款人姓名">
					</div>
				</div>

				<div class="layui-inline">
					<div class="layui-input-inline">
						<a class="layui-btn search_btn" data-type="reload" lay-filter="reload" lay-submit><i
								class="layui-icon">&#xe615;</i>搜 索</a>
						<a class="layui-btn layui-btn-normal" data-type="daochu" lay-filter="daochu" lay-submit><i class="layui-icon">&#xe605;</i>导 出</a>
					</div>
				</div>
			</form>
		</blockquote>
		<table id="userList" lay-filter="userList" style="min-width: 1900px;"></table>
		<!--头部-->
		<script type="text/html" id="toolbarDemo">
			<div class="layui-btn-container table-tool">
				<button class="layui-btn layui-btn-normal examineAll_btn">批量审核成功 <i class="layui-icon">&#xe605;</i></button>
				<button class="layui-btn layui-btn-normal refundsALL_btn">确认已返款成功 <i class="layui-icon">&#xe605;</i></button>
<!--				<button class="layui-btn layui-btn-normal add_btn">导出 <i class="iconfont icon">&#xe70f;</i></button>-->
			</div>
		</script>
		<!--审核状态-->
		<script type="text/html" id="state">
			{{#  if(d.newsStatus == "2"){ }}
			<span class="layui-red">不通过222</span>
			{{#  } else if(d.newsStatus == "1"){ }}
			<span class="layui-blue">等待审核</span>
			{{#  } else if(d.newsStatus == "0"){ }}
				审核通过
			{{#  } else { }}
				无法识别
			{{#  }}}
		</script>
	</form>
	<script type="text/javascript" src="/admin_style/layui/layui.js"></script>
	<script type="text/javascript" src="/admin_style/PresentationAudit.js"></script>
	<script src="/admin_style/assets/plugins/jquery/jquery.min.js"></script>
</body>

</html>
<script>
	layui.use(['form', 'layer', 'table', 'laytpl', 'laydate', 'upload'], function () {
		var form = layui.form;
		table = layui.table;
		//导出
		form.on("submit(daochu)", function (data) {
			var field = data.field;
			var name = $(".name").val(); //名字
			name = name ? name : 0;
			var phone = $(".phone").val(); //手机号
			phone = phone ? phone : 0;
			//第二种
			var time = field.time;  //时间
			time = time ? time : 0;
			var state = field.state; //状态 默认全部选中 请自行更改html
			state = state ? state : "88";//88表示未选择
			var type = field.type;
			type = type ? type : 0;
			var account = field.account; //账户
			account = account ? account : 0;
			//弹出loading 加载
			// var index = top.layer.msg('数据提交中，请稍候', { icon: 16, time: false, shade: 0.8 });
			window.open("<?php echo url('finance/cash_export','','',false); ?>/name/"+name+"/phone/"+phone+"/time/"+time+"/state/"+state+"/type/"+type+"/account/"+account);
		});


		/*点击回车登录*/
		$(document).on('keydown', function(e){
			if(event.keyCode == 13){
				e.preventDefault();//防止两次询问
				if($(".layui-layer-btn0").length<1){
					// 搜索条件
					var name = $("input[name=name]").val(); //姓名
					var time = $("input[name=time]").val(); //时间
					var phone = $("input[name=phone]").val(); //手机号
					var state = $('#state1 option:selected').val(); //状态
					var type = $('#type option:selected').val(); //身份
					var account = $("input[name=account]").val(); //账户
					var bank_seller = $("input[name=bank_seller]").val(); //开户人
					var qq = $("input[name=qq]").val(); //QQ号
					table.reload('userListTable', {
						method: 'post'
						, where: {
							'name': name, //姓名
							'time': time,    //时间
							'phone': phone,  //手机号
							'state': state, //状态
							'type': type, //身份
							'account': account, //账户
							'bank_seller': bank_seller, //开户人
							'qq': qq, //QQ号
						}
						, page: {
							curr: 1
						}
					});
					setTimeout(function () {
						//top.layer.close(index);
						top.layer.msg("操作成功！");
					}, 500);
					return false;
				}
			}

		})
	})
</script>
