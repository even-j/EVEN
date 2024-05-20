<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
    	 <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=user&ac=view">用户管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
             <form action="/index.php?app=admin&mod=user&ac=doadd" method="post" onclick="return validateForm();" id="myform" name="myform" enctype="multipart/form-data">
                <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th width="120">手机号：</th>
                                <td><input class="common-text required" id="mobile" name="mobile" size="50" value="" type="text"/> <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th width="120">密码：</th>
                                <td><input class="common-text required" id="password" name="password" size="50" value="" type="text"/> <i class="tip left pd10"></i>
                                </td>
                            </tr>
                            <tr>
                                <th>姓名：</th>
                                <td><input class="common-text required" id="true_name" name="true_name" size="50" value="" type="text"/> <i class="tip left pd10"></i></td>
                            </tr>
                            <tr>
                                <th>身份证号：</th>
                                <td><input class="common-text required" id="id_card" name="id_card" size="50" value="" type="text"/> <i class="tip left pd10"></i></td>
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
function validateForm(){
    var mobile = $('#mobile');
    var password = $('#password');
    if (mobile.val() == "") {
        mobile.next().html('手机号不能为空');
        return false;
    }else{
        mobile.next().html('');
    }
    if (password.val() == "") {
        password.next().html('密码不能为空');
        return false;
    }else{
        password.next().html('');
    }
    return true;
}




</script>
<!--include file "admin_bottom.php"-->