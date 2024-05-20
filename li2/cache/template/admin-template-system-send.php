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
        <div class="result-wrap">
            <form action="/index.php?app=admin&mod=system&ac=doSend" method="post" id="myform" name="myform" enctype="multipart/form-data">
                <div class="config-items">
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tbody>
                                <tr>
                                    <th width="15%">注册赠送金额：</th>
                                    <td><input type="text" name="regist" id="regist" value="<?php echo $params_send['regist'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">实名认证赠送金额：</th>
                                    <td><input type="text" name="sfz" id="sfz" value="<?php echo $params_send['sfz'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">绑定银行卡赠送金额：</th>
                                    <td><input type="text" name="bank" id="bank" value="<?php echo $params_send['bank'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">首次充值赠送金额：</th>
                                    <td><input type="text" name="recharge" id="recharge" value="<?php echo $params_send['recharge'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">首次策略赠送金额：</th>
                                    <td><input type="text" name="peizi" id="peizi" value="<?php echo $params_send['peizi'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">首次追加赠送金额：</th>
                                    <td><input type="text" name="add" id="add" value="<?php echo $params_send['add'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">首次补亏赠送金额：</th>
                                    <td><input type="text" name="fill" id="fill" value="<?php echo $params_send['fill'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">首次提盈赠送金额：</th>
                                    <td><input type="text" name="profit" id="profit" value="<?php echo $params_send['profit'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">签到赠送金额：</th>
                                    <td><input type="text" name="sign" id="maxLimitMoney" value="<?php echo $params_send['sign'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%">签到循环周期：</th>
                                    <td><input type="text" name="sign_cycle" id="maxLimitMoney" value="<?php echo $params_send['sign_cycle'] ?>" onkeyup="" size="50"  class="common-text"> 
                                        <i class="tip left pd10">（单位：天）</i></td>
                                </tr>

                                <tr>
                                    <th></th>
                                    <td>
                                        <input type="submit" value="提交" class="btn btn-primary btn10 mr10">
                                        <input type="reset" value="重置" class="btn btn10 mr10">
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
<script language="JavaScript" type="text/javascript">
    function clearNoNum(obj) {
        obj.value = obj.value.replace(/[^\d.]/g, "");  //清除“数字”和“.”以外的字符  
        obj.value = obj.value.replace(/^\./g, "");  //验证第一个字符是数字而不是. 
        obj.value = obj.value.replace(/\.{2,}/g, "."); //只保留第一个. 清除多余的.   
        obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
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
