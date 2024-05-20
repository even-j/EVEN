
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
                    <form method="post" action="">
                        
                        <dt id="methodCaption">新密码：</dt>
                        <dd>
                            <input class="text" type="password" value="" name="password" id="password"/>
                            <span class="error" id="pe"></span>
                        </dd>
                        <dt id="methodCaption">确认密码：</dt>
                        <dd>
                            <input class="text" type="password" value="" name="password2" id="password2"/>
                            <span class="error" id="ce"></span>
                        </dd>
                        <dd>
                            <button type="button" id="twoBtn" class="btn btnBg1" style="width:242px;font-size:16px;height:38px">下一步</button>
                        </dd>
                        <input type="hidden" id="account" name="account" value="<?php echo $mobile;?>"/>
                    </form>
                </dl>

                <div class="zhR">
                    <b>找回密码流程：</b>
                    <p><span>01</span>验证用户信息</p>
                    <p><span class="now">02</span>设置新的登录密码</p>
                    <p><span>03</span>登录密码找回成功</p>
                </div>	
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $('#twoBtn').click(function() {
                    if (!$('#password').val()) {
                        $('#pe').show();
                        $('#pe').html('请输入6-18位的新密码');
                        return false;
                    }
                    $('#pe').hide();
                    if ($('#password').val() != $('#password2').val()) {
                        $('#ce').show();
                        $('#ce').html('两次输入的密码不一致');
                        return false;
                    }
                    $('#ce').hide();
                    $.post("<?php echo \App::URL('web/member/resetpwd')?>",{account : $("#account").val(),password : $('#password').val() },function(ret){
                        if(ret.code == '0'){
                            $('#pe').show();
                            $('#pe').html(ret.msg);
                        }
                        else{
                            window.location.href = "<?php echo \App::URL('web/member/findpwd3')?>";
                        }
                    },'json')
                });
            });
        </script>
        <!-- Content End -->
        <!--include file "footer.php"-->
    </body>
</html>