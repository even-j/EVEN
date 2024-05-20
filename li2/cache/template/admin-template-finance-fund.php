<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(isset($title)) echo $title.'_'?><?php echo SITE_NAME;?>—后台管理</title>
<link rel="stylesheet" type="text/css" href="/public/admin/css/common.css?v=201812202"/>
<link rel="stylesheet" type="text/css" href="/public/admin/css/main.css?v=5"/>
<script type="text/javascript" src="/public/admin/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/public/admin/js/common.js?v=201812202"></script>
<script type="text/javascript" src="/public/admin/js/libs/modernizr.min.js"></script>
<script type="text/javascript" src="/public/admin/js/layer/layer.js"></script>

</head>

<body>
<?php $admin_user = \Model\Admin\User::getAdminInfo(array('admin_id'=>\Model\Admin\User::checks())); ?>
<link type="text/css" href="/public/admin/css/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
<link type="text/css" href="/public/admin/css/jquery-ui-timepicker-addon.css" rel="stylesheet" />
<script type="text/javascript" src="/public/admin/js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="/public/admin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/public/admin/js/jquery-ui-timepicker-zh-CN.js"></script>
<script type="text/javascript">
    $(function () {
        $(".ui_timepicker").datetimepicker();
    })
</script>

<div class="container clearfix">
    <div class="main-wrap">
       <div class="crumb-wrap">
  <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name"><?php if(isset($title)) echo $title?></span></div>
</div>   
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="finance" >
                    <input type="hidden" name="ac" value="fund" >
                    <table class="search-tab">
                        <tr>
                            <th width="60">手机号:</th>
                            <td><input class="common-text" placeholder="手机号" name="mobile" value="<?php echo $condition['mobile']?>" id="" type="text" style="width:100px"></td>
                            <th width="60">姓名:</th>
                            <td><input class="common-text" placeholder="姓名" name="true_name" value="<?php echo $condition['true_name']?>" id="" type="text" style="width:80px"></td>
                            <th width="80">实盘单号:</th>
                            <td><input style="width:100px" class="common-text" placeholder="实盘单号" name="order_id" value="<?php echo $condition['order_id']?>" id="" type="text"></td>
                            <th width="50">用户id:</th>
                            <td>
                                <input style="width:80px" class="common-text" placeholder="用户id" name="uid" value="<?php echo $condition['uid']?>" id="" type="text">
                            </td>
                            <th width="80">资金类型:</th>
                            <td>
                                <select name="type" id="type" class="common-select">
                                    <option <?php echo $condition['type'] == ''?'selected="selected"':''?> value="">&nbsp;全部&nbsp; </option>
                                    <option <?php echo $condition['type'] == '1'?'selected="selected"':''?> value="1">充值</option>
                                    <option <?php echo $condition['type'] == '2'?'selected="selected"':''?> value="2">提现</option>
                                    <option <?php echo $condition['type'] == '5'?'selected="selected"':''?> value="5">冻结保证金</option>
                                    <option <?php echo $condition['type'] == '6'?'selected="selected"':''?> value="6">解冻保证金</option>
                                    <option <?php echo $condition['type'] == '7'?'selected="selected"':''?> value="7">补交亏损</option>
                                    <option <?php echo $condition['type'] == '8'?'selected="selected"':''?> value="8">支付利息</option>
                                    <option <?php echo $condition['type'] == '9'?'selected="selected"':''?> value="9">退回利息</option>
                                    <option <?php echo $condition['type'] == '10'?'selected="selected"':''?> value="10">支付账户管理费</option>
                                    <option <?php echo $condition['type'] == '11'?'selected="selected"':''?> value="11">退回账户管理费</option>
                                    <option <?php echo $condition['type'] == '12'?'selected="selected"':''?> value="12">结束策略盈亏</option>
                                    <option <?php echo $condition['type'] == '13'?'selected="selected"':''?> value="13">追加策略</option>
                                    <option <?php echo $condition['type'] == '14'?'selected="selected"':''?> value="14">系统充值</option>
                                    <option <?php echo $condition['type'] == '15'?'selected="selected"':''?> value="15">系统扣除</option>
                                    <option <?php echo $condition['type'] == '19'?'selected="selected"':''?> value="19">借入策略本金</option>
                                    <option <?php echo $condition['type'] == '20'?'selected="selected"':''?> value="20">退还策略本金</option>
                                    <option <?php echo $condition['type'] == '21'?'selected="selected"':''?> value="21">冻结策略本金</option>
                                    <option <?php echo $condition['type'] == '22'?'selected="selected"':''?> value="22">解冻策略本金</option>
                                    <option <?php echo $condition['type'] == '25'?'selected="selected"':''?> value="25">冻结提现</option>
                                    <option <?php echo $condition['type'] == '26'?'selected="selected"':''?> value="26">解冻提现</option>
                                    <option <?php echo $condition['type'] == '100'?'selected="selected"':''?> value="100">管理费赠送</option>
                                    <option <?php echo $condition['type'] == '101'?'selected="selected"':''?> value="101">赠送消费</option>
                                    <option <?php echo $condition['type'] == '102'?'selected="selected"':''?> value="102">赠送扣除</option>
                                    <option <?php echo $condition['type'] == '103'?'selected="selected"':''?> value="103">注册赠送</option>
                                    <option <?php echo $condition['type'] == '104'?'selected="selected"':''?> value="104">签到赠送</option>
                                    <option <?php echo $condition['type'] == '105'?'selected="selected"':''?> value="105">实名认证赠送</option>
                                    <option <?php echo $condition['type'] == '106'?'selected="selected"':''?> value="106">绑定银行卡赠送</option>
                                    <option <?php echo $condition['type'] == '107'?'selected="selected"':''?> value="107">首次策略赠送</option>
                                    <option <?php echo $condition['type'] == '108'?'selected="selected"':''?> value="108">首次追加策略赠送</option>
                                    <option <?php echo $condition['type'] == '109'?'selected="selected"':''?> value="109">首次补亏赠送</option>
                                    <option <?php echo $condition['type'] == '110'?'selected="selected"':''?> value="110">首次提盈赠送</option>
                                    <option <?php echo $condition['type'] == '111'?'selected="selected"':''?> value="111">首次充值赠送</option>
                                    <option <?php echo $condition['type'] == '200'?'selected="selected"':''?> value="200">介绍佣金</option>
                                    <option <?php echo $condition['type'] == '300'?'selected="selected"':''?> value="300">盈利提取</option>
                                </select>
                            </td>
                            <th width="80">时间:</th>
                            <td><input class="common-text ui_timepicker" style="width:120px;" placeholder="开始时间" name="begindate" value="<?php echo $condition['begindate']?>" id="begindate" type="text"> — </td>
                            <td><input class="common-text ui_timepicker" style="width:120px;" placeholder="结束时间" name="enddate" value="<?php echo $condition['enddate']?>" id="enddate" type="text"></td>
                            <th width="80"><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
      
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div id="div_content" class="result-content" style="width:100%">
                    <table class="result-tab" style="width:100%" >
                        <tr>
                        	<th style="width: 60px;">用户ID</th>
                        	<th style="width: 120px;">手机号码</th>
                                <th style="width: 120px;">姓名</th>
                            <th style="width: 100px;">资金类型</th>
                            <th style="width: 100px;">金额</th>
                            <th style="width: 120px;">实盘单号</th>
                            <th style="width: 150px;">时间</th>
                             <th style="width: 150px;">备注</th>

                        </tr>
                         														
                        <?php foreach ($list as $item){?>
                            <tr>
                            	<td><?php echo $item['uid'] ?></td>
                            	<td><?php $user = \Model\User\UserInfo::getinfo($item['uid']);echo $user['mobile'] ? $user['mobile'] : '-----' ?></td>
                                <td><?php echo $user['true_name']; ?></td>
                                <td><?php echo \Model\User\Fund::fundTypeName($item['type']) ?></td>
                                <td><?php echo number_format($item['money']/100,2) ?></td>
                                <td><?php echo $item['pz_time'] ? date('Ymd',$item['pz_time']).$item['rec_id'] :'-----' ?></td>
                                <td><?php echo date('Y-m-d H:i',$item['rtime']) ?></td>
                                <td><?php echo $item['remark']?></td>
                            </tr>
                        <?php }?>             
                    </table>
                    
                </div>
            </form>
        </div>
       <div class="list-page"><?php echo $pager;?></div>
    </div>
  
    <!--/main-->
