<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:111:"D:\phpstudy\WWW\zhan\shua_li\pubic/../application/admin\view\PlatformCounterpayment\PlatformCounterpayment.html";i:1577930094;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>买家购买管理</title>
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
                        <label class="layui-form-label">买家旺旺ID:</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="wwid" lay-verify="wwid" autocomplete="off" class="layui-input wwid"
                                placeholder="买家旺旺ID">
                        </div>
                    </div>

				<div class="layui-inline">
					<label class="layui-form-label">用户名:</label>
					<div class="layui-input-inline">
						<input type="tel" name="username" lay-verify="username" autocomplete="off" class="layui-input wwid"
							   placeholder="用户名">
					</div>
				</div>

				<div class="layui-inline">
					<label class="layui-form-label">接单时间：</label>
					<div class="layui-input-inline">
						<input type="text" name="time" lay-verify="time" class="layui-input time" id="application-Time"
							placeholder="接单时间">
					</div>
				</div>
				<div class="layui-inline">
						<label class="layui-form-label">状态：</label>

					<div class="layui-input-inline" style="width: 150px;">
						<select name="state" id="state1" lay-verify="" >
							<option value="" >全部</option>
							<option value="0" selected>未发货</option>
							<option value="4">买家已付款，待打印快递单</option>
							<option value="1">已录入快递单号，待确认发货</option>
							<option value="2">已发货</option>
							<option value="3">已签收</option>
						</select>
					</div>
                </div>
				<div class="layui-inline">
					<div class="layui-input-inline">
						<a class="layui-btn search_btn" data-type="reload" lay-filter="reload" lay-submit><i class="layui-icon">&#xe615;</i>搜 索</a>
						<a class="layui-btn layui-btn-normal" data-type="daochu" lay-filter="daochu" lay-submit><i class="layui-icon">&#xe605;</i>导 出</a>
					</div>
				</div>
			</form>
		</blockquote>
		<table id="userList" lay-filter="userList"></table>
		<!--头部-->
		<script type="text/html" id="toolbarDemo">
			<div class="layui-btn-container table-tool">
<!--			  <button class="layui-btn layui-btn-normal delAll_btn">确认批量返款 <i class="layui-icon">&#xe605;</i></button>-->
			  <button class="layui-btn layui-btn-normal" id="daoru"><i class="layui-icon"></i> 导入</button>
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
			<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="setTop">查 看</a>
		</script>
	</form>
	<script type="text/javascript" src="/admin_style/layui/layui.js"></script>
	<script type="text/javascript" src="/admin_style/PlatformCounterpayment.js"></script>
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
		var id = $(".id").val(); //任务编号
		id = id ? id : 0;
		var wwid = $(".wwid").val(); //旺旺ID
		wwid = wwid ? wwid : 0;
		//第二种
		var time = field.time;  //接单时间
		time = time ? time : 0;
		var state = field.state; //状态
		state = state ? state : "88";//88表示未选择
		console.log(field)
		//弹出loading 加载
		// var index = top.layer.msg('数据提交中，请稍候', { icon: 16, time: false, shade: 0.8 });
		window.open("<?php echo url('task/export','','',false); ?>/id/"+id+"/wwid/"+wwid+"/time/"+time+"/state/"+state);
	});

		/*点击回车登录*/
		$(document).on('keydown', function(e){
			if(event.keyCode == 13){
				e.preventDefault();//防止两次询问
				if($(".layui-layer-btn0").length<1){
					// 搜索条件
					var id = $("input[name=id]").val(); //任务编号
					var wwid = $("input[name=wwid]").val(); //旺旺ID
					var time = $("input[name=time]").val(); //接单时间
					var username = $("input[name=username]").val(); //用户名
					var state = $('#state1 option:selected').val(); //状态
					table.reload('userListTable', {
						method: 'post'
						, where: {
							'id': id, //任务编号
							'wwid': wwid,    //旺旺ID
							'state': state, //状态
							'time': time, //接单时间
							'username': username, //用户名
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
