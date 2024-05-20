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
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=peizi&ac=fund">实盘资金划拔</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
             <form action="/index.php?app=admin&mod=peizi&ac=doFundEdit" method="post" onclick="return validateForm();" id="myform" name="myform" enctype="multipart/form-data">
                 <input type="hidden" name="pz_id" value="<?php echo $_GET['pz_id']?>" />
                 <table class="insert-tab" width="100%">
                    <tbody>
                        <tr>
                            <th width="120">策略类型：</th>
                            <td><?php echo \Model\Peizi\Peizi::getPzType($pz_row['pz_type'])  ?></td>
                        </tr>
                        <tr>
                            <th>订单时间：</th>
                            <td><?php echo date('Y-m-d H:i',$pz_row['pz_time']);?></td>
                        </tr>
                        <tr>
                            <th><i class="require-red">*</i>证券账户：</th>
                            <td><input type="text" id="sp_user" name="sp_user" value="<?php echo $pz_row['sp_user'] ?>" /><i class="tip left pd10"></i></td>
                        </tr>
                        <tr>
                            <th><i class="require-red">*</i>证券密码：</th>
                            <td><input type="text" id="sp_pwd" name="sp_pwd" value="<?php echo $pz_row['sp_pwd'] ?>" /><i class="tip left pd10"></i></td>
                        </tr>
                        <tr>
                            <th>保证金：</th>
                            <td><?php echo floatval($pz_row['bond_total'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>倍数：</th>
                            <td><?php echo floatval($pz_row['pz_ratio'])?></td>
                        </tr>
                        <tr>
                            <th>策略金额：</th>
                            <td><?php echo floatval($pz_row['bond_total'])*floatval($pz_row['pz_ratio'])/100?></td>
                        </tr>
                        <tr>
                            <th>总操盘金额：</th>
                            <td><?php echo floatval($pz_row['trade_money_total'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>风险警戒线：</th>
                            <td><?php echo floatval($pz_row['alarm_money'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>平仓止损线：</th>
                            <td><?php echo floatval($pz_row['stop_money'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>开始时间：</th>
                            <td><?php echo date('Y-m-d H:i',$pz_row['start_time']) ?></td>
                        </tr>
                        <tr>
                            <th>结束时间：</th>
                            <td><?php echo date('Y-m-d H:i',$pz_row['end_time']) ?></td>
                        </tr>
                        <tr>
                            <th>实盘单号：</th>
                            <td><?php echo date('Ymd',$pz_row['pz_time']).$pz_row['pz_id'] ?></td>
                        </tr>
                        <tr>
                            <th><i class="require-red">*</i>划拔状态：</th>
                            <td>
                                <?php if($pz_row['status'] == 1){?>
                                <select name="status" id="status">
                                    <option value="1">未划拔</option>
                                    <option value="2">已划拔</option>
                                </select>
                                <?php }else{?>
                                    已划拔
                                <?php }?>
                            </td>
                        </tr>
                         
                             <tr>
                            <th></th>
                            <td>
                                <?php if($pz_row['status'] == 1){?>
                                <input class="btn btn-primary btn6 mr10" name="submit" value="提交" type="submit">
                                <?php }?>
                                <input class="btn btn6" onClick="goback()" value="返回" type="button">
                            </td>
                        </tr>
                    </tbody>
                 </table>
                </form> 
            </div>
        </div>

    </div>
    <!--/main-->
</div>
<script type="text/javascript">
function validateForm(){
	var sp_user = $('#sp_user');
	var sp_pwd = $('#sp_pwd');
	
	if (sp_user.val() == "") {
            sp_user.next().html('证券用户不能为空');
            return false;
	}else{
            sp_user.next().html('');
	}
        if (sp_pwd.val() == "") {
            sp_pwd.next().html('证券密码不能为空');
            return false;
	}else{
            sp_pwd.next().html('');
	}
	return true;
}
function goback(){
    var url = '/index.php?app=admin&mod=peizi&ac=fund';
    window.location.href = url;
}
</script>
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
