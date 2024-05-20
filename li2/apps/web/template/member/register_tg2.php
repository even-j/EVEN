<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>加强版股票工具</title>
	</head>
	<body style="margin: 0px; font-family: SimHei;" rlt="1">
		<script src="/public/web/js/jquery.js" type="text/javascript"></script>
		<script src="/public/web/layer/3.0.3/layer.js" type="text/javascript"></script>
		<script src="/public/web/js/common_home.js" type="text/javascript"></script>
		<script src="/public/web/js/main.js" type="text/javascript"></script>
	
		<link rel="stylesheet" href="/public/web/css/tg2/shibei.css">
		<link rel="stylesheet" href="/public/web/css/tg2/style.css">
		<div style="background-image: url(/public/web/images/tg2/1.jpg); background-position: center; height: 253px;"> </div>
		<div id="gotop" style="background-image: url(/public/web/images/tg2/2.jpg); background-position: center;height: 253px;"> </div>
		<div style="background-image: url(/public/web/images/tg2/3.jpg); background-position: center; height: 253px;">
			<div style="width: 1132px; background: rgba(0,0,0,0); margin: 0 auto; padding-top: 16px;">
				<div class="head-right" style="margin-top:-225px; margin-right:50px;">
					<div id="JsActForm" class="reg-box">
						<h1>立即注册 <span class="title-second">领 2000元新人红包</span></h1>
						<ul class="reg-list">
							<li>
								<i class="icon-shouji1"><img src="/public/web/images/tg2/icon-phone.png"></i>
								<input type="text" name="cellphone" id="mobileAccount" placeholder="请输入11位手机号码" class="input-text">
								<div class="ts-word" id="cellphone-tip" style="display: none; "><span>请输入正确的手机号</span></div>
							</li>
                                                        <li>
								<i class="icon-duanxinyanzheng"><img src="/public/web/images/tg2/icon-code.png"></i>
								<input type="text" name="code" id="code" placeholder="图片验证码" class="input-text">
                                                                <span class="yzm-img"><img src="<?php echo \App::URL('web/member/makeCertPic')?>" onclick="this.src='/index.php?app=web&mod=member&ac=makeCertPic'"/></span>
								<div class="ts-word" id="cellphone-tip" style="display: none; "><span>请输入图片验证码</span></div>
							</li>
							<li class="yzm-short">
								<i class="icon-duanxinyanzheng"><img src="/public/web/images/tg2/icon-code.png"></i>
								<input type="verifyCode" id="regVerifyCode" name="pcode" placeholder="短信验证码" class="input-text">
								<span class="yzm-img"><button id="sendCode">获取验证码</button></span>
								<div class="ts-word" id="pcode-tip" style="display: none; "><span>请输入短信验证码</span></div>
							</li>
							<li>
								<i class="icon-mima1"><img src="/public/web/images/tg2/icon-psw.png"></i>
								<input type="password" id="mobilePwd" name="user_pass" placeholder="密码为6-16位数字和字母" class="input-text">
							</li>
							<li>
								<i class="icon-mima1"><img src="/public/web/images/tg2/icon-psw.png"></i>
								<input type="password" id="pwd2" name="user_pass" placeholder="确认密码" class="input-text">
							</li>
							<li>
								<div class="ap_loginargee">
									<input type="checkbox" checked="checked" id="agreement" style="outline: #ab1e1e;-webkit-appearance:checkbox; ">
									<span>同意</span>
									<a target="_blank" href="##">《网站服务协议》</a>
								</div>
								<a href="javascript:void(0);" id="register" class="btn-reg">立即注册</a>
							</li>

						</ul>
					</div>

					<div class="user-reg"></div>
				</div>

				<div style="height: 38px; clear: both;"> </div>
				<div id="btn1" style="width: 413px; height: 56px; cursor: pointer; float: right;"> </div>
			</div>
		</div>
		<div style="background-image: url(/public/web/images/tg2/4.jpg); background-position: center; height: 253px;"> </div>

		<div style="width: 1160px; margin: 0 auto;">
			<div onclick="location.href=&#39;#gotop&#39;;" style="width: 416px; height: 60px;
                float: left; margin-top: 65px; cursor: pointer;"> </div>
		</div>

		<div style="width: 918px; margin: 0 auto;">
			<div onclick="location.href=&#39;#gotop&#39;;" style="width: 416px; height: 60px;
                float: right; margin-top: 30px; cursor: pointer;"> </div>
		</div>

		<div style="background-image: url(/public/web/images/tg2/9.jpg); background-position: center; height: 253px;"> </div>
		<div style="background-image: url(/public/web/images/tg2/10.jpg); background-position: center; height: 253px;
        position: relative;">
			<div style="width: 1160px; margin: 0 auto;">
				<div onclick="location.href=&#39;#gotop&#39;;" style="width: 416px; height: 60px;
                float: left; margin-top: 81px; cursor: pointer;"> </div>
			</div>
			<div style="text-align: center; padding-top: 60px; color: rgb(101,101,101); font-size: 12px;
            clear: both;"> 投资有风险，入市需谨慎<br>
				<span id="copyright">广州圣禾网络科技有限公司版权</span></div>
		</div>

		<!--图形验证 start-->
		<div class="imgyz" style="display:none;" id="validateWin">
			<div class="imgyz-mask"></div>
			<div class="imgyz-content">
				<div class="imgyz-box">
					<div class="imgyz-title">
						<div class="imgyz-title-txt">输入图形验证码</div>
						<a href="javascript:void(0);" class="imgyz-ico" id="closeImgCodeBox">
							<div class="imgyz-ico1"></div>
							<div class="imgyz-ico2"></div>
						</a>
					</div>
					<div class="imgyz-box-content">
						<span>验证码：</span>
						<input type="txt" id="imgCode" style="width: 60px;height: 30px;border: 1px solid #e9e9e9;">
						<span class="imgyz-pic"><img id="codeImg" src="/public/web/images/tg2/validate.code"></span>
						<a href="javascript:void(0);" id="refreshImgCode">刷新</a>
					</div>
					<div class="imgyz-box-btn">
						<a href="javascript:void(0);" id="sendSms">确认</a>
					</div>
				</div>
			</div>
		</div>
		<!--图形验证码 end-->
                <script>
            var CAN_SEND = true;
            var rs = 60;
            $(function(){ 
                $('#sendCode').click(function() {
                    if ($('#mobileAccount').val().length != 11) {
                        layer.alert('请输入正确的手机号！');
                        return false;
                    }
//                    if ($('#code').val() == "") {
//                        layer.alert('请输入图形验证码！');
//                        return false;
//                    }
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
                    if(password!=$("#pwd2").val()){
                        $('#mobilePwd').focus();
                        layer.alert('两次输入密码不一样','error');
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