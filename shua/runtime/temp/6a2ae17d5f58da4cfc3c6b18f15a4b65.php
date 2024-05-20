<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"/www/wwwroot/xbt.com/pubic/../application/mobile/view/login/register.html";i:1698586779;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
  <title>注册</title>
  <link rel="stylesheet" href="/static/mobile/css/plugin.css" type="text/css">
  <link rel="stylesheet" href="/static/mobile/css/public.css" type="text/css">
  <link rel="stylesheet" href="/static/mobile/css/page.css" type="text/css">
  <script src="/static/mobile/js/all.js" type="text/javascript" charset="UTF-8"></script>
  <script src="/static/mobile/js/jquery-1.12.4.min.js" type="text/javascript" charset="UTF-8"></script>
  <script src="/static/mobile/js/vue-2.6.10.min.js" type="text/javascript" charset="UTF-8"></script>
  <script src="/static/mobile/js/vant.min.js" type="text/javascript" charset="UTF-8"></script>
  <script src="/static/mobile/js/public.js" type="text/javascript" charset="UTF-8"></script>
  <script>
    $(function () {
      // 手机号正则表达式
      var phoneReg = /^1[3-9]\d{9}$/;
      var vm = new Vue({
        el: ".tfkz-container",
        data: function () {
          return {
            yzmMsg: "发送验证码",
            mobile:'',
            login_pwd:'',
            login_pwd2:'',
            qq:'',
            username:'',
            dxyzm:'',
            isDisabled: false
          };
        },
        methods: {
          check_mobile:function(){
            $.ajax({
              type : 'POST',
              url : "<?php echo url('buy/login/check_mobile'); ?>",
              async : true,
              data : {
                "mobile":vm.mobile,
              },
              success : function(data){
                if(data.code==1){
                  alertSuccess(data.msg);
                  setTimeout(function(){
                    return location.href=data.url;
                  },3000)

                }else{
                  return alertError(data.msg);
                }
              },
              error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert(XMLHttpRequest.status + "," + textStatus);
              }
            });
          },
          //点击注册
          click:function(){
            if(!this.mobile) return vm.alertError("手机号不能为空");
            if (!phoneReg.test(this.mobile)) {
              return vm.alertError("手机号码格式不规范,请检查后重新输入");}
            if(!this.login_pwd) return vm.alertError("密码不能为空");
            if(!this.login_pwd2) return vm.alertError("确认密码不能为空");
            if(!this.qq) return vm.alertError("QQ账号不能为空");
            if(!this.username) return vm.alertError("用户名不能为空");
           // if(!this.dxyzm) return vm.alertError("验证码不能为空,请点击发送验证码");
            $.ajax({
              type : 'POST',
              url : "<?php echo url('mobile/login/check_register'); ?>",
              async : true,
              data : {
                "mobile":vm.mobile,
                "login_pwd":vm.login_pwd,
                "login_pwd2":vm.login_pwd2,
                "qq":vm.qq,
                "username":vm.username,
                "dxyzm":vm.dxyzm,
                'type':"<?php echo $type; ?>",
                'invite':"<?php echo $invite; ?>",
              },
              success : function(data){
                if(data.code==1){
                  alertSuccess(data.msg);
                  setTimeout(function(){
                    return location.href=data.url;
                  },3000)

                }else{
                  return alertError(data.msg);
                }
              },
              error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert(XMLHttpRequest.status + "," + textStatus);
              }
            });
          },
          sendYzm: function () {
            if(!vm.mobile) return alertError("手机号不能为空");
            if (!phoneReg.test(vm.mobile)) {
              return alertError("手机号码格式不规范,请检查后重新输入");}
            $.ajax({
              type : 'POST',
              url : "<?php echo url('mobile/way/send_code'); ?>",
              async : true,
              data : {
                "mobile":vm.mobile,
                "dxyzm":vm.dxyzm
              },
              success : function(data){
                // vm.alertError(data.msg);
              },
              error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert(XMLHttpRequest.status + "," + textStatus);
              }
            });
            var num = 60;
            var that = this;
            this.isDisabled = true;
            var timer = setInterval(function () {
              num--;
              that.yzmMsg = "还剩 " + num + " 秒";
              if (num <= 0) {
                that.isDisabled = false;
                that.yzmMsg = "重新发送";
                clearInterval(timer);
              }
              if (num === 59) {
                alertSuccess("验证码发送成功");
              }
            }, 1000);
          }
        }
      });
    });
  </script>
</head>
<body>
<div class="tfkz-container">
  <div class="register-box">
    <!-- 登录框 -->
    <div class="login-wrap">
      <h1>买手注册</h1>
      <div class="input-box">
        <input type="text" maxlength="11" @blur="check_mobile" placeholder="请输入手机号" v-model="mobile" />
      </div>
      <div class="input-box">
        <input type="text" placeholder="请输入用户名" v-model="username" />
      </div>
      <div class="input-box">
        <input type="text" placeholder="请输入密码" v-model="login_pwd" />
      </div>
      <div class="input-box">
        <input type="text" placeholder="请确认密码" v-model="login_pwd2" />
      </div>
      <div class="input-box">
        <input type="text" placeholder="请输入QQ账号" v-model="qq" />
      </div>
     <!-- <div class="input-box">
        <input type="text" maxlength="6" placeholder="短信验证码" v-model="dxyzm" />
        <van-button :disabled="isDisabled" class="send-yzm" type="info" @click="sendYzm">{{yzmMsg}}</van-button>
      </div>-->
      <div class="login-btn">
        <van-button class="login-btn-item" @click="click" type="info">点击注册</van-button>
      </div>
    </div>
  </div>
</div>
</body>
</html>

