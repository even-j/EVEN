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

<div class="container clearfix">
    <div class="main-wrap">
       <div class="crumb-wrap">
  <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name"><?php if(isset($title)) echo $title?></span></div>
</div>   
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="peizi" >
                    <input type="hidden" name="ac" value="view" >
                    <table class="search-tab">
                        <tr>
                            <th width="60">策略类型:</th>
                            <td>
                                <select name="pz_type" id="status" class="common-select">
                                    <option <?php echo $condition['pz_type'] == ''?'selected="selected"':''?> value="">&nbsp;全部&nbsp; </option>
                                    <option <?php echo $condition['pz_type'] == '1'?'selected="selected"':''?> value="1">按日策略</option>
                                    <option <?php echo $condition['pz_type'] == '2'?'selected="selected"':''?> value="2">按月策略</option>
                                    <option <?php echo $condition['pz_type'] == '4'?'selected="selected"':''?> value="4">免费体验</option>
                                </select>
                            </td>
                            <th width="60">手机号:</th>
                            <td><input class="common-text" placeholder="手机号" name="mobile" value="<?php echo $condition['mobile']?>" id="" type="text" style="width:100px"></td>
                            <th width="60">姓名:</th>
                            <td><input class="common-text" placeholder="姓名" name="true_name" value="<?php echo $condition['true_name']?>" id="" type="text" style="width:80px"></td>
                            <th width="80">实盘单号:</th>
                            <td><input class="common-text" placeholder="实盘单号" name="order_id" value="<?php echo $condition['order_id']?>" id="" type="text" style="width:100px"></td>
                            
                            <th width="50">状态:</th>
                            <td>
                                <select name="status" id="status" class="common-select">
                                    <option <?php echo $condition['status'] == ''?'selected="selected"':''?> value="">&nbsp;全部&nbsp; </option>
                                    <option <?php echo $condition['status'] == '1'?'selected="selected"':''?> value="1">已付款</option>
                                    <option <?php echo $condition['status'] == '2'?'selected="selected"':''?> value="2">操盘中</option>
                                    <option <?php echo $condition['status'] == '3'?'selected="selected"':''?> value="3">申请结算</option>
                                    <option <?php echo $condition['status'] == '4'?'selected="selected"':''?> value="4">完成</option>
                                </select>
                            </td>
                            <th width="80"><input class="btn btn-primary btn10" name="sub" value="查询" type="submit"></td>
                        </tr>
                        <tr>
                            <th width="70">用户ID:</th>
                            <td><input class="common-text" placeholder="用户ID" name="uid" value="<?php echo $condition['uid']?>" id="" type="text" style="width:60px"></td>
                            <th width="70">证券帐户:</th>
                            <td><input class="common-text" placeholder="证券帐户" name="sp_user" value="<?php echo $condition['sp_user']?>" id="" type="text" style="width:100px"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
      
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div id="div_content" class="result-content" style="width:100%;overflow: auto">
                    <table class="result-tab" style="width:1630px" >
                        <tr>
                            <th style="width: 100px;">策略类型</th>
                            <th style="width: 150px;">订单时间</th>
                            <th style="width: 100px;">姓名</th>
                            <th style="width: 100px;">手机号</th>
                            <th style="width: 100px;">证券帐户</th>
                            <th style="width: 100px;">保证金</th>
                            <th style="width: 60px;">倍数</th>
                            <th style="width: 60px;">策略金额</th>
                            <th style="width: 100px;">总操盘金<br></th>
                            <th style="width: 100px;">开始操盘时间</th>
                            <th style="width: 100px;">结束操盘时间</th>
                            <th style="width: 100px;">管理费收取至</th>
                            <th style="width: 120px;">实盘单号</th>
                            <th style="width: 100px;">状态</th>
                            <th style="width: 100px;">操作</th>
                        </tr>
                         							
                        <?php foreach ($list as $item){?>
                            <tr>
                                <td style="display: none"><?php echo $item['pz_id']?></td>
                                <td><?php echo \Model\Peizi\Peizi::getPzType($item['pz_type'])  ?></td>
                                <td><?php echo date('Y-m-d H:i',$item['pz_time']) ?></td>
                                <td><a href="/index.php?app=admin&mod=user&ac=info&uid=<?php echo $item['uid']?>" ><?php echo $item['true_name']?></a></td>
                                <td><?php echo $item['mobile'] ?></td>
                                <td><?php echo $item['sp_user'] ?></td>
                                <td><?php echo floatval($item['bond_total'])/100 ?></td>
                                <td><?php echo floatval($item['pz_ratio'])?></td>
                                <td><?php echo floatval($item['bond_total'])* intval($item['pz_ratio'])/100 ?></td>
                                <td><?php echo floatval($item['trade_money_total'])/100 ?></td>
                                <td><?php echo date('Y-m-d',$item['start_time']) ?></td>
                                <td><?php echo date('Y-m-d',$item['end_time_act']) ?></td>
                                <td><?php echo date('Y-m-d',$item['manage_cost_time']) ?></td>
                                <td><?php echo date('Ymd',$item['pz_time']).$item['pz_id'] ?></td>
                                <td><?php echo \Model\Peizi\Peizi::getStatusName($item['status']) ?></td>
                                <td>
                                    <?php if($item['pz_type'] == 1 || $item['pz_type'] == 2){?>
                                    <a href="javascript:openWin('追加记录','/index.php?app=admin&mod=peizi&ac=plus&status=1&pz_id=<?php echo $item['pz_id'] ?>')" >追加记录</a>
                                    <a href="javascript:openWin('补亏记录','/index.php?app=admin&mod=peizi&ac=loss&status=1&pz_id=<?php echo $item['pz_id'] ?>')" >补亏记录</a>
                                    <a href="javascript:openWin('提盈记录','/index.php?app=admin&mod=system&ac=getprofit&status=1&pz_id=<?php echo $item['pz_id'] ?>')" >提盈记录</a>
                                    <?php }?>
                                    <a href="javascript:openWin('资金记录','/index.php?app=admin&mod=finance&ac=fund&pz_id=<?php echo $item['pz_id'] ?>')" >资金记录</a>
                                </td>
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
