<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style type="text/css">
            .table{font-size:14px}
            .table td{height:40px;padding-left: 40px;border: 1px solid #eee;padding-right:20px;text-align: left}
            .table th{width:80px;height:40px;text-align: right;border: 1px solid #eee;padding-right:20px}
            .recharge td{text-align: left;padding-left: 40px!important}
            .STYLE1 {color: #0000FF}
            .STYLE2 {color: #FF0000}
            .iw {
                display: inline-block;
                vertical-align: middle;
                width: 114px;
                height: 25px;
                padding-top: 5px;
                padding-left: 10px;
                background: url(/public/web/images/bank/bank_logo.png) no-repeat;
                border: #DDD solid 1px;
                text-indent: -9999px;
            }

           
        </style>
        <script type="text/javaScript">
            $(function () { 
                $(".ms-c6-pay li").click(function(){
                    $(".ms-c6-pay li").removeClass("selected");
                    $(this).addClass("selected");
                    
                    if($(this).attr('type') == 'online'){
                        $(".pay_con").hide();
                        $("#con_"+$(this).attr("id").replace("pay_","")).show();
                    }
                    else if($(this).attr('type') == 'offline'){
                        $(".pay_con").hide();
                        $("#con_"+$(this).attr("id").replace("pay_","")).show();
                    }
                })
                $(".ms-c6-pay li").first().click();
                //choose_type("alipay");
               
                
                $("#inMoney").keyup(function () {
                    var inMoney = $(this).val();
                    if (inMoney.match(/^\d{1,7}(\.\d{1,2})?$/)) {
                        $('#totalPay').html(inMoney - $('#commissionFee').html());
                        $("#inMoneyErr").html('');
                    } else {
                        $("#inMoneyErr").html('请输入正确的数字');
                    }
                });

                $('#banks_desc').find('table').hide();

            });
  
            function submitForm() {
                var type = $(".ms-c6-pay .selected").attr("id").replace("pay_","");
                var paytype = $(".ms-c6-pay .selected").attr("type");
                var controller = $(".ms-c6-pay .selected").attr("controller");
                var domain = $(".ms-c6-pay .selected").attr("domain");
                var channel = $(".ms-c6-pay .selected").attr("channel");
                $("#channel").val(channel);
                 
                var inMoney = $("#inMoney").val();
                var name=$("#name").val();
                if(name=="" || name==null)
                {
                    top.dialog("付款账号不能为空!");
                    return false;
                }
                if (!inMoney.match(/^\d{1,7}(\.\d{1,2})?$/)) {
                    top.dialog("充值金额格式错误");
                    return false;
                } else if (inMoney < 1) {
                    top.dialog("最低充值金额不小于1元");
                    return false;
                }
                else if(type=='jinm_zfb' && inMoney<10)
                {
                    top.dialog("最低充值金额不小于10元");
                    return false;
                }
                var url1= "<?php echo App::URL('web/user/fund'); ?>";
                var html = '<div style="text-align:center;font-size:18px;margin:80px 0">请在新打开页面完成支付</div>';
                html += '<div style="width:450px;height:100px;margin:40px;text-align:center"><ul>';
                html += '<a href="'+url1+'"><li style="display:inline-block;width:150px;height:40px;line-height:40px;text-align:center;border-radius:3px;font-size:16px;background:#ff3b3b;color:#fff;margin:0 10px">充值成功</li></a>';
                html += '<a href="javascript:dlg.destroy();"><li style="display:inline-block;width:150px;height:40px;line-height:40px;text-align:center;border-radius:3px;font-size:16px;background:#ddd;color:#555;margin:0 10px">充值失败</li>';
                html += '</ul></div>';
                dialog(html,"支付提示"); 
                
                if(paytype == 'online'){
                    var uid = $("#uid").val();
                    var money = $("#inMoney").val();
                    var name = $("#name").val();
                    window.open(domain+"/index.php?app=pay&mod="+controller+"&ac=saoma&uid="+uid+"&money="+money+"&name="+escape(name)+"&code="+type);
                    return false;
                }
                return true;
            }

        </script>
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
                        <h2><strong>账户充值</strong><span></span></h2>
                        <div class="ms-c6">
                            <div class="ms-c6-m">
                                <div class="ms-c6-pay">
                                    <ul>
                                        <?php foreach ($pay_list as $row){?>
                                        <li type="online" channel="<?php echo $row['name'];?>" id="pay_<?php echo $row['code'];?>" controller="<?php echo $row['controller'];?>" domain="<?php echo $row['domain'];?>"><?php echo $row['name'];?></li>
                                        <?php }?>
                                        <?php foreach ($account_list as $key=>$row){?>
                                        <li type="offline" channel="<?php echo $row['channel'];?>" id="pay_<?php echo $key;?>"><?php echo $row['name'];?></li>
                                        <?php }?>
                                        <div style="clear:both"></div>
                                    </ul>
                                </div>
                                <?php foreach ($pay_list as $row){?>
                                    <?php if ($row['memo']){?>
                                    <div class="pay_con" id="con_<?php echo $row['code'];?>" style="padding:20px 0px 0px 10px;display: none">
                                        <p style="color:orange"><?php echo $row['memo'];?></p>
                                    </div>
                                    <?php }?>
                                <?php }?>
                                <?php foreach ($account_list as $key=>$row){?>
                                    <?php if ($row['type']==0){?>
                                    <div class="pay_con" id="con_<?php echo $key;?>" style="padding:20px 0px 0px 10px;display: none">
                                        <table class="table">
                                         <tr>
                                                <th>公司名称：</th>
                                                <td><?php echo $row['holder'];?></td>
                                          </tr>
                                            <tr>
                                                <th>公司账号：</th>
                                                <td><?php echo $row['account'];?></td>
                                            </tr>
                                            <tr>
                                                <th>开户地址：</th>
                                                <td><?php echo $row['address'];?></td>
                                            </tr>

                                            <tr>
                                                <th>充值步骤：</td>
                                                <td><?php echo str_replace('&amp;gt;','>',str_replace('&amp;lt;', '<', $row['remark']));?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php }else{?>
                                    <div class="pay_con" id="con_<?php echo $key;?>" style="padding:20px 0px 0px 10px;display: none">
                                        <table class="table" style="width:100%">
                                            <?php if($row['holder']){?>
                                            <tr>
                                                <th style="width:120px">收款人</th>
                                                <td><?php echo $row['holder'];?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if($row['account']){?>
                                            <tr>
                                                <th style="width:120px">收款账号</th>
                                                <td><?php echo $row['account'];?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if($row['path']){?>
                                            <tr>
                                                <th style="width:120px">二维码</th>
                                                <td><img src="<?php echo $row['path'];?>" width="180"/></td>
                                            </tr>
                                            <?php }?>
                                            <tr>
                                                <th>说明</th>
                                                <td><?php echo str_replace('&quot;','"',str_replace('&amp;gt;','>',str_replace('&amp;lt;', '<', $row['remark'])))?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php }?>
                                <?php }?>

                                <h3>填写充值金额</h3>
                                <div class="formbox">
                                    <form id="chargeForm" action="<?php echo \App::URL('web/recharge/dorecharge_offline'); ?>" method="post" target="_blank" onsubmit="return submitForm();">
                                        <input id="channel" name="channel" type="hidden" value="" />
                                        <input name="uid" id="uid" type="hidden" value="<?php echo $uid; ?>" />
                                        <table class="recharge">
                                            <!--tr>
                                                <th>账户余额：</th>
                                                <td><strong class="c-red">0.00</strong>元</td>
                                            </tr-->
                                            <tr>
                                                <th>可用余额：</th>
                                                <td><strong class="c-red">0.00</strong>元</td>
                                            </tr>
                                            <tr>
                                                <th>转账金额：</th>
                                                <td>
                                                    <input type="text" id="inMoney" name="p3_Amt" value="" style="width:140px;height:25px" class="inp" maxlength="10" autocomplete="off"/>元
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>付款账号：</th>
                                                <td>
                                                    <input type="text" id="name" name="name" value="" style="width:140px;height:25px" class="inp" maxlength="20" autocomplete="off"/>
                                                </td>
                                            </tr>
                                            <tr style="display:none">
                                                <th>充值手续费：</th>
                                                <td>
                                                    <span id="commissionFee" class="c-f60">0.00</span>元
                                                    <span class="red" style="font-size:12px">（充值手续费由华亿策略承担）</span>
                                                </td>
                                            </tr>
                                            <tr style="display:none">
                                                <th>实际支付金额：</th>
                                                <td>
                                                    <span id="totalPay" class="c-f60">0.00</span>元
                                                </td>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <td>
                                                    <button id="addBankBtn" class="btn-b" type="submit">提 交</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                                <div class="ms-c6-b" id="banks_desc">
                                    <dl>
                                        <dt>温馨提示：</dt>
                                        <dd>1.为了您资金安全，请您充值前先实名认证和绑定银行卡号。</dd>
			<dd>2.转账金额最好有些零头(1000.18)，方便我们确认是您汇款。</dd>
            <dd>3.到账时间：08:00--18:00(十分钟内到账)，18:00以后(次日08:00前到账)</dd>
			<dd>4.充值过程遇到问题，请联系在线客服(微信客服、QQ客服)或拨打客服热线：4000-039-678</dd>
                                    </dl>
                                </div>
                            </div>
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