<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<meta name="format-detection" content="telephone=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title><?php if (isset($title)) echo $title ?></title>
<meta name="keywords" content="<?php if (isset($keywords)) echo $keywords ?>">
<meta name="description" content="<?php if (isset($description)) echo $description ?>">
<link rel="stylesheet" href="/public/wap/css/wap_style.css">
<link rel="stylesheet" href="/public/wap/css/wap_new.css">
<script src="/public/wap/js/jquery.js" type="text/javascript"></script>
<script src="/public/wap/js/layer_mobile/layer.js" type="text/javascript"></script>
<script src="/public/wap/js/common.js" type="text/javascript"></script>

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
            <div class="header">
                <h1>登录</h1>
                <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
<!--                <div class="top-menu">
                    <button type="button" class="btn"></button>
                </div>-->
            </div>
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
                            <div class="titbox">
                                <a href="<?php echo  \App::URL('wap/member/register');?>" class="l" style="font-size: 12px">没有账号？立即注册</a>
                                <a href="<?php echo  \App::URL('wap/member/findpwd');?>" class="r" style="font-size: 12px">忘记密码?</a>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </body>
</html>