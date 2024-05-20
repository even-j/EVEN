
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
                    <form method="post" action="<?php echo \App::URL('web/member/findpwd2')?>">
                        <dt>方式：</dt>
                        <dd>
                            <select name="method" id="method">
                                <!--<option value="email">邮箱找回</option>-->
                                <option value="mobile">手机找回</option>
                            </select>
                        </dd>
                        <div id="codeDiv" style="">
                            <dt>图片验证码：</dt>
                            <dd>
                                <input class="text" type="text" value="" name="authcode" id="authcode"/>
                                <span class="error" id="ixx"></span>
                                <img src="<?php echo \App::URL('web/member/makeCertPic')?>"  onclick="this.src='/index.php?app=web&mod=member&ac=makeCertPic'"/>
                            </dd>
                        </div>
                        <dt id="methodCaption">已绑定手机：</dt>
                        <dd>
                            <input class="text" type="text" value="" name="account" id="account"/>
                            <input class="btn btnBg3" id="sendAuthBtn" type="button" type="text" value="获取验证码" style=""/><br/>
                            <span class="error" id="ia"></span>
                        </dd>
                        
                        <div id="codeDiv" style="">
                            <dt>验证码：</dt>
                            <dd>
                                <input class="text" type="text" value="" name="smscode" id="smscode"/>
                                <span class="error" id="ic"></span>
                                <input type="hidden" name="step" value="2" />
                            </dd>
                        </div>
                        <input type="hidden" name="valid_cash" id="valid_cash" value=""/>
                        <dd><button type="button" id="oneBtn" class="btn btnBg1" style="width:242px;font-size:16px;height:38px">下一步</button></dd>
                    </form>
                </dl>



                <div class="zhR">
                    <b>找回密码流程：</b>
                    <p><span class="now">01</span>验证用户信息</p>
                    <p><span >02</span>设置新的登录密码</p>
                    <p><span >03</span>登录密码找回成功</p>
                </div>	</div>
        </div>
        <script type="text/javascript">
            $(function() {
                var rs = 60;
                var method = '手机';
                $('#method').change(function() {
                    if ($(this).val() == 'email') {
                        method = '邮箱';
                        $('#sendAuthBtn').hide();
                        $('#codeDiv').hide();
                        $('#methodCaption').html('已绑定邮箱：');
                    } else {
                        method = '手机';
                        $('#sendAuthBtn').show();
                        $('#codeDiv').show();
                        $('#methodCaption').html('已绑定手机：');
                    }
                    $('#ia').hide();
                });

                $('#account').blur(function() {
                    if ($('#method').val() == 'email') {
                        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        if (!filter.test($('#account').val())) {
                            $('#ia').show();
                            $('#ia').html('邮箱地址格式不正确');
                            return false;
                        }
                        $('#ia').show();
                        $('#codeDiv').show();
                        $.post("/member/forget.html", {exists: $('#account').val()}, function(ret) {
                            if (ret.status > 0) {
                                $('#ia').show();
                                $('#ia').html(ret.info);
                            }
                        }, 'json');
                    } else {
                        $('#ia').hide();
                    }
                });

                $('#oneBtn').click(function() {
                    if (!$('#account').val()) {
                        $('#ia').show();
                        $('#ia').html('请填写您绑定的' + method);
                        return false;
                    } else {
                        if ($('#method').val() == 'email') {
                            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                            if (!filter.test($('#account').val())) {
                                $('#ia').html('邮箱地址格式不正确');
                                return false;
                            }
                            $.post("/member/forget.html", {check: $('#smscode').val(), exists: $('#account').val()}, function(ret) {
                                if (ret.status > 0) {
                                    $('#ic').show();
                                    $('#ic').html(ret.info);
                                } else {
                                    $('form').submit();
                                }
                            }, 'json');
                        } else {
                            var filter = /^1\d{10}$/;
                            if (!filter.test($('#account').val())) {
                                $('#ia').html('手机号码格式不正确');
                                return false;
                            }
                            $.post("/index.php?app=web&mod=member&ac=codeValidate_findpwd", {mobile : $('#account').val(),mobilePwd: $('#smscode').val()}, function(ret) {
                                if (ret.code == 0) {
                                    $('#ic').show();
                                    $('#ic').html(ret.msg);
                                } else {
                                    $("#valid_cash").val(ret.data);
                                    $('form').submit();
                                }
                            }, 'json');
                        }
                        $('#ia').hide();
                    }


                });
                $('#sendAuthBtn').click(function() {
                    var filter = /^1\d{10}$/;
                    if (!filter.test($('#account').val())) {
                        $('#ia').show();
                        $('#ia').html('手机号码格式不正确');
                        return false;
                    } else {
                        $('#ia').hide();
                    }
                    if($('#authcode').val()==""){
                        $('#ixx').show();
                        $('#ixx').html('图片验证码不能为空');
                        return false;
                    }
                    else{
                        $('#ixx').hide();
                    }

                    $.post("/index.php?app=web&mod=member&ac=getValidateCode_findpwd", {mobile: $('#account').val(),authcode : $('#authcode').val()}, function(ret) {
                        if (ret.code == 0) {
                            $('#ia').show();
                            $('#ia').html(ret.msg);
                        } else {
                            $('#sendAuthBtn').val('重新发送(' + rs + ')');
                            $('#ia').hide();
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
            });
        </script>
        <!-- Content End -->
        <!--include file "footer.php"-->
    </body>
</html>