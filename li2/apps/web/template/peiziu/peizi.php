
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
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
            <!--include file "header.php"-->
            <!--include file "nav.php"-->
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

        <!--include file "footer.php"-->
    </body>
</html>