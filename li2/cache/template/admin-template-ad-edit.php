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
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=ad&ac=view">广告管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=ad&ac=doEdit" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input type="hidden" name="id" value="<?php echo $data['id'];?>" />
                	<input type="hidden" id="ad_path" name="ad_path" value="<?php echo $data['ad_pic'];?>" />
                    <table class="insert-tab" width="100%">
                        <tbody>
                        <tr>
                            <th width="120"><i class="require-red">*</i>广告分类：</th>
                            <td>
                                <select name="type_id" id="type_id" class="required">
                                   <?php foreach ($ad_type as $key=>$val){
                                    	$selected = $data['type_id'] && $val['id']==$data['type_id'] ? 'selected="selected"' : '';
                                    ?>
                                    <option value="<?php echo $val['id'];?>" <?php echo $selected;?>><?php echo $val['type_name'];?></option>
                                    <?php }?>
                                </select>
                            </td>
                        </tr>
                            <tr>
                                <th><i class="require-red">*</i>广告标题：</th>
                                <td>
                                    <input class="common-text required" id="ad_name" name="ad_name" size="50" value="<?php if($data['ad_name']){ echo $data['ad_name']; }?>" type="text">
                                </td>
                            </tr>
                         
                            <tr>
                                <th><i class="require-red">*</i>广告图片：</th>
                                <td><input name="ad_pic" id="ad_pic" type="file"><!--<input type="submit" onclick="submitForm('/jscss/admin/design/upload')" value="上传图片"/>--></td>
                            </tr>
                             <tr>
                                <th>广告链接：</th>
                                <td><input class="common-text" name="ad_link" size="50" value="<?php if($data['ad_link']){ echo $data['ad_link']; }else{ echo '#';} ?>" type="text">&nbsp;&nbsp;<span>链接地址必须是以“http”开头，例如：<?php echo DOMAIN;?></span></td>
                            </tr>
                           
                            <tr>
                                <th><i class="require-red">*</i>排序：</th>
                                <td>
                                    <input class="common-text required" id="order" name="order" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" size="50" value="<?php echo  $data && $data['order'] ? $data['order'] :'0';?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            
                             <tr>
                            <th width="120"><i class="require-red">*</i>广告状态：</th>
                            <td>
                                <select name="status" id="status" class="required">
                                   <?php foreach ($status as $key=>$val){
                                    	$selected = $val['status']==$data['status'] ? 'selected="selected"' : '';
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
$(document).ready(function(){
	$('#myform').submit(function(){
		if($('#ad_name').val()==""){
			layer.msg('请输入广告标题！');
			$('#ad_name').focus();
			return false;
		}
		
		if($('#type_id option:selected').val()!=2 && $('#ad_path').val()=='' && $('#ad_pic').val()==""){
			layer.msg('请选择要上传的广告图片！');
			$('#ad_name').focus();
			return false;
		}
		if($('#ad_pic').val()!='' && !/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test($('#ad_pic').val()))
        {
	          layer.msg("广告图片必须是.gif,jpeg,jpg,png中的一种")
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
