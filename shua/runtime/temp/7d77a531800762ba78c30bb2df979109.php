<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"/www/wwwroot/xbt.com/pubic/../application/seller/view/login/forget.html";i:1698557939;}*/ ?>
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
    <link rel="stylesheet" type="text/css" href="/static/buy/css/pageCss/forgetPassword.css"/>
</head>
<body>
<div class="container">

    <!-- 忘记密码 -->
    <div class="login_box">
        <p class="text_font">忘记密码</p>
        <a href="<?php echo url('login/index'); ?>" class="fanhui_login">返回登陆</a>
        <div class="login_input">
            <!-- 手机号 -->
            <div class="input_box">
                <img class="input_pic" src="/static/buy/img/phone.png" alt=""/>
                <input type="text" placeholder="请输入手机号" maxlength="11" class="user_input"  v-model="mobile">
            </div>
            <!-- 验证码 -->
            <div class="yzm_input_box">
                <img class="yzm_pic" style="height: 26px;" src="/static/buy/img/123.png"/>
                <input type="text"  placeholder="短信验证码" class="yzm_input" maxlength="6"  v-model="code">
                <el-button class="el_btn1 send" type="primary" @click="send()" :disabled="disabled">发送验证码</el-button>
            </div>
            <!-- 新密码 -->
            <div class="input_box">
                <img class="input_pic" src="/static/buy/img/password.png" alt=""/>
                <input type="password"  placeholder="请输入新密码" class="user_input"  v-model="password">
            </div>
            <!-- 确认密码 -->
            <div class="input_box">
                <img class="input_pic" src="/static/buy/img/password.png" alt=""/>
                <input type="password" placeholder="请确认新密码" class="user_input"  v-model="password2">
            </div>
            <!-- 按钮 -->
            <div class="btn">
                <el-button class="el_btn2" @click="click" type="primary">修改密码</el-button>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    window.onload = function () {
        // 用户密码正则,6到16位,(字母,数字,下划线,减号)
        var passWordReg = /^[a-zA-Z0-9_-]{6,16}$/;
        // 手机号正则表达式
        var phoneReg = /^1[3-9]\d{9}$/;
        var vm = new Vue({
            el: ".container",
            data: {
                mobile: "",
                password: "",
                password2:'',
                code: "",
                disabled:false,
            },
            methods: {
                send:function(){
                    if (!this.mobile) return layer.msg("手机号不能为空!", {
                        icon: 2,
                        time: 1500
                    });
                    if (!phoneReg.test(this.mobile)) return layer.msg("手机号格式不正确!", {
                        icon: 2,
                        time: 1500
                    });

                    $.post("<?php echo url('Login/mobileDo'); ?>", {mobile: this.mobile,}, function (res) {
                        if (res.code == 1) {
                                return layer.msg(res.msg, {icon: 1, time: 1500},function(){
                                    var num = 60;
                                    var that = this;
                                    var timer = setInterval(function () {
                                        num--;
                                        vm.disabled = true;
                                        if (num <= 0) {
                                            clearInterval(timer);
                                            $(that).html("重新发送");
                                            vm.disabled = false;
                                            num = 60;
                                        }else{
                                            $('.send').html("还剩 " + num + " 秒");
                                        }
                                    }, 1000);
                                });
                        } else {
                            return layer.msg(res.msg, {icon: 2, time: 1500});
                        }
                    });
                },
                click: function () {
                    if (!this.mobile) return layer.msg("手机号不能为空!", {
                        icon: 2,
                        time: 1500
                    });
                    if (!phoneReg.test(this.mobile)) return layer.msg("手机号格式不正确!", {
                        icon: 2,
                        time: 1500
                    });
                    if (!this.password) return layer.msg("密码不能为空！", {icon: 2, time: 1500});
                    if (!passWordReg.test(this.password)) return layer.msg("密码为6到16位的字母或数字组合！", {icon: 2, time: 1500});
                    if (!this.code) return layer.msg("验证码不能为空！", {icon: 2, time: 1500});
                    //发送 post 请求
                    $.post("<?php echo url('Login/forgetDo'); ?>", {
                        mobile: this.mobile,
                        password: this.password,
                        code: this.code
                    }, function (res) {
                        if (res.code == 1) {
                            return layer.msg(res.msg, {icon: 1, time: 1500}, function () {
                                location.href = res.url;
                            })
                        } else {
                            return layer.msg(res.msg, {icon: 2, time: 1500});
                        }
                    });
                }
            }
        });
    };
</script>
</body>
</html>
