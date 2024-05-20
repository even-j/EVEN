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
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=trade&ac=view">交易账户管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=trade&ac=doEdit" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input class="common-text required" id="addtime" name="addtime" size="50" value="<?php if($data['addtime']){ echo $data['addtime']; }?>" type="hidden">
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th><i class="require-red">*</i>账号类型：</th>
                                <td>
                                    <input class="common-text required" id="type" name="type" size="50" value="<?php if($data['type']){ echo $data['type']; }?>" type="text">
                                    <i class="tip left pd10">1为普通账号，2为免费体验账号</i>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>母账号：</th>
                                <td>
                                    <input class="common-text required" id="parent_account" name="parent_account" size="50" value="<?php if($data['parent_account']){ echo $data['parent_account']; }?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr <?php if($data['account']){ echo 'class="none"'; }?>>
                                <th><i class="require-red">*</i>交易账户名：</th>
                                <td>
                                    <input class="common-text required" onblur="checkAccount()" id="account" name="account" size="50" value="<?php if($data['account']){ echo $data['account']; }?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                         	 <tr>
                                <th><i class="require-red">*</i>交易账户密码：</th>
                                <td>
                                    <input class="common-text required" id="pwd" name="pwd" size="50" value="<?php if($data['pwd']){ echo $data['pwd']; }?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                             <tr>
                            <th width="120"><i class="require-red">*</i>交易账户状态：</th>
                            <td>
                                <select name="status" id="status" class="required">
                                   <?php foreach ($status as $key=>$val){
                                    	$selected = $key==$data['status'] ? 'selected="selected"' : '';
                                    ?>
                                    <option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $val;?></option>
                                    <?php }?>
                                </select>
                            </td>
                        </tr>
                        
                         <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" name="submit" value="提交" type="submit">
                                    <input class="btn btn6" onClick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody></table>
                </form>
            </div>
        </div>

    </div>
    <!--/main-->
</div>
<script type="text/javascript">
<!--
function checkAccount(){
	$.post('/index.php?app=admin&mod=trade&ac=ajaxCheckAccount',{"account": $('#account').val()},function(res){
		 if(res.status=='1'){
			 $('#account').next().html('该交易账户名已存在！');
		 }else{
			 $('#account').next().html('');
		 }
	},'json');
}

$(document).ready(function(){
	$('#myform').submit(function(){
		var parent_account = $('#parent_account').val();
		var account = $('#account').val();
		
		if(parent_account==""){
			$('#parent_account').next().html('请输入母账号！');
			$('#parent_account').focus();
			return false;
		}
		
		if(account==""){
			$('#account').next().html('请输入交易账户名！');
			$('#account').focus();
			return false;
		}
			
		if($('#pwd').val()==""){
			$('#pwd').next().html('请输入交易账户密码！');
			$('#pwd').focus();
			return false;
		}
		if($("#account").next('i').html()!=''){
			return false;
		}
		return true;
	});
});
//-->
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
