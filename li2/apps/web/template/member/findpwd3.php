
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>

    <body class="index">
        <!-- Header Start -->
        <div id="top">
            <!--include file "header.php"-->
            <!--include file "nav.php"-->
        </div>
        <link href="/public/web/css/login.css" rel="stylesheet" type="text/css" media="screen,projection" />
        <style>
            dd span.error{display:none;color: #F00;}
        </style>
        <!-- Content Start -->
        <div class="bar">
            <div class="borBox" id="zhBar">
                <div class="title1"><b>找回密码</b></div>
                <dl class="form">
                    <div style="padding:50px 100px;text-align: center">
                        <div style="width:100px;display: inline-block">
                            <img src="/public/web/images/alert-s.png"/>
                        </div>
                        <div style="display: inline-block;color:#777;font-size:16px;font-weight: 700;padding: 20px">
                            密码设置成功
                        </div>
                    </div>
                    <dd style="text-align:center;padding-left:0">
                        <button type="button" id="threeBtn" class="btn btnBg1" style="width:120px;font-size:16px;height:38px">登录</button>
                    </dd>
                </dl>
                
                <div class="zhR">
                    <b>找回密码流程：</b>
                    <p><span>01</span>验证用户信息</p>
                    <p><span>02</span>设置新的登录密码</p>
                    <p><span class="now">03</span>登录密码找回成功</p>
                </div>	
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $('#threeBtn').click(function() {
                    window.location.href = "<?php echo \App::URL('web/member/login')?>";
                });
            });
        </script>
        <!-- Content End -->
        <!--include file "footer.php"-->
    </body>
</html>