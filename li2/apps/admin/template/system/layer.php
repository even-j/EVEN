<!--include file "admin_include.php"-->

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
       <!--include file "admin_nav.php"-->
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
<!--include file "admin_bottom.php"-->