</div>
<script type="text/javascript">

function show(title,url){
	//iframe层
    layer.open({
        type: 2,
        title: title,
        shadeClose: true,
        shade: 0.8,
        fix: false, //不固定
        maxmin: true,
        area: ['60%', '500px'],
        content: url //iframe的url
    }); 
}
var layerIndex = 0;
var isOpen=false;
var interval= window.setInterval("showWindow()",20000);
function showWindow(){
	$.post('/index.php?app=admin&mod=index&ac=showWindow',{},function(res){
		 if(res.status=='1'){
                    if(isOpen){
                        layer.close(layerIndex);
                    }
                    //iframe窗
                    layerIndex = layer.open({
                        type: 1,
                        title: '您有新的<b class="red"> '+res.num+' </b>条待办事项',
                        shade: false,
                        //skin: 'layui-layer-demo', //样式类名
                        area: ['340px', '315px'],
                        shadeClose: false, //开启遮罩关闭
                        offset: 'rb', //右下角弹出
                        content: '<div class="result-content"><ul id="wait-do" class="sys-info-list pt10">'+res.msg+'</ul></div><div style="display:none;"><audio controls="true" autoplay="autoplay" loop="loop"><source src="/public/admin/sound/music.mp3" /><source src="/public/admin/sound/music.ogg" /></audio></div>', 
                        end:function(){ // 点击右上角关闭按钮  
                            isOpen=false;
                            layerIndex=0;
                        }
                    });
                    isOpen = true;
		 }
	},'json');
}

</script>
</body>
</html>
