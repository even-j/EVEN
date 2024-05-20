<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">修改密码</span></div>
        </div>
        <div class="result-wrap">
            <form action="/index.php?app=admin&mod=user&ac=dopassword" method="post" id="myform" name="myform">
                <div class="config-items">
                    <div class="config-title">
                        <h1><i class="icon-font">&#xe015;</i>修改管理员密码</h1>
                    </div>
                    <div class="result-content">
                    	<?php if(!empty($msg)){?><h4 align="center" class="require-red"><?php echo $msg;?></h4><br/><?php }?>
                        <table width="100%" class="insert-tab">
                            <tbody>
	                            <tr>
	                                <th width="15%"><i class="require-red">*</i>旧密码：</th>
	                                <td><input type="password" id="oldpwd" value="" size="85" name="oldpwd" class="common-text">&nbsp;&nbsp;<span class="all_submit_error">请输入您的旧密码</span></td>
	                            </tr>
                                <tr>
                                    <th><i class="require-red">*</i>新密码：</th>
                                    <td><input type="password" id="pwd" value="" size="85" name="pwd" class="common-text">&nbsp;&nbsp;<span class="all_submit_error">请输入您的新密码</span></td>
                                </tr>
                                <tr>
                                    <th><i class="require-red">*</i>确认密码：</th>
                                    <td><input type="password" id="repwd" value="" size="85" name="repwd" class="common-text">&nbsp;&nbsp;<span class="all_submit_error">新密码和确认密码输入不一致</span></td>
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
<!--
$(document).ready(function(){
	$('.common-text').bind('focus',function(){
		if($(this).val()==""){
			$(this).next('.all_submit_error').show();
		}else{
			$(this).next('.all_submit_error').hide();
		}
	});

	$('.common-text').bind('blur',function(){
		if($(this).val()==""){
			$(this).next('.all_submit_error').show();
		}else{
			$(this).next('.all_submit_error').hide();
		}
	});
	
	/*修改密码*/
	$("#myform").submit(function(e){
		var oldpwd = $('#oldpwd'), pwd = $('#pwd'), repwd = $('#repwd');
		if(oldpwd.val()==""){
			oldpwd.next('.all_submit_error').show();
			return false;
		}
		if(pwd.val()==""){
			pwd.next('.all_submit_error').show();
			return false;
		}
		if(repwd.val()=="" || pwd.val() != repwd.val()){
			repwd.next('.all_submit_error').show();
			return false;
		}
		
		$(this).submit();
		//$("#bg-mask,#share-map").show();
	});
	
});
//-->
</script>
<!--include file "admin_bottom.php"-->