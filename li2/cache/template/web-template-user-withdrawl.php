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

        <style>
            .withdraw td{text-align: left;padding-left: 40px!important}
        </style>
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
        <link href="/public/web/css/user.css" rel="stylesheet" type="text/css" media="screen,projection" />
<script type="text/javascript"src="/public/web/js/common_member.js"></script>
<div class="ms-c1 bg-night">
    <div class="w1000">
        <dl>
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
            <dt>
                <span><?php echo $user['user_name'];?></span>，欢迎回来！&nbsp&nbsp&nbsp&nbsp
                <?php if (!\Model\User\UserInfo::checkBindInfo($user['uid'])){?>
                <a href="<?php echo \App::URL('web/user/sfz') ?>">如需策略，请尽快进行实名认证！</a>
                <?php }?>
            </dt>
        </dl>
    </div>
</div>
        <div class="bar">
            <div class="my-space">
                <div class="space-main clearfix">
                    <div class="space-left">
                        <dl>
    <dt class="t4"><a>操盘管理</a></dt>
    <a href="<?php echo \App::URL("web/user/peizi",array('pz_type'=>4));?>"><dd <?php if($_GET['ac']=='peizi' && $_GET['pz_type']==4){echo ' class="current"';}?>>免费体验</dd></a>
    <a href="<?php echo \App::URL("web/user/peizi",array('pz_type'=>1));?>"><dd <?php if($_GET['ac']=='peizi' && $_GET['pz_type']==1){echo ' class="current"';}?>>按天策略</dd></a>
    <a href="<?php echo \App::URL("web/user/peizi",array('pz_type'=>2));?>"><dd <?php if($_GET['ac']=='peizi' && $_GET['pz_type']==2){echo ' class="current"';}?>>按月策略</dd></a>
    <dt class="t4"><a>资金管理</a></dt>
    <a href="<?php echo \App::URL("web/user/recharge");?>"><dd <?php if($_GET['ac']=='recharge'){echo ' class="current"';}?>>账户充值</dd></a>
    <a href="<?php echo \App::URL("web/user/withdrawl");?>"><dd <?php if($_GET['ac']=='withdrawl'){echo ' class="current"';}?>>我要提款</dd></a>
    <a href="<?php echo \App::URL("web/user/fund");?>"><dd <?php if($_GET['ac']=='fund'){echo ' class="current"';}?>>资金流水</dd></a>
    <dt class="t4"><a>账户管理</a></dt>
    <a href="<?php echo \App::URL("web/user/account");?>"><dd <?php if($_GET['ac']=='account'){echo ' class="current"';}?>>我的账户</dd></a>
    <a href="<?php echo \App::URL("web/user/bank");?>"><dd <?php if($_GET['ac']=='bank'){echo ' class="current"';}?>>银行卡管理</dd></a>
    <a href="<?php echo \App::URL("web/user/sfz");?>"><dd <?php if($_GET['ac']=='sfz'){echo ' class="current"';}?>>实名认证</dd></a>
    <a href="<?php echo \App::URL("web/user/login_password");?>"><dd <?php if($_GET['ac']=='login_password'){echo ' class="current"';}?>>登陆密码</dd></a>
    <a href="<?php echo \App::URL("web/user/tuiguang");?>"><dd <?php if($_GET['ac']=='tuiguang'){echo ' class="current"';}?>>推广链接</dd></a>
