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
                        <h2><strong>银行卡管理</strong></h2>
                        <div class="ms-c6">
                            <div class="ms-c6-m" style="padding-top: 10px">
                                <div class="formbox">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <th>您认证的银行卡：</th>
                                                <?php foreach ($bankList as $key=>$bank){?>
                                                <td>
                                                    <div class="card">
                                                        <div class="bank-logo" style="width:120px;">
                                                            <?php if(array_key_exists($bank['bank_name'],$bank_arr)){?>
                                                            <img alt="<?php echo $bank['bank_name'];?>" src="/public/web/images/bank/<?php echo $bank_arr[$bank['bank_name']];?>.png">
                                                            <?php } elseif($bank['type']==2){ ?>
                                                               虚拟币地址:
                                                            <?php } else{ ?>
                                                            <img alt="<?php echo $bank['bank_name'];?>" src="/public/web/images/bank/union.png">
                                                            <?php }?>
                                                        </div>
                                                        <span>尾号：<strong><?php echo substr($bank ['card_no'], - 4);?></strong></span>
                                                        <div class="inpbox" style="width:240px;">
                                                            <i>已绑定</i>
                                                        </div>
                                                    </div>                        
                                                </td>
                                                <?php }?>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h4>添加银行卡</h4>
                                    <span style="color:red">（温馨提示：为了您的账户资金安全，银行卡绑定仅限实名认证本人的银行帐号）</span>
                                    <form id="addMemberBank" method="POST">
                                        <input id="bankCardType" name="bankCardType" value="1" type="hidden"/>
                                        <input id="id" name="id" value="" type="hidden"/>
                                        <table>
                                            <tbody>

                                        <tr>
                                            <th>类型：</th>
                                            <td>

                                                <select class="sel" style="width:150px;height:30px;line-height:18px; padding:2px" id="type" name="type">
                                                    <option value="1">银行卡</option>
                                                    <option value="2">虚拟币地址</option>
                                                </select>
                                                <font id="province_error_msg" color="red">*</font>
                                            </td>
                                        </tr>
                                            </tbody>
                                        </table>

                                        <table id ='xunibi' style="display:none;">


                                            <tr >
                                                <th>虚拟币地址：</th>
                                                <td>
                                                    <div class="kh-box">
                                                        <div class="kh" style="display:none;"></div>
                                                        <input class="inp c-inp" maxlength="20" id="address" name="address" value="" type="text">
                                                        <font id="bankCardNumer_error_msg" color="red">*</font>
                                                    </div>
                                                </td>
                                            </tr>


                                            <tr>
                                                <th></th>
                                                <td>
                                                    <button id="saveWithdrawBank" type="button" class="btn-b">提 交</button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <table id ='yinhangka'>
                                            <tbody>
                                                <tr>
                                                    <th>帐户名：</th>
                                                    <td>
                                                        <?php echo $user['true_name'];?>
                                                    </td>
                                                </tr>




                                                <tr>
                                                    <th>开户银行：</th>
                                                    <td>
                                                        <div class="kh-box">
                                                            <div class="kh" style="display:none;"></div>
                                                            <input class="inp c-inp" maxlength="50" id="bank" name="bank" value="" type="text">
                                                                <font id="bankCardNumer_error_msg" color="red">*</font>
                                                        </div>
                                                        <!--
                                                        <div class="sbox" style="float:left;">
                                                            <div>
                                                                <input class="inp" readonly="readonly" name="bank" value="中国银行" style="width:165px;">
                                                            </div>
                                                            <div class="s-option" style="width:175px;">
                                                                <ul>
                                                                    <li li_val="cmb">招商银行</li>
                                                                    <li li_val="boc">中国银行</li>
                                                                    <li li_val="icbc">中国工商银行</li>
                                                                    <li li_val="ccb">中国建设银行</li>
                                                                    <li li_val="abc">中国农业银行</li>
                                                                    <li li_val="psbc">中国邮政储蓄银行</li>
                                                                    <li li_val="bcom">交通银行</li>
                                                                    <li li_val="spdb">上海浦东发展银行</li>
                                                                    <li li_val="sf">深圳发展银行</li>
                                                                    <li li_val="ms">中国民生银行</li>
                                                                    <li li_val="cib">兴业银行</li>
                                                                    <li li_val="pa">平安银行</li>
                                                                    <li li_val="bj">北京银行</li>
                                                                    <li li_val="tj">天津银行</li>
                                                                    <li li_val="sh">上海银行</li>
                                                                    <li li_val="hx">华夏银行</li>
                                                                    <li li_val="gd">光大银行</li>
                                                                    <li li_val="gf">广发银行</li>
                                                                    <li li_val="zx">中信银行</li>
                                                                    <li li_val="ns">上海农商银行</li>
                                                                    <li li_val="xys">农村信用社</li>
                                                                    <li li_val="other">其他</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <input class="inp c-inp" style='margin-top:3px;display: none'  type='text' name='otherbank' id='otherbank' Placeholder='请填写银行名称'/>-->


                                                        <input id="bankCode" name="bankCode" value="boc" type="hidden">
                                                           <!-- <font style="margin-top:10px;" id="bankCode_error_msg" color="red">*</font>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>开户行所在地：</th>
                                                    <td>
                                                        <select title="" class="sel" id="province" style="width:100px;height:30px;line-height:18px; padding:2px" id="province" name="province">
                                                            <option value="">请选择</option>
                                                            <?php foreach ($province as $p){
                                                                $selected = $bankinfo && $bankinfo['province_id']==$p['id'] ? 'selected="selected"' : '';	
                                                            ?> 
                                                            <option value="<?php echo $p['id']?>" <?php echo $selected;?>><?php echo $p['name']?></option>
                                                            <?php }?>	
                                                        </select>
                                                        <select class="sel" style="width:150px;height:30px;line-height:18px; padding:2px" id="city" name="city">
                                                            <option value="">请选择</option>
                                                        </select>
                                                        <font id="province_error_msg" color="red">*</font>
                                                    </td>
                                                </tr>
