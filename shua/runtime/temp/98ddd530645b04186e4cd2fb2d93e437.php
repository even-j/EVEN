<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"/www/wwwroot/xbt.com/pubic/../application/admin/view/task/task.html";i:1583151584;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>平台返款管理</title>
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
		/*p{*/
		/*	height: 15px !important;*/
		/*	font-size: 14px;*/
		/*}*/
		.p1{
			color: red;
		}
		.p2{
			color: rgb(25, 105, 52);
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
		.layui-table-fixed {
			display: none!important;
		}
		.layui-table-fixed-r{
			display: none!important;
		}
	</style>
</head>
<body class="childrenBody">
	<form class="layui-form">
		<blockquote class="layui-elem-quote quoteBox">
			<form class="layui-form">
				<div class="layui-inline">
					<label class="layui-form-label">任务编号：</label>
					<div class="layui-input-inline">
						<input type="tel" name="id" lay-verify="id" autocomplete="off" class="layui-input id"
							placeholder="请输入任务编号">
					</div>
                </div>

				<div class="layui-inline">
					<label class="layui-form-label">任务id：</label>
					<div class="layui-input-inline">
						<input type="tel" name="rand_num" lay-verify="rand_num" autocomplete="off" class="layui-input rand_num"
							   placeholder="请输入任务id">
					</div>
				</div>
                <div class="layui-inline">
                        <label class="layui-form-label">商家旺旺ID:</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="wwid" lay-verify="wwid" autocomplete="off" class="layui-input wwid"
                                placeholder="商家旺旺ID">
                        </div>
                    </div>

				<div class="layui-inline">
					<label class="layui-form-label">用户名:</label>
					<div class="layui-input-inline">
						<input type="tel" name="seller_name" lay-verify="seller_name" autocomplete="off" class="layui-input wwid"
							   placeholder="用户名">
					</div>
				</div>
<!--                    <div class="layui-inline">-->
<!--                            <label class="layui-form-label">卖家店铺名:</label>-->
<!--                            <div class="layui-input-inline">-->
<!--                                <input type="tel" name="dpid" lay-verify="dpid" autocomplete="off" class="layui-input dpid"-->
<!--                                    placeholder="卖家店铺名">-->
<!--                            </div>-->
<!--                        </div>-->
				<div class="layui-inline">
					<label class="layui-form-label">发布时间：</label>
					<div class="layui-input-inline">
						<input type="text" name="time" lay-verify="time" class="layui-input time" id="application-Time"
							placeholder="发布时间">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">任务类型：</label>
					<div class="layui-input-inline" style="width: 150px;">
						<select name="task_type" id="task_type" lay-verify="" >
							<option value="" selected >全部</option>
							<option value="1">文字好评</option>
							<option value="2">淘口令</option>
							<option value="3">二维码</option>
							<option value="4">直通车</option>
							<option value="5">通道任务</option>
						</select>
					</div>
				</div>

				<div class="layui-inline">
						<label class="layui-form-label">状态：</label>
					<div class="layui-input-inline" style="width: 150px;">
						<select name="state" id="state1" lay-verify="" >
							<option value="" selected >全部</option>
<!--							<option value="1" >未支付</option>-->
							<option value="2">已支付，待审核</option>
							<option value="3">已通过</option>
							<option value="4">已拒绝</option>
							<option value="5">已撤销</option>
							<option value="6">已完成</option>
						</select>
					</div>
                </div>
				<div class="layui-inline">
					<div class="layui-input-inline">
						<a class="layui-btn search_btn" data-type="reload" lay-filter="reload" lay-submit><i class="layui-icon">&#xe615;</i>搜 索</a>
						<a class="layui-btn layui-btn-normal" data-type="daochu1" lay-filter="daochu1" lay-submit><i class="layui-icon">&#xe605;</i>导 出</a>
					</div>
				</div>
			</form>
		</blockquote>
		<table id="userList" lay-filter="userList" style="font-size: 14px"></table>
		<!--头部-->
<!--		<script type="text/html" id="toolbarDemo">-->
<!--			<div class="layui-btn-container table-tool">-->
<!--				<button class="layui-btn layui-btn-normal examineAll_btn">批量审核成功 <i class="layui-icon">&#xe605;</i></button>-->
<!--				<button class="layui-btn layui-btn-normal refundsALL_btn">确认已返款成功 <i class="layui-icon">&#xe605;</i></button>-->
<!--				&lt;!&ndash;				<button class="layui-btn layui-btn-normal add_btn">导出 <i class="iconfont icon">&#xe70f;</i></button>&ndash;&gt;-->
<!--			</div>-->
<!--		</script>-->

		<script type="text/html" id="toolbarDemo">
			<div class="layui-btn-container table-tool">
                <button class="layui-btn layui-btn-normal delAll_btn">批量审核通过 <i class="layui-icon">&#xe605;</i></button>
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
			<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="setTop">详 情</a>
			<a class="layui-btn layui-btn-xs" lay-event="jeidan">接单情况</a>
			<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="fangqi">放弃情况</a>
		</script>
	</form>
	<script type="text/javascript" src="/admin_style/layui/layui.js"></script>
	<script type="text/javascript" src="/admin_style/task.js"></script>
	<script src="/admin_style/assets/plugins/jquery/jquery.min.js"></script>
</body>
<script>
	layui.use(['form', 'layer', 'table', 'laytpl', 'laydate'], function () {
		var form = layui.form,
				layer = parent.layer === undefined ? layui.layer : top.layer,
				$ = layui.jquery,
				laytpl = layui.laytpl,
				table = layui.table;
		laydate = layui.laydate;
		//导出
		form.on("submit(daochu1)", function (data) {
			var field = data.field;
			var id = $(".id").val(); //任务编号
			id = id ? id : 0;
			var wwid = $(".wwid").val(); //旺旺ID
			wwid = wwid ? wwid : 0;
			//第二种
			var time = field.time;  //接单时间
			time = time ? time : 0;
			var state = field.state; //状态
			state = state ? state : "88";//88表示未选择
			var seller_name = field.seller_name; //用户名
			seller_name = seller_name ? seller_name : 0;

			console.log(field)
			//弹出loading 加载
			// var index = top.layer.msg('数据提交中，请稍候', { icon: 16, time: false, shade: 0.8 });
			window.open("<?php echo url('task/task_export','','',false); ?>/id/"+id+"/wwid/"+wwid+"/time/"+encodeURI(time)+"/state/"+state+"/seller_name/"+seller_name);
		});

		/*点击回车登录*/
		$(document).on('keydown', function(e){
			if(event.keyCode == 13){
				e.preventDefault();//防止两次询问
				if($(".layui-layer-btn0").length<1){
					// 搜索条件
					var id = $("input[name=id]").val(); //任务编号
					var wwid = $("input[name=wwid]").val(); //旺旺ID
					var dpid = $("input[name=dpid]").val(); //店铺ID
					var state = $('#state1 option:selected').val(); //状态
					var task_type = $('#task_type option:selected').val(); //任务类型
					var time = $("input[name=time]").val(); //接单时间
					var seller_name = $("input[name=seller_name]").val(); //发货状态
					var rand_num = $("input[name=rand_num]").val(); //任务编号id

					table.reload('userListTable', {
						method: 'post'
						, where: {
							'id': id, //任务编号
							'wwid': wwid,    //旺旺ID
							'dpid': dpid,    //店铺ID
							'state': state, //状态
							'task_type': task_type, //任务类型
							'seller_name': seller_name, //接单时间
							'time': time, //接单时间
							'rand_num': rand_num, //任务编号id
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
