
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>

    <body class="index" style="background: #f3f3f3">
        <!-- Header Start -->
        <div id="top">
            <!--include file "header.php"-->
            <!--include file "nav.php"-->
        </div>
        <link href="/public/web/css/login.css" rel="stylesheet" type="text/css" media="screen,projection" />
        <script type="text/javascript" src="/public/web/js/common_member.js"></script>
        <script type="text/javascript" src="/public/web/js/login.js"></script>
        <style type="text/css">
        </style><div class="bar">
            <div class="borBox" id="regBox" style="margin: 30px 0px; padding: 10px 20px; border-radius: 5px;background-color: #ffffff;">
                <form id="registerForm" method="post">
                    <div class="title1"><b>注册</b><!--<b class="other"><a href="#">企业注册</a></b>--></div>
                    <dl class="form">
                        <dt>手机号码：</dt>
                        <dd>
                            <input class="text" type="text" name="mobile" id="mobile" style="ime-mode:disabled" autocomplete="off"/><span id="im" class="tip" data="请输入正确的手机号码">当前使用的手机号</span>
                        </dd>

                        <div style="">
                        <dt>图形验证码：</dt>
                        <dd><input class="text" type="text" value="" name="authcode" id="authcode" autocomplete="off"/><img class="yzmPic codeimg" src="<?php echo \App::URL('web/member/makeCertPic')?>" onclick="this.src='/index.php?app=web&mod=member&ac=makeCertPic'" /><span><i id="ua"></i></span></dd>
                        </div>
                        
                       <!-- <dt>手机验证码：</dt>
                        <dd><input class="text" type="text" name="smscode" id="smscode" autocomplete="off"/><input class="btn btnBg3 smscode" id="sendAuthBtn" data="bind" type="button" type="text" value="获取验证码" /><span class="tip" id="ia" data="验证码必须为4位数字">输入手机收到的验证码</span></dd>
                       <!-- 去掉短信验-->


                        <dt>设置密码：</dt>
                        <dd><input class="text" type="password" name="password" id="password" autocomplete="off"/><span id="ip" class="tip" data="密码长度至少为6位">密码长度6~20位 </span></dd>
                        <dt>确认密码：</dt>
                        <dd><input class="text" type="password" name="confirm" id="confirm" autocomplete="off"/><span id="ic" class="tip" data="两次输入的密码须一致">再次输入上边的密码 </span></dd>
                        <dt>推荐人：</dt>
                        <dd><input class="text" type="text" name="intid" id="intid" value="<?php if(isset($_SESSION['intid'])){ echo $_SESSION['intid'];}  ?>"  <?php if(isset($_SESSION['intid'])){ echo 'readonly="readonly"';}  ?> autocomplete="off"/><span id="intidtip" class="tip" data="可以为空">可以为空</span></dd>
                        
                        <dd>
                            <input type="checkbox" class="checkbox" checked="true">&nbsp;同意并愿意遵守
                                <a href="<?php echo \App::URL("web/help/agreement");?>" class="font3" target="_blank">《用户协议和隐私政策》</a>
                        </dd>
                        <dd><button id="register" type="button" class="btn btnBg1">立即注册</button>已有账号，<a href="<?php echo \App::URL("web/member/login");?>" class="font3">马上登录</a></dd>
                    </dl>
                </form>
            </div>
        </div>
        <!-- Footer Start -->
        <!--include file "footer.php"-->
    </body>
</html>