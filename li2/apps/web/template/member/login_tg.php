
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>

    <body class="index">
        <!-- Header Start -->
        <div id="top">
        </div>
        <link href="/public/web/css/login.css" rel="stylesheet" type="text/css" media="screen,projection" />
        <script type="text/javascript" src="/public/web/js/login.js"></script>
        <style type="text/css">
            .foot{ margin-top:0;}
        </style>
        <div class="login">
            <div class="bar">
                <form id="loginForm" method="post">
                    <div class="loginBox">
                        <b>登录</b>
                        <p class="inputBox">
                            <span>用户名/手机号码：<i id="un"></i></span><input type="text" name="username" id="username"/>
                        </p>
                        <p class="inputBox">
                            <span>密码：<i id="up"></i></span><input type="password" name="password" id="password"/>
                        </p>

                        <p class="inputBox authcode" style="display:none">
                            <span>验证码：<i id="ua"></i></span><input class="yzm" type="text" name="authcode" id="authcode"/>
                            <img class="yzmPic codeimg" src="/member/authcode.html" />
                        </p>
                        <p class="text authcode codeimg" style="display:none">
                            <a class="authcode font3" href="#">看不清楚，换一个</a>
                        </p>
                        </empty>
                        <input type="hidden" name="from" id="from" value="<?php echo $refer;?>"/>
                        <a href="#" id="login" class="btn btnBg1">登录</a>
                        <p class="text">
<!--                            <a class="font3" href="<?php echo \App::URL("web/member/findpwd");?>">忘记密码？</a><a class="font3" href="<?php echo \App::URL("web/member/register");?>">立即注册</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
                            <span class="regLink">奔往财富之路！ </span>
                        </p>
                    </div>
            </div>
        </div>
        <!-- Footer Start -->
    </body>
</html>