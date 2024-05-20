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
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">修改密码</span></div>
        </div>
        <div class="result-wrap">
            <form action="/index.php?app=admin&mod=user&ac=domodpwd" method="post" id="myform" name="myform">
                <div class="config-items">
                    <div class="config-title">
                        <h1><i class="icon-font">&#xe015;</i>修改用户密码</h1>
                    </div>
                    <div class="result-content">
                        <?php if(!empty($msg)){?><h4 align="center" class="require-red"><?php echo $msg;?></h4><br/><?php }?>
                        <table width="100%" class="insert-tab">
                            <tbody>
                                <tr>
                                    <th>手机号：</th>
                                    <td><?php echo $mobile;?><input type="hidden" id="mobile" value="<?php echo $mobile;?>" size="85" name="mobile" class="common-text"></td>
                                </tr>
                                <tr>
                                    <th><i class="require-red">*</i>新密码：</th>
                                    <td><input type="password" id="pwd" value="" size="85" name="pwd" class="common-text" placeholder="请输入您的新密码">&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <th><i class="require-red">*</i>确认密码：</th>
                                    <td><input type="password" id="repwd" value="" size="85" name="repwd" class="common-text" placeholder="请再次输入您的新密码">&nbsp;&nbsp;</td>
                                </tr>
                            
                                <tr>
                                    <th></th>
                                    <td>
                                        <input type="submit" value="提交" class="btn btn-primary btn6 mr10">
                                        <input type="button" value="返回" onClick="history.go(-1)" class="btn btn6">
                                    </td>
                                </tr>
                            </tbody>
                         </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--/main-->
</div>
<script type="text/javascript">
<!--
$(document).ready(function(){
	$('.common-text').bind('focus',function(){
		if($(this).val()==""){
			$(this).next('.all_submit_error').show();
		}else{
			$(this).next('.all_submit_error').hide();
		}
	});

	$('.common-text').bind('blur',function(){
		if($(this).val()==""){
			$(this).next('.all_submit_error').show();
		}else{
			$(this).next('.all_submit_error').hide();
		}
	});
	
	/*修改密码*/
	$("#myform").submit(function(e){
		var  pwd = $('#pwd'), repwd = $('#repwd');
		if(pwd.val()==""){
			pwd.next('.all_submit_error').show();
			return false;
		}
		if(repwd.val()=="" || pwd.val() != repwd.val()){
			repwd.next('.all_submit_error').show();
			return false;
		}
		
		$(this).submit();
		//$("#bg-mask,#share-map").show();
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
