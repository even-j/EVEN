<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"/www/wwwroot/xbt.com/pubic/../application/admin/view/seller/buyer_list.html";i:1578878574;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>商家列表
	</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="/admin_style/layui/css/layui.css" media="all" />
	<link rel="stylesheet" href="/admin_style/css/public.css" media="all" />
	<link rel="stylesheet" href="//at.alicdn.com/t/font_1308190_7kttvg3l5i.css" media="all" />

	<style>
		.wgbz{
			color: red;
		}
		.layui-table-cell {
			height: auto!important;
			line-height: 100%!important;
		}
		.layui-table-fixed {
			display: none!important;
		}
		.layui-table-fixed-r{
			display: none!important;
		}
		.layui-table-cell {
			font-size:16px;
			padding:0 5px;
			height:auto;
			overflow:visible;
			text-overflow:inherit;
			white-space:normal;
			word-break: break-all;
		}
	</style>
</head>
<body class="childrenBody">
	<form class="layui-form">
		<blockquote class="layui-elem-quote quoteBox">
			<form class="layui-form">

				<div class="layui-inline">
					<label class="layui-form-label">用户名：</label>
					<div class="layui-input-inline">
						<input type="tel" name="username" lay-verify="username" autocomplete="off" class="layui-input phone"
							   placeholder="请输入用户名">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">QQ号：</label>
					<div class="layui-input-inline">
						<input type="tel" name="qq" lay-verify="qq" autocomplete="off" class="layui-input phone"
							   placeholder="请输入QQ号">
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
					<label class="layui-form-label">注册时间：</label>
					<div class="layui-input-inline">
						<input type="text" name="registerTime" lay-verify="time" class="layui-input time" id="application-Time"
							   placeholder="注册时间">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label" >是否VIP：</label>
					<div class="layui-input-inline" style="width: 100px;">
						<select name="state" id="state1" lay-verify="" >
							<option value="5" selected>全部</option><!-- 默认选中 -->
							<!--						<option value="1" disabled>待审核</option>&lt;!&ndash; 禁用 &ndash;&gt;-->
							<option value="1" >是</option>
							<option value="2">否</option>
						</select>
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">会员到期：</label>
					<div class="layui-input-inline">
						<input type="text" name="expireTime" lay-verify="expireTime" class="layui-input expireTime" id="expireTime-Time"
							   placeholder="会员到期时间">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">来源id：</label>
					<div class="layui-input-inline">
						<input type="tel" name="tjuser" lay-verify="tjuser" autocomplete="off"
							   class="layui-input tjuser" placeholder="请输入来源id">
					</div>


				<!--				<div class="layui-inline">-->
				<!--					<label class="layui-form-label">提现账户：</label>-->
				<!--					<div class="layui-input-inline">-->
				<!--						<input type="tel" name="account" lay-verify="account" autocomplete="off"-->
				<!--							class="layui-input account" placeholder="请输入银行/卡号/姓名">-->
				<!--					</div>-->
				</div>
				<div class="layui-inline">
					<div class="layui-input-inline">
						<a class="layui-btn search_btn" data-type="reload" lay-filter="reload" lay-submit><i class="layui-icon">&#xe615;</i>搜 索</a>
					</div>
				</div>
			</form>
		</blockquote>
		<table id="userList" lay-filter="userList"></table>
		<!--头部-->
		<script type="text/html" id="toolbarDemo">
			<div class="layui-btn-container table-tool">
			  <button class="layui-btn layui-btn-normal delAll_btn">新增商家 <i class="layui-icon">&#xe605;</i></button>
			</div>
		</script>
		<!--审核状态-->
		<script type="text/html" id="state">
			{{#  if(d.newsStatus == "2"){ }}
			<span class="layui-red">不通过</span>
			{{#  } else if(d.newsStatus == "1"){ }}
			<span class="layui-blue">等待审核</span>
			{{#  } else if(d.newsStatus == "0"){ }}
				审核通过
			{{#  } else { }}
				无法识别
			{{#  }}}
		</script>
		<!--操作-->
		<script type="text/html" id="userListBar">
			<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="setTop">银 锭</a>
			<a class="layui-btn layui-btn-xs" lay-event="yajin">押 金</a>
			<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="maihao">店 铺</a>
			<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="bianji">编辑资料</a>
<!--			<a class="layui-btn layui-btn-xs" lay-event="tuijian">推 荐</a>-->
			<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="wgbz">违规备注</a>
			<a class="layui-btn layui-btn-xs" lay-event="updatePwd">改密码</a>

<!--			<a class="layui-btn layui-btn-xs" lay-event="tixian">提现账户</a>-->
			<a class="layui-btn  layui-btn-xs" lay-event="xiaoxi">消息</a>
		</script>
	</form>
	<script type="text/javascript" src="/admin_style/layui/layui.js"></script>
	<script type="text/javascript" src="/admin_style/BusinessList.js"></script>
	<script type="text/javascript" src="/static/seller/js/jquery.min.js"></script>
</body>
<script>
	layui.use(['form', 'layer', 'table', 'laytpl', 'laydate'], function () {
		var form = layui.form,
				layer = parent.layer === undefined ? layui.layer : top.layer,
				$ = layui.jquery,
				laytpl = layui.laytpl,
				table = layui.table;
		laydate = layui.laydate;
		/*点击回车登录*/
		$(document).on('keydown', function(e){
			if(event.keyCode == 13){
				e.preventDefault();//防止两次询问
				if($(".layui-layer-btn0").length<1){
					// 搜索条件
					var name = $("input[name=name]").val(); //姓名
					var expireTime = $("input[name=expireTime]").val(); //会员到期
					var registerTime = $("input[name=registerTime]").val(); //注册时间
					var phone = $("input[name=phone]").val(); //手机号
					var state = $('#state1 option:selected').val(); //状态
					var account = $("input[name=account]").val(); //账户
					var username = $("input[name=username]").val(); //用户名
					var qq = $("input[name=qq]").val(); //QQ号
					var tjuser = $("input[name=tjuser]").val(); //来源id

					table.reload('userListTable', {
						method: 'post'
						, where: {
							'name': name, //姓名
							'expireTime': expireTime,    //会员到期
							'registerTime': registerTime,    //注册时间
							'phone': phone,  //手机号
							'state': state, //状态
							'account': account, //账户
							'username': username, //用户名
							'qq': qq, //QQ号
							'tjuser': tjuser, //来源id

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

</html>
