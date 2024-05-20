<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=trade&ac=view">交易账户管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=trade&ac=doEdit" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input class="common-text required" id="addtime" name="addtime" size="50" value="<?php if($data['addtime']){ echo $data['addtime']; }?>" type="hidden">
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th><i class="require-red">*</i>账号类型：</th>
                                <td>
                                    <input class="common-text required" id="type" name="type" size="50" value="<?php if($data['type']){ echo $data['type']; }?>" type="text">
                                    <i class="tip left pd10">1为普通账号，2为免费体验账号</i>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>母账号：</th>
                                <td>
                                    <input class="common-text required" id="parent_account" name="parent_account" size="50" value="<?php if($data['parent_account']){ echo $data['parent_account']; }?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr <?php if($data['account']){ echo 'class="none"'; }?>>
                                <th><i class="require-red">*</i>交易账户名：</th>
                                <td>
                                    <input class="common-text required" onblur="checkAccount()" id="account" name="account" size="50" value="<?php if($data['account']){ echo $data['account']; }?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                         	 <tr>
                                <th><i class="require-red">*</i>交易账户密码：</th>
                                <td>
                                    <input class="common-text required" id="pwd" name="pwd" size="50" value="<?php if($data['pwd']){ echo $data['pwd']; }?>" type="text">
                                    <i class="tip left pd10"></i>
                                </td>
                            </tr>
                             <tr>
                            <th width="120"><i class="require-red">*</i>交易账户状态：</th>
                            <td>
                                <select name="status" id="status" class="required">
                                   <?php foreach ($status as $key=>$val){
                                    	$selected = $key==$data['status'] ? 'selected="selected"' : '';
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
function checkAccount(){
	$.post('/index.php?app=admin&mod=trade&ac=ajaxCheckAccount',{"account": $('#account').val()},function(res){
		 if(res.status=='1'){
			 $('#account').next().html('该交易账户名已存在！');
		 }else{
			 $('#account').next().html('');
		 }
	},'json');
}

$(document).ready(function(){
	$('#myform').submit(function(){
		var parent_account = $('#parent_account').val();
		var account = $('#account').val();
		
		if(parent_account==""){
			$('#parent_account').next().html('请输入母账号！');
			$('#parent_account').focus();
			return false;
		}
		
		if(account==""){
			$('#account').next().html('请输入交易账户名！');
			$('#account').focus();
			return false;
		}
			
		if($('#pwd').val()==""){
			$('#pwd').next().html('请输入交易账户密码！');
			$('#pwd').focus();
			return false;
		}
		if($("#account").next('i').html()!=''){
			return false;
		}
		return true;
	});
});
//-->
</script>
<!--include file "admin_bottom.php"-->