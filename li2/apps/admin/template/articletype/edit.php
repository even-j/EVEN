<!--include file "admin_include.php"-->
<link rel="stylesheet" href="/public/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/public/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="/public/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/public/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/public/kindeditor/plugins/code/prettify.js"></script>
<script>
	KindEditor.ready(function(K) {
		var editor1 = K.create('textarea[name="contents"]', {
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
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=articletype&ac=view">栏目管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=articletype&ac=doEdit" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input class="common-text required" id="id" name="id" size="50" value="<?php if($data && $data['id']){ echo $data['id']; }?>" type="hidden">
                    <table class="insert-tab" width="100%">
                        <tbody>
                       	
                            <tr>
                                <th width="10%"><i class="require-red">*</i>栏目名称：</th>
                                <td>
                                    <input class="common-text required" onblur="checkname()" id="name" name="name" size="50" value="<?php if($data && $data['name']){ echo $data['name']; }?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                         	 <tr>
                                <th><i class="require-red">*</i>排序编号：</th>
                                <td>
                                    <input class="common-text required" id="order" name="order" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" size="50" value="<?php echo  $data && $data['order'] ? $data['order'] :'0';?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><i class="require-red">*</i>父级栏目：</th>
                                <td>
                           
                               	<select id="pid" name="pid" style="width: 480px;" class="common-select required">
										<option value="0">根目录</option>
										<?php foreach ($cate_list as $cate){?>
										<option value="<?php echo $cate['id'];?>" <?php if($data && $data['pid']==$cate['id'] || $cate['id']==$pid){ echo 'selected="selected"';}?>><?php echo $cate['name'];?></option>
										<?php if(!empty($cate['child'])){?>
											<?php foreach ($cate['child'] as $child){?>
											<option value="<?php echo $child['id'];?>" <?php if($data && $data['pid']==$child['id'] || $child['id']==$pid){ echo 'selected="selected"';}?>>—<?php echo $child['name'];?></option>
											<?php }?>
										<?php }?>
										<?php }?>
								</select>
                                </td>
                            </tr>
                              <tr>
                                <th><i class="require-red">*</i>内容：</th>
                                <td>
                                	<textarea name="contents" class="common-textarea required" style="width:470px;"><?php if($data && $data['contents']){ echo htmlspecialchars_decode($data['contents']); }?></textarea>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                             <tr>
                                <th><i class="require-red">*</i>SEO标题：</th>
                                <td>
                                    <input class="common-text required" id="title" name="title" size="50" value="<?php if($data && $data['title']){ echo $data['title']; }?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                             <tr>
                                <th><i class="require-red">*</i>SEO关键词：</th>
                                <td>
                                    <input class="common-text required" id="tags" name="tags" size="50" value="<?php if($data && $data['tags']){ echo $data['tags']; }?>" type="text">
                                    <i class="tip left pd10">多个关键词用“,”隔开</i>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><i class="require-red">*</i>SEO描述：</th>
                                <td>
                                	<textarea name="description" class="common-textarea required" style="width:470px;height:80px;"><?php if($data && $data['description']){ echo $data['description']; }?></textarea>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                              <tr>
                                <th><i class="require-red">*</i>是否单页：</th>
                                <td>
                              	<select name="is_page"  class="common-select required mr10" style="width:120px;">
                                    <?php foreach ($typeArr as $key=>$type){?>
                                    <option value="<?php echo $key;?>" <?php if(isset($data) && $data['is_page']==$key ) {echo 'selected="selected"';}?> ><?php echo $type;?></option>
                                    <?php }?>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>跳转链接：</th>
                                <td>
                                    <input class="common-text required" id="link" name="link" size="50" value="<?php if($data && $data['link']){ echo $data['link']; }?>" type="text">
                                    <i class="tip left pd10">外部链接必须是“http://”开头</i>
                                </td>
                            </tr>
                            
                             <tr>
                                <th><i class="require-red">*</i>栏目状态：</th>
                                <td>
                               	<select id="is_use" name="is_use" style="width: 480px;" class="common-select required">
                               		<option value="1" <?php if($data && $data['is_use']==1){ echo 'selected="selected"';}?>>可用</option>
                               		<option value="0" <?php if($data && $data['is_use']==0){ echo 'selected="selected"';}?>>禁用</option>
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
function checkname(){
	/*$.post('/index.php?app=admin&mod=trade&ac=ajaxCheckname',{"name": $('#name').val()},function(res){
		 if(res.status=='1'){
			 $('#name').next().html('该栏目名称已存在！');
		 }else{
			 $('#name').next().html('');
		 }
	},'json');*/
	var name = $('#name').val();
	if(name!=""){
		$('#name').next().html('');
	}
}

$(document).ready(function(){
	
	$('#myform').submit(function(){
		var name = $('#name').val();
		if(name==""){
			$('#name').next().html('请输入栏目名称！');
			$('#name').focus();
			return false;
		}else{
			$('#name').next().html('');
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