<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <!--include file "common.php"-->
        <link rel="stylesheet" href="/public/wap/css/wap_new.css">
        <script>
            $(function(){
                var rs = 60;
                $('#oneBtn').click(function() {
                    if (!$('#account').val()) {
                        layermsg("请填写您绑定的手机号")
                        return false;
                    } else {
                        var filter = /^1\d{10}$/;
                        if (!filter.test($('#account').val())) {
                            layermsg('手机号码格式不正确');
                            return false;
                        }
                        $.post("/index.php?app=wap&mod=member&ac=codeValidate_findpwd", {mobile : $('#account').val(),mobilePwd: $('#smscode').val()}, function(ret) {
                            if (ret.code == 0) {
                                layermsg(ret.msg);
                            } else {
                                $("#valid_cash").val(ret.data);
                                $('form').submit();
                            }
                        }, 'json');
                    }
                });
                $('#sendAuthBtn').click(function() {
                    var filter = /^1\d{10}$/;
                    if (!filter.test($('#account').val())) {
                        layermsg('手机号码格式不正确');
                        return false;
                    }
                    if ($('#authcode').val()=="") {
                        layermsg('请输入图片验证码');
                        return false;
                    }
                    $.post("/index.php?app=wap&mod=member&ac=getValidateCode_findpwd", {mobile: $('#account').val(),authcode : $('#authcode').val()}, function(ret) {
                        if (ret.code == 0) {
                            layermsg(ret.msg);
                        } else {
                            layermsg(ret.msg);
                            $('#sendAuthBtn').val('重新发送(' + rs + ')');
                            //倒计时
                            int = setInterval(function() {
                            rs--;
                            if (rs < 1) {
                                rs = 60;
                                clearInterval(int);
                                $('#sendAuthBtn').val('发送验证码');
                                $('#sendAuthBtn').removeAttr('disabled');
                            } else {
                                $('#sendAuthBtn').attr('disabled', true);
                                $('#sendAuthBtn').val('重新发送(' + rs + ')');
                            }
                        }, 1000);
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
            <div class="header">
                <h1>找回密码</h1>
                <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
                <div class="top-menu">
                    <!--<button type="button" class="btn"></button>-->
                </div>
            </div>
            <!-----------登录框开始----------------->
            <div class="main">
                <div class="wrap-a">
                    <form id="forgetPwd" action="<?php echo \App::URL('wap/member/findpwd2')?>" method="POST">
                        <input type="hidden" name="valid_cash" id="valid_cash" value=""/>
                        <div class="inpbox">
                            <input id="account" type="number" name="account" value="" autocomplete="off" tabindex="1" class="inp s3" placeholder="注册的手机号">
                        </div>
                        <div class="inpbox box100">
                            <div class="box100-item mr10">
                                <input id="authcode" type="text" name="authcode" value="" autocomplete="off" tabindex="2" class="inp s4" placeholder="请输入图片验证码">
                            </div>
                            <img src="<?php echo \App::URL('web/member/makeCertPic')?>"  onclick="this.src='/index.php?app=web&mod=member&ac=makeCertPic'"/>
                        </div>
                        <div class="inpbox box100">
                            <div class="box100-item mr10">
                                <input id="smscode" type="text" name="smscode" value="" autocomplete="off" tabindex="2" class="inp s4" placeholder="请输入短信验证码">
                            </div>
                            <input type="button" id="sendAuthBtn" value="获取验证码" class="btn-c">
                        </div>
                        <div class="btnbox">
                            <input id="oneBtn" type="button" value="下一步" class="btn-a">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>