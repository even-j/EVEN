<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"/www/wwwroot/xbt.com/pubic/../application/seller/view/login/index.html";i:1698591548;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="renderer" content="webkit"/>
  <meta name="force-rendering" content="webkit"/>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
  <title>小白兔</title>
  <link rel="stylesheet" type="text/css" href="/static/seller/node_modules/element-ui/lib/theme-chalk/index.css"/>
  <script src="/static/seller/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
  <script src="/static/seller/js/vue.js" type="text/javascript" charset="utf-8"></script>
  <script src="/static/seller/layer/layer.js" type="text/javascript" charset="utf-8"></script>
  <script src="/static/seller/node_modules/element-ui/lib/index.js"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* 全屏背景图 */
    .container {
      width: 100%;
      height: 100vh;
      min-height: 200px;
      background: url("/static/seller/img/login2dba51d.png") 50%;
      background-size: cover;
      overflow-y: auto;
      position: relative;
    }

    /* 登录 */
    .login_box {
      width: 100%;
      height: 310px;
      max-width: 360px;
      background: rgba(0, 0, 0, 0.5);
      position: absolute;
      top: 0;
      bottom: 0;
      right: 0;
      left: 0;
      margin: auto;
      border-radius: 5px;
      padding: 20px;
    }

    .text_font {
      text-align: center;
      font-size: 20px;
      font-weight: 600;
      color: #fff;
      letter-spacing: 2px;
    }

    /* input区域 */
    .login_input {
      width: 90%;
      margin: 20px auto;
    }

    .login_input .user_input_box,
    .login_input .paddword_input_box {
      height: 36px;
      line-height: 36px;
      width: 100%;
      border-radius: 5px;
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: flex-start;
      background: #FFFFFF;
      margin-bottom: 20px;
    }

    .user_input_box .user_pic,
    .paddword_input_box .paddword_pic {
      width: 22px;
      margin: 0 5px;
    }

    .user_input_box .user_input,
    .paddword_input_box .paddword_input {
      height: 36px;
      line-height: 36px;
      width: 100%;
      border: none;
      background: none;
      outline: none;
    }

    .user_input_box .user_input::placeholder,
    .paddword_input_box .paddword_input::placeholder,
    .yzm_input_box .yzm_input::placeholder {
      color: #aaaaaa;
    }

    /* 验证码 */
    .login_input .yzm_input_box {
      height: 36px;
      line-height: 36px;
      width: 40%;
      border-radius: 5px;
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: flex-start;
      background: #FFFFFF;
      margin-bottom: 10px;
    }

    .yzm_input_box .yzm_input {
      height: 36px;
      line-height: 36px;
      width: 100%;
      border: none;
      background: none;
      outline: none;
    }

    .yzm_input_box .yzm_pic {
      width: 22px;
      margin: 0 5px;
      height: 22px;
    }

    .yzm_input_box .yzm_img {
      height: 36px;
      position: absolute;
      right: 40px;
    }

    .checkbox .checkbox_item {
      color: white;
      font-size: 14px;
    }

    .checkbox .wangji_mima {
      color: white;
      font-size: 14px;
      position: absolute;
      right: 40px;
    }

    .btn {
      width: 100%;
      margin: 20px 0;
    }

    .btn .el_btn {
      width: 100%;
    }
  </style>
</head>
<body>
<div class="container">

  <!-- 登录区域 -->
  <div class="login_box">
    <p class="text_font">商家登录</p>
    <div class="login_input">
      <div class="user_input_box">
        <img class="user_pic" src="/static/seller/img/user.png"/>
        <input type="text" placeholder="请输入用户名" v-model="seller_name" class="user_input">
      </div>
      <div class="paddword_input_box">
        <img class="paddword_pic" src="/static/seller/img/password.png"/>
        <input type="password" placeholder="请输入密码" v-model="password" class="paddword_input">
      </div>
     <!-- <div class="yzm_input_box">
        <img class="yzm_pic" src="/static/seller/img/123.png"/>
        <input type="text" v-model="code" placeholder="验证码" class="yzm_input">
        <img src="<?php echo url('login/yanzhengma'); ?>" alt="captcha" class="yzm_img"/>
      </div>-->
      <div class="checkbox"style="height: 10px">
        <!--<el-checkbox v-model="checked" class="checkbox_item">记住密码</el-checkbox>-->
        <!-- <el-checkbox class="checkbox_item">记住密码</el-checkbox> -->
        <a href="<?php echo url('login/register'); ?>"><span class="wangji_mima">注册有礼</span></a>
      </div>
      <div class="btn">
        <el-button class="el_btn" type="primary" @click="loginDo()">登录</el-button>
      </div>
    </div>
  </div>

</div>
<script type="text/javascript">
    window.onload = function () {
        var vm = new Vue({
            el: ".container",
            data: {
                seller_name: "",
                password: "",
                code: "",
            },
            mounted:function(){
              $('.yzm_img').click(function(){
                  $(this).attr('src',"<?php echo url('login/yanzhengma'); ?>");
              })
            },
            created:function(){
                var that = this;
                document.onkeydown = function(e){
                    var key = window.event.keyCode;
                    if(key == 13){
                        that.loginDo();
                    }
                }
            },
            methods: {
                loginDo: function () {
                    if (!this.seller_name) return layer.msg("用户名不能为空!", {
                        icon: 2,
                        time: 1500
                    });
                    if (!this.password) return layer.msg("密码不能为空！", {icon: 2, time: 1500});
                   // if (!this.code) return layer.msg("验证码不能为空！", {icon: 2, time: 1500});
                    //发送 post 请求
                    $.post("<?php echo url('Login/loginDo'); ?>", {
                        seller_name: this.seller_name,
                        password: this.password,
                        code: this.code
                    }, function (res) {
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1, time: 1500}, function () {
                                location.href = res.url;
                            })
                        } else {
                            layer.msg(res.msg, {icon: 2, time: 1500});
                        }
                    });
                },
            }
        });
    };
</script>
</body>
</html>