<!--                                                <tr>
                                                    <th>支行名称：</th>
                                                    <td>
                                                        <input class="inp" maxlength="20" id="branch" name="branch" value="" type="text">
                                                            <font id="bankBranchName_error_msg" color="red"></font>
                                                    </td>
                                                </tr>-->
                                                <tr>
                                                    <th>银行卡号：</th>
                                                    <td>
                                                        <div class="kh-box">
                                                            <div class="kh" style="display:none;"></div>
                                                            <input class="inp c-inp" maxlength="20" id="number" name="number" value="" type="text">
                                                                <font id="bankCardNumer_error_msg" color="red">*</font>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th></th>
                                                    <td>
                                                        <button id="saveWithdrawBank" type="button" class="btn-b">提 交</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="province_name" name="province_name" value="">
                                        <input type="hidden" id="city_name" name="city_name" value="">
                                        <input type="hidden" name="__hash__" value="f753a8639919e7e83497364fbd1dc74e_5242a73d036ed72d6f40c3f99e20a5d7" /></form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(function() {
                $(".sbox .inp").click(function() {
                    $(this).parents(".sbox").children(".s-option").toggleClass("show");
                });
                $(".s-option li").click(function() {
                    $(this).parents(".sbox").children().children(".inp").val($(this).html());
                    $("#bankCode").val($(this).attr('li_val'));
                    $(this).parents(".s-option").toggleClass("show");

                    if($(this).attr('li_val')=="other")
                    {
                        $("#otherbank").show();
                    }
                    else
                    {
                        $("#otherbank").hide().val("");
                    }
                });

                $('#type').change(function() {
                    if($('#type').val() ==1){

                        $("#yinhangka").show();
                        $("#xunibi").hide();
                    }else{
                        $("#yinhangka").hide();
                        $("#xunibi").show();
                    }

                });

                $('#province').change(function() {
                    $('#province_name').val($(this).find('option:selected').text());
                    getCitys($(this).val());
                    //$.get('/member/area.html?parent=' + $(this).val(), function(data) {
                    //    $('#city').html(data);
                    //});
                });
                $("#city").change(function() {
                    $('#city_name').val($(this).find('option:selected').text());
                });
                //$.get('/member/area.html?parent=1', function(data) {
                //    $('#province').html('<option value="">请选择</option>' + data);
                //});

                $('#saveWithdrawBank').click(function() {
                    if($('#type').val()==1){
                    if (!$('#city').val()) {
                        top.dialog('请选择开户行所在城市。');
                        return false;
                    }
                    if (!$('#city').val()) {
                        top.dialog('请选择开户行所在城市。');
                        return false;
                    }
                    if ($('#branch').val() == '') {
                        top.dialog('请输入支行名称。');
                        return false;
                    }
                    if ($('#number').val() == '') {
                        top.dialog('请输入正确的卡号。');
                        return false;
                    }
                    if($("input[name='bank']").val()=="其他" && $.trim($("#otherbank").val())=="")
                    {
                        top.dialog('请输入银行名称。');
                        return false;
                    }
                    }else{
                        if ($('#address').val() == '') {
                            top.dialog('请输入虚拟币地址。');
                            return false;
                        }
                    }

                    $.post('<?php echo \App::URL('web/user/bankinfoveried')?>', $('form').serialize(), function(res) {
                        if (res.code == 1) {
                            window.location.reload();
                        } else {
                            top.dialog(res.msg, 'error');
                        }
                    }, 'json');
                });
            });
            function getCitys(provinceId){
                var city_name = $('#city_name').val();
                $.ajax({
                    url: "<?php echo \App::URL('web/user/ajaxregion')?>",
                    dataType: "json",
                    data: {
                        provinceId: provinceId,
                        subLength: 4,
                        t: new Date().getTime()
                    },
                    success: function(data) {
                        $("#city").html("");
                        var str = " <option value='-1'>请选择</option>";
                        $("#city").append(str);
                        $.each(data,function(i, temp) {
                            var selected = '';
                            if(city_name==temp.name){
                                selected = 'selected="selected"';
                            }
                            var str = "<option value='" + temp.id + "' "+selected+">" + temp.name + "</option>";
                            $("#city").append(str);
                        });
                    }
                });
            }
        </script>



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