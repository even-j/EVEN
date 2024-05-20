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
        <!--include file "user_header.php"-->
        <div class="bar">
            <div class="my-space">
                <div class="space-main clearfix">
                    <div class="space-left">
                        <!--include file "user_left_menu.php"-->
                    </div>
                    <div class="space-right">
                        <h2><strong>登录密码修改</strong></h2>
                        <div class="formbox">
                            <form method="post">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>原密码：</th>
                                            <td>
                                                <input id="oldPwd" name="oldPwd" class="inp" type="password" autocomplete="off">
                                                    <span style="color:red" id="io"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>新密码：</th>
                                            <td>
                                                <input id="newPwd" name="newPwd" class="inp" type="password" autocomplete="off">
                                                    <span style="color:red" id="in"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>确认新密码：</th>
                                            <td>
                                                <input id="newPwdConfirm" name="newPwdConfirm" class="inp" type="password" autocomplete="off">
                                                    <span style="color:red" id="ic"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <td>
                                                <button id="dosubmit" type="button" class="btn-b">保存新登录密码</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" name="__hash__" value="c9db0e4128f72421f9012545930e2d89_7fa65d66398d9485009f3ae030d04c48" /></form>
                        </div>
                        <script type="text/javascript">
                            $(function() {
                                $('#dosubmit').click(function() {
                                    if (!$('#oldPwd').val()) {
                                        top.dialog('为了您的账户安全，请先输入原密码。');
                                        return false;
                                    }
                                    if (!$('#newPwd').val()) {
                                        top.dialog('请输入新密码，并在下面再次输入确认。');
                                        return false;
                                    } else if ($('#newPwd').val().length < 6) {
                                        top.dialog('密码必须为 6-20位的英文或数字组合。');
                                        return false;
                                    }
                                    if ($('#newPwdConfirm').val() != $('#newPwd').val()) {
                                        top.dialog('新密码和确认密码输入不一致，请重新输入。');
                                        return false;
                                    }

                                    $.post('<?php echo \App::URL("web/user/modifyLoginPwd")?>', $('form').serialize(), function(res) {
                                        if (res.code == 1) {
                                            $('#io').html('');
                                            window.location.href = "<?php echo \App::URL("web/user/success",array('msg'=>'密码修改成功'))?>"
                                            //top.dialog(res.msg, 'success');
                                        } else {
                                            $('#io').html(res.msg);
                                        }
                                    }, 'json');

                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <!--include file "footer.php"-->
    </body>
</html>