
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <script type="text/javascript">
        //#####------------------------------------------------------------------------------------------------------
        $(function () {
            $('#subBtn').on('click', function () {
                var status = <?php echo $params['status'] ?>;
                var isChaogeshu = <?php echo $var['isChaogeshu'] ?>;
                //活动暂停
                if(status==0){
                    return;
                }
                //超当天体验数
                if(isChaogeshu==1){
                    return;
                }
                var cpj = <?php echo $params['service_cost_rate']?>;//操盘金
                var deposit = <?php echo $params['baozheng_free']?>;//保证金
                var jgx = 0;//警告线
                var pcx = 0;//平仓线
                var glf = 0;//管理费
                var risk = cpj/deposit;//配资比例
                var duration = <?php echo $params['free_day']?>;//时间周期
                var params = "&cpj="+cpj+"&deposit="+deposit+"&jgx="+jgx+"&pcx="+pcx+"&glf="+glf+"&risk="+risk+"&duration="+duration;
                window.location.href="<?php echo \App::URL('web/peiziu/peizi');?>&pz_type=4"+params;
                return false;
            });
        });

        </script> 
    </head>

    <body class="index">
        <!-- Header Start -->
        <div id="top">
            <!--include file "header.php"-->
            <!--include file "nav.php"-->
        </div>
        <div style="margin:0 auto;text-align: center;height: 280px;background-image: url('/public/web/images/experience1.png');background-repeat: no-repeat;background-position: center">
        </div>
        <link href="/public/web/css/event.css" rel="stylesheet" type="text/css" media="screen,projection" />

        <!-- Content Start -->
        <div class="bar">
            <div class="borBox" id="experienceBox">
                <dl id="textBox">
                    <dt>每个新用户只有一次体验机会（机不可失）</dt>
                    <dd><?php echo SITE_NAME?>出<b class="font1"><?php echo $params['service_cost_rate']?></b>元<span>（完全免费）</span></dd>
                    <dd>您支付<b class="font1"><?php echo $params['baozheng_free']?></b>元<span>（体验费，体验结束全额退还）</span></dd>
                    <dd>总计<b class="font1"><?php echo $params['service_cost_rate']?></b>元<span>（由您操盘）</span></dd>
                    <dd>交易<b class="font1"><?php echo $params['free_day']?></b>天<span>（第二个交易日14:00前必须卖出股票）</span></dd>
                    <dd>盈利全归你，超额亏损算我们</dd>
                    <?php if (apps\Config::getInstance()->free_profit_to=='send'){?>
                    <dd>盈利部分不能提现，只能当管理费使用</dd>
                    <?php }?>
                </dl>

                <div class="ruleText">
                    <!--p>免费体验"股票交易账户"会在下个交易日9点15分前开出</p-->
                    <?php if($params['status']==1){?>
                        <?php if($var['isChaogeshu']==1){?>
                            <p>今日体验操盘帐号已分配完毕，请明日再来</p>
                            <p>小贴士：由于申请免费体验操盘人数众多，建议早上9点前申请</p>
                            <a class="btn btnBg2" id="subBtn">免费体验</a>
                        <?php }else{?>
                            <p>只需支付<?php echo $params['baozheng_free']?>元就可以立刻获得<?php echo $params['service_cost_rate']?>元体验操盘帐号</p>
                            <a class="btn btnBg1" id="subBtn">免费体验</a>
                        <?php }?>    
                    <?php }else{?>
                        <p>活动暂停</p>
                        <a class="btn btnBg2" id="subBtn">免费体验</a>
                    <?php }?>
                </div>
            </div>
        </div>
        <!-- Content End -->
        <!--include file "footer.php"-->
    </body>
</html>