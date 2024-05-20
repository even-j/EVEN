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
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=article&ac=view">文章管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=article&ac=doEdit" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input class="common-text required" id="id" name="id" size="50" value="<?php if($data && $data['id']){ echo $data['id']; }?>" type="hidden">
                    <table class="insert-tab" width="100%">
                        <tbody>
                       	
                            <tr>
                                <th width="8%"><i class="require-red">*</i>标题：</th>
                                <td>
                                    <input class="common-text required" onblur="checkname()" id="title" name="title" size="50" value="<?php if($data && $data['title']){ echo $data['title']; }?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><i class="require-red">*</i>栏目：</th>
                                <td>
                                    <select name="pid"  class="common-select required mr10" style="width:480px;">
	                                    <?php foreach ($cateList as $cate){?>
	                                    <option value="<?php echo $cate['id']?>" <?php if($data && $data['pid']==$cate['id']) {echo 'selected="selected"';}?> ><?php echo $cate['name'];?></option>
	                                    	<?php if(!empty($cate['child'])){?>
												<?php foreach ($cate['child'] as $child){?>
												<option value="<?php echo $child['id'];?>" <?php if($data && $data['pid']==$child['id']) {echo 'selected="selected"';}?>>—<?php echo $child['name'];?></option>
												<?php }?>
											<?php }?>
	                                    <?php }?>
	                                </select>
                                    <i class="tip left pd10"></i>
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
                                <th>发布时间：</th>
                                <td>
                                    <input class="common-text required" id="addtime" name="addtime" size="50" value="<?php if($data && $data['addtime']){ echo date('Y-m-d H:i:s',$data['addtime']); }else{echo date('Y-m-d H:i:s');}?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                             <tr>
                                <th><i class="require-red">*</i>分类：</th>
                                <td>
                                <?php foreach ($flagArr as $key=>$flag){?>
                                   <input type="checkbox" value="<?php echo $key;?>" name="flag[]" <?php echo $data['flag']&&in_array($key,$data['flag']) ? 'checked="checked"' : ''?>> <?php echo $flag;?>&nbsp;&nbsp;
								<?php }?>  
                                   <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><i class="require-red">*</i>关键词：</th>
                                <td>
                                    <input class="common-text required" id="tags" name="tags" size="50" value="<?php if($data && $data['tags']){ echo $data['tags']; }?>" type="text">
                                    <i class="tip left pd10">多个关键词用“,”隔开</i>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><i class="require-red">*</i>描述：</th>
                                <td>
                                	<textarea name="description" class="common-textarea required" style="width:470px;height:50px;"><?php if($data && $data['description']){ echo $data['description']; }?></textarea>
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><i class="require-red">*</i>排序：</th>
                                <td>
                                    <input class="common-text required" id="order" name="order" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" size="50" value="<?php echo  $data && $data['order'] ? $data['order'] :'0';?>" type="text">
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
	var title = $('#title').val();
	if(title!=""){
		$('#title').next().html('');
	}
}

$(document).ready(function(){
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