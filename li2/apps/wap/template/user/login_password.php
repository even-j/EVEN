<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>

    <body class="index">
        <div class="body">
            <div class="header">
                <h1>修改密码</h1>
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
                            <input id="oldPwd" name="oldPwd" type="password" autocomplete="off" tabindex="2" class="inp s2" placeholder="旧登录密码">
                        </div>
                        <div class="inpbox">
                            <input id="newPwd" name="newPwd" type="password" autocomplete="off" tabindex="2" class="inp s2" placeholder="新登录密码">
                        </div>
                        <div class="inpbox">
                            <input id="newPwdConfirm" name="newPwdConfirm" type="password" autocomplete="off" tabindex="2" class="inp s2" placeholder="新登录密码确认">
                        </div>
                        <div class="btnbox">
                            <div id="dosubmit" class="btn_primary">修改</div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $('#dosubmit').click(function() {
                    if (!$('#oldPwd').val()) {
                        layeralert("为了您的账户安全，请先输入原密码");
                        return false;
                    }
                    if (!$('#newPwd').val()) {
                        layeralert("请输入新密码，并在下面再次输入确认");
                        return false;
                    } else if ($('#newPwd').val().length < 6) {
                        layeralert("密码必须为 6-20位的英文或数字组合");
                        return false;
                    }
                    if ($('#newPwdConfirm').val() != $('#newPwd').val()) {
                        layeralert("新密码和确认密码输入不一致，请重新输入");
                        return false;
                    }

                    $.post('<?php echo \App::URL("wap/user/modifyLoginPwd")?>', $('form').serialize(), function(res) {
                        if (res.code == 1) {
                            layeralert("密码修改成功");
                            //top.dialog(res.msg, 'success');
                        } else {
                            layeralert(res.msg);
                        }
                    }, 'json');

                });
            });
        </script>
    </body>
</html>