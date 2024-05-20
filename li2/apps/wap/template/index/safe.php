
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>

    <body class="index">
        <!-- Header Start -->
        <!--include file "header.php"-->
        <link href="/public/web/css/event.css" rel="stylesheet" type="text/css" media="screen,projection" />
        <link rel="stylesheet" type="text/css" href="/public/web/css/util.css"/>
        <link rel="stylesheet" type="text/css" href="/public/web/css/main_aqbz.css"/>
        <script type="text/javascript" src="/public/web/js/jquery-1.8.3.min.js"></script>
        <!-- Content Start -->
        <div class="safe_con">
            <ul>
                <li class="safe_creat">
                    <div class="wrap clear safe_creat_wrap">
                        <img class="safe_creat_safe" src="/public/web/images/aqbz/safe.png"/>
                        <img class="safe_creat_safe1" src="/public/web/images/aqbz/safe-1.png"/>
                        <img class="safe_creat_safe2" src="/public/web/images/aqbz/safe-2.png"/>
                        <img class="safe_creat_safe3" src="/public/web/images/aqbz/safe-3.png"/>
                        <img class="safe_creat_safe4" src="/public/web/images/aqbz/safe-4.png"/>
                        <img class="safe_creat_safe5" src="/public/web/images/aqbz/safe-5.png"/>
                    </div>
                </li>
                <li class="safe_guo">
                    <!-- <a name="1"></a> -->
                    <div class="wrap clear">
                        <div class="left">
                            <h4><span>强</span>实力</h4>
                            <strong>500万人民币注册资本金</strong>
                            <p>广州栋供科技有限公司经广州市政府批准成立并在广州市工商行政管理局正式注册登记，注册资本500万元人民币，是广州实力品牌策略公司之一。</p>
                        </div>
                        <div class="right">
                            <img src="/public/web/images/aqbz/pic-16.png" alt="">
                        </div>
                    </div>
                </li>
                <li class="safe_you">
                    <!-- <a name="4"></a> -->
                    <div class="wrap clear">
                        <div class="left">
                            <img src="/public/web/images/aqbz/pic-21.png" alt="">
                        </div>
                        <div class="right">
                            <h4>有<span>保险</span></h4>
                            <strong>保险机构100%风险保障</strong>
                            <p>保险机构承保“信用履约保证保险”。如果被保险人（即平台方）不按照合同约定或法律的规定履行义务，保险机构对投资人风险全额保障。</p>
                        </div>
                    </div>
                </li>
                <li class="safe_bao">
                    <!-- <a name="3"></a> -->
                    <div class="wrap clear">
                        <div class="left">
                            <h4><span>技术</span>保障</h4>
                            <strong>专业的技术保障交易安全</strong>
                            <p>强大的技术团队、独立研发系统、科学严格的权限管理及银行级数据灾备系统保障用户信息以及交易信息的绝对安全，为用户资金及个人信息提供360度无死角的安全保障。</p>
                        </div>
                        <div class="right">
                            <img src="/public/web/images/aqbz/pic-18.png" alt="">
                        </div>
                    </div>

                </li>
                <li class="safe_chao">
                    <!-- <a name="2"></a> -->
                    <div class="wrap clear">
                        <div class="left">
                            <img src="/public/web/images/aqbz/pic-17.jpg" alt="">
                        </div>
                        <div class="right">
                            <h4><span>风控</span>管理</h4>
                            <strong>科学严密的风控运维体系</strong>
                            <p>采用先进的安全风控体系，由一批业内顶尖的风控专业人员建立并完善了一系列风险控制机制和风险管理制度，确保用户的个人信息、交易信息安全，并及时采取风控措施降低用户交易风险。</p>
                        </div>
                    </div>
                </li>
                <li class="safe_zhen">
                    <!-- <a name="5"></a> -->
                    <div class="wrap clear">
                        <div class="left">
                            <h4>三方<span>存管</span></h4>
                            <strong>资金第三方存管，专款专用</strong>
                            <p>使用证券公司及银行合作监管，所有资金通过证券公司和银行合作监管进行结算。平台账户、投资人资管账户完全隔离，避免资金管理风险；平台注用户须进行实名认证，保证提现资金的安全性。</p>
                        </div>
                        <div class="right">
                            <img src="/public/web/images/aqbz/pic-19.png" alt="">
                        </div>
                    </div>

                </li>
            </ul>
            <ol class="safe_icon">
                <li class="on"></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ol>
        </div>





        <!-- online custom service start -->


        <script type="text/javascript">
            $(function() {

                var WscrollTop = document.body.scrollTop || document.documentElement.scrollTop;
                Wscroll(WscrollTop);
                $(window).scroll(function() {
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
                $('.safe_icon li').click(function() {
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
        <!--include file "footer.php"-->
    </body>
</html>