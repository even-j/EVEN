<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <!--include file "common.php"-->
        <link rel="stylesheet" href="/public/wap/css/wap_new.css">
        <script>
        $(function(){
            var rs = 60;
            $('#sendBtn').click(function() {
                if ($('#mobile').val().length != 11) {
                    layermsg('请输入正确的手机号！');
                    return false;
                }

                $.post('/index.php?app=wap&mod=member&ac=regValidate',{mobile: $('#mobile').val()},function(ret){
                    if (ret.code == 0) {
                        layermsg(ret.msg);
                    }
                    else{
                        $(this).val('重新发送(' + rs + ')');
                        var int = setInterval(function() {
                            rs--;
                            if (rs < 1) {
                                rs = 60;
                                clearInterval(int);
                                $('#sendBtn').val('发送验证码');
                                $('#sendBtn').removeAttr('disabled');
                            } else {
                                $('#sendBtn').attr('disabled', true);
                                $('#sendBtn').val('重新发送(' + rs + ')');
                            }
                        }, 1000);
                        $.post('/index.php?app=wap&mod=member&ac=getValidateCode', {mobile: $('#mobile').val()}, function(ret) {
                            if (ret.code == 0) {
                                $('#sendBtn').val('发送验证码');
                                layermsg(ret.msg);
                                $('#sendBtn').attr('disabled', false);
                                clearInterval(int);
                            }
                            
                        }, 'json');
                    }
                },'json')
            });
            $('#regBtn').click(function() {
                if (!$('#mobile').val()) {
                    $('#mobile').focus();
                    layermsg('手机号不能为空');
                    return;
                } 
                if (!$('#smscode').val()) {
                    $('#smscode').focus();
                    layermsg('验证码不能为空');
                    return;
                } 
                if (!$('#password').val()) {
                    $('#password').focus();
                    layermsg('密码不能为空');
                    return;
                }
                if ($('#password').val()!=$('#confirm').val()) {
                    $('#confirm').focus();
                    layermsg('两次密码不一致');
                    return;
                } 
                $.post("/index.php?app=wap&mod=member&ac=doregister", $("#regForm").serialize(), function(res) {
                    if (res.code == 0) {
                        layermsg(res.msg);
                    } else {
                        window.location.href = '/index.php?app=wap&mod=user&ac=account';
                    }

                }, 'json');
            });
        })
        </script>
    </head>
    <body>
        <!--第二行-->
        <!--------头部导航------------>
        <div class="body">
            <!-----------登录框开始----------------->
            <div class="main">
                <div class="wrap-a">
                    <form id="regForm" name="regForm" action="" method="post">
                        <div class="inpbox">
                            <input type="number" id="mobile" name="mobile" class="inp s3" value="" placeholder="手机号码" autocomplete="off">
                        </div>
                        <div class="inpbox box100">
                            <div class="box100-item mr10">
                                <input type="text" id="smscode" name="smscode" value="" class="inp s4" placeholder="短信验证码" autocomplete="off"> 
                            </div>
                            <input id="sendBtn" type="button" class="btn-c" value="获取短信验证码" style="width:120px;">
                            <!--  不可点状态 class="btn-d" -->
                        </div>
                        <div class="inpbox">
                            <input type="password" id="password" name="password" class="inp s2" placeholder="登录密码" autocomplete="off">
                        </div>
                        <div class="inpbox">
                            <input type="password" id="confirm" name="confirm" class="inp s2" placeholder="确认密码" autocomplete="off">
                        </div>
                        <div class="inpbox">
                            <input type="text" id="yaoqingma" name="yaoqingma" value="" class="inp s5" maxlength="20" placeholder="邀请码，没有可以不填" autocomplete="off">
                        </div>
<!--                        <p class="checkbox">
                            <input id="agreement" type="checkbox" checked="checked" class="checkbox"><label for="agreement">同意并接受</label><a href="<?php echo \App::URL("web/help/agreement");?>">《富牛网注册协议》</a>
                        </p>-->

                        <div class="btnbox">
                            <input type="button" id="regBtn" class="btn-a" value="立即注册">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </body>
</html>