
<!DOCTYPE html>
<html>
    <head>
        <title><?php if (isset($title)) echo $title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if($ISHTTPS==true) {?>
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> 
<?php }?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="description" content="<?php if (isset($description)) echo $description ?>" />
<meta name="keywords" content="<?php if (isset($keywords)) echo $keywords ?>" />
<!--<link href="/public/web/css/common.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="/public/web/css/main.css" rel="stylesheet" type="text/css">
-->
<script src="/public/web/js/jquery.js" type="text/javascript"></script>
<script src="/public/web/layer/3.0.3/layer.js" type="text/javascript"></script>
<script src="/public/web/js/common_home.js?v=3" type="text/javascript"></script>
<script src="/public/web/js/main.js" type="text/javascript"></script>

<script type="text/javascript" src="/public/web/js/add/com.js"></script>
<link href="/public/web/css/add/common.css?v=3" rel="stylesheet" type="text/css" />
<link href="/public/web/css/main.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="/public/web/js/add/jquery.edslider.js"></script>
        <script type="text/javascript" src="/public/web/js/add/jquery.lazyload.js"></script>
        <link rel="stylesheet" href="/public/web/css/add//index.css?v=201801107">
        <link rel="stylesheet" href="/public/web/css/add/edslider.css?v=20180110">
        <link href="/public/web/css/add/indexHnt_new.css?v=20180110" rel="stylesheet" type="text/css" />
        <script src="/public/wap/js/jquery.flexslider-min.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://hq.sinajs.cn/rn=1461855885572&list=s_sh000001,sh000001,s_sz399001,s_sz399001,sz399001"></script>
        <?php if(isset($layer_param['type']) && $layer_param['type']=='img'){ ?>
        <style>.layui-layer-dialog .layui-layer-content{padding:0px !important;} .layui-layer-content img{width:100%}</style>
        <?php }?>
        <script type="text/javascript">
            $(function(){
                var status=<?php if(isset($layer_param['status'])){ echo $layer_param['status'];} else{echo 0;}?>;
                var content=$('#layerpop').html();
                if(status==1 && content!=null && content!='')
                {
                    //标题
                    var title="";
                    <?php if(isset($layer_param['title']) && $layer_param['title']!='') {?>;
                    title=<?php echo '"'.$layer_param['title'].'"';?>;
                    <?php }?>
                    
                    //弹窗类型
                    var type="text";
                    <?php if(isset($layer_param['type']) && $layer_param['type']=='img'){ ?>
                    type="img";
                    <?php }?>
                    
                    if(type=="text" && title=="")
                    {
                        title="通知";
                    }
                    
                    //弹窗宽度
                    var width="800px";
                    <?php if(isset($layer_param['width']) && $layer_param['width']!=''){?>
                    width=<?php echo '"'.$layer_param['width'].'px"';?>;
                    <?php }?>
                    
                    //弹窗高度
                    var height="560px";
                    <?php if(isset($layer_param['height']) && $layer_param['height']!=''){?>
                    height=<?php echo '"'.$layer_param['height'].'px"';?>;
                    <?php }?>
                        
                    var sjc=Date.parse(new Date())/1000;
                    if(sjc>=<?php if(isset($layer_param['starttime'])){echo strtotime($layer_param['starttime']);}else{ echo time();}  ?>)
                    {
                        <?php if(isset($layer_param['type']) && $layer_param['type']=='img'){ ?>
                         layer.open({
                            type: 1,
                            title:'',
                            skin: '', //加上边框
                            area: [width,height], //宽高
                            content: content
                          });
                        <?php } else {?>
                        layer.alert(content
                         ,{
                             title :title,
                            area:[width,height],
                            btnAlign:'c',
                         })
                        <?php } ?>
                    }
                }
            });
        </script>
        <script type="text/javascript" >
            $(function () {

                $('.mySlideshow').edslider({
                    width: '100%',
                    height: '350'
                });

                noticeAnimate($("#noticeScroll"));

                function noticeAnimate(obj) {
                    setInterval(function () {
                        obj.animate({
                            "margin-top": "-30px"},
                                300, function () {
                                    obj.find('a').first().appendTo(obj.after());
                                    obj.css('margin-top', 0)
                                });
                    }, 3000)
                }
                $('img[data-original]').lazyload();

            });
        </script>
        <link href="/public/web/css/animate.min.css" rel="stylesheet" type="text/css">
        <script>
            $(function(){
                $("#qiandao").click(function(){
                    var uid = <?php echo $uid;?>;
                    if(uid<=0){
                        top.dialog2('您还未登录！','error');
                        return;
                    }
                    $.post("<?php echo \App::URL('web/user/sign')?>",{},function(res){
                        if(res.ret == 0){
                            $("#sign_times").html(res.times);
                            $("#sign_money").html("+"+res.money);
                            $("#sign_money").show();
                            setTimeout(function(){
                                $("#sign_money").animate({fontSize:'80px'},1000);
                            },200)
                            setTimeout(function(){
                                $("#sign_money").animate({fontSize:'16px'},500);
                            },1200)
                            setTimeout(function(){
                                $("#sign_money").hide();
                            },1900)
                        }
                        else{
                            top.dialog2(res.msg,'error');
                        }
                    },'json')
                })
            })
        </script>
        <style>
            .jiaxi{
                top: -12px;
            }
            .fanxian{
                right: 50px;
                top: 10px;
                position: absolute;
            }
            .zhunong .znt-item .b{
                position: relative;
                text-align: left
            }
            .hello2018{
                position: fixed;
                top:  50%;
                left: 20px;
                z-index: 100;
                margin-top: -110px;
                transition: transform 1s;
            }
            .act_close{
                position: absolute;
                left: 87px;
                bottom: -16px;
                cursor: pointer;
                width: 30px;
                height: 30px;
            }

            #features{background: #fff;overflow:hidden;}
            
