<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo SITE_NAME;?>—后台用户登陆</title>
    <link href="/public/admin/css/login.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="admin_login_wrap">
    <h1>用户登陆</h1>
   
    <div class="adming_login_border">
        <div class="admin_input">
        	
            <form action="/index.php?app=admin&mod=login&ac=doLogin" method="post">
                <ul class="admin_items">
                    <li>
                        <label for="user">用户名：</label>
                        <input type="text" name="username" value="" id="user" size="40" class="admin_input_style" style="width:98%" />
                    </li>
                    <li>
                        <label for="pwd">密码：</label>
                        <input type="password" name="pwd" value="" id="pwd" size="40" class="admin_input_style" style="width:98%" />
                    </li>
                    <li align="center" class="orange">&nbsp;<?php if(!empty($msg)){ echo $msg;} ?></li>
                    <li>
                        <input type="submit" tabindex="3" value="提交" class="btn btn-primary" />
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <p class="admin_copyright"><a tabindex="5" href="/index.php" target="_blank">返回首页</a> &copy; <?php echo date('Y',time()).'  <a href="'.DOMAIN.'" target="_blank">'.SITE_NAME;?></a> 版权所有</p>
</div>
<script type="text/javascript">
<!--
if(parent.window.frames.length>0){
	parent.window.top.location.reload();
}

//-->
</script>

</body>
</html>