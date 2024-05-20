<!--include file "admin_include.php"-->
<link type="text/css" href="/public/admin/css/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
<link type="text/css" href="/public/admin/css/jquery-ui-timepicker-addon.css" rel="stylesheet" />
<script type="text/javascript" src="/public/admin/js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="/public/admin/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/public/admin/js/jquery-ui-timepicker-zh-CN.js"></script>
<script type="text/javascript">
    $(function () {
        $(".ui_timepicker").datetimepicker({
        	showTimepicker:true,
        	showButtonPanel:true,
        	showSecond: false,
	       	timeFormat: "hh:mm:ss",
	        dateFormat: "yy-mm-dd",
            stepHour: 1,
            stepMinute: 1,
            stepSecond: 1
         });
    })
</script>

<link rel="stylesheet" href="/public/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/public/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="/public/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/public/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/public/kindeditor/plugins/code/prettify.js"></script>
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
		prettyPrint();
	});
</script>
	
<div class="container clearfix">
    <div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=question&ac=view">问答管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=question&ac=doEdit" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input class="common-text required" id="id" name="id" size="50" value="<?php if($data && $data['que_id']){ echo $data['que_id']; }?>" type="hidden">
                	<input class="common-text required" id="type" name="type" size="50" value="<?php if($type){ echo $type; }?>" type="hidden">
                    <table class="insert-tab" width="100%">
                        <tbody>
                       	
                            <?php if($type=='huifu'){?>
	                             <tr>
	                                <th><i class="require-red">*</i>问题内容：</th>
	                                <td><div style="width:670px;line-height:25px;margin-bottom:10px;"><?php if($data && $data['content']){ echo htmlspecialchars_decode($data['content']); }?></div>
	                                    <i class="tip left pd10"></i>
	                                </td>
	                            </tr>
	                            <?php if($data && $data['typeid']==2){?>
	                             <tr>
	                                <th><i class="require-red">*</i>建议内容：</th>
	                                <td><div style="width:670px;line-height:25px;margin-bottom:10px;"><?php if($data && $data['advice']){ echo htmlspecialchars_decode($data['advice']); }?></div>
	                                    <i class="tip left pd10"></i>
	                                </td>
	                            </tr>
	                            <?php }?> 
	                              <tr>
	                                <th><i class="require-red">*</i>回复内容：</th>
	                                <td>
	                                	<textarea name="content" class="common-textarea required" style="width:470px;"></textarea>
	                                    <i class="tip left pd10"></i>
	                                </td>
	                            </tr>
                            <?php }else{?>
                            <tr>
                                <th><i class="require-red">*</i>分类：</th>
                                <td>
                                    <select name="typeid" class="common-select required mr10" style="width:480px;" id="question_type">
	                                    <?php foreach ($typeArr as $key=>$val){?>
	                                    <option value="<?php echo $key;?>" <?php if($data && $data['typeid']==$key) {echo 'selected="selected"';}?>><?php echo $val;?></option>
	                                    <?php }?>
	                                </select>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>提问时间：</th>
                                <td>
                                    <input class="common-text required ui_timepicker" id="que_time" name="que_time" size="50" value="<?php if($data && $data['que_time']){ echo date('Y-m-d H:i:s',$data['que_time']); }else{echo date('Y-m-d H:i:s',time());}?>" type="text">
                                </td>
                            </tr>
                             <?php if($type!='wenda'){?>
                            <tr>
                                <th><i class="require-red">*</i>回复时间：</th>
                                <td>
                                    <input class="common-text required ui_timepicker" id="reply_time" name="reply_time" size="50" value="<?php if($data && $data['reply_time']){ echo date('Y-m-d H:i:s',$data['reply_time']); }else{echo date('Y-m-d H:i:s',time());}?>" type="text">
                                </td>
                            </tr>
                            <?php }?>
                            <tr>
                                <th><i class="require-red">*</i>流量次数：</th>
                                <td>
                                    <input class="common-text required" id="views" name="views" size="50" value="<?php if($data && $data['views']){ echo $data['views'];}else{ echo '1';}?>" type="text">
                                </td>
                            </tr>
                             <tr>
                                <th><i class="require-red">*</i>问题内容：</th>
                                <td>
                                	<textarea name="content" class="common-textarea required" style="width:470px;"><?php if($data && $data['content']){ echo htmlspecialchars_decode($data['content']); }?></textarea>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                             <tr id="tr_advice" style="<?php echo $data && $data['typeid']==3 ? '' :'display:none'; ?>">
                                <th><i class="require-red">*</i>建议内容：</th>
                                <td>
                                	<textarea name="advice" class="common-textarea required" style="width:645px;height:50px;"><?php if($data && $data['advice']){ echo ($data['advice']); }?></textarea>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                         	 <tr>
                                <th><i class="require-red">*</i>状态：</th>
                                <td>
                                     <select name="status"  class="common-select required mr10" style="width:480px;">
                                     	<?php foreach ($status as $key=>$val){?>
											<option value="<?php echo $key;?>" <?php if($data && $data['status']==$key) {echo 'selected="selected"';}?>><?php echo $val;?></option>
                                     	<?php }?>
                                     </select>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            
                           <?php }?> 
                        
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
	$('#question_type').change(
		function(){
			var typeid = $(this).val();
			if(typeid==3){
				$('#tr_advice').show();
			}else{
				$('#tr_advice').hide();
			}
		}
	);
	$('#myform').submit(function(){
		var title = $('#title').val();
		if(title==""){
			$('#title').next().html('请输入文章标题！');
			$('#title').focus();
			return false;
		}else{
			$('#title').next().html('');
		}
			
		if($('#order').val()==""){
			$('#order').next().html('请输入排序编号！');
			$('#order').focus();
			return false;
		}else{
			$('#order').next().html('');
		}

		
		return true;
	});
});
//-->
</script>
<!--include file "admin_bottom.php"-->