</dl>
                    </div>
                    <div class="space-right">
                        <h2><strong>我要提款</strong><span>提款到指定银行卡</span></h2>
                        <div class="ms-c6">
                            <div class="ms-c6-m" style="padding-top: 10px">
                                <div class="formbox">
                                    <form id="chargeMoney" name="chargeMoney">
                                        <table class="withdraw">
                                            <tbody>
                                                <tr>
                                                    <th>可提款金额：</th>
                                                    <td>
                                                        <strong class="red"><?php echo $userinfo ['aviable_money'];?></strong> 元
                                                        <input type="hidden" name="total" id="total" value="0.00">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>提款金额：</th>
                                                    <td>
                                                        <input id="money" name="money" value="" class="inp" style="width:200px;" type="text"> 元
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>提款银行卡：</th>
                                                    <td>
                                                        <select name="bank" id="bank">
                                                            <option value="">请选择</option>
                                                            <?php foreach ($bankList as $key=>$bank){?>
                                                            <option value="<?php echo $bank['card_id'];?>"><?php echo $bank['bank_name'];?> ( <?php echo $bank['last_card_no'];?> )</option>    
                                                            <?php }?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <!--tr>
                                                    <th>绑定的手机：</th>
                                                    <td>                                
                                                                                            <input value="135*****010" type="text" disabled="disabled" class="inp" style="width:200px;background:#eee" autocomplete="off">
                                                            <input id="mobile" value="13599533010" type="hidden">
                                                            <input id="smscode" value="获取验证码" class="smscode" type="button">                            </td>
                                                </tr>
                                                <notempty name="data['phone']">
                                                <tr>
                                                    <th>验证码：</th>
                                                    <td>
                                                        <input id="code" name="smscode" class="inp" maxlength="8" style="width:200px;" type="text" autocomplete="off">
                                                    </td>
                                                </tr>
                                                </notempty-->
<!--                                                <tr>
                                                    <th>支付密码：</th>
                                                    <td>
                                                        <input id="password" name="password" class="inp" maxlength="20" style="width:200px;" type="password" autocomplete="off" >
                                                            <a href="/member/account/password.html" in="pop" data="forget">
                                                                设置支付密码                                </a>
                                                    </td>
                                                </tr>-->
                                                <tr>
                                                    <th></th>
                                                    <td>
                                                        <button id="withdraw" class="btn-b" type="button">提 交</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="__hash__" value="5b026c8aaac4b88a7c7b961518428b06_80fa7ad077399374efe035f34166dc4b" /></form>
                                </div>
                                <div class="ms-c6-dl clearfix">
                                    <dl>
                                        <dt>最快<strong>秒</strong>到账</dt>
                                        <dd>工作时间内提款秒到账(节假日无休)</dd>
                                    </dl>
                                    <dl>
                                        <dt>提款<strong>0</strong>手续费</dt>
                                        <dd>提款产生的银行手续费全免</dd>
                                    </dl>
                                    <dl>
                                        <dt>支持银行多达<strong>几十</strong>家</dt>
                                        <dd>建议您使用大型银行提款，到账最快</dd>
                                    </dl>
                                   
                                        
                                         <p>温馨提示：1、禁止洗钱、信用卡套现、虚假交易等行为.</p>

                                        <p>温馨提示：2、若资金多次直充直提，我们将视为非法洗钱行为,申请提款将收取30%的手续费.</p>

                                        <p>温馨提示：3、建议提现时间：周一至周五 08:00-18:00 周末 10:00-17:00 提现1-10分钟到账.</p>

                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
						    
                            $(function() {
                                $('#withdraw').click(function() {
                                    var balance = <?php echo $userinfo ['balance'];?>;
                                    if ($('#money').val() == '') {
                                        top.dialog('请输入本次要提现的金额。');
                                        return false;
                                    } else if ($('#money').val() > balance) {
                                        top.dialog('提现金额不能大于可提款金额。');
                                        return false;
                                    }
                                    if ($('#bank').val() == '') {
                                        top.dialog('请选择要提现到那个银行卡。');
                                        return false;
                                    }
//                                    if ($('#code').val() == '') {
//                                        top.dialog('请输入手机收到的验证码。');
//                                        return false;
//                                    }
//                                    if ($('#password').val() == '') {
//                                        top.dialog('请输入支付密码。');
//                                        return false;
//                                    }
									$('#withdraw').attr("disabled","true");
                                    $.post('<?php echo \App::URL("web/user/withdrawalsMoney");?>', $('form').serialize(), function(res) {
                                        if (res.code == 1) {
                                            window.location.href = "<?php echo \App::URL("web/user/success",array('msg'=>'提现提交成功，请等待银行转账！'))?>"
                                        } else {
                                            top.dialog(res.msg, 'error');
                                        }
                                    }, 'json');
									$('#withdraw').attr("disabled","false");

                                });
                            });
							
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $('dd').click(function() {
                    $('dd').removeClass('current');
                    $(this).addClass('current');
                    $('#mainFrame').css('height', '0px');
                    $('#loading').css('display', 'block');
                });
            });
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