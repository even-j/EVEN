<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <!--include file "common.php"-->
        <!--<link rel="stylesheet" href="/public/web/css/mn-20150101.css">-->
        <link href="/public/web/css/animate.min.css" rel="stylesheet" type="text/css">
        <style>
            body{background: #f5f5f5}
            .btn_cz{width:40%;height:30px;line-height: 30px;display: inline-block;border-radius: 4px;background: #fff;color:#ef6886;text-align: center;font-size: 14px;margin: 0px 3%;margin-top:30px}
            .zc_table{color:#fff;font-size:12px;line-height: 20px;margin-top: 5px;width:100%;text-align: left}
            .zc_table td{width:33.33%}
            /*.header{background-image: linear-gradient(140deg, #f78484 0%, #eb6497 100%);}*/
        </style>
        <script>
            function withdraw(){
                window.location.href= "<?php echo \App::URL('wap/user/withdrawl')?>";
            }
            function recharge(){
                window.location.href= "<?php echo \App::URL('wap/user/recharge')?>";
            }
        </script>
        <script>
            $(function(){
                $("#qiandao").click(function(){
                    var uid = <?php echo $userinfo['uid'];?>;
                    if(uid<=0){
                        layeralert('您还未登录！');
                        return;
                    }
                    $.post("<?php echo \App::URL('web/user/sign')?>",{},function(res){
                        if(res.ret == 0){
                            $("#sign_times").html(res.times);
                            $("#sign_money").html("+"+res.money);
                            $("#sign_money").show();
                            setTimeout(function(){
                                $("#sign_money").animate({fontSize:'40px'},1000);
                            },200)
                            setTimeout(function(){
                                $("#sign_money").animate({fontSize:'16px'},500);
                            },1200)
                            setTimeout(function(){
                                $("#sign_money").hide();
                            },1900)
                        }
                        else{
                            layeralert(res.msg);
                        }
                    },'json')
                })
            })
        </script>
    </head>
    <body>
        <!--第二行-->
        <div class="header">
            <h1>我的</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu" style="width: 120px;top:15px;right:10px;text-align: right">
                <?php echo $userinfo['user_name']; ?>
            </div>
        </div>
        <div class="clear" style="height:40px"></div>
        <div id="container" class="daywin" >
            <div class="wap_box">
                <div class="wap_photo" style="background: #ff774f;padding:0 30px;position: relative;background-image: linear-gradient(180deg, #ff835f 0%, #eb6497 100%); border-top: 1px solid #fb8b6a">
                    <div id="qiandao" style="position:absolute;top:10px;right:10px;width:50px;line-height: 20px;text-align: center;font-size:12px;border-radius: 4px;background: #fff0c9;color:#ef6886;">
                        <div style="position:absolute;left:0;top:0;display: none;color:#27b70f;font-size:16px;font-weight: bold;height: 50px;line-height: 50px;width:100%;text-align: center" id="sign_money"></div>
                        签到
                        <!--<p style="text-align: center">已连续签到<span id="sign_times"><?php echo intval($sign['times']);?></span>天</p>-->
                    </div>
                    <div class="head_text" style="color:#fff;">
                        <p style="text-align:center;font-size: 16px;padding-top: 20px">账户余额</p>
                        <p style="text-align:center;font-size: 32px;padding-top: 15px;"><?php echo number_format(floatval($userinfo['balance'])/100,2) ?></p>
                    </div>
                    <div style="text-align:center">
                        <div class="btn_cz" onClick="recharge();">充值</div>
                        <div class="btn_cz" onClick="withdraw();">提现</div>
                    </div>
                    
                </div>
                <div class="user_box">
                    <ul>
                        <li>
                            <a href="<?php echo \App::URL('wap/user/assets')?>">
                                <div class="icon"><img src="/public/wap/images/user/1_icon.png"/></div>
                                <div class="title">帐户资产</div>
                                <div class="tips"><span style="color:red;padding-right: 5px"><?php echo number_format(($userinfo['balance']+$userinfo['frozen']+$userinfo['send'])/100,2);?></span>元</div>
                                <div class="more"></div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo \App::URL('wap/user/peizi',array('pz_type'=>1))?>">
                                <div class="icon"><img src="/public/wap/images/user/2_icon.png"/></div>
                                <div class="title">策略订单</div>
                                <div class="tips"><span style="color:red;padding-right: 5px"><?php echo intval($userinfo['peizi_count']);?></span>单</div>
                                <div class="more"></div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo \App::URL('wap/user/fund',array('fundtype'=>0))?>">
                                <div class="icon"><img src="/public/wap/images/user/3_icon.png"/></div>
                                <div class="title">资金流水</div>
                                <div class="tips"></div>
                                <div class="more"></div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div style="height:10px"></div>
                <div class="user_box">
                    <ul>
                        <li>
                            <a href="<?php echo \App::URL('wap/user/sfz')?>">
                                <div class="icon"><img src="/public/wap/images/user/4_icon.png"/></div>
                                <div class="title">实名认证</div>
                                <div class="tips"><?php echo $userinfo['is_bind_idcard']?'已认证':'未认证';?></div>
                                <div class="more"></div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo \App::URL('wap/user/bank')?>">
                                <div class="icon"><img src="/public/wap/images/user/5_icon.png"/></div>
                                <div class="title">银行卡管理</div>
                                <div class="tips"><?php echo $userinfo['is_bind_bankcard']?'已绑定':'未绑定';?></div>
                                <div class="more"></div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo \App::URL('wap/user/login_password')?>">
                                <div class="icon"><img src="/public/wap/images/user/6_icon.png"/></div>
                                <div class="title">修改密码</div>
                                <div class="tips"></div>
                                <div class="more"></div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div style="height:10px"></div>
                <div class="user_box">
                    <ul>
                        <li>
                            <a href="<?php echo \App::URL('wap/index/kefu')?>">
                                <div class="icon"><img src="/public/wap/images/user/8_icon.png"/></div>
                                <div class="title">在线客服</div>
                                <div class="tips"></div>
                                <div class="more"></div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo \App::URL('wap/user/tuiguang')?>">
                                <div class="icon"><img src="/public/wap/images/user/7_icon.png"/></div>
                                <div class="title">推广链接</div>
                                <div class="tips"></div>
                                <div class="more"></div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo \App::URL('wap/help/index')?>">
                                <div class="icon"><img src="/public/wap/images/user/9_icon.png"/></div>
                                <div class="title">帮助中心</div>
                                <div class="tips"></div>
                                <div class="more"></div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo \App::URL('wap/about/index')?>">
                                <div class="icon"><img src="/public/wap/images/user/8_icon.png"/></div>
                                <div class="title">关于我们</div>
                                <div class="tips"></div>
                                <div class="more"></div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div style="text-align:center;line-height: 40px;color:#666;font-size: 16px;background: #fff;margin-top: 10px"><a href="<?php echo \App::URL('wap/member/logout')?>">退出登录</a></div>
<!--                <ul>
                        <li><a href="<?php echo \App::URL('wap/user/assets')?>">账户资产</a></li>
                        <li><a href="<?php echo \App::URL('wap/user/peizi',array('pz_type'=>1))?>">配资订单</a></li>
                        <li><a href="<?php echo \App::URL('wap/user/fund',array('fundtype'=>0))?>">资金流水</a></li>
                        <li><a href="<?php echo \App::URL('wap/user/bank')?>">银行卡管理</a></li>
                        <li><a href="<?php echo \App::URL('wap/user/sfz')?>">实名认证</a></li>
                        <li><a href="<?php echo \App::URL('wap/user/login_password')?>">修改密码</a></li>
                        <li><a href="<?php echo \App::URL('wap/user/tuiguang')?>">推广链接</a></li>
                        <li><a href="<?php echo \App::URL('wap/member/logout')?>">退出登录</a></li>
                    </ul>-->
            </div>
            <div class="clear"></div>
        </div>
        <!--investGuide-end--> 

        <!--include file "footer.php"-->

    </body>
</html>