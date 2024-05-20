<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
    	<?php if($user['uid']){?>
    	 <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=user&ac=view">用户管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <?php }?>
        <div class="result-wrap">
            <div class="result-content">
             <form action="/index.php?app=admin&mod=user&ac=sendTelmsg" method="post" id="myform" name="myform" onsubmit="return validateForm();" enctype="multipart/form-data">
                	<input type="hidden" name="uid" value="<?php echo $user['uid'];?>" />
                <table class="insert-tab" width="100%">
                        <tbody>
                        	<?php if($user['uid']){?>
                            <tr>
                                <th width="120">姓名：</th>
                                <td><?php echo $user['true_name'];?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <th width="120">手机：</th>
                                <td><input type="text" id="mobile" name="mobile" value="<?php echo $user['mobile'];?>"/><i class="tip left pl10"></i></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>内容：</th>
                                <td><textarea id="con" name="con" rows="10"></textarea><i class="tip left pl10"></i></td>
                            </tr>
                            
                       		 <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" name="submit" value="发送" type="submit">
                                    <input class="btn btn6" onClick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody>
                 </table>
                </form> 
            </div>
        </div>

    </div>
    <!--/main-->
</div>
<script type="text/javascript">
function validateForm(){
	var mobile = $('#mobile');
	if (mobile.val() == "") {
		mobile.next().html('请输入您的手机号码');
		return false;
	}else{
		mobile.next().html('');
	}
	
	var content = $('#con');
	if (content.val() == "") {
		content.next().html('短信内容不能为空');
		return false;
	}else{
		content.next().html('');
	}
	return true;
}

</script>
<!--include file "admin_bottom.php"-->