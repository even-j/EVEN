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
        <script type="text/javascript">
            $(function() {
                $('#twoBtn').click(function() {
                    if (!$('#password').val()) {
                        layermsg('请输入6-18位的新密码');
                        return false;
                    }
                    if ($('#password').val() != $('#password2').val()) {
                        layermsg('两次输入的密码不一致');
                        return false;
                    }
                    $.post("<?php echo \App::URL('wap/member/resetpwd')?>",{account : $("#account").val(),password : $('#password').val() },function(ret){
                        if(ret.code == '0'){
                            layermsg(ret.msg);
                        }
                        else{
                            window.location.href = "<?php echo \App::URL('wap/member/findpwd3')?>";
                        }
                    },'json')
                });
            });
        </script>
    </head>
    <body>
        <!--第二行-->
        <!--------头部导航------------>
        <div class="body">
            <div class="header">
                <h1>重置密码</h1>
                <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
                <div class="top-menu">
                    <!--<button type="button" class="btn"></button>-->
                </div>
            </div>
            
            <!-----------登录框开始----------------->
            <div class="main">
                <div class="wrap-a">
                    <form id="forgetPwd" action="" method="POST">
                        <div class="inpbox">
                            <input id="password" type="password" name="password" autocomplete="off" tabindex="1" class="inp s2" placeholder="新密码">
                        </div>
                        <div class="inpbox">
                            <input id="password2" type="password" name="password2" autocomplete="off" tabindex="2" class="inp s2" placeholder="确认新密码">
                        </div>
                        <input type="hidden" id="account" name="account" value="<?php echo $mobile;?>"/>
                        <div class="btnbox">
                            <input type="button" id="twoBtn" class="btn-a" value="重置密码">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>