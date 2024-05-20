<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\phpstudy\WWW\zhan\shua_li\pubic/../application/buy\view\login\register.html";i:1698586624;}*/ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>小白兔</title>
    <link rel="stylesheet" type="text/css" href="/static/buy/element-ui/lib/theme-chalk/index.css" />
      <!-- 页面内容CSS -->
      <link rel="stylesheet" type="text/css" href="/static/buy/css/pageCss/register.css"/>
      <link rel="Shortcut Icon" type="image/x-icon" href="/static/buy/img/index.png" />
    <script src="/static/buy/js/vue-2.6.10.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/buy/element-ui/lib/index.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/buy/js/jquery-1.12.4.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
      $(function() {
          // 手机号正则表达式
          var phoneReg = /^1[3-9]\d{9}$/;
        var vm = new Vue({
         el: ".container",
          data: function() {
            return {
              disabled: false,
              mobile:'',
              login_pwd:'',
              login_pwd2:'',
              qq:'',
                username:'',
              dxyzm:''
            }
          },
          methods: {
            /* 失败的弹框 */
            alertError: function(e) {
              this.$message.error(e);
            },
            /* 成功的弹框 */
            alertSuccess: function(e) {
              this.$message({
                message: e,
                type: "success"
              });
            },
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
                    vm.alertSuccess(data.msg);
                    setTimeout(function(){
                      return location.href=data.url;
                    },3000)

                  }else{
                    return vm.alertError(data.msg);
                  }
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                  alert(XMLHttpRequest.status + "," + textStatus);
                }
              });
            },
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
                url : "<?php echo url('buy/login/check_register'); ?>",
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
                    vm.alertSuccess(data.msg);
                    setTimeout(function(){
                      return location.href=data.url;
                    },3000)

                  }else{
                   return vm.alertError(data.msg);
                  }
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                  alert(XMLHttpRequest.status + "," + textStatus);
                }
              });
            },

          }
        });
        var sendBtn = $(".login_box .login_input .yzm_input_box .el_btn1");


        /* 验证码倒计时 */
        sendBtn.click(function() {
            if(!vm.mobile) return vm.alertError("手机号不能为空");
            if (!phoneReg.test(vm.mobile)) {
                return vm.alertError("手机号码格式不规范,请检查后重新输入");}
          $.ajax({
            type : 'POST',
            url : "<?php echo url('buy/way/send_code'); ?>",
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
          var timer = setInterval(function() {
            num--;
            vm.disabled = true;
            $(that).html(num + "s");
            if (num <= 0) {
              clearInterval(timer);
              $(that).html("重新发送");
              vm.disabled = false;
            } else if (num === 59) {
              vm.alertSuccess("验证码发送成功,若接收失败请耐心等待一分钟后点击重新发送");
            }
          }, 1000);
        });

      });
    </script>
  </head>
  <body>
    <div class="container">
      <!-- 注册区域 -->
      <div class="login_box">
        <p class="text_font">买手注册</p>
        <div class="login_input">
          <div class="input_box">
            <img class="input_pic" src="/static/buy/img/phone.png" />
            <input type="text" name="mobile" placeholder="请输入手机号" @blur="check_mobile" maxlength="13" class="user_input" v-model="mobile">
          </div>
            <div class="input_box">
                <img class="input_pic" src="/static/buy/img/user.png" />
                <input type="text" name="username" id="user" placeholder="请输入用户名" class="user_input" v-model="username">
            </div>
          <div class="input_box">
            <img class="input_pic" src="/static/buy/img/password.png" />
            <input type="password" name="login_pwd" placeholder="请输入密码" class="user_input" v-model="login_pwd">
          </div>
          <div class="input_box">
            <img class="input_pic" src="/static/buy/img/password.png" />
            <input type="password" name="login_pwd2"  placeholder="请确认密码" class="user_input" v-model="login_pwd2">
          </div>
          <div class="input_box">
            <img class="input_pic" src="/static/buy/img/qq.png" />
            <input type="text" name="qq" placeholder="请输入QQ账号" class="user_input" maxlength="11" v-model="qq">
          </div>
          <!-- 验证码 -->
        <!--  <div class="yzm_input_box">
            <img class="yzm_pic" style="height: 26px;" src="/static/buy/img/123.png" />
            <input type="text" placeholder="短信验证码" class="yzm_input" maxlength="6"  v-model="dxyzm">
            <el-button class="el_btn1" type="primary" :disabled="disabled">发送验证码</el-button>
          </div>-->
          <div class="btn">
            <el-button class="el_btn2" type="primary" @click="click">注册</el-button>
          </div>
        </div>
      </div>

    </div>
  </body>
</html>
