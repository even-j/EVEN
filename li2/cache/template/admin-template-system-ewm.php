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
<link rel="stylesheet" href="/public/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="/public/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/public/kindeditor/lang/zh_CN.js"></script>
<script>
	KindEditor.ready(function(K) {
            var editor = K.editor({
                allowFileManager : true
            });
            K('#btn_weixin_path').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl: K('#weixin_path').val(),
                        clickFn: function (url, title, width, height, border, align) {
                            K('#weixin_path').val(url);
                            K('#img_weixin_path').attr('src',url);
                            editor.hideDialog();
                        }
                    });
                });
            });
            K('#btn_gzh_path').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl: K('#gzh_path').val(),
                        clickFn: function (url, title, width, height, border, align) {
                            K('#gzh_path').val(url);
                            K('#img_gzh_path').attr('src',url);
                            editor.hideDialog();
                        }
                    });
                });
            });
            K('#btn_qq_path').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl: K('#qq_path').val(),
                        clickFn: function (url, title, width, height, border, align) {
                            K('#qq_path').val(url);
                            K('#img_qq_path').attr('src',url);
                            editor.hideDialog();
                        }
                    });
                });
            });
            K('#btn_peiziapp_path').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl: K('#peiziapp_path').val(),
                        clickFn: function (url, title, width, height, border, align) {
                            K('#peiziapp_path').val(url);
                            K('#img_peiziapp_path').attr('src',url);
                            editor.hideDialog();
                        }
                    });
                });
            });
            K('#btn_tradeapp_path').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl: K('#tradeapp_path').val(),
                        clickFn: function (url, title, width, height, border, align) {
                            K('#tradeapp_path').val(url);
                            K('#img_tradeapp_path').attr('src',url);
                            editor.hideDialog();
                        }
                    });
                });
            });
        });
</script>

<div class="container clearfix">
    <div class="main-wrap">
        <div class="crumb-wrap">
  <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name"><?php if(isset($title)) echo $title?></span></div>
</div>   
        <div class="result-wrap">
            <form action="/index.php?app=admin&mod=system&ac=doEwmSave" method="post" id="myform" name="myform">
                <div class="config-items">
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tbody>
                               <tr>
                                    <th width="15%">网站APP：</th>
                                    <td>
                                        <img id="img_peiziapp_path" src="<?php if(isset($params_site_ewm['peiziapp_path'])){echo $params_site_ewm['peiziapp_path'];};?>" width="100" />
                                        <input type="hidden" id="peiziapp_path" name="peiziapp_path" value="<?php if(isset($params_site_ewm['peiziapp_path'])){echo $params_site_ewm['peiziapp_path'];};?>" class="common-text"> 
                                        <input type="button" id="btn_peiziapp_path" value="上传" />
                                        <br/>
                                        <input type="text" id="peiziapp_url" name="peiziapp_url" placeholder="地址" value="<?php if(isset($params_site_ewm['peiziapp_url'])){echo $params_site_ewm['peiziapp_url'];};?>" class="common-text" style="width:90%"> 
                                    </td>
                                    <th width="15%">交易APP：</th>
                                    <td>
                                        <img id="img_tradeapp_path" src="<?php if(isset($params_site_ewm['tradeapp_path'])){echo $params_site_ewm['tradeapp_path'];};?>" width="100" />
                                        <input type="hidden" id="tradeapp_path" name="tradeapp_path" value="<?php if(isset($params_site_ewm['tradeapp_path'])){echo $params_site_ewm['tradeapp_path'];};?>" class="common-text"> 
                                        <input type="button" id="btn_tradeapp_path" value="上传" />
                                        <br/>
                                        <input type="text" id="tradeapp_url" name="tradeapp_url" placeholder="地址" value="<?php if(isset($params_site_ewm['tradeapp_url'])){echo $params_site_ewm['tradeapp_url'];};?>" class="common-text" style="width:90%"> 
                                    </td>
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
