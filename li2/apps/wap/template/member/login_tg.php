<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <!--include file "common.php"-->
        <link rel="stylesheet" href="/public/wap/css/wap_new.css">
        <script>
            $(function(){
                $('#login').click(function() {
                    if (!$('#username').val()) {
                        $('#username').focus();
                        layermsg("帐号不能为空");
                        return;
                    } 
                    if (!$('#password').val()) {
                        layermsg("密码不能为空");
                        return;
                    }
                    $.post("/index.php?app=wap&mod=member&ac=dologin", $("#loginForm").serialize(), function(res) {
                        if (res.code == 0) {
                            layermsg(res.msg);
                        } else {
                            var url = $('#from').val();
                            if(url==""){
                                url = "/index.php?app=wap&mod=user&ac=account";
                            }
                            window.location = url;
                        }
                    }, 'json');
                });
            })
            
        </script>
    </head>
    <!--------头部导航------------>
    <body class="ios7">
        <div class="body">
            <!--------登录框------------>
            <div class="main">
                <input type="hidden" name="from" id="from" value="<?php echo $refer;?>"/>
                <div class="wrap-a">
                    <form id="loginForm" action="" method="POST">
                        <div class="inpbox">
                            <input type="text" id="username" name="username" value="" autocomplete="off" tabindex="1" class="inp s1" placeholder="手机号">
                        </div>
                        <div class="inpbox">
                            <input id="password" type="password" name="password" autocomplete="off" tabindex="2" class="inp s2" placeholder="登录密码">
                        </div>
                        <div class="btnbox">
                            <div id="login" class="btn_primary">登录</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </body>
</html>