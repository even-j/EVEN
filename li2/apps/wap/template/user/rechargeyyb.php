<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style type="text/css">
            .table{font-size:14px}
            .table td{height:40px;border: 1px solid #eee}
            .table th{width:80px;height:40px;text-align: right;border: 1px solid #eee}
            .STYLE1 {color: #0000FF}
            .STYLE2 {color: #FF0000}
            #con_offline td{padding:0;vertical-align: middle}
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

            /******借记卡信用卡logo******/
            .ABC { background-position: 0px 0px !important;/*农业银行*/ }
            .CCB { background-position: 0px -93px !important;/*建设银行*/ }
            .ICBC { background-position: 0px -186px !important;/*工商银行*/ }
            .BOC { background-position: -12px -279px !important;/*中国银行*/ }
            .BOCO { background-position: 0px -372px !important;/*交通银行*/ }
            .CMBCHINA { background-position: -8px -465px !important;/*招商银行*/ }
            .CMBC { background-position: 0px -558px !important;/*民生银行*/ }
            .CIB { background-position: 0px -651px !important;/*兴业银行*/ }
            .CEB { background-position: 0px -744px !important;/*光大银行*/ }
            .ECITIC { background-position: -5px -837px !important;/*中信银行*/ }
            .POST { background-position: 0px -930px !important;/*邮政储蓄银行*/ }
            .BCCB { background-position: -7px -1023px !important;/*北京银行*/ }
            .GDB { background-position: 0px -1116px !important;/*广发银行*/ }
            .SDB { background-position: 0px -1209px !important;/*深圳发展银行*/ }
            .SPDB { background-position: -5px -1302px !important;/*浦发银行*/ }
            .HXB { background-position: -5px -1395px !important;/*华夏银行*/ }
            .BJRCB { background-position: 0px -1488px !important;/*北京农商银行*/ }
            .SHB { background-position: -150px 0px !important;/*上海银行*/ }
            .CZ { background-position: -148px -93px !important;/*浙商银行*/ }
            .SDE { background-position: -137px -186px !important;/*顺德信用社*/ }
            .SCCB { background-position: -140px -372px !important;/*河北银行*/ }
            .EGB { background-position: -145px -465px !important;/*恒丰银行*/ }
            .ZJTLCB { background-position: -135px -558px !important;/*浙江泰隆商业银行*/ }
            .CBHB { background-position: -138px -651px !important;/*渤海银行*/ }
            .HKBEA { background-position: -138px -744px !important;/*东亚银行*/ }
            .NJCB { background-position: -145px -930px !important;/*南京银行*/ }
            .NBCB { background-position: -148px -1023px !important;/*宁波银行*/ }
            .GZCB { background-position: -137px -1116px !important;/*广州市商业银行*/ }
            .SRCB { background-position: -137px -1209px !important;/*上海农村商业银行*/ }
            .HZBANK { background-position: -145px -1302px !important;/*杭州银行*/ }
            .NCBBANK { background-position: -140px -1395px !important;/*南洋商业银行*/ }
            .PINGANBANK { background-position: -137px -1488px !important;/*平安银行*/ }
            /******借记卡信用卡logo结束******/
            .formbox table th ,.formbox table td{text-align: left}
        </style>
        <script type="text/javaScript">
            $(function () { 
                choose_type("online");
                $(".more-bank").show();
                //显示更多银行
                $(".ms-c6-bank .more").click(function () {
                    $(".more-bank").show();
                });
                //选择充值方式
                $(".ms-c6-bank li").click(function () {
                    $(".ms-c6-bank li").removeClass("current");
                    $("div").remove(".ico");
                    $(this).addClass("current").children("input[type='radio']").prop("checked", true);
                    $(this).append("<div class='ico'></div>");
                    $("#selectedBank").val($("input:radio[name='bank']:checked").val());
                    var sel_bank_val = $("input:radio[name='bank']:checked").val();
                    $("#banks_desc").find('table').hide();
                    $("#" + sel_bank_val + "_desc").show();
                });

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
                var paytype = $(".ms-c6-pay .selected").attr("id");
                if(paytype == "online" && $("#pay_bus").val() == 'xinqidian'){ //新起点需要选择银行
                   var chargeBank = $("input:radio[name='bank']:checked").val();
                    if (typeof (chargeBank) == "undefined" || chargeBank == null) {
                        top.dialog("请先选择充值银行");
                        return false;
                    } 
                }
                 
                var inMoney = $("#inMoney").val();
                if (!inMoney.match(/^\d{1,7}(\.\d{1,2})?$/)) {
                    top.dialog("充值金额格式错误");
                    return false;
                } else if (inMoney < 1) {
                    top.dialog("最低充值金额不小于1元");
                    return false;
                } 
                else if (inMoney > 49999) {
                    top.dialog("最低充值金额不大于49999元");
                    return false;
                }
                var url1= "<?php echo App::URL('wap/user/fund'); ?>";
                var html = '<div style="text-align:center;font-size:18px;margin:80px 0">请在新打开页面完成支付</div>';
                html += '<div style="width:450px;height:100px;margin:40px;text-align:center"><ul>';
                html += '<a href="'+url1+'"><li style="display:inline-block;width:150px;height:40px;line-height:40px;text-align:center;border-radius:3px;font-size:16px;background:#ff3b3b;color:#fff;margin:0 10px">充值成功</li></a>';
                html += '<a href="javascript:dlg.destroy();"><li style="display:inline-block;width:150px;height:40px;line-height:40px;text-align:center;border-radius:3px;font-size:16px;background:#ddd;color:#555;margin:0 10px">充值失败</li>';
                html += '</ul></div>';
                dialog(html,"支付提示"); 
                return true;
            }
             
            var url = '';
            //选择充值方式
            function choose_type(type) {
                $(".ms-c6-pay li").removeClass("selected");
                $("#"+type).addClass("selected");

                if (type == 'offline') {
                    $("#chargeForm").attr("action","<?php echo \App::URL('web/recharge/dorecharge_offline'); ?>") ; 
                    $("#con_offline").show();
                    $("#con_online_xinqidian").hide();
                }
                else if(type == 'weixin') {
                    if($("#pay_bus_wx").val() == 'ddbill'){
                        $("#chargeForm").attr("action","http://pay.autoamrb.com.cn<?php echo \App::URL('web/recharge/recharge_weixin'); ?>") ;
                        $("#con_offline").hide();
                        $("#con_online_xinqidian").hide();
                    }
                    else if($("#pay_bus_wx").val() == 'mbupay'){
                        $("#chargeForm").attr("action","http://www.bxpz.com<?php echo \App::URL('web/recharge/dorecharge_weixin2'); ?>") ;
                        $("#con_offline").hide();
                        $("#con_online_xinqidian").hide();
                    }
                } 
                else if(type == 'alipay') {
                    if($("#pay_bus_zfb").val() == 'ddbill'){
                        $("#chargeForm").attr("action","http://pay.autoamrb.com.cn<?php echo \App::URL('web/recharge/recharge_alipay'); ?>") ;
                        $("#con_offline").hide(); 
                        $("#con_online_xinqidian").hide();
                    }
                    else if($("#pay_bus_zfb").val() == 'mbupay'){
                        $("#chargeForm").attr("action","http://www.bxpz.com<?php echo \App::URL('web/recharge/dorecharge_alipay2'); ?>") ;
                        $("#con_offline").hide();
                        $("#con_online_xinqidian").hide();
                    }
                }
                else if(type == 'online'){
                    if($("#pay_bus").val() == 'ddbill'){
                        $("#chargeForm").attr("action","http://pay.dyctkjpay.top<?php echo \App::URL('web/recharge/dorecharge'); ?>") ;
                        $("#con_offline").hide();
                        $("#con_online_xinqidian").hide();
                    }
                    else if($("#pay_bus").val() == 'yeepay'){
                        $("#chargeForm").attr("action","http://pay3.tonl44.top<?php echo \App::URL('web/recharge/dorecharge_yeepay'); ?>") ;
                        $("#con_offline").hide();
                        $("#con_online_xinqidian").hide();
                    }
					else if($("#pay_bus").val() == 'yyb'){
                        $("#chargeForm").attr("action","<?php echo \App::URL('web/recharge/dorecharge_yyb'); ?>") ;
                        $("#con_offline").hide();
                        $("#con_weixin").hide();
                        $("#con_alipay").hide();
                        $("#con_online_xinqidian").hide();
						$("#con_yyb").hide();
                        $("#channel").val("");
                    }
                }
				
            }
        </script>
    </head>

    <body class="index">
        <div class="header">
            <h1>充值</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height: 40px"></div>
        <div class="space-main clearfix" style="margin: 10px">
            <div class="ms-c6">
                <div class="ms-c6-m">
                    <div class="more-bank">
                        <div class="ms-c6-pay">
                            <ul>
                                <li class="selected" id="online" onclick="choose_type('online')">支付宝<i class="iconcheck"></i></li>
                                <div style="clear:both"></div>
                            </ul>
                        </div>
                        <div id="con_online_xinqidian">
                            <h3>选择充值银行</h3>
                            <div class="ms-c6-bank">
                                <ul class="clearfix">
                                    <li title="工商银行">
                                        <input type="radio" name="bank" class="radio" value="icbc"/>
                                        <div class="iw ICBC" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="工商银行"></div>
                                    </li>
                                    <li title="农业银行">
                                        <input type="radio" name="bank" class="radio" value="abc"/>
                                        <div class="iw ABC" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="农业银行"></div>
                                    </li>
                                    <li title="中国银行">
                                        <input type="radio" name="bank" class="radio" value="boc"/>
                                        <div class="iw BOC" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="中国银行"></div>
                                    </li>
                                    <li title="建设银行">
                                        <input type="radio" name="bank" class="radio" value="ccb"/>
                                        <div class="iw CCB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="建设银行"></div>
                                    </li>
                                    <li title="招商银行">
                                        <input type="radio" name="bank" class="radio" value="cmb"/>
                                        <div class="iw CMBCHINA" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="招商银行"></div>
                                    </li>
                                    <li title="交通银行">
                                        <input type="radio" name="bank" class="radio" value="bcom"/>
                                        <div class="iw BOCO" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="交通银行"></div>
                                    </li>
                                    <li title="兴业银行">
                                        <input type="radio" name="bank" class="radio" value="cib"/>
                                        <div class="iw CIB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="兴业银行"></div>
                                    </li>
                                    <li title="光大银行">
                                        <input type="radio" name="bank" class="radio" value="ceb"/>
                                        <div class="iw CEB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="光大银行"></div>
                                    </li>
                                    <li title="中信银行">
                                        <input type="radio" name="bank" class="radio" value="citic"/>
                                        <div class="iw ECITIC" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="中信银行"></div>
                                    </li>
                                    <li title="民生银行">
                                        <input type="radio" name="bank" class="radio" value="cmbc"/>
                                        <div class="iw CMBC" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="民生银行"></div>
                                    </li>
                                    <li title="邮储银行">
                                        <input type="radio" name="bank" class="radio" value="psbc"/>
                                        <div class="iw POST" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="邮储银行"></div>
                                    </li>

                                    <li title="广发银行">
                                        <input type="radio" name="bank" class="radio" value="1114"/>
                                        <div class="iw GDB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="广发银行"></div>
                                    </li>
                                    <li title="上海浦东发展银行">
                                        <input type="radio" name="bank" class="radio" value="1109"/>
                                        <div class="iw SPDB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="上海浦东发展银行"></div>
                                    </li>
                                    <li title="平安银行">
                                        <input type="radio" name="bank" class="radio" value="1121"/>
                                        <div class="iw PINGANBANK" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="平安银行"></div>
                                    </li>
                                    <li title="南京银行">
                                        <input type="radio" name="bank" class="radio" value="1115"/>
                                        <div class="iw NJCB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="南京银行"></div>
                                    </li>
                                    <li title="上海银行">
                                        <input type="radio" name="bank" class="radio" value="1116"/>
                                        <div class="iw SHB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="上海银行"></div>
                                    </li>
                                    <li title="渤海银行">
                                        <input type="radio" name="bank" class="radio" value="1123"/>
                                        <div class="iw CBHB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="渤海银行"></div>
                                    </li>
                                    <li title="华夏银行">
                                        <input type="radio" name="bank" class="radio" value="1111"/>
                                        <div class="iw HXB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="华夏银行"></div>
                                    </li>
                                    <li title="北京农商银行">
                                        <input type="radio" name="bank" class="radio" value="1124"/>
                                        <div class="iw BJRCB" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="北京农商银行"></div>
                                    </li>
                                    <li title="东亚银行">
                                        <input type="radio" name="bank" class="radio" value="1122"/>
                                        <div class="iw HKBEA" style=" padding-top:3px; padding-bottom:3px; margin-left:10px" title="东亚银行"></div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div id="con_offline" style="padding:20px 0px 0px 10px;display: none">
                            <table class="table">
                                                                    <tr>
                                    <th>账户名称：</th>
                                    <td>深圳市恭贺投资有限公司</td>
                              </tr>
                                <tr>
                                    <th>银行账号：</th>
                                    <td>44250100015900000938</td>
                                </tr>
                                <tr>
                                    <th>开户银行：</th>
                                    <td>中国建设银行股份有限公司深圳坂田支行</td>
                                </tr>

                                <tr>
                                    <th>充值步骤：</td>
                                    <td style="text-align:left">
                                        <p class="STYLE2">①通过网上银行向华亿策略对公账号转账，请务必选择实时到账选项；（华亿策略不收任何手续费）</p>
                                        <p class="STYLE2">②请确认转账成功后，再点击提交等待审核到账；（工作时间及时到账）</p>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>

                    <div style="margin:10px 0">填写充值金额</div>
                    <form id="chargeForm" method="post" target="_blank" onsubmit="return submitForm();">
                        <div class="formbox">
                            <input id="pay_bus" type="hidden" value="yyb" />
                            <input id="pay_bus_wx" type="hidden" value="<?php echo $pay_bus_wx; ?>" />
                            <input id="pay_bus_zfb" type="hidden" value="<?php echo $pay_bus_zfb; ?>" />
                            <input name="uid" type="hidden" value="<?php echo $uid; ?>" />

                            <input type="hidden" id="selectedBank" name="pd_FrpId" value=""/>
                            <table>
                                <!--tr>
                                    <th>账户余额：</th>
                                    <td><strong class="c-red">0.00</strong>元</td>
                                </tr-->
                                <tr>
                                    <th>可用余额：</th>
                                    <td><strong style="color: #F00;font-size: 20px;margin-right: 5px;">0.00</strong>元</td>
                                </tr>
                                <tr>
                                    <th>充值金额：</th>
                                    <td>
                                        <input type="text" id="inMoney" name="p3_Amt" value="" style="width:80%px;height:25px" class="inp" maxlength="10" autocomplete="off"/>元
                                    </td>
                                </tr>
                                <tr style="display:none">
                                    <th>充值手续费：</th>
                                    <td>
                                        <span id="commissionFee">0.00</span>元
                                        <span class="red" style="font-size:12px">（充值手续费由华亿策略承担）</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>实际支付金额：</th>
                                    <td>
                                        <span id="totalPay" style="color: #F60;margin-right: 5px;">0.00</span>元
                                    </td>
                                </tr>

                            </table>
                        </div>
                        <div style="margin: 10px auto;width:80%" >
                            <button id="addBankBtn" class="btn-b" type="submit">提 交</button>
                        </div>
                    </form>
                    
                    <div class="ms-c6-b" id="banks_desc">
                        <dl style="background: #fff;">
                            <dt>温馨提示</dt>
                            <dd style="color:red">充值5000元以上建议选择对公账号充值，享受赠送0.5%现金，最高500元封顶。如：充值10000元可得50元现金！</dd>
                            <dd>1、为了您的资金安全，您的账户资金将专款专户管理</dd>
                            <dd>2、请使用PC端IE浏览器进行充值，未返回充值成功页面之前勿关闭页面；普通版网银有限额，请使用U盾或专业版网银</dd>
                            <dd>3、禁止洗钱、信用卡套现、虚假交易等行为，一经发现并确认，将终止该账户的使用</dd>
                            <dd>4、为了您的资金安全，建议充值前进行实名认证</dd>
                            <dd>5、如果充值遇到任何问题，请致电服务热线或联系在线客服为您解决</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>