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
<link rel="stylesheet" href="/public/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="/public/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/public/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/public/kindeditor/plugins/code/prettify.js"></script>

<script type="text/javascript">
    $(function () {
        $(".ui_timepicker").datetimepicker();
    })
</script>
<script>
	KindEditor.ready(function(K) {
		var editor1 = K.create('textarea[name="content"]', {
			cssPath : '/public/kindeditor/plugins/code/prettify.css',
			uploadJson : '/public/kindeditor/php/upload_json.php',
			fileManagerJson : '/public/kindeditor/php/file_manager_json.php',
			allowFileManager : true,
			//autoHeightMode : true,
			afterCreate : function() {
				//this.loadPlugin('autoheight');
				var self = this;
				K.ctrl(document, 13, function() {
					self.sync();
					K('form[name=myform]')[0].submit();
				});
				K.ctrl(self.edit.doc, 13, function() {
					self.sync();
					K('form[name=myform]')[0].submit();
				});
			}
		});
                
                var editor2 = K.create('textarea[name="content2"]', {
			cssPath : '/public/kindeditor/plugins/code/prettify.css',
			uploadJson : '/public/kindeditor/php/upload_json.php',
			fileManagerJson : '/public/kindeditor/php/file_manager_json.php',
			allowFileManager : true,
			//autoHeightMode : true,
			afterCreate : function() {
				//this.loadPlugin('autoheight');
				var self = this;
				K.ctrl(document, 13, function() {
					self.sync();
					K('form[name=myform]')[0].submit();
				});
				K.ctrl(self.edit.doc, 13, function() {
					self.sync();
					K('form[name=myform]')[0].submit();
				});
			}
		});
		prettyPrint();
	});
</script>
	
<div class="container clearfix">
    <div class="main-wrap">
       <div class="crumb-wrap">
  <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name"><?php if(isset($title)) echo $title?></span></div>
</div>   
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=system&ac=dolayeredit" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th width="14%"><i class="require-red">*</i>是否开启：</th>
                                <td>
                                    <span class="select-box">
                                        <input type="radio" name="status" value="0" style="margin-left:10px" <?php if(isset($data['status']) && $data['status']==0){ ?> checked="true"<?php } ?>/>否
                                        <input type="radio" name="status" value="1" style="margin-left:10px" <?php if(isset($data['status']) && $data['status']==1){ ?> checked="true"<?php } ?>/>是
                                    </span>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th width="8%"><i class="require-red">*</i>弹窗类型：</th>
                                <td>
                                    <span class="select-box">
                                        <input type="radio" onchange="handmobileimg(this)" name="type" value="text" style="margin-left:10px" <?php if(isset($data['type']) && $data['type']=='text'){ ?> checked="true"<?php } ?>/>文本
                                        <input type="radio" onchange="handmobileimg(this)" name="type" value="img" style="margin-left:10px" <?php if(isset($data['type']) && $data['type']=='img'){ ?> checked="true"<?php } ?>/>单图
                                    </span>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th>PC端标题：</th>
                                <td>
                                    <input  class="common-text " type="text" name="title" value="<?php if(isset($data['title'])){ echo $data['title'];}?>" id="title"  style=""/>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th>PC端弹窗宽度(px)：</th>
                                <td>
                                    <input class="common-text " id="width" name="width"   value="<?php if(isset($data['width'])){ echo $data['width'];}?>" type="text" placeholder="只需填写数字">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th>PC端弹窗高度(px)：</th>
                                <td>
                                    <input class="common-text " id="height" name="height"   value="<?php if(isset($data['height'])){ echo $data['height'];}?>" type="text" placeholder="只需填写数字">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th>开始时间：</th>
                                <td>
                                    <input class="common-text " id="starttime" name="starttime" size="50" value="<?php if($data && $data['starttime']){ echo $data['starttime']; }else{echo date('Y-m-d H:i:s');}?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>内容：</th>
                                <td>
                                	<textarea name="content" id="content" class="common-textarea required" style="width:470px;"><?php if($data && $data['content']){ echo htmlspecialchars_decode($data['content']); }?></textarea>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr id="rowmobile"  style="<?php if(isset($data['type']) && $data['type']== 'text'){ echo 'display:none'; }?>">
                                <th><i class="require-red">*</i>手机端图片上传：</th>
                                <td>
                                	<textarea name="content2" id="content2" class="common-textarea required" style="width:470px;"><?php if($data && $data['content2']){ echo htmlspecialchars_decode($data['content2']); }?></textarea>
                                    <i class="tip left pd10"></i>
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


$(document).ready(function(){
	$('#myform').submit(function(){
                var starttime = $('#starttime').val();
                var status = $("input[name='status']:checked").val();
		if(starttime==""){
			$('#starttime').next().html('请输入开始时间！');
			$('#starttime').focus();
			return false;
		}else{
			$('#starttime').next().html('');
		}
                if(status=="" || status==null){
			alert("开启状态不能为空!");
			return false;
		}
		return true;
	});
});

            function handmobileimg(obj)
            {
                var value=$(obj).attr("value");
                if(value=="text")
                {
                    $("#labcont").html("内容");
                    $("#rowmobile").hide();
                }
                else
                {
                    $("#labcont").html("电脑端图片上传");
                    $("#rowmobile").show();
                }
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
