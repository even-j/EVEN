<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\phpstudy\WWW\zhan\shua_li\pubic/../application/buy\view\login\index.html";i:1698581863;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>小白兔</title>
    <link rel="stylesheet" type="text/css" href="/static/buy/element-ui/lib/theme-chalk/index.css" />
    <!-- 页面内容CSS -->
    <link rel="stylesheet" type="text/css" href="/static/buy/css/pageCss/index.css"/>
    <link rel="Shortcut Icon" type="image/x-icon" href="/static/buy/img/index.png" />
    <script src="/static/buy/js/vue-2.6.10.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/buy/element-ui/lib/index.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/buy/js/jquery-1.12.4.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $(function() {
            var vm = new Vue({
               el: ".container",
                data: function() {
                    return {
                        disabled: false,
                        name:'',
                        password:'',
                        code:'',
                    }
                },
                mounted:function(){
                    $('.yzm_img').click(function(){
                        $(this).attr('src',"<?php echo url('login/yanzhengma'); ?>");
                    })
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

                click:function(){
                    $.ajax({
                        type : 'POST',
                        url : "<?php echo url('buy/login/index'); ?>",
                        async : true,
                        data : {
                            "aoData" : 'aaaa',//测试数据,
                            "captcha_code":vm.code,
                            "name":vm.name,
                            "password":vm.password
                        },
                        success : function(data){
                            console.log(data);
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



        });
    </script>
</head>
<body>
<div class="container" style="background: url('/static/buy/img/login.2dba51d.png') 50%;background-size: cover;overflow-y: auto;">

    <!-- 登录区域 -->
    <div class="login_box">
        <p class="text_font" >买家登录</p>
        <div class="login_input">
                <div class="user_input_box">
                    <img class="user_pic" src="/static/buy/img/user.png" />
                    <input type="text" name="name" id="user" placeholder="请输入用户名" class="user_input" v-model="name">
                </div>
                <div class="paddword_input_box">
                    <img class="paddword_pic" src="/static/buy/img/password.png" />
                    <input  type="password" name="password" id="pwd"  placeholder="请输入密码" class="paddword_input" v-model="password">
                </div>
              <!--  <div class="yzm_input_box" style="width: 42%;">
                    <img class="yzm_pic" style="height: 26px;" src="/static/buy/img/123.png" />
                    <input type="text" name="captcha_code" class="yzm_input" placeholder="请输入验证码" id="cap_wid" v-model="code">
                    <img src="<?php echo url('login/yanzhengma'); ?>" class="yzm_img" alt="captcha" />
                </div>-->
                <div class="checkbox" style="width: 80%;height: 10px;">
                    <span class="wangji_mima"><a style="text-decoration:none;color:#fff;" href="<?php echo url('login/register'); ?>">注册有礼</a></span>
                </div>
                <div class="btn">
                    <!-- <input type="submit" tabindex="3" value="提交" class="btn btn-primary" />-->
                    <el-button class="el_btn"   id="button1" type="primary " @click="click">登录</el-button>
                </div>
        </div>
    </div>
    <script type="text/javascript">

    </script>
</div>
</body>
</html>
