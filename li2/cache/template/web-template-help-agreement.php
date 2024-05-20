
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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

    </head>

    <body class="index">
        <!-- Header Start -->
        <div id="top">
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
        </div>
        <link href="/public/web/css/article.css" rel="stylesheet" type="text/css" media="screen,projection" />
        <!-- Content Start -->
        <div class="bar">
            <div class="aboutNav">
                <style>
    body {background: #f3f3f3;}
</style>
<ul>
    <li <?php if($_GET['mod']=='help' && $_GET['ac']=='guide'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/help/guide");?>" >新手指南</a></li>
    <li <?php if($_GET['mod']=='help' && $_GET['ac']=='member'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/help/member");?>" >常见问题</a></li>
    <li <?php if($_GET['mod']=='help' && $_GET['ac']=='storck'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/help/storck");?>" >策略相关</a></li>
    <li <?php if($_GET['mod']=='help' && $_GET['ac']=='agreement'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/help/agreement");?>" >注册协议</a></li>
    <li <?php if($_GET['mod']=='help' && $_GET['ac']=='software'){echo ' class="now"';}?>><a href="<?php echo \App::URL("web/help/software");?>" >APP下载</a></li>
</ul>
            </div>
            <div class="aboutMain">
                <p class="title1"><b>注册协议</b></p>
                <div class="aboutM"><style>
                        .contracts{padding:5px 20; margin:0 auto; font-size:14px; }
                        .contracts h2{ text-align:center; line-height:60px; font-size:20px; border-bottom:1px solid #ddd; margin-bottom:10px;}
                        .contracts h3{ font-size:15px; line-height:40px;}
                        .contracts p{ line-height:24px; margin:5px 0; text-indent:30px;}
                        .contracts p.r{ text-align:right;}
                        .contracts ul { margin-bottom:10px;}
                        .contracts ul li{line-height:24px; margin:5px 0; text-indent:48px;}
                        .contracts table{ width:100%; border-collapse:collapse; margin-bottom:10px;}
                        .contracts table th{ border:1px solid #ccc; padding:5px 10px; text-align:left; font-weight:300;}
                        .contracts table td{border:1px solid #ccc; padding:5px 10px;}
                        .contracts table.b0 td,.contracts table.b0 th{ border:0;}
                        .contracts i{ font-style:normal; border-bottom:1px solid #666; padding:0 10px 3px 10px;}
                    </style>
                    <div class="contracts">
                        <h3>特别提示：</h3>
                        <p>在使用华亿策略服务之前，您应当认真阅读并遵守《华亿策略服务协议》（以下简称"本协议"），请您务必审慎阅读、充分理解各条款内容，特别是免除或者限制责任的条款、争议解决和法律适用条款。 如您对协议有任何疑问的，应向华亿策略客服咨询。
                        </p>
                        <p>
                        </p>
                        <p>当您按照注册页面提示填写信息、阅读并同意本协议且完成全部注册程序后，或您按照激活页面提示填写信息、阅读并同意本协议且完成全部激活程序后， 或您以其他华亿策略允许的方式实际使用华亿策略服务时，即表示您已充分阅读、理解并接受本协议的全部内容，并与华亿策略达成协议。 您承诺接受并遵守本协议的约定，届时您不应以未阅读本协议的内容或者未获得华亿策略对您问询的解答等理由，主张本协议无效，或要求撤销本协议。
                        </p>
                        <h3>一、协议范围</h3>
                        <p>1、本协议由您与华亿策略的经营者共同缔结，本协议具有合同效力。有关华亿策略经营者的信息请查看华亿策略首页底部公布的公司信息和证照信息。</p>
                        <p>2、除另行明确声明外，华亿策略服务包含任何华亿策略提供的基于互联网以及移动网的相关服务，且均受本协议约束。如果您不同意本协议的约定，您应立即停止注册/激活程序或停止使用华亿策略服务。</p>
                        <p>3、本协议内容包括协议正文及所有华亿策略已经发布或将来可能发布的各类规则、公告或通知均为本协议不可分割的组成部分，与协议正文具有同等法律效力。</p>
                        <p>4、华亿策略有权根据需要不时地制订、修改本协议及/或各类规则，并以网站公示的方式进行变更公告，无需另行单独通知您。变更后的协议和规则一经在网站公布后，立即或在公告明确的特定时间自动生效。 若您在前述变更公告后继续使用华亿策略服务的，即表示您已经阅读、理解并接受经修订的协议和规则。若您不同意相关变更，应当立即停止使用华亿策略服务。
                        </p>
                        <h3>二、使用规则</h3>
                        <p>1、您确认，在您完成注册程序或以其他华亿策略允许的方式实际使用华亿策略服务时，您应当是具备完全民事行为能权利能力和完全民事力的自然人、法人或其他组织。 若您不具备前述主体资格，则您及您的监护人应承担因此而导致的一切后果，且华亿策略有权注销或永久冻结您的账户，并向您及您的监护人索偿相应损失。
                        </p>
                        <p>2、您注册成功后，华亿策略将给予每个注册用户一个用户帐号及相应的密码，该用户帐号和密码由您负责保管；您应当对您帐号进行的所有活动和事件负法律责任。</p>
                        <p>3、您不应将您的帐号、密码转让或出借予他人使用。如您发现您的帐号遭他人非法使用，应立即通知华亿策略。因黑客行为或您的保管疏忽导致帐号、密码遭他人非法使用，华亿策略不承担任何责任。</p>
                        <p>4、您承诺不得以任何方式利用华亿策略直接或间接从事违反中国法律、以及社会公德的行为，华亿策略有权对违反上述承诺的内容和帐户予以删除。</p>
                        <p>5、华亿策略有权对您使用华亿策略的情况进行审查和监督，如您在使用华亿策略时违反规定， 华亿策略或其授权的人有权要求您改正或直接采取一切必要的措施（包括但不限于更改或删除用户张贴的内容、暂停或终止您使用华亿策略的权利）以减轻您不当行为造成的影响。
                        </p>
                        <p>6、您注册的帐号昵称如存在违反法律法规或国家政策要求，或侵犯任何第三方合法权益的情况，华亿策略有权收回该账号昵称。</p>
                        </p>
                        <h3>三、免责声明</h3>
                        <p>1、华亿策略不对您发表的内容或评论的正确性进行保证。</p>
                        <p>2、您在华亿策略发表的内容仅表明您个人的立场和观点，并不代表华亿策略的立场或观点。 作为内容的发表者，需自行对所发表的内容负责，因所发表内容引发的一切纠纷，由该内容的发表者承担全部法律及连带责任。华亿策略不承担任何法律及连带责任。
                        </p>
                        <p>3、鉴于网络服务的特殊性，您同意华亿策略有权随时变更、中断或终止部分或全部的网络服务。</p>
                        <p>4、您理解，华亿策略需要定期或不定期地对提供网络服务的平台（如互联网网站、移动网络等）或相关的设备进行检修或者维护， 如因此类情况而造成网络服务在合理时间内的中断，华亿策略无需为此承担任何责任，但华亿策略应尽可能事先进行通告。
                        </p>
                        <p>5、华亿策略不保证网站中有关公司商情、股票评析、投资方向等内容的正确性和适用性。您基于上述内容所进行的交易或投资决定，由您承担全部后果和责任。股市有风险，入市须谨慎！</p>
                        <p>6、华亿策略是一个理财服务平台，汇集了诸多类型的投资者、理财机构，华亿策略建议您在使用过程中保护自己的个人隐私与股票账户秘密， 不宜将个人隐私或者账户信息透露给其他人员。由此造成的损失，由您自己承担。
                        </p>
                        <p>7、本声明未涉及的问题参见国家有关法律法规，当本声明与国家法律法规冲突时，以国家法律法规为准。华亿策略之声明以及其修改权、更新权及最终解释权均属华亿策略所有。</p>
                        <h3>四、隐私保护</h3>
                        <p>保护注册用户隐私是华亿策略的一项基本政策，华亿策略保证不对外公开或向第三方提供单个注册用户的注册资料及注册用户在使用网络服务时存储在华亿策略的非公开内容，但下列情况除外：</p>
                        <p>1、事先获得用户的明确授权；</p>
                        <p>2、根据有关的法律法规要求；</p>
                        <p>3、按照相关政府主管部门的要求；</p>
                        <p>4、为维护社会公众的利益；</p>
                        <p>5、为维护华亿策略的合法权益。</p>
                        <h3>五、退订政策</h3>
                        <p>华亿策略在提供服务过程中有可能以其他方式向您发送网站相关的服务或者活动信息，这是华亿策略提供的服务的组成部分，如您不愿意收到类似信息，可联系华亿策略客服完成退订手续。</p>
                        <h3>六、协议终止</h3>
                        <p>1、您同意，华亿策略有权自行全权决定以任何理由不经事先通知的中止、终止向您提供部分或全部华亿策略服务，暂时冻结或永久冻结（注销）您的账户在华亿策略的权限，且无须为此向您或任何第三方承担任何责任。</p>
                        <p>2、出现以下情况时，华亿策略有权直接以注销账户的方式终止本协议，并有权永久冻结（注销）您的账户在华亿策略的权限：</p>
                        <p>a)您提供的用户信息中的主要内容不真实或不准确或不及时或不完整；</p>
                        <p>b)本协议（含规则）变更时，您明示并通知华亿策略不愿接受新的服务协议的；</p>
                        <p>c)其它华亿策略认为应当终止服务的情况。</p>
                        <h3>七、关于链接</h3>
                        <p>华亿策略平台内容中可能会提供与其他互联网网站或资源的链接。对于上述网站或资源是否可以利用，华亿策略不予保证。因使用或依赖上述网站或资源产生的损失或损害，华亿策略也不负担任何责任。</p>
                        <h3>八、法律适用</h3>
                        <p>1、本协议之效力、解释、变更、执行与争议解决均适用中华人民共和国大陆地区法律，如无相关法律规定的，则应参照通用国际商业惯例和/或行业惯例。</p>
                        <p>2、本协议及因本协议产生的一切法律关系及纠纷，您与华亿策略平台的经营者均同意以被告住所地人民法院为第一审管辖法院。</p>
                    </div>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>
        <!-- Content End -->
        <script type="text/javascript">
            $(function(e) {
//                $(window).scroll(function() {
//                    if ($(document).scrollTop() > 140) {
//                        $('.aboutNav').css('position', 'fixed');
//                        $('.aboutNav').css('top', '0px');
//                        $('.aboutMain').css('margin-left', '190px');
//                    } else {
//                        $('.aboutNav').css('position', '');
//                        $('.aboutMain').css('margin-left', '');
//                    }
//                });
            });
        </script>
        <!-- Footer Start -->
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