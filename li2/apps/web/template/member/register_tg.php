<!DOCTYPE html>
<html>
    <head>
        <title><?php if (isset($title)) echo $title ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="description" content="<?php if (isset($description)) echo $description ?>" />
        <meta name="keywords" content="<?php if (isset($keywords)) echo $keywords ?>" />
        <script src="/public/web/js/jquery.js" type="text/javascript"></script>
        <script src="/public/web/layer/3.0.3/layer.js" type="text/javascript"></script>
        <script src="/public/web/js/common_home.js" type="text/javascript"></script>
        <script src="/public/web/js/main.js" type="text/javascript"></script>

        <link rel="stylesheet" href="/public/web/css/tg/shibei.css" />
    </head>
    <body>
        <div class="container">
            <div class="shibei-bg1">
                <div class="wrap-pc clearfix">
                    <div class="head-left">
                        <div class="word-line1">
                            一份投资
                        </div>
                        <div class="word-line1">
                            <li>十倍收获助您财富翻番</li>
                            <li>注册送2000操盘资金</li>
                        </div>
                        <ul class="word-line2">
                            <li>我出钱，您炒股,提供1-10倍股票操盘资金</li>

                        </ul>

                        <div class="btn-line"> 
                            <a href="http://chat6.livechatvalue.com/chat/chatClient/chatbox.jsp?companyID=911305&configID=56062&jid=5959956683" class="blue-btn-big JSgoto-top">前往</a>
                        </div>
                    </div>  
                    <div class="head-right">
                        <div id="JsActForm" class="reg-box">
                            <h1>马上注册，立即参赛</h1>
                            <ul class="reg-list">
                                <li>
                                    <i class="icon-shouji1" ><img src="/public/web/images/tg/icon-phone.png" /></i>
                                    <input type="text" name="cellphone" id="mobileAccount" placeholder="请输入11位手机号码" class="input-text" />
                                </li>
                                <li class="yzm-short"> 
                                    <i class="icon-duanxinyanzheng"><img src="/public/web/images/tg/icon-code.png" /></i>
                                    <input type="text" id = 'code' name="code" placeholder="图片验证码" class="input-text" />
                                    <span class="yzm-img"><img src="/index.php?app=web&mod=member&ac=makeCertPic" onclick="this.src=this.src"/></span>
                               
                                </li>
                                <li class="yzm-short"> 
                                    <i class="icon-duanxinyanzheng"><img src="/public/web/images/tg/icon-code.png" /></i>
                                    <input type="verifyCode" id = 'regVerifyCode' name="pcode" placeholder="短信验证码" class="input-text" />
                                    <span class="yzm-img"><button id="sendCode" >获取验证码</button></span>

                                </li>
                                <li>
                                    <i class="icon-mima1"><img src="/public/web/images/tg/icon-psw.png" /></i>
                                    <input type="password" id = 'mobilePwd' name="user_pass" placeholder="密码为6-16位数字和字母" class="input-text" />
                          
                                </li>
                                <li>
                                    <a id="register" class="btn-reg">立即注册</a>
                                </li>
                                <!-- <li class="login-line">
                                    已有账号？<a href="http://www.91zhifu.com/member/common/login">点击登录</a>
                                </li> -->
                            </ul>
                        </div>

                        <div class="user-reg"></div>
                    </div>
                </div>
            </div>
            <div class="shibei-bg2">
                <div class="report-cont">
                    <div class="wrap-pc clearfix">
                        <div class="title">
                            权威报道：
                        </div>
                        <div class="img-list">
                            <img src="/public/web/images/tg/logo-01.png" />
                        </div>
                        <div class="img-list">
                            <img src="/public/web/images/tg/logo-02.png" />
                        </div>
                        <div class="img-list">
                            <img src="/public/web/images/tg/logo-03.png" />
                        </div>
                        <div class="img-list">
                            <img src="/public/web/images/tg/logo-04.png" />
                        </div>
                        <div class="img-list">
                            <img src="/public/web/images/tg/logo-05.png" />
                        </div>
                    </div>
                </div>
                <div class="flow-path">
                    <div class="path-cont">
                        <div class="icon icon1"></div>
                        <div class="path-word">
                            十秒注册
                        </div>
                    </div>
                    <div class="path-arrow"></div>
                    <div class="path-cont">
                        <div class="icon icon2"></div>
                        <div class="path-word">
                            实名绑卡
                        </div>
                    </div>
                    <div class="path-arrow"></div>
                    <div class="path-cont">
                        <div class="icon icon3"></div>
                        <div class="path-word">
                            申请合约
                        </div>
                    </div>
                    <div class="path-arrow"></div>
                    <div class="path-cont">
                        <div class="icon icon4"></div>
                        <div class="path-word">
                            结算盈利
                        </div>
                    </div>
                </div>
            </div>
            <div class="get-wealth">
                <div class="title-level1">
                    如何获得10倍财富？
                </div>
                <div class="content">
                    <img src="/public/web/images/tg/img01.jpg" />
                </div>
            </div>
            <div class="operate-case">
                <div class="title-level1">
                    多种操盘方案任您选
                </div>
                <div class="title-level2">
                    我们的服务&nbsp;&nbsp;&nbsp;&nbsp;助您股市更牛
                </div>
                <div class="trade-list clearfix">
                    <ul>
                        <li>
                            <div class="title">
                                按天操盘
                            </div>
                            <div class="title2">
                                短线狙击&nbsp;&nbsp;&nbsp;&nbsp;博高收益
                            </div>
                            <div class="describe">
                                最高&nbsp;10倍&nbsp;&nbsp;2-30天
                            </div><a ng-click="goTop()" class="blue-btn-small JSgoto-top">立即操盘</a></li>
                        <li>
                            <div class="title">
                                按月操盘
                            </div>
                            <div class="title2">
                                伺机布局&nbsp;&nbsp;&nbsp;&nbsp;稳健收益
                            </div>
                            <div class="describe">
                                低门槛&nbsp;&nbsp;最高&nbsp;10倍&nbsp;&nbsp;持仓&nbsp;1-12月
                            </div><a ng-click="goTop()" class="blue-btn-small JSgoto-top">立即操盘</a></li>
                        <li>
                            <div class="title">
                                互惠操盘
                            </div>
                            <div class="title2">
                                互惠互利&nbsp;&nbsp;&nbsp;&nbsp;安心操盘
                            </div>
                            <div class="describe">
                                免管理费&nbsp;&nbsp;最高&nbsp;10倍
                            </div><a ng-click="goTop()" class="blue-btn-small JSgoto-top">立即操盘</a></li>
                        <li>
                            <div class="title">
                                新手体验
                            </div>
                            <div class="title2">
                                小试牛刀&nbsp;&nbsp;&nbsp;&nbsp;精彩人生
                            </div>
                            <div class="describe">
                                免费领取2000元操盘资金
                            </div><a ng-click="goTop()" class="blue-btn-small JSgoto-top">立即操盘</a></li>
                    </ul>
                </div>
            </div>
            <div class="we-promise">
                <div class="title-level1">
                    我们的承诺
                </div>
                <div class="title-level2">
                    24小时保障用户资金安全，助您赢取财富
                </div>
                <ul class="clearfix">
                    <li>
                        <div class="img img1"></div>
                        <div class="title">
                            账户保障
                        </div>
                        <div class="describe">
                            第三方支付机构为平台提供账户委托服务，严格把控，确保用户财产安全。
                        </div></li>
                    <li>
                        <div class="img img2"></div>
                        <div class="title">
                            信息保障
                        </div>
                        <div class="describe">
                            国际领先的系统加密保护技术，保障用户的交易信息和财产信息不泄露。
                        </div></li>
                    <li>
                        <div class="img img3"></div>
                        <div class="title">
                            项目保险
                        </div>
                        <div class="describe">
                            设立严格的风控制度，从而实现全程财产严控，保证财产安全。
                        </div></li>
                </ul>
            </div>
            <div class="partner-list">
                <div class="title-level1">
                    战略合作伙伴
                </div>
                <div class="title-level2">
                    国有银行、知名券商、核心支付平台，全程为您保驾护航，实力值得信赖！
                </div>
                <div class="bank-logo">
                    <div class="logo-list">
                        <img src="/public/web/images/tg/bank-logo1.jpg" />
                        <img src="/public/web/images/tg/bank-logo2.jpg" />
                        <img src="/public/web/images/tg/bank-logo3.jpg" />
                        <img src="/public/web/images/tg/bank-logo4.jpg" />
                        <img src="/public/web/images/tg/bank-logo5.jpg" />
                    </div>
                </div>
            </div>
            <div class="shibei-footer">
                <div class="title">
                    风险提示
                </div>
                <div class="line1">
                    我们提醒您：股市有风险，投资需谨慎！
                </div>
                <div class="line1"> 
                    <img src="/public/web/images/tg/icon-safe.png" />正在为您提供银行级别的安全保障
                </div>
                <div>
                    版权所有 &copy; 安徽大时代证券投资咨询有限公司 保留一切权利
                    <br />皖ICP备 16025696号-4
                </div>
            </div>
        </div>   

        <script>
            var CAN_SEND = true;
            var rs = 60;
            $(function(){ 
                $('#sendCode').click(function() {
                    if ($('#mobileAccount').val().length != 11) {
                        layer.alert('请输入正确的手机号！');
                        return false;
                    }
                    if ($('#code').val() == "") {
                        layer.alert('请输入图形验证码！');
                        return false;
                    }
                    if(!CAN_SEND){
                        return;
                    }
                    $.post('/index.php?app=web&mod=member&ac=regValidate',{mobile: $('#mobileAccount').val()},function(ret){
                        if (ret.code == 0) {
                            layer.alert(ret.msg);
                        }
                        else{
                            CAN_SEND = false;
                            $(this).val('重新发送(' + rs + ')');
                            var int = setInterval(function() {
                                rs--;
                                if (rs < 1) {
                                    rs = 60;
                                    clearInterval(int);
                                    $('#sendCode').html('发送验证码');
                                    CAN_SEND = true;
                                } else {
                                    CAN_SEND = false;
                                    $('#sendCode').html('重新发送(' + rs + ')');
                                }
                            }, 1000);
                            $.post('/index.php?app=web&mod=member&ac=getValidateCode_tg', {mobile: $('#mobileAccount').val(),code : $("#code").val()}, function(ret) {
                                if (ret.code == 0) {
                                    $('#sendCode').html('发送验证码');
                                    //$('#im').html(ret.msg);
                                    CAN_SEND = true;
                                    clearInterval(int);
                                    layer.alert(ret.msg);
                                }
                            }, 'json');
                        }
                    },'json')
                });
                
                $('#register').click(function() {
                    var mobile = $('#mobileAccount').val();
                    var password = $('#mobilePwd').val();
                    var regVerifyCode = $('#regVerifyCode').val();
                    if (!mobile) {
                        $('#mobileAccount').focus();
                        layer.alert('手机号不能为空','error');
                        return;
                    }
                    if (!password) {
                        $('#mobilePwd').focus();
                        layer.alert('密码不能为空','error');
                        return;
                    }
                    if (!regVerifyCode) {
                        $('#regVerifyCode').focus();
                        layer.alert('验证码不能为空','error');
                        return;
                    } 
                    
                    $.post("/index.php?app=web&mod=member&ac=doregister", {mobile : mobile,password : password,confirm : password,smscode : regVerifyCode}, function(res) {
                        if (res.code == 0) {
                            layer.alert(res.msg,'error');
//                            $('#im').html(res.msg);
//                            $('#im').attr('class', 'error');
                        } else {
                            window.location = '/index.php?app=web&mod=user&ac=account';
                        }

                    }, 'json');
                });
                
                $('#btn_login').click(function() {
                    var account_name = $('#account_name').val();
                    var loginPwd1 = $('#loginPwd1').val();
                    if (!account_name) {
                        $('#account_name').focus();
                        layer.alert('帐号不能为空','error');
                        return;
                    } 
                    if (!loginPwd1) {
                        layer.alert('密码不能为空','error');
                        return;
                    } 
                    $.post("/index.php?app=web&mod=member&ac=dologin", {username : account_name,password : loginPwd1}, function(res) {
                        if (res.code == 0) {
                            //if(res.data=='ua'){
                            //$('.yzmPic').attr('src','/member/authcode.html#'+new Date().getTime());
                            //}
                            //$('.authcode').show();
                            layer.alert(res.msg,'error');
                        } else {
                            window.location = "/index.php?app=web&mod=user&ac=account";
                        }
                    }, 'json');
                });
            })
            
        </script>
    </body>
</html>