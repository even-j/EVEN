
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
        <link rel="stylesheet" type="text/css" href="/public/web/css/extend.css"/>
        <script type="text/javascript" src="/public/web/js/jquery-1.8.3.min.js"></script>
        <!-- Content Start -->
        <div class="safe_con">
            <div class="extend-bg01"></div>
            <div class="extend-bg02"></div>
            <div class="extend-bg03"></div>
            
            <div class="extend-bg08">
                <div class="wrap">
                    <div class="word-request request2">
                        <h1>属于你的 <span>1 </span>重大礼</h1>
                        <h2>邀请的好友成功申请策略，</h2>
                        <h2><span>个人推广最高可获管理费50%高额返佣</span>，上不封顶！！！</h2>
                    </div>
                </div>
            </div>
            <div class="extend-bg09">
                <div class="wrap">
                    <div class="word-white">
                        举例：您成功邀请了12个用户，平均每个用户申请策略30万元（按月策略），操盘时间为1个月
                    </div>
                    <div class="word-yellow1">以上，一个月您可以获得：1800元
                        <span class="small-yellow">（按月策略10倍杠杆，申请30万元的每月管理费）</span>*50%
                        <span class="small-yellow">（返佣比例）</span>
                    </div>
                    <div class="word-yellow3">
                        *12
                        <span class="small-yellow">人</span>*1
                        <span class="small-yellow">月</span> = 10800元
                    </div>
                    <div class="word-white2">
                        系统收到被邀请人支付管理费后，系统自动存入邀请人账户，可直接提取。
                        <br />自被邀请人完成华亿策略注册之日开始计算，返现有效期为终身有效。
                    </div>
                </div>
            </div>
            <div class="extend-bg10">
                <div class="btn-position2">
                    <a href="<?php echo \App::URL("web/user/tuiguang");?>"><img src="/public/web/images/extend/btn.png" /></a>
                </div>
            </div>
            <div class="extend-bg11"></div>

        </div>





        <!-- online custom service start -->


        <script type="text/javascript">
            $(function () {

                var WscrollTop = document.body.scrollTop || document.documentElement.scrollTop;
                Wscroll(WscrollTop);
                $(window).scroll(function () {
                    var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
                    Wscroll(scrollTop);
                })
                if (window.location.hash == "#1") {
                    $(window).scrollTop(500);
                } else if (window.location.hash == "#4") {
                    $(window).scrollTop(1041);
                } else if (window.location.hash == "#3") {
                    $(window).scrollTop(1582);
                } else if (window.location.hash == "#2") {
                    $(window).scrollTop(2164);
                } else if (window.location.hash == "#5") {
                    $(window).scrollTop(2705);
                }
                $('.safe_icon li').click(function () {
                    var index = $(this).index();
                    $('html,body').animate({scrollTop: 541 * index}, 800);
                    return false;

                })

                function Wscroll(scrolltop) {
                    if (0 <= scrolltop && scrolltop < 440) {
                        $('.safe_icon li').removeClass('on');
                        $('.safe_icon li:eq(0)').addClass('on');
                        $('.safe_creat_safe1').delay(500).fadeIn();
                        $('.safe_creat_safe2').delay(700).fadeIn();
                        $('.safe_creat_safe3').delay(900).fadeIn();
                        $('.safe_creat_safe4').delay(1100).fadeIn();
                        $('.safe_creat_safe5').delay(1300).fadeIn();
                    } else if (440 <= scrolltop && scrolltop < 980) {
                        $('.safe_icon li').removeClass('on');
                        $('.safe_icon li:eq(1)').addClass('on');
                        $('.safe_guo .left').animate({marginLeft: '0'}, 1000, 'swing');
                        $('.safe_guo .right').animate({marginRight: '0'}, 1000, 'swing');
                    } else if (980 < scrolltop && scrolltop < 1520) {
                        $('.safe_icon li').removeClass('on');
                        $('.safe_icon li:eq(2)').addClass('on');
                        $('.safe_you .left').animate({marginLeft: '0'}, 1000, 'swing');
                        $('.safe_you .right').animate({marginRight: '0'}, 1000, 'swing');
                    } else if (1520 < scrolltop && scrolltop < 2060) {
                        $('.safe_icon li').removeClass('on');
                        $('.safe_icon li:eq(3)').addClass('on');
                        $('.safe_bao .left').animate({marginLeft: '0'}, 1000, 'swing');
                        $('.safe_bao .right').animate({marginRight: '0'}, 1000, 'swing');
                    } else if (2060 < scrolltop && scrolltop < 2600) {
                        $('.safe_icon li').removeClass('on');
                        $('.safe_icon li:eq(4)').addClass('on');
                        $('.safe_chao .left').animate({marginLeft: '0'}, 1000, 'swing');
                        $('.safe_chao .right').animate({marginRight: '0'}, 1000, 'swing');
                    } else if (2600 < scrolltop && scrolltop < 3140) {
                        $('.safe_icon li').removeClass('on');
                        $('.safe_icon li:eq(5)').addClass('on');
                        $('.safe_zhen .left').animate({marginLeft: '0'}, 1000, 'swing');
                        $('.safe_zhen .right').animate({marginRight: '0'}, 1000, 'swing');
                    }
                }

            });
        </script>
        <!-- Content End -->
        <!--include file "footer.php"-->
    </body>
</html>