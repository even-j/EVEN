
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

        <link rel="stylesheet" type="text/css" href="/public/web/css/stock.css"></link>
        <link rel="stylesheet" type="text/css" href="/public/web/css/main.css"></link>
        <script type="text/javascript" src="/public/web/js/stock.js"></script>
        <script type="text/javascript" src="/public/web/js/main.js"></script>
        <script language="javascript" type="text/javascript">
            $(function () {
                $('#submitBtn').click(function () {
                    if (!$('#id_agree_contract').is(':checked')) {
                        dialog('请先认真阅读借款协议，并同意借款协议内容。');
                        return false;
                    }
                    var deposit = <?php echo $var['deposit']?>;
                    var pz_ratio = <?php echo $var['pz_ratio']?>;
                    var pz_type = <?php echo $var['pz_type']?>;
                    var duration = <?php echo $var['duration'];?>;
                    var trade_time = <?php echo $var['trade_time'];?>;
                    var url = "<?php echo \App::URL('web/peiziu/daywinadd')?>";
                    $.post(url,{deposit:deposit,duration:duration,pz_ratio:pz_ratio,pz_type:pz_type,trade_time : trade_time},function(res){
                        if(res.status == 0){
                            dialog(res.msg);
                        }
                        else{
                            window.location.href = "<?php echo \App::URL('web/user/peizi');?>" + "&pz_type="+pz_type;
                            //window.location.href = "<?php echo \App::URL('web/peiziu/daywin3');?>&pz_id="+res.msg+"&pz_type=<?php echo $var['pz_type'] ?>";
                        }
                    },'json');
                    //$("form").submit();

                });
                
                X.init();
                X.slideUP.init("pz_scroll");
                X.prompt.init('tip_1', '', {width: 250, close: false, dire: 4, reget: true});
                X.prompt.init('tip_2', '', {width: 250, close: false, dire: 4, reget: true});
                X.prompt.init('tip_3', '', {width: 250, close: false, dire: 4, reget: true});
                X.prompt.init('tip_4', '', {width: 250, close: false, dire: 4, reget: true});
                X.prompt.init('tip_5', '', {width: 250, close: false, dire: 4, reget: true});
            });
            
            
        </script>
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
        
        <style>
            h4 { margin: 30px 0 15px 25px; font-size: 18px }
            table { margin-top: 2px }
            td option { padding: 3px 15px 3px 3px }
            .ddw_l .pz_sel li { width: 110px; height: 80px; margin-right: 20px; margin-bottom: 15px; border: 1px solid #D7D7D7; float: left; text-align: center; cursor: pointer }
            .ddw_l .pz_sel li p.m { padding-top: 20px }
            .sure td { padding-left: 15px; border-bottom: 1px solid #E4E4E4; height: 50px; line-height: 49px }
            .sure .title { font-size: 14px }
            .ddw_r { width: 430px; float: left; margin-bottom: 20px; margin-left: 18px; }
            .ddw_l { width: 435px; float: left; margin-right: 10px }
            .pz_inp { width: 378px; height: 372px; border: 1px solid #D7D7D7 }
            .pz_bj { border: 1px solid #D7D7D7; height: 90px; }
            .pz_pz { border: 1px solid #D7D7D7; height: 158px; }
            .pz_pztxt { font-size: 20px; font-weight: bold; text-align: center; height: 60px; line-height: 49px; color: #676767; }
        </style>
        <!--中部开始-->
        <div class="peizibox conbox" style="margin-top:10px;">
            <img width="100%" src="/public/web/images/add/peiziimg3.jpg"/>
        </div>
        <div class="peizibox conbox" style="margin-top:10px;">
            <?php if(empty($error_msg)){ ?>
            <div class="pl50 pr50">
                <div class="experienceText" style="width:846px;margin-right:58px">
                    <p class="account">
                        支付策略保证金<b><?php echo number_format($var['deposit'],2)?></b>元
                        <?php if($_GET['pz_type']==1 || $_GET['pz_type']==4){?>
                        和管理费 <b><?php echo number_format($_GET['glf'],2)?></b>元
                        <?php }else{ ?>
                        和利息 <b><?php echo number_format($_GET['glf'],2)?></b>元
                        <?php }?>
                        ，当前账户可用余额为<b><?php echo number_format(floatval($user['balance'])/100,2) ?></b>元</p>
                    <?php if(($var['bond']+$var['manage_cost_money'])>$user['balance']){?>
                    <p>本次支付还差<b id="left"><?php echo number_format($var['bond']+$var['manage_cost_money']-$user['balance'],2);?></b>元 
                        <a class="btn btnBg1" href="<?php echo \App::URL("web/user/recharge",array("money"=>$var['bond']+$var['manage_cost_money']-$user['balance'])); ?>" target="_blank">马上充值</a></p>
                    <?php }?>

                </div>
                <div class="clearfix" style="margin:20px 0 0 0;height:300px;">
                    <div class="ddw_l">
                        <div class="pz_bj">
                            <p class="t" STYLE="padding-top:25px">
                                <em><?php echo number_format($_GET['deposit'],2)?></em>元
                            </p>
                            <p>投资本金</p>
                        </div>
                        <div class="pz_pztxt">策略</div>
                        <div class="pz_pz">
                            <p class="t">
                                <em><?php echo number_format($_GET['cpj'],2)?></em>元
                            </p>
                            <p>策略金额</p>
                        </div>
                    </div>
                    <div class="ddw_r">
                        <table width="100%" cellspacing="0" cellpadding="0" class="sure">

                            <tr>
                                <td class="title">操盘须知</td>
                                <td>
                                    投资沪深A股，盈利全归您<!--div style="line-height:130%;">投资沪深A股，仓位不限制，盈利全归您</div-->
                                </td>
                            </tr>
                            <tr>
                                <td class="title">总操盘资金</td>
                                <td><em><?php echo number_format($_GET['cpj'],2)?></em> 元</td>
                            </tr>
                            <tr>
                                <td class="title">亏损警告线</td>
                                <td><em><?php echo number_format($_GET['jgx'],2)?></em> 元                                <span style="cursor: pointer;" class="icon icon-help-s ml5" data-text="当总操盘资金低于警戒线以下时，只能平仓不能建仓" id="tip_1"></span></td>
                            </tr>
                            <tr>
                                <td class="title">亏损平仓线</td>
                                <td><em><?php echo number_format($_GET['pcx'],2)?></em> 元                                <span style="cursor: pointer;" class="icon icon-help-s ml5" data-text="当总操盘资金低于平仓线以下时，我们将有权把您的股票进行平仓，为避免平仓发生，请时刻关注本金是否充足" id="tip_2"></span></td>
                            </tr>

                            <tr>
                                <td class="title">管理费</td>
                                <td>
                                    <?php if($_GET['pz_type']==1){?>
                                        <?php echo number_format($_GET['glf'],2)?> 元
                                    <?php }elseif($_GET['pz_type']==2){?>
                                        <?php echo number_format($_GET['glf'],2)?> 元
                                    <?php }elseif($_GET['pz_type']==4){?>
                                        免费
                                    <?php }?>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="title">资金使用期限</td>
                                <td>
                                    <input type="hidden" value="5" name="duration" id="duration"/>
                                    <i class="fs20"><?php echo $_GET['duration']?></i> 
                                    <?php if($_GET['pz_type'] ==1 || $_GET['pz_type'] ==4){ echo '天';}else{echo '个月';}?>
                                </td>
                            </tr>
<!--                            <tr>
                                <td class="title">开始交易时间</td>
                                <td>
                                    <input type="hidden" value="1" name="start"/> 下个交易日                            </td>
                            </tr>-->
                            <!--tr>
                                <td class="title">还款方式</td>
                                <td>
                                    <label id="nday">到期还本。</span>
                                </td>
                            </tr-->

                        </table>
                    </div>
                </div>
            </div>
            <form action="/stock/done.html" method="POST">
                <div class="ruleText" style="clear:both">
                    <p><b class="font1" id="id_agree_contract_error">请在阅读并同意借款协议后继续操作</b></p>
                    <p class="jkxy">
                        <input type="checkbox" value="1" checked="checked" id="id_agree_contract"/>
                        <label for="id_agree_contract" style="cursor:pointer;">我已阅读并同意</label><a href="<?php echo \App::URL('web/help/contract');?>" target="_blank">《借款协议》</a>
                        <br>                
                    </p>
                    <input type="button" id="submitBtn" class="btn btnBg1" value="确定"/>
                </div>
            </form>
            <?php }else{ ?>
            <div style="padding:150px 0px;text-align: center;font-size: 18px;color:red">
                <?php echo $error_msg;?>
            </div>
            
            <?php }?>
        </div>

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