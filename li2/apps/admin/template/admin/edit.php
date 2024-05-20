<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
    	 <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=user&ac=manage">管理员管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
             <form action="/index.php?app=admin&mod=admin&ac=doEdit" method="post" onclick="return validateForm();" id="myform" name="myform" enctype="multipart/form-data">
                	<input type="hidden" name="admin_id" value="<?php echo $adminInfo ? $adminInfo['admin_id'] :'';?>" />
                <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th><i class="require-red">*</i>姓名：</th>
                                <td><input class="common-text required" id="real_name" name="real_name" size="50" value="<?php echo $adminInfo ? $adminInfo['real_name'] : '';?>" type="text"/> <i class="tip left pd10"></i></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>用户名：</th>
                                <td><input class="common-text required" id="user_name" name="user_name" size="50" value="<?php echo $adminInfo ? $adminInfo['user_name'] : '';?>" type="text"/> <i class="tip left pd10"></i></td>
                            </tr>
                            
                            
                       		 <tr>
                                <th><i class="require-red">*</i>密码：</th>
                                <td><input class="common-text required" id="pwd" name="pwd" size="50" value="<?php echo $adminInfo ? $adminInfo['pwd'] : '';?>" type="password"/> <i class="tip left pd10"></i></td>
                            </tr>
                             <tr>
                                <th><i class="require-red">*</i>确认密码：</th>
                                <td><input class="common-text required" id="pwd2" name="pwd2" size="50" value="<?php echo $adminInfo ? $adminInfo['pwd'] : '';?>" type="password"/> <i class="tip left pd10"></i></td>
                            </tr>
                             <tr>
                                <th><i class="require-red"></i>手机号码：</th>
                                <td><input class="common-text required" id="mobile" name="mobile" size="50" value="<?php echo $adminInfo ? $adminInfo['mobile'] : '';?>" type="text"/> <i class="tip left pd10"></i></td>
                            </tr>
                              <tr>
                                <th><i class="require-red">*</i>所属角色：</th>
                                <td>
                                <select class="common-select required" name="role_id" id="role_id" style="width: 480px;">
									<?php foreach ($roles as $role){
									$selected = $adminInfo && $adminInfo['role_id']==$role['id'] ? 'selected="selected"' : '';
									?>	
									<option value="<?php echo $role['id']?>" <?php echo $selected;?>><?php echo $role['name']?></option>
									<?php }?>	
									</select>
									<i class="tip left pd10"></i>
                                
                                </td>
                              </tr>
                             
                             <tr class="bank">
                             	<th><i class="require-red">*</i>所属商户：</th>
                                <td>
                             	 <select class="common-select required" name="shop_id" id="shop_id" style="width: 480px;">
									<?php foreach ($shopList as $shop){
									$selected = $adminInfo && $adminInfo['shop_id']==$shop['shop_id'] ? 'selected="selected"' : '';
									?>	
									<option value="<?php echo $shop['shop_id']?>" <?php echo $selected;?>><?php echo $shop['shop_name']?></option>
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
                        </tbody>
                 </table>
                </form> 
            </div>
        </div>

    </div>
    <!--/main-->
</div>
<script type="text/javascript">
$(document).ready(
	function(){
		if($('#role_id').val()==5){
			$('.bank').show();
		}else{
			$('.bank').hide();
		}

		$('#role_id').bind('change',function(){
			if($(this).val()==5){
				$('.bank').show();
			}else{
				$('.bank').hide();
			}
		});
	}
);
function validateForm(){
	var real_name = $('#real_name');
	var user_name = $('#user_name');
	var pwd = $('#pwd');
	var pwd2 = $('#pwd2');
	
	if (real_name.val() == "") {
		real_name.next().html('姓名不能为空');
		return false;
	}else{
		real_name.next().html('');
	}

	if (user_name.val() == "") {
		user_name.next().html('用户名不能为空');
		return false;
	}else{
		real_name.next().html('');
	}

	if (pwd.val() == "" || pwd.val().length<6) {
		pwd.next().html('密码不能为空并且长度不少于6位');
		return false;
	}else{
		if (pwd.val() != pwd2.val()) {
			 pwd2.next().html('两次输入的密码不一致');
			return false;
		}else{
			 pwd2.next().html('');
			 pwd.next().html('');
		}
	}
	if($("#user_name").next('i').html()!=''){
		return false;
	}

	if($('#role_id').val()==5){
		var bank_name = $('#bank_name');
		var bank_realname = $('#bank_realname');
		var card_no = $('#card_no');
		var bank_address = $('#bank_address');
		if (bank_name.val() == "") {
			bank_name.next().html('开户行的名称不能为空');
			return false;
		}else{
			bank_name.next().html('');
		}

		if (bank_realname.val() == "") {
			bank_realname.next().html('户名不能为空');
			return false;
		}else{
			bank_realname.next().html('');
		}

		if (card_no.val() == "") {
			card_no.next().html('卡号不能为空');
			return false;
		}else{
			card_no.next().html('');
		}
		if (bank_address.val() == "") {
			bank_address.next().html('开户行地址不能为空');
			return false;
		}else{
			bank_address.next().html('');
		}
	}
	return true;
}

$("#user_name").blur(function() {
	$.post('/index.php?app=admin&mod=user&ac=ajaxCheckUserName',{"user_name": $.trim($(this).val())},function(res){
		 if(res.status=='1'){
			 $("#user_name").next().html('该用户名已存在！');
		 }else{
			 $("#user_name").next().html('');
		 }
	},'json');
});


</script>
<!--include file "admin_bottom.php"-->