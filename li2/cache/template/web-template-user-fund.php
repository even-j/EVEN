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
                        <h2><strong>资金流水</strong></h2>
                        <div class="ms-c8">
                            <dl>
                                <dd><h5>冻结资金</h5><strong><?php echo number_format(floatval($user['frozen'])/100,2) ?></strong>元</dd>
                                <dd class="last"><h5>账户余额</h5><strong><?php echo number_format(floatval($user['balance'])/100,2) ?></strong>元</dd>
                                <dd class="last"><h5>赠送管理费余额</h5><strong><?php echo number_format(floatval($user['send'])/100,2) ?></strong>元</dd>
                                <dt><h5>总资产</h5><strong><?php echo number_format((floatval($user['balance'])+floatval($user['frozen'])+floatval($user['send']))/100,2) ?></strong>元</dt>
                            </dl>
                        </div>
                        <br>
                        <div class="ms-c6">
                            <div class="ms-c6-t">
                                <ul id="accountLogTypes">
                                    <li <?php if(!isset($_GET['fundtype']) || (isset($_GET['fundtype']) && $_GET['fundtype']==0)){echo 'class="current"';}?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>0));?>">全部</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==1){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>1));?>">充值</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==2){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>2));?>">提现</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==5){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>5));?>">冻结保证金</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==6){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>6));?>">解冻保证金</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==7){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>7));?>">补交亏损</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==10){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>10));?>">支付管理费</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==12){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>12));?>">盈利提取</a>
                                    </li>
                                </ul>
                            </div>
                            <div id="accountLogList">
                                <div class="ms-c6-m">
                                    <div class="search-r">
                                        <form id="accountLogListForm" name="accountLogListForm" action="" method="post">
                                            <input id="accountLogType" name="accountLogType" value="all" type="hidden">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <!--th>总记录数：<strong>2</strong></th>
                                                        <th>发生金额汇总：<strong>200.01 元</strong></th-->
                                                        <!--td>
                                                            <div class="sbox">
                                                                <select>
                                                                        <option value="">请选择</option>
                                                                        <option value="27">充值成功</option><option value="80">配资保证金解冻</option>                                            </select>
                                                            </div>
                                                            <div class="sbox">
                                                                <select>
                                                                    <option value="one_week">一星期</option>
                                                                    <option value="one_month">一个月</option>
                                                                    <option value="one_season">三个月</option>
                                                                    <option value="one_year">一年</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="width:68px">
                                                            <button id="queryBtn" class="btn" type="button">查询</button>
                                                        </td-->
                                                    </tr>
                                                </tbody>
                                            </table>
                                        <input type="hidden" name="__hash__" value="5731a2cb6647abfdcc77d69fa3ca772e_e081804399179a1a8845e313f4f4f43b"></form>
                                    </div>
                                    <div class="ms-c6-table clearfix">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th style="width:170px">发生具体时间</th>
                                                    <th>类型</th>
                                                    <th style="text-align:right">发生金额</th>
                                                    <th style="text-align:right">账户余额</th>
                                                    <th style="text-align:right">管理费</th>
                                                    <th>备注</th>
                                                </tr>
                                                <?php foreach ($rows as $row){?>
                                                <tr>
                                                    <td><?php echo date('Y-m-d H:i',$row['rtime'])?></td>
                                                    <td><?php echo \Model\User\Fund::fundTypeName($row['type'])?></td>
                                                    <td class="r"><b>
                                                        <?php if($row['in_or_out']>0){?>
                                                        <span style="color:red"><?php echo number_format($row['in_or_out']*floatval($row['money'])/100,2) ?></span></b>
                                                        <?php }else{?>
                                                        <span style="color:green"><?php echo number_format($row['in_or_out']*floatval($row['money'])/100,2) ?></span></b>
                                                        <?php }?>
                                                    </td>
                                                    <td class="r"><?php echo number_format(floatval($row['balance'])/100,2) ?></td>
                                                    <td class="r"><?php echo number_format(floatval($row['send'])/100,2) ?></td>
                                                    <td>
                                                        <?php 
                                                            if(intval($row['rec_id'])>0){
                                                                echo ' <a href="'.\App::URL('web/user/peizi_detail',array('pz_id'=>$row['rec_id'])).'" target="_blank">查看</a>'; 
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                        <div class="list-page">
                                            <?php echo $pager?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
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
