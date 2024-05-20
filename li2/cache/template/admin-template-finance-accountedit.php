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
<script>
	KindEditor.ready(function(K) {
		var editor1 = K.create('textarea[name="remark"]', {
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
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=finance&ac=account">收款账户设置</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=finance&ac=accountDoedit" method="post"  id="myform" name="myform" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" size="50" value="<?php if($data && $data['id']){ echo $data['id']; }?>" >
                    <input type="hidden" id="path" name="path" value="<?php if($data && $data['path']){echo $data['path'];}?>" />
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th width="20%"><i class="require-red">*</i>名称：<br/>(用户看到的名称)</th>
                                <td>
                                    <input class="common-text required"  id="name" name="name" style="width:480px;" value="<?php if($data && $data['name']){ echo $data['name']; }?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>收款类型：</th>
                                <td>
                                    <select name="type" id="type"  class="common-select required mr10" style="width:480px;">
	                                <?php foreach ($accountType_arr as $key=>$val){
                                            $selected='';
                                            if($data && $data['type'] && $key==$data['type'])
                                            {
                                                $selected='selected="selected"';
                                            }
                                            ?>
                                            <option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $val;?></option>
                                        <?php }?>
                                            
                                            
	                            </select>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>收款渠道：<br/>(后台看到的不同帐户通道)</th>
                                <td>
                                    <input class="common-text required"  id="channel" name="channel" style="width:480px;" value="<?php if($data && $data['channel']){ echo $data['channel']; }?>" type="text">
                                </td>
                            </tr>
                            <tr id="tr_holder">
                                <th>收款开户人：</th>
                                <td>
                                    <input class="common-text required"  id="holder" name="holder" style="width:480px;" value="<?php if($data && $data['holder']){ echo $data['holder']; }?>" type="text">
                                </td>
                            </tr>
                            <tr id="tr_account">
                                <th>收款账号：</th>
                                <td>
                                    <input class="common-text required"  id="account" name="account" style="width:480px;" value="<?php if($data && $data['account']){ echo $data['account']; }?>" type="text">
                                </td>
                            </tr>
                            <tr id="tr_address">
                                <th>开户地址：</th>
                                <td>
                                    <input class="common-text required"  id="address" name="address" style="width:480px;" value="<?php if($data && $data['address']){ echo $data['address']; }?>" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th>描述(手机端用)：</th>
                                <td>
                                    <input class="common-text required"  id="caption" name="caption" style="width:480px;" value="<?php if($data && $data['caption']){ echo $data['caption']; }?>" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>用户组：</th>
                                <td>
                                    <input type="hidden" id="group_id" name="group_id" value="<?php if($data && $data['group_id']){echo $data['group_id'];}?>">
                                    <input type="text" id="group_name" style="width:480px;"  class="input-text" value="<?php if($data && $data['group_name']){echo $data['group_name'];}?>" readonly="readonly" placeholder="双击选择用户组" datatype="*" nullmsg="不能为空" ondblclick="btn_open_group();"  >
                                    <input type="button" value="选择" class="btn btn-default radius" onclick="btn_open_group();" />
                                    <span id="tips_group_id" style="color:red">必填</span>
                                </td>
                            </tr>
                            <tr>
                                <th>序号：</th>
                                <td>
                                    <input class="common-text required"  id="sortno" name="sortno" style="width:480px;" value="<?php if($data && $data['sortno']){ echo $data['sortno']; }?>" type="number">
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>状态：</th>
                                <td>
                                     <select name="status" id="status"  class="common-select required mr10" style="width:480px;">
                                     	<?php foreach ($status_arr as $key=>$val){?>
						<option value="<?php echo $key;?>" <?php if($data && $data['status']==$key) {echo 'selected="selected"';}?>><?php echo $val;?></option>
                                     	<?php }?>
                                     </select>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                             <tr id="tr_path">
                                <th>收款二维码：</th>
                                <td><input name="path" id="path" type="file">
                                    <img src="<?php if($data && $data['path']){echo $data['path'];}?>" style="height: 100px"/>
                                </td>
                               
                            </tr>
                            <tr>
                                <th>备注：</th>
                                <td>
                                    <textarea name="remark" class="common-textarea required" style="width:480px;"><?php if($data && $data['remark']){ echo htmlspecialchars_decode($data['remark']); }?></textarea>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            
                        
                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" name="submit" value="提交" type="submit" onclick="validateForm()">
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
        type_change();
	$('#myform').submit(function(){
            if($('#name').val()==""){
                $('#name').next().html('请输入名称！');
                $('#name').focus();
                return false;
            }else{
                $('#name').next().html('');
            }
            
            if($('#type').val()==""){
                $('#type').next().html('请选择收款类型！');
                $('#type').focus();
                return false;
            }else{
                $('#type').next().html('');
            }
            
            if($('#channel').val()==""){
                $('#channel').next().html('请输入收款渠道！');
                $('#channel').focus();
                return false;
            }else{
                $('#channel').next().html('');
            }

            if($('#path').val()!='' && !/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test($('#path').val()))
            {
                layer.msg("二维码图片必须是.gif,jpeg,jpg,png中的一种")
                return false;
            }
            return true;
	});
        
        $("#type").change(function(){
            type_change();
        });
        function type_change(){
            var value=$("#type").val();
            if(value=='0')
            {
                $("#tr_holder").show();                
                $("#tr_account").show();
                $("#tr_address").show();
                $("#tr_path").hide();
            }
            else
            {
                $("#tr_holder").show();                
                $("#tr_account").show();
                $("#tr_address").hide();
                $("#tr_path").show();
            }
        }
});

//选择用户组
function btn_open_group() {
    
    var group_id = $("#group_id").val().trim();
    var group_name = $("#group_name").val().trim();
    var url="/index.php?app=admin&mod=user&ac=grouppop&group_id="+group_id+"&group_name="+group_name;
    var index = layer.open({
        type: 2,
        title: '选择用户组',
        area: ['800px', '350px'],
        content: url
    });
}

function validateForm() {
    
        var group_id = $('#group_id');
        if (group_id.val() == "") {
            alert('用户组不能为空!');
            return false;
        }
        return true;
    }
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