/*            .login-index { left: 0; margin: 0 auto;overflow: visible;position: relative;top: -280px;width: 1030px;z-index: 1001;}*/
            .login-wrap {background: #fff;position: relative;border-radius: 10px;width: 280px;height: 260px;position: absolute;z-index: 99999;top: 35px;right: 0px;padding-top: 20px;}
            .mo_login_lhall_con ul li{margin-bottom: 5px}
            .mo_login_lhall_con ul li label{font-size: 12px;color: #999;margin-bottom: 8px;display: inline-block;width: 260px;}
            .mo_login_lhall_con ul li input{width: 220px;height: 32px; line-height: 38px; background: #f7f7f7;border:1px solid #e2e2e2;padding-left: 38px;font-size: 12px;color: #999999;}
            .mo_login_lhall_con ul li i{width:16px;height: 16px;display: block;position: absolute;top:12px;left:14px;}
            .mo_login_lhall_con ul li i.mo_name{background:url(/public/web/images/name.png) no-repeat 0 0; }
            .mo_login_lhall_con ul li i.mo_pass{background:url(/public/web/images/pass.png) no-repeat 0 0; }
            .mo_login_lhall_con ul li i.mo_pictu{background:url(/public/web/images/icon40.png) no-repeat 0 0;}
            .mo_login_lhall_con ul li input.mo_login_1inp2{width: 100px;display: block;float: left;}
            .mo_login_lhall_con ul li input.error_input{border:1px solid #fc4419; }
            .mo_login_lhall_con ul li input:focus {border: 1px solid #86bbf6;}
            .mo_login_lhall_con ul li .mo_login_pic2{float: right;width: 110px;height: 40px;background: #afafaf;line-height: 40px;text-align: center;font-size: 12px;color: #fff;display: inline-block;margin-left: 8px;border-radius: 3px;}
            .mo_login_lhall_con ul li .mo_login_pic2:hover,.mo_login_lhall_con ul li .mo_login_pic3{color: #fff ! important}
            .mo_login_lhall_con ul li .mo_login_pic3{float: right;width: 110px;height: 34px;background: #e94652;line-height: 34px;text-align: center;font-size: 12px;color: #fff;display: inline-block;margin-left: 8px;border-radius: 3px;}
            .mo_login_lhall_con .mo_input,.mo_login_lhall_con .mo_login_pass{position: relative}
            .siderTab ul .current{ background-color: #e94652; border-radius: 4px; color: #fff!important; }
            .siderTab ul li{ float: left; width: 113px; cursor: pointer; height: 30px; line-height: 30px; text-align: center; font-size: 16px; color: #000; position: relative; margin:0; }
            .l_tab{ position: absolute; left: 50%; top: 30px; background: url("/public/web/images/l_tab_bg.png") no-repeat; width: 14px; height: 8px; margin-left: -7px; }
             .mo_login_lhall_con ul li .mo_btn{width: 260px;height: 35px;line-height: 35px;text-align: center;font-size: 16px;color: #fff;background: #E12D2D;border-radius: 5px;display: block;margin-top:13px;margin-bottom: 0px;}     
            .mo_deal_s {float: left;display: inline-block;cursor: pointer;width: 16px;height: 16px;background: url(/public/web/images/deal_s.png) no-repeat;margin-right: 2px;vertical-align: middle;} 
            .mo_deal_n {background: url(/public/web/images/deal_n.png) no-repeat;}
            .login_btn{ height: 35px; line-height: 35px; text-align: center; display: block; margin-top: 20px; background-color: #E12D2D; color: #fff; font-size: 16px; border-radius: 4px; }
            .mo_login_lhall_con ul .last { text-align: right;margin: 15px 0 10px 0;}
            .mo_login_lhall_con a { color: #0088CC; text-decoration: none; }
            .slider-0501 .login-wrap p {font-size: 12px;line-height: 20px;margin-top: 5px;text-align: center;color: #999;}
            .inpbox li{display: inline-block;width:100px;height:35px;line-height: 35px;border-radius: 5px;color:#fff;text-align: center;margin: 3px}
            .inpbox li a{display: block;cursor:pointer}
            .inpbox li a:hover{color:#fff;}
            .inpbox li:nth-child(1){background: #f59745}
            .inpbox li:nth-child(2){background: #5bb8e6}
            .inpbox li:nth-child(3){background: #abbbfd}
            .inpbox li:nth-child(4){background: #ff6163}
        </style>
        <script>
            var CAN_SEND = true;
            var rs = 60;
            $(function(){
                $(".siderTab li").click(function(){
                    $(".siderTab li").removeClass("current");
                    $(".siderTab li").find(".l_tab").hide();
                    $(this).addClass("current");
                    $(this).find(".l_tab").show();
                    $(".siderInfo").hide();
                    var index = $(".siderTab li").index(this);
                    $(".siderInfo").eq(index).show();
                });
                
                $('#sendCode').click(function() {
                    if ($('#mobileAccount').val().length != 11) {
                        top.dialog('请输入正确的手机号！');
                        return false;
                    }
                    if ($('#authcode').val() == "") {
                        top.dialog('请输入图片验证码');
                        return false;
                    }
                    if(!CAN_SEND){
                        return;
                    }
                    $.post('/index.php?app=web&mod=member&ac=regValidate',{mobile: $('#mobileAccount').val()},function(ret){
                        if (ret.code == 0) {
                            top.dialog(ret.msg);
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
                            $.post('/index.php?app=web&mod=member&ac=getValidateCode', {mobile: $('#mobileAccount').val(), authcode : $('#authcode').val()}, function(ret) {
                                if (ret.code == 0) {
                                    $('#sendCode').html('发送验证码');
                                    //$('#im').html(ret.msg);
                                    CAN_SEND = true;
                                    clearInterval(int);
                                }
                            }, 'json');
                        }
                    },'json')
                });
                
                $('#register').click(function() {
                    var mobile = $('#mobileAccount').val();
                    var password = $('#mobilePwd').val();
                    var regVerifyCode = $('#regVerifyCode').val();
					var authcode =  $('#authcode').val();
                    if (!mobile) {
                        $('#mobileAccount').focus();
                        top.dialog2('手机号不能为空','error');
                        return;
                    }
                    if (!password) {
                        $('#mobilePwd').focus();
                        top.dialog2('密码不能为空','error');
                        return;
                    }
                   /* if (!regVerifyCode) {
                        $('#regVerifyCode').focus();
                        top.dialog2('验证码不能为空','error');
                        return;
                    } /*去掉短信验*/
					 if (!authcode) {
                        $('#authcode').focus();
                        top.dialog2('验证码不能为空','error');
                        return;
                    }
                    if(!$('#chkxy').hasClass("mo_deal_n")){
                        top.dialog2('您需要遵守《用户协议》','error');
                        return;
                    }
                    $.post("/index.php?app=web&mod=member&ac=doregister", {mobile : mobile,password : password,confirm : password,smscode : regVerifyCode}, function(res) {
                        if (res.code == 0) {
                            top.dialog2(res.msg,'error');
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
                        top.dialog2('帐号不能为空','error');
                        return;
                    } 
                    if (!loginPwd1) {
                        top.dialog2('密码不能为空','error');
                        return;
                    } 
                    $.post("/index.php?app=web&mod=member&ac=dologin", {username : account_name,password : loginPwd1}, function(res) {
                        if (res.code == 0) {
                            //if(res.data=='ua'){
                            //$('.yzmPic').attr('src','/member/authcode.html#'+new Date().getTime());
                            //}
                            //$('.authcode').show();
                            top.dialog2(res.msg,'error');
                        } else {
                            //window.location = "/index.php?app=web&mod=member&ac=check_jump&mobile="+account_name+"&password="+loginPwd1;
                            window.location = "/index.php?app=web&mod=user&ac=account";
                        }
                    }, 'json');
                });
            })
            
        </script>
        <script type="text/javascript">
            $(function() {
                //板块行情
                $.post("/index.php?app=web&mod=index&ac=hq_bankuai",{},function(data){
                    $("#hq_bankuai").html(data);
                })
                //进度
                $('.jd em').each(function() {
                    var sch = parseFloat($(this).text());
                    $(this).text(sch);
                    var sch = Math.floor(sch);
                    $(this).css('background-position', sch * -70 + 'px 0');
                });
                //选项卡/
                jQuery.jqtab = function(tabtit, tab_conbox, shijian) {
                    $(tab_conbox).children().hide();
                    $(tabtit).find("b").first().addClass("thistab").show();
                    $(tab_conbox).children().first().show();

                    $(tabtit).find("b").bind(shijian, function() {
                        $(this).parents(".tabBoxT").find("b").removeClass("thistab");
                        $(this).siblings().removeClass("thistab");
                        $(this).addClass("thistab");
                        var activeindex = $(tabtit).find("b").index(this);
                        $(tab_conbox).children().eq(activeindex).show().siblings().hide();
                        return false;
                    });
                };
                $.jqtab(".linkT", ".linkM", "mouseenter");
            });
        </script>
        

    </head>
    <body>


        <!-- 头部 -->
        <?php 
if(!isset($_SESSION)){
    session_start();
}
$uid = isset($_SESSION['uid'])?$_SESSION['uid']:0;
if($uid >0){
    $user = \Model\User\UserInfo::getinfo($uid);
    $user['user_name'] = substr_replace($user['mobile'], '****',3,4);
}
?>
<div id="base-info-bar">
    <div class="w1200">
        <div class="fl">
            <span>欢迎访问华亿策略</span>
            <span style="font-weight: bold;color:#ff3344">&nbsp;</span>
            <span>&nbsp;|&nbsp;</span>
            <span>财富热线：<span style="font-weight: bold;color:#ff3344">4000-039-678</span></span>
        </div>
        <div class="right">
            <?php if ($uid > 0) { ?>
                <a href="<?php echo \App::URL("web/user/account"); ?>">您好，<?php echo $user['user_name']; ?></a>
                <a href="<?php echo \App::URL('web/member/logout'); ?>">退出登录</a>
            <?php } else { ?>
                <a href="<?php echo \App::URL("web/member/register"); ?>" class="register-btn">免费注册</a>
                <a href="<?php echo \App::URL("web/member/login"); ?>">立即登录</a>
            <?php } ?>
            <a href="<?php echo \App::URL("web/help/software"); ?>" class="mobile-phone"><span class="web-icon mobile-phone-icon"></span>APP下载</a>
            <a href="<?php echo \App::URL("web/help/member"); ?>" class="hover_text">帮助中心</a>
            <a href="<?php echo \App::URL("web/about/us"); ?>" class="hover_text">关于我们</a>
            <a href="<?php echo \App::URL("web/help/guide"); ?>" class="hover_text">新手指引</a>
        </div>
    </div>
</div>
        <div class="logo-module">
    <div class="w1200">
        <a href="/"><span class="yhqz-logo"></span></a>
        <div class="main-nav-bar" id="logo-nav">
            <span <?php if((isset($_GET['mod']) && $_GET['mod']=='index' && $_GET['ac']=='view') || !isset($_GET['mod'])){echo ' class="active-bar"';}?>><a href="<?php echo \App::URL("web/index/view");?>" target="">首页</a></span>
            <span <?php if(isset($_GET['mod']) && $_GET['mod']=='peizi' && $_GET['ac']=='month'){echo ' class="active-bar"';}?> ><a href="<?php echo \App::URL("web/peizi/month");?>" target="">按月策略</a>
                <div class="hit"><img src="/public/web/images/hot.gif" width="30"/></div>
            </span>
            <span <?php if(isset($_GET['mod']) && $_GET['mod']=='peizi' && $_GET['ac']=='day'){echo ' class="active-bar"';}?>><a href="<?php echo \App::URL("web/peizi/day");?>"  target="">按天策略</a></span>
            <span <?php if(isset($_GET['mod']) && $_GET['mod']=='peizi' && $_GET['ac']=='free'){echo ' class="active-bar"';}?>><a href="<?php echo \App::URL("web/peizi/free");?>" target="">免费体验</a></span>
            <span <?php if(isset($_GET['mod']) && $_GET['mod']=='index' && $_GET['ac']=='activity'){echo ' class="active-bar"';}?>><a href="<?php echo \App::URL("web/index/activity");?>"  target="">新手任务</a>
                <div class="hit" style="top:10px"><img src="/public/web/images/new.gif" width="25"/></div>
            </span>
            <span <?php if(isset($_GET['mod']) && $_GET['mod']=='index' && $_GET['ac']=='extend'){echo ' class="active-bar"';}?>><a rel="nofollow" href="<?php echo \App::URL("web/index/extend");?>"  target="">我要推广</a></span>
            <!-- <span <?php if(isset($_GET['mod']) && $_GET['mod']=='index' && $_GET['ac']=='safe'){echo ' class="active-bar"';}?>><a href="<?php echo \App::URL("web/index/safe");?>"  target="">安全保障</a></span> -->
             <span <?php if(isset($_GET['mod']) && $_GET['mod']=='help' && $_GET['ac']=='tradeapp'){echo ' class="active-bar"';}?>><a href="<?php echo \App::URL("web/help/tradeapp");?>"  target="">交易软件</a></span>
            <span <?php if(isset($_GET['mod']) && $_GET['mod']=='user'){echo ' class="active-bar"';}?>><a href="<?php echo \App::URL("web/user/account");?>"  target="">我的账户</a></span>
        </div>
    </div>
</div>
        <!-- 头部end -->

        <!--主体区域-->
        <div class="w1200 banner-login">
            <div style="display: none" id="layerpop">
            <?php if(isset($layer_param['content'])){ echo str_replace('&quot;','"',str_replace('&gt;','>',str_replace('&lt;', '<', str_replace('&amp;', '&', $layer_param['content']))));}?>
            </div>
            <?php 
                if(!isset($_SESSION)){
                    session_start();
                }
                $uid = isset($_SESSION['uid'])?$_SESSION['uid']:0;
            ?>
            <?php if($uid>0){?>
            <div class="login-index">
                <div class="login-wrap">
                    <div class="myid" style="height:100px;margin:20px 10px;color:#666">
                        <h5 style="font-size:16px;line-height: 40px">实力品牌承诺</h5>
                        <p style="font-size:16px;line-height: 40px">资金安全双重保障，100%实盘交易</p>
                    </div>
                    <div class="inpbox">
                        <ul>
                            <li><a href="<?php echo \App::URL('web/user/recharge')?>">充值</a></li>
                            <li><a href="<?php echo \App::URL('web/user/withdrawl')?>">提现</a></li>
                            <li><a href="<?php echo \App::URL('web/user/fund')?>">资金流水</a></li>
                            <li><a href="<?php echo \App::URL('web/member/logout')?>">退出</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php }else{?>
            <div class="login-index">
                <div class="login-wrap">
                    <div class="mo_login_lhall_con">
                        <div class="siderTab clr" style=" height: 48px;padding-left: 27px">
                            <ul>
                                <li class="current"><span>快速注册</span>
                                    <div class="l_tab"></div></li>
                                <li class=""><span class="">快速登录</span>
                                    <div class="l_tab" style="display:none"></div></li>
                            </ul>
                        </div>
                        <div class="siderBox" style="margin:0 10px">
                            <div class="siderInfo">
                                <ul>
                                    <li>
                                        <div class="mo_input error_input">
                                            <i class="mo_name"></i> <input type="text" maxlength="16" id="mobileAccount" placeholder="请使用手机注册" class="mo_login_1inp" >
                                        </div>
                                    </li>
                                    <li>
                                        <div class="mo_input" id="mobilePassDiv">
                                            <i class="mo_pass"></i> 
                                            <input type="password" id="mobilePwd" placeholder="请设置6-16位密码" class="mo_login_1inp1" maxlength="16">
                                        </div>
                                    </li>
                                 <li class="mo_login_pass" style="height:40px;">
                                        <i class="mo_pictu"></i>
                                        <input id="authcode"  type="text" placeholder="请输入验证码" value="" class="mo_login_1inp2" >
                                        <img src="<?php echo \App::URL('web/member/makeCertPic')?>"  onclick="this.src='/index.php?app=web&mod=member&ac=makeCertPic'" style="height:34px"/>
                                        <div style="clear: both;"></div>
                                    </li>
                                    <!--<li class="mo_login_pass" style="height:40px;">
                                        <i class="mo_pictu"></i>
                                        <input id="regVerifyCode"  type="text" placeholder="请输入验证码" class="mo_login_1inp2" >
                                        <a id="sendCode" href="javascript:;" class="mo_login_pic3">发送验证码</a>
                                        <div style="clear: both;"></div>
                                    </li><!--去掉短信验-->
                                    <li class="mo_login_txt" style="height:16px; margin-bottom:10px;display: none"><span id="e_chkxy" class="noteXy" style="display: none;"> * 您没有同意并遵守协议 </span> <span id="chkxy" class="mo_deal_s mo_deal_n" onClick="$(this).toggleClass('mo_deal_n')"></span>
                                        <p style="text-align: left;color:#999;font-size: 12px">同意并愿意遵守 <a href="<?php echo \App::URL("web/help/agreement");?>" target="_blank">《用户协议》</a>
                                        </p></li>
                                    <li class="mo_login_last"><a id="register" href="javascript:;" title="" class="mo_btn" style="margin-top: 5px">注&nbsp;&nbsp;册</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="siderInfo" style="display: none;">
                                 <input name="tg" value="" type="hidden">
                                <input name="errorNum" value="3" type="hidden">
                                <input id="rememberMe" name="rememberMe" value="" type="hidden">
                                <input id="isFirstLogin" name="isFirstLogin" value="1" type="hidden">
                                <ul class="siderUl">
                                    <li>
                                        <div class="mo_input error_input">
                                            <i class="mo_name"></i> <input id="account_name" name="account_name" autocomplete="off" tabindex="1" type="text" placeholder="请输入手机号" class="mo_login_1inp" >
                                        </div>
                                    </li>
                                    <li>
                                        <div class="mo_input">
                                            <i class="mo_pass"></i>
                                            <input type="password" id="loginPwd1" style="display: block;" placeholder="请输入密码" class="mo_login_1inp1" maxlength="16">
                                        </div>
                                    </li>

                                    <li class="mbtn"><a href="javascript:void(0)" title="" id="btn_login" class="login_btn" style="color: #fff;">登&nbsp;&nbsp;&nbsp;录</a>
                                    </li>
                                    <li class="last"><a href="<?php echo \App::URL("web/member/register");?>" class="sbtn">10秒注册</a>
                                        <span>|</span> <a href="<?php echo \App::URL("web/member/findpwd");?>" class="sbtn">忘记密码？</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>

        <ul class="mySlideshow">
            <li style="background-image: url(/public/web/images/banner/banner04.png)">
                <a href="javascript:;" target="_blank"></a>
            </li>
            <li style="background-image: url(/public/web/images/banner/banner02.png)">
                <a href="javascript:;" target="_blank"></a>
            </li>
            <li style="background-image: url(/public/web/images/banner/banner03.png)">
                <a href="javascript:;" target="_blank"></a>
            </li>
            <li style="background-image: url(/public/web/images/banner/banner01.png)">
                <a href="javascript:;" target="_blank"></a>
            </li>
        </ul>
<!--公告开始-->    
    <div class="section1" style="background: #f5f6f7;border-bottom: 1px solid #ddd;" >
        <div class="notice clearfix w1200">
            <i></i>
            <span class="notice-tag fl">官方公告</span>
            <div id="notice_slider" style="margin-left:28px;height:34px;line-height: 35px;width: 1000px;display: inline-block;">
                <ul class="slides">
                    <?php foreach ($noticeList['data'] as $key=>$notice) { ?>
                        <li>
                            <a href="<?php echo \App::URL('web/article/show', array('id' => $notice['id'], 'pid' => $notice['pid'])); ?>" target="_blank" class="clearfix" title="<?php echo $notice['title'];?>">
                                <?php if(mb_strlen($notice['title'],'utf-8')<=50){ ?>
                                <span class="fl"><?php echo $notice['title']; ?></span> 
                                <?php }else{ ?>
                                <span class="fl"><?php echo mb_substr($notice['title'],0,50,'utf-8'); ?>...</span> 
                                <?php }?>
                                <span class="fr" style="margin-right: 18px;"><?php echo date('Y-m-d',$notice['addtime']); ?></span>
                            </a>
                        </li>
                    <?php } ?>
                </ul> 
             </div>
            <div class="right">
                <a class="noticegd"  href="<?php echo \App::URL('web/article/view', array('pid'=>5)); ?>" target="__Blank" class="fr" >更多>></a>
            </div>
            
            <script type="text/javascript">
               // $(function () {
                    $('#notice_slider').flexslider({
                        animation : 'slide',
                        controlNav : false,
                        directionNav : false,
                        animationLoop : true,
                        slideshow : true,
                        useCSS : false,
                        touch:true,
                        pauseOnHover: true,
                       direction: "vertical", 
                        after: function (slider) {
                            slider.pause();
                            slider.play();
                        },
                    });
              //  });
          </script>
        </div>
    </div>
    <!--公告结束-->
    <!--特色开始-->
    <div class="newbee">
        <div class="w1200 clearfix">
            <div class="item">
                <div class="figure">
                    <img src="/public/web/images/icon-1.png" alt="">
                </div>
                <div class="item-body">
                    <div class="title">资金保障</div>
                    <div class="text">资金第三方托管，专款专用</div>
                </div>
            </div>
            <div class="item">
                <div class="figure">
                    <img src="/public/web/images/icon-2.png" alt="">
                </div>
                <div class="item-body">
                    <div class="title">真实交易</div>
                    <div class="text">100%实盘，level2可查委托</div>
                </div>
            </div>
            <div class="item">
                <div class="figure">
                    <img src="/public/web/images/icon-3.png" alt="">
                </div>
                <div class="item-body">
                    <div class="title">快捷提现</div>
                    <div class="text">闪电提现，五分钟到账</div>
                </div>
            </div>
            <div class="item">
                <div class="figure">
                    <img src="/public/web/images/icon-4.png" alt="">
                </div>
                <div class="item-body">
                    <div class="title">专业服务</div>
                    <div class="text">客户体验至上为宗旨</div>
                </div>
            </div>
        </div>
    </div>
    <!--特色结束-->
     
    <!--配资开始-->
    <div class="section-product section-peizi clearfix w1200 mb20">
        <div class="section-left"> <div class="section-left-bg"></div>
            <h3 class="right-tit">股票策略</h3>
            <p class="right-info">
                您炒股 我出钱  <br>
                资金放大1-10倍 <br>
                盈利全归您 <br>
                低门槛 提现快
            </p>
        </div>
        <div class="section-main">
            

            <div class="peizi-item wow flipInY animated" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: flipInY;">
                <div class="title">按天策略</div>
                <div class="title_del">1 - 6倍</div>
                <div class="desc">策略杠杆</div>
                <div class="desc_del">券商独立账户</div>  
                <div class="meta">
                    <div class="clearfix"><div class="name">最高可操盘：</div><div class="val"><?php echo $params['maxLimitMoney']/100*7;?>元</div></div>
                    <div class="clearfix"><div class="name">起配金额：</div><div class="val"><?php echo $params['minLimitMoney']/100;?>元</div></div>
                </div>
                <div class="btns-botton">
                    <a class="grab-btn" href="<?php echo \App::URL('web/peizi/day'); ?>">
                        <em></em><i>立即申请</i>
                    </a>
                </div>
            </div>

            <div class="peizi-item wow flipInY animated" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: flipInY;">
                <div class="title">按月策略</div>
                <div class="title_del">5 - 10倍</div>
                <div class="desc">策略杠杆</div>
                <div class="desc_del">券商独立账户</div>    
                <div class="meta">
                    <div class="clearfix"><div class="name">最高可操盘：</div><div class="val"><?php echo $params_peizi_month['maxLimitMoney']/100*11;?>元</div></div>
                    <div class="clearfix"><div class="name">起配金额：</div><div class="val"><?php echo $params_peizi_month['minLimitMoney']/100;?>元</div></div>
                </div>
                <div class="btns-botton">
                    <a class="grab-btn" href="<?php echo \App::URL('web/peizi/month'); ?>">
                        <em></em><i>立即申请</i>
                    </a>
                </div>
            </div> 
            
            <div class="peizi-item wow flipInY animated" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: flipInY;">
                <div class="title">免费体验</div>
                <div class="title_del">所有费用全免</div>
                <div class="desc">盈利全归您</div>
                <div class="desc_del">不收取管理费</div>  
                <div class="meta">
                    
                    <div class="clearfix"><div class="name">操盘金额：</div><div class="val"><?php echo $params_peizi_free['service_cost_rate']?>元</div></div>
                    <div class="clearfix"><div class="name">体验时长：</div><div class="val"><?php echo $params_peizi_free['free_day']?>个交易日</div></div>
                </div>
                <div class="btns-botton">
                    <a class="grab-btn" href="<?php echo \App::URL('web/peizi/free'); ?>">
                        <em></em><i>立即申请</i>
                    </a>
                </div>
            </div>
        </div> 
    </div>
    <!--配资结束-->

    <!--操作流程开始-->
    <div class="wrapper clearfix  w1200 mb20">
    <div class="liuchengimg">
    </div>
    </div>
    <!--操作流程结束-->
    
    <!--行情中心开始-->
    <div class="w1200 plan2 mb20">
        <div class="plan-left">
            <h2>行情中心</h2>
            <div style="color: #000;font-size: 18px;">大盘行情 实时关注</div>
            <div class="hangqing" id="menu_szzs">
                <ul>
                    <li sv="0" class="active">上证指数</li>
                    <li sv="1">深证指数</li>
                </ul>
            </div>
            <a href="<?php echo \App::URL('web/help/tradeapp'); ?>" class="xxbtn-rj" target="_blank">交易软件下载</a>
        </div>

        <div class="plan-right">
            <div class="hq_con">
                <div class="hq_txt" id="a0001_bnt">
                    <a class="cur" sv="0" href="javascript:;">分时线</a> <a sv="1" href="javascript:;">日K线</a> <a sv="2" href="javascript:;">周K线</a> <a sv="3" href="javascript:;">月K线</a>
                </div>
                <div class="hq_img">
                    <img src="http://image.sinajs.cn/newchart/min/n/sh000001.gif" width="545" height="300" id="a0001_img">
                </div>
            </div>
            <div class="hq_con" style="display: none;">
                <div class="hq_txt" id="s0001_bnt">
                    <a class="cur" sv="0" href="javascript:;">分时线</a> <a sv="1" href="javascript:;">日K线</a> <a sv="2" href="javascript:;">周K线</a> <a sv="3" href="javascript:;">月K线</a>
                </div>
                <div class="hq_img">
                    <img src="http://image.sinajs.cn/newchart/min/n/sz399001.gif" width="545" height="300" id="s0001_img">
                </div>
            </div>
            <div class="hq_sv" style="width:305px;">
                <div class="hq_st">
                    <div id="zstype" style="padding-top: 20px;font-size: 26px;text-align: center;">上证指数</div>
                    <div class="hq_a1" id="a0001_v1">
                        <li class="sv" style="color: rgb(255, 0, 0);"></li>
                        <li class="ico"></li>
                        <li class="icon-right" style="color: rgb(255, 0, 0);"></li>
                        <li class="icon-right" style="color: rgb(255, 0, 0);"></li>
                    </div>
                    <div class="hq_aq1_xq" id="a0001_detail">
                        <p>
                            <span> <span class="xq-color">今开：</span>
                                <font color="#237c02"></font>
                            </span>
                            <span><span class="xq-color">成交量：</span>
                                <font color="#237c02"></font>
                            </span>
                            <span><span class="xq-color">振幅：</span>
                                <font color="#007cc8"></font>
                            </span>
                            <span><span class="xq-color">最高：</span>
                                <font color="#237c02"></font>
                            </span>
                            <span><span class="xq-color">成交额：</span>
                                <font color="#007cc8"></font>
                            </span>
                            <span><span class="xq-color">昨收：</span>
                                <font color="#007cc8"></font>
                            </span>
                            <span><span class="xq-color">总市值：</span>
                                <font color="#007cc8"></font>
                            </span>
                        </p>
                    </div>
                    <div class="gupiao">
                        <table id="gpInfo" width="100%">
                            <colgroup>
                                <col style="width:90px">
                                <col style="width:110px">
                                <col style="width:80px">
                                <col>
                            </colgroup>
                            <tbody id="hq_bankuai">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--行情中心结束-->
    
    <!--网站公告开始-->
    <div class="pb6  w1200">
    <div class="index_down_load">
        <div class="load_top">
            <span>交易软件下载</span>
            <p>新用户注册并实名认证后请下载安装此交易软件</p>
            <i></i>
            <a href="<?php echo \App::URL('web/help/tradeapp');?>" target="_blank">电脑版下载</a>
        </div>
    </div>

    <div class="pb6-r" style="float:none;width:auto;">
       <div class="gonggaoBox">

        <div id="bd_two" class="bd dd">
            <p class="dd_line"><span>网站公告</span> <a href="<?php echo \App::URL('web/article/view',array('pid'=>5));?>" target="_blank" class="gg">更多...</a></p> 
            <span>
                <?php foreach ($noticeList['data'] as $key=> $notice){ ?>
                    <?php if($key<=5){?>
                        <li><span class="date"><?php echo date('Y-m-d',$notice['addtime']);?></span><a id="bd_colors" href="<?php echo \App::URL('web/article/show',array('id'=>  $notice['id']));?>" title="<?php echo $notice['title'];?>" target="_blank"><?php echo \App::msubstr($notice['title'],0, 19).'...';?></a></li>
                    <?php }?>
                <?php }?>
            </span> 
        </div>
        <div id="hd_two" class="hd dd" style="width: 470px">   
            <div class="shouci">
                <div class="sctitle">新用户领<span><?php echo $params_peizi_free['service_cost_rate']?></span>元实盘资金</div>
                <div>新用户注册并实名认证后 </div>
                <div>立即领取<span><?php echo $params_peizi_free['service_cost_rate']?></span>实盘资金</div>
                <i  class="i1"></i>
                <a class="btnx"  target="_blank" rel="nofollow" href="<?php echo \App::URL('web/peizi/free');?>">马上体验</a>
           </div>
            <div class="shouci">
                <div  class="sctitle">注册送<span><?php echo $params_sendmoney;?></span>元大礼包</div>
                <div>注册会员后，完成任务赚现金</div>
                <div>赠送的<span><?php echo $params_sendmoney;?></span>元只能用于支付管理费用</div>
                <i class="i2"></i>
                <a class="btnx" target="_blank" rel="nofollow" href="<?php echo \App::URL('web/member/register');?>">马上注册</a>
            </div>
        </div>


        </div>

    </div>
    </div>
    <!--网站公告结束-->
    
    <!--合作伙伴开始-->
    <div class="partners w1200">
    <div class="partner-hd">
        <div class="text">合作伙伴</div>
    </div>
    <div class="partner-bd">
            <ul class="clearfix">
                            <li class="item">
                    <a href="https://www.360.cn/" target="_blank">
                        <img class="img-responsive" src="/public/web/images/friends/s1.png" alt="360官网" >
                    </a>
                </li>
                            <li class="item">
                    <a href="http://www.ebscn.com/" target="_blank">
                        <img class="img-responsive" src="/public/web/images/friends/s2.png" alt="光大证券">
                    </a>
                </li>
                            <li class="item">
                    <a href="http://www.ccb.com/" target="_blank">
                        <img class="img-responsive" src="/public/web/images/friends/s3.png" alt="建设银行">
                    </a>
                </li>
                            <li class="item">
                    <a href="http://www.citicbank.com/" target="_blank">
                        <img class="img-responsive" src="/public/web/images/friends/s4.png" alt="中信银行">
                    </a>
                </li>
                            <li class="item">
                    <a href="http://www.cs.ecitic.com/" target="_blank">
                        <img class="img-responsive" src="/public/web/images/friends/s5.png" alt="中信证券">
                    </a>
                </li>
                            <li class="item">
                    <a href="http://www.htsc.com.cn/" target="_blank">
                        <img class="img-responsive" src="/public/web/images/friends/s6.png" alt="华泰证券">
                    </a>
                </li>
                            <li class="item">
                    <a href="https://www.htsec.com" target="_blank">
                        <img class="img-responsive" src="/public/web/images/friends/s7.png" alt="海通证券">
                    </a>
                </li>
                            <li class="item">
                    <a href="http://www.cmbchina.com/" target="_blank">
                        <img class="img-responsive" src="/public/web/images/friends/s8.png" alt="招商银行">
                    </a>
                </li>
                            <li class="item">
                    <a href="http://www.icbc.com.cn/" target="_blank">
                        <img class="img-responsive" src="/public/web/images/friends/s9.png" alt="工商银行">
                    </a>
                </li>
                            <li class="item">
                    <a href="http://www.gf.com.cn/" target="_blank">
                        <img class="img-responsive" src="/public/web/images/friends/s10.jpg" alt="广发证券">
                    </a>
                </li>
                            <li class="item">
                    <a href="http://www.10jqka.com.cn/" target="_blank">
                        <img class="img-responsive" src="/public/web/images/friends/s11.png" alt="同花顺财经">
                    </a>
                </li>
                            <li class="item">
                    <a href="http://www.jrj.com.cn/" target="_blank">
                        <img class="img-responsive" src="/public/web/images/friends/s12.png" alt="金融界">
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <!--合作伙伴结束-->
          
           <div style=" width: 122px; height: 171px; position: fixed; z-index: 9999; left: 20px; bottom: 60px; display: block;">
            <div id="" onClick="$(this).parent().remove();" style=" border-radius: 50%; background-image: linear-gradient(to top, #f77062 0%, #fe5196 100%); font-family: '微软雅黑'; width: 20px; height: 20px;line-height: 18px; color: #ffffff;transform: rotate(-45deg);text-align: center; font-size: 19px; margin-left: 160px;cursor:pointer">+</div>
            <a href="/index.php?app=web&mod=help&ac=tradeapp" style="width: 180px; height: 160px; background: url(/public/web/images/add/down.png) no-repeat; background-size: 200px; display: block;"></a>
          </div>

        <!--主体区域 end-->

<script type="text/javascript">
            var _barColor = '#FF5D5B';
        </script>
        <script>
        

        function hq_code(s) {
            var zqcode = "sh000001";
            if (s == '0') $("#a0001_img").attr('src', 'http://image.sinajs.cn/newchart/min/n/' + zqcode + '.gif');
            if (s == '1') $("#a0001_img").attr('src', 'http://image.sinajs.cn/newchart/daily/n/' + zqcode + '.gif');
            if (s == '2') $("#a0001_img").attr('src', 'http://image.sinajs.cn/newchart/weekly/n/' + zqcode + '.gif');
            if (s == '3') $("#a0001_img").attr('src', 'http://image.sinajs.cn/newchart/monthly/n/' + zqcode + '.gif');
        }

        function hq_code1(s) {
            var zqcode = "sz399001";
            if (s == '0') $("#s0001_img").attr('src', 'http://image.sinajs.cn/newchart/min/n/' + zqcode + '.gif');
            if (s == '1') $("#s0001_img").attr('src', 'http://image.sinajs.cn/newchart/daily/n/' + zqcode + '.gif');
            if (s == '2') $("#s0001_img").attr('src', 'http://image.sinajs.cn/newchart/weekly/n/' + zqcode + '.gif');
            if (s == '3') $("#s0001_img").attr('src', 'http://image.sinajs.cn/newchart/monthly/n/' + zqcode + '.gif');
        }
        $("#a0001_bnt a").click(function() {
            hq_code($(this).attr('sv'));
            $("#a0001_bnt a").removeClass('cur');
            $(this).addClass('cur');
        })
        $("#s0001_bnt a").click(function() {
            hq_code1($(this).attr('sv'));
            $("#s0001_bnt a").removeClass('cur');
            $(this).addClass('cur');
        })
        $("#menu_szzs li").click(function() {
                $("#menu_szzs li").removeClass("active");
                $(this).addClass("active");
                $(".hq_con").hide();
                $(".hq_con").eq($(this).attr("sv")).show();
                if ($(this).attr("sv") == '0') {
                    hq_show(0);
                } else {
                    hq_show(1);
                }
            })
            //当前股票价
        function hq_show(type) {
            if (type == 0) {
                var elements = hq_str_sh000001.split(",");
                var elements_bl = hq_str_s_sh000001.split(",");
                $("#zstype").html("上证指数");
            } else {
                $("#zstype").html("深证指数");
                var elements = hq_str_sz399001.split(",");
                var elements_bl = hq_str_s_sz399001.split(",");
            }
            var a0001_k_pr = parseFloat(elements[1]);
            var a0001_z_pr = parseFloat(elements[2]);
            var a0001_t_pr = parseFloat(elements[3]);

            $("#a0001_v1 li").eq(0).text(a0001_t_pr.toFixed(2))
            $("#a0001_v1 li").eq(2).text(parseFloat(elements_bl[2]).toFixed(2))
            $("#a0001_v1 li").eq(3).text(parseFloat(elements_bl[3]).toFixed(2))
            $("#a0001_v1 li").eq(3).text($("#a0001_v1 li").eq(3).text() + '%');

            //股票明细
            var a0001_cj_pr = parseFloat(elements[8]);
            var a0001_cjm_pr = parseFloat(elements[9]);

            $("#a0001_detail font").eq(0).text(a0001_k_pr.toFixed(2));
            $("#a0001_detail font").eq(1).text((pr_style(parseFloat(elements_bl[4]) * 100)) + '手');
            $("#a0001_detail font").eq(2).text($("#a0001_v1 li").eq(3).html());
            $("#a0001_detail font").eq(3).text(parseFloat(elements[4]).toFixed(2));
            $("#a0001_detail font").eq(4).text(parseFloat(elements[5]).toFixed(2));
            $("#a0001_detail font").eq(5).text(pr_style(parseFloat(elements_bl[5]) * 10000));
            $("#a0001_detail font").eq(6).text(parseFloat(elements[2]).toFixed(2));
            $("#a0001_detail font").eq(7).text(pr_style((parseFloat(elements_bl[4]) * 100) * parseFloat(a0001_k_pr.toFixed(2))));



            if (parseFloat(elements_bl[2]) < 0) {
                $("#a0001_v1 li").eq(0).css("color", "#009900");
                $("#a0001_v1 li").eq(2).css("color", "#009900");
                $("#a0001_v1 li").eq(3).css("color", "#009900");
                $("#a0001_v1 li").eq(1).removeClass('ico').addClass('dw');
            } else {
                $("#a0001_v1 li").eq(0).css("color", "#FF0000");
                $("#a0001_v1 li").eq(2).css("color", "#FF0000");
                $("#a0001_v1 li").eq(3).css("color", "#FF0000");
                $("#a0001_v1 li").eq(1).removeClass('dw').addClass('ico');
            }
        }
        hq_show(0)

        function pr_style(s) {
            var re_pr = 0;
            var re_str = "";
            if (s > 10000 && s < 10000000) {
                re_pr = s / 10000;
                re_str = '万';
            } else if (s > 10000000 && s < 100000000) {
                re_pr = s / 10000000;
                re_str = '千万';
            } else if (s >= 100000000) {
                re_pr = s / 100000000;
                re_str = '亿';
            } else if (s < 10000) {
                re_pr = s;
            }
            if (s < 10000) {
                re_pr = re_pr;
            } else {
                re_pr = re_pr.toFixed(2);
            }
            return (re_pr + re_str);
        }
        //alert(elements[3]);
        </script>


        <!-- 网站底部 -->
        <div class="footer-module">
            <div class="footer-nav w1200">
                
                <div class="service-num-module">
                    <p style="font-size: 22px;color: #fff;text-align: right;padding-right: 60px;">客服热线</p>
                    <span class="service-tel-icon" style="font-size:28px;color:#fff;    font-weight: 700;">4000-039-678</span>
                    <div  style="color: #999999;text-align: right;padding-right: 50px;">服务时间：08:00-20:00（工作日）<br>12:00-17:00（节假日）                </div>
                </div>
                <div class="qr-code-module">
                    
                   <!-- <div class="qr-code-item">
                        <span class="yhqb-app-icon"><img style="width:120px;" src="/public/web/images/add/ewm_weixin.png?v=2"/></span>
                        <p >客服微信二维码</p>
                    </div>-->
                    
                </div>
                <div class="related-link">
                    <div>
                        <p class="first-row">关于我们</p>
                        <p><a href="/index.php?app=web&mod=about&ac=us" target="_blank">平台简介</a></p>
                        <p><a href="/index.php?app=web&mod=about&ac=qualification" target="_blank">公司证件</a></p>
                        <p><a href="/index.php?app=web&mod=article&ac=view&pid=5" target="_blank">平台公告</a></p>
                        <p><a href="/index.php?app=web&mod=about&ac=contact" target="_blank">联系我们</a></p>
                    </div>
                    <div>
                        <p class="first-row">股票策略</p>
                        <p><a href="/index.php?app=web&mod=peizi&ac=month" target="_blank">按月策略</a></p>
                        <p><a href="/index.php?app=web&mod=peizi&ac=day" target="_blank">按天策略</a></p>
                        <p><a href="/index.php?app=web&mod=peizi&ac=free" target="_blank">免费体验</a></p>
                        <p><a href="/index.php?app=web&mod=help&ac=software" target="_blank">APP下载</a></p>
                    </div>
                    <div>
                        <p class="first-row">贴心指引</p>
                        <p><a href="/index.php?app=web&mod=help&ac=guide" target="_blank">新手指南</a></p>
                        <p><a href="/index.php?app=web&mod=index&ac=activity" target="_blank">福利专区</a></p>
                        <p><a href="/index.php?app=web&mod=help&ac=agreement" target="_blank">注册协议</a></p>
                        <p><a href="/index.php?app=web&mod=index&ac=safe" target="_blank">安全保障</a></p>
                    </div>
                    <div>
                        <p class="first-row">帮助中心</p>
                        <p><a href="/index.php?app=web&mod=help&ac=member" target="_blank">注册问题</a></p>
                        <p><a href="/index.php?app=web&mod=help&ac=member" target="_blank">充值问题</a></p>
                        <p><a href="/index.php?app=web&mod=help&ac=member" target="_blank">认证问题</a></p>
                        <p><a href="/index.php?app=web&mod=help&ac=storck" target="_blank">策略问题</a></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="company-copyright">
            <div class="w1200">
                
                <div class="copyright">
                    <p style="text-align: center"><?php echo SITE_COPYRIGHT;?>  股市有风险,投资需谨慎</p>
                    
                    <DIV style="text-align: center;height: 48px;line-height: 48px;">
                               

                

    <!--360代码开始-->
    <!--<a target='_blank' href="http://webscan.360.cn/index/checkwebsite/url/www.hypz.cn"><img  height="48px" border="0" src="/public/web/images/360aq.png"/></a>
    <!--360代码结束-->


    <!--创宇信用开始-->
    <!--<a target='_blank' href="https://v.yunaq.com/certificate?domain=www.hypz.cn&from=label&code=90030"><img  height="48px" src="/public/web/images/label_sm_90030.png"></a>
    <!--创宇信用结束-->

    <!--315开始-->
   <!-- <a id='___szfw_logo___' href='https://credit.szfw.org/CX29080008865820181219.html' target='_blank'><img  height="48px" src='/public/web/images/green.jpg' border='0' /></a>
    <script type='text/javascript'>(function(){document.getElementById('___szfw_logo___').oncontextmenu = function(){return false;}})();</script>
    <!--315结束-->

    <!--诚信网站开始-->
   <!-- <a id='___szfw_logo___' href='https://credit.szfw.org/CX75010008863520181219.html' target='_blank'><img  height="48px" src='/public/web/images/cert.png' border='0' /></a>
    <script type='text/javascript'>(function(){document.getElementById('___szfw_logo___').oncontextmenu = function(){return false;}})();</script>
    <!--诚信网站结束-->

    <!--可信网站图片LOGO安装开始-->   
   <!-- <script src="http://kxlogo.knet.cn/seallogo.dll?sn=e18121844010076377rm6r000000&size=0"></script>
    <!--可信网站图片LOGO安装结束-->

    <!--水滴开始-->

   <!-- <a target="_blank" href="http://shuidi.cn/seller/home-498ee6ca9b39906f40b72c3bf1d7a801.html"><img  height="48px"  src="/public/web/images/lixin.png"></a>

    <!--水滴结束-->

    <!--知道创宇开始-->
    <!--<a id="jsl_speed_stat0" href="http://www.hypz.cn/" target="_blank">知道创宇云安全</a><script src="//static.yunaq.com/static/js/stat/picture_stat.js" charset="utf-8" type="text/javascript"></script>
    <!--知道创宇结束-->
<a target="cyxyv" href="https://v.yunaq.com/certificate?domain=www.hypz.cn&from=label&code=90030"><img src="https://aqyzmedia.yunaq.com/labels/label_sm_90030.png"></a>

    <!--安全可信代码开始-->
    <a target="_blank" href="http://www.cn-ecusc.org.cn/cert/aqkx/site/?site=www.hypz.cn"><img  height="48px" src="/public/web/images/aqkx_124x47.png"></a>
    <!--安全可信代码结束-->
    
	<a id='___szfw_logo___' href='https://credit.szfw.org/CX201902151226123658830328.html' target='_blank'><img  height="48px" src='/public/web/images/cert.png' border='0' /></a>
	
	<a id="_pingansec_bottomimagelarge_p2p" href="http://si.trustutn.org/info?sn=315190409000668672441&certType=4" target='_blank'><img  height="48px" src='/public/web/images/jr.png' border='0' /></a>	
	
<script type='text/javascript'>(function(){document.getElementById('___szfw_logo___').oncontextmenu = function(){return false;}})();</script>


                    </DIV>            
                </div>
            </div>
        </div>

        <div class="right-fixed-side-bar">
            <ul>
                <li id="f1_img" class="f1-img" title="点击咨询在线客服"><a href="<?php echo SITE_SERVICE_URL;?>" target="_blank"><img src="/public/web/images/zxkf.png" /><p>在线客服</p></a></li>
                <li id="f2_img" class="f2-img" title="客服热线"><a href="javascript:void(0)" ><img src="/public/web/images/kfdh3-icons.png" /><p class="p2">客服热线</p></a>
                    <div class="dropdown">
                        <ul> 
                            <li>
                                <span title="" style="color: #fff;font-size: 23px;line-height: 60px;">4000-039-678</span>
                            </li>
                        </ul>
                    </div>
                </li>
                <li id="f3_img" class="f3-img" title="点击咨询QQ客服"><a href="tencent://AddContact/?fromId=45&fromSubId=1&subcmd=all&uin=75698888&website=www.oicqzone.com"  target="_blank"><img src="/public/web/images/kefu-icon.png" /><p class="p3">QQ客服</p></a></li>
               <!-- <li id="f4_img" class="f4-img" title="扫一扫咨询微信客服"><a href="javascript:void(0)" ><img src="/public/web/images/weixin2.png" /><p class="p4">微信客服</p></a></li>-->

                
                <li id="f6_img" class="f6-img"  title="点击下载APP"><a href="<?php echo \App::URL('web/help/software');?>"   target="_blank"><img src="/public/web/images/down2.png" /><p class="p2">APP下载</p></a></li>
                <li id="f7_img" class="f7-img"  title="点击下载交易端"><a href="<?php echo \App::URL('web/help/tradeapp');?>"   target="_blank"><img src="/public/web/images/61816.jpg" /></a></li>
                <li id="f8_img" class="f8-img"  title="点击签到"><img src="/public/web/images/qiandao.png" />
                            <div style="position:absolute;left:-100px;top:0;display: none;color:red;font-size:16px;font-weight: bold;height: 50px;line-height: 50px;width:100%;text-align: center" id="sign_money"></div>
                </li>

                <li id="f5_img" class="f5-img"><a href="javascript:void(0)"><img src="/public/web/images/float_8.png" /><p class="p2">返回</p></a></li>
            </ul>
        </div>

<script type="text/javascript">
$(function(){
        $("#f8_img").click(function(){
            var uid = <?php echo $uid;?>;
            if(uid<=0){
                top.dialog2('您还未登录！','error');
                return;
            }
            $(this).attr("disabled",true);
            $.post("<?php echo \App::URL('web/user/sign')?>",{},function(res){
                 $(this).attr("disabled",false);
                if(res.ret == 0){
                    $("#sign_times").html(res.times);
                    $("#sign_money").html("+"+res.money);
                    $("#sign_money").show();
                    setTimeout(function(){
                        $("#sign_money").animate({fontSize:'90px'},2000);
                    },200)
                    setTimeout(function(){
                        $("#sign_money").animate({fontSize:'16px'},2000);
                    },1200)
                    setTimeout(function(){
                        $("#sign_money").hide();
                    },4000)
                }
                else{
                    top.dialog2(res.msg,'error');
                }
            },'json')
        })
    })
            
    $(function () {
        $(window).scroll(function () {
            var scrollValue = $(window).scrollTop();
            if (scrollValue > 100) {
                $('#f5_img').height() == 0 && $('#f5_img').stop().animate({'height': '60px', 'margin-top': '5px'}, 200);
                $('#f5_img').show();
            } else {
                $('#f5_img').height() > 0 && $('#f5_img').stop().animate({'height': 0, 'margin-top': '0'}, 200);
                $('#f5_img').hide();
            }
        });
        $('#f5_img').click(function () {
            $("html,body").animate({scrollTop: 0}, 200);
        });
    })
</script>
        <script type="text/javascript" src="https://s96.cnzz.com/z_stat.php?id=1276284630&web_id=1276284630"></script>
        <!--脚本开始-->
        <?php echo str_replace("&#039;", "'", html_entity_decode(SITE_SERVICE_SCRIPT))  ; ?>
        <!--脚本结束-->
        <!-- 网站底部 -->

        
    </body>
</html>
