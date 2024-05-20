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
        <!--include file "user_header.php"-->
        <div class="bar">
            <div class="my-space">
                <div class="space-main clearfix">
                    <div class="space-left">
                        <!--include file "user_left_menu.php"-->
                    </div>
                    <div class="space-right">
                        <h2></notempty><strong>我的账户</strong></h2>
                        <div class="ms-c3 clearfix">
                            <div class="ms-c3-l">
                                <span>账户余额：</span>
                                <br />
                                <strong><?php echo number_format(floatval($userinfo['balance'])/100,2) ?></strong>元
                                <a href="<?php echo \App::URL("web/user/fund");?>" style="color: #069">查询资金明细</a>
                            </div>
                            <p>
                                <a href="<?php echo \App::URL("web/user/recharge"); ?>" class="s1">充值</a>
                                <a href="<?php echo \App::URL("web/user/withdrawl"); ?>" class="s2">提现</a>
                            </p>
                        </div>
                        <div class="ms-c8">
                            <dl>
                                <dd><h5>账户余额</h5><strong><?php echo number_format(floatval($userinfo['balance'])/100,2) ?></strong>元</dd>
                                <dd><h5>冻结资金</h5><strong><?php echo number_format(floatval($userinfo['frozen'])/100,2) ?></strong>元</dd>
                                <dd class="last"><h5>赠送管理费余额</h5><strong><?php echo number_format(floatval($userinfo['send'])/100,2) ?></strong>元</dd>
                                <dt><h5>总资产</h5><strong><?php echo number_format((floatval($userinfo['balance'])+floatval($userinfo['frozen'])+floatval($userinfo['send']))/100,2) ?></strong>元</dt>
                            </dl>
                        </div>
                        <div class="ms-c3-b">
                            <!-- 未完成的是：  class="sX"    完成的是：  class="sX-green"     -->
                            <?php if (\Model\User\UserInfo::checkBindInfo($userinfo['uid'])){?>
                            <dl>
                                <dt class="s1-green">
                                    <h4>实名认证<br/><span></span></h4>
                                    <span class="red">已认证</span>
                                    <a href="<?php echo \App::URL("web/user/sfz");?>">查看</a>
                                </dt>
                            </dl>
                            <?php }else{?>
                            <dl>
                                <dt class="s1">
                                    <h4>实名认证<br/><span></span></h4>
                                    <span class="red">未认证</span>
                                    <a href="<?php echo \App::URL("web/user/sfz");?>">去认证</a>
                                </dt>
                            </dl>
                            <?php }?>
                            <dl>
                                <dt class="s2-green">
                                    <h4>绑定手机<br/><span><?php echo $userinfo['user_name']; ?></span></h4>
                                    <span class="green">已绑定</span>
                                    <!--<a href="/member/validate/phone.html" data="set">修改</a>-->
                                </dt>	
                            </dl>
                            <!--<dl>
                                <dt class="s4">
                                    <h4>提现密码<br/>
                                    </h4><span class="red">未设置</span><a href="/member/account/password.html" in="pop" data="set">设置</a></dt>
                            </dl>-->
                            <?php if ($userinfo['bank_card']) { ?>
                            <dl>
                                <dt class="s3-green">
                                    <h4>绑定银行卡</h4>
                                    <span class="red">已绑定</span>
                                    <a href="<?php echo \App::URL("web/user/bank");?>" data="bind">查看</a>
                                </dt>
                            </dl>
                            <?php }else { ?>
                            <dl>
                                <dt class="s3">
                                    <h4>绑定银行卡</h4>
                                    <span class="red">未绑定</span>
                                    <a href="<?php echo \App::URL("web/user/bank");?>" data="bind">去绑定</a>
                                </dt>
                            </dl>
                            <?php }?>
                        </div>
                        <div  class="ms-c4">
                            <table>
                            <!--<tr>
                                    <th>登录名：</th>
                                    <td><strong style="color:red;font-size:17px">golimens</strong> 累计登录 1 次</td>
                                    <td class="r"><a href="/member/log.html">登录记录</a></td>
                                </tr>-->
                                <tr>
                                    <th>银行卡管理：</th>
                                    <td>余额提款到银行卡需要先绑定一张您名下的银行卡</td>
                                    <td class="r"><a href="<?php echo \App::URL("web/user/bank");?>">去绑定</a></td>
                                </tr>
                                <tr>
                                    <th>登录密码：</th>
                                    <td>登录时需要输入的密码</td>
                                    <td class="r"><a href="<?php echo \App::URL("web/user/login_password");?>">修改</a></td>
                                </tr>
                                <!--tr>
                                    <th>消息通知：</th>
                                    <td>如果您不想接收某类消息，您可以在这里设置</td>
                                    <td class="r"><a href="/member/notice.html?setting=true">通知设置</a></td>
                                </tr>
                                <tr>
                                    <th>自动投标：</th>
                                    <td>您已经开通了自动投标功能</td>
                                    <td class="r"><a href="/member/invest/auto.html">设置</a></td>
                                </tr>
                                <tr>
                                    <th>个人信息：</th>
                                    <td>完善您的详细个人信息</td>
                                    <td class="r"><a href="/member/profile.html">个人信息</a></td>
                                </tr-->
                                <tr>
                                    <th>注册时间：</th>
                                    <td><?php echo date('Y年m月d日',$userinfo['reg_time']); ?> </td>
                                    <td class="r"></td>
                                </tr>
                            </table>
                        </div>
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
        <!--include file "footer.php"-->
    </body>
</html>