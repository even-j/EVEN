<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <link rel="stylesheet" type="text/css" href="/public/wap/css/web/newindexV2.css">
        <link rel="stylesheet" href="/public/wap/css/web/serviceCenter.css">
        <link rel="stylesheet" href="/public/wap/css/web/daywin_2015.css">
        <link rel="stylesheet" href="/public/wap/css/wap_style.css">
        <!--include file "common.php"-->
        <style>
            html,body{height: 100%}
            .arrow_down{height: 40px;width:16px;position: absolute;right: 10px;top:0;background-image: url('/public/wap/images/arrow_down.png');background-position: center;background-repeat: no-repeat;opacity: 0.5}
            .arrow_up{height: 40px;width:16px;position: absolute;right: 10px;top:0;background-image: url('/public/wap/images/arrow_up.png');background-position: center;background-repeat: no-repeat;opacity: 0.5}
            .ddw_l li em {
                color: #FF6600;
                font-size: 26px;
            }
        </style>
    </head>
    <body style="background: #fff">
        <div class="header">
            <h1><?php echo SITE_NAME;?></h1>
            <a class="l-link" href="<?php echo \App::URL('wap/index/view');?>"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height:40px;"></div>
        <!--include file "peizi_menu.php"-->
        <div style="padding:0px 20px;">
            <input type="hidden" value="8" name="type"/>
            <input type="hidden" value="0" name="fee" id="fee"/>
            <input type="hidden" value="0" name="deposit" id="ideposit"/>
            <input type="hidden" value="0" name="risk"/>
            <input type="hidden" value="0" name="quota" id="quota"/>
            <p class="wap_ddw_l">1.输入保证金</p>
            <div class="ddw_l" id="money_input">
                <div class="mt10" style="position:relative;">
                    <input name="zhi" id="money" type="text" class="ui-input" value="" placeholder="<?php echo $params['minLimitMoney']/100?>~<?php echo $params['maxLimitMoney']/10000/100?>万" style="height:40px; line-height:40px; width:98%; text-align:center;font-size: 16px;border-radius: 3px;border: 1px solid #ddd;">
                    <div style="width:50px; line-height:38px; height:30px; position:absolute;right:5px; _right:25px; top:3px; _top:6px;">元 </div>
                </div>
            </div>
            <p class="wap_ddw_l">2.选择杠杆，资金放大5-10倍</p>
            <div id="div_risk">
                <ul class="clearfix">
                    <li class="active" data-times="5">
                        <strong>5</strong>倍
                        <p>月利率 <?php echo $params['manage_cost_money5']; ?>%</p>
                    </li>
                    <li data-times="6">
                        <strong>6</strong>倍
                        <p>月利率 <?php echo $params['manage_cost_money6']; ?>%</p>
                    </li>
                    <li data-times="7">
                        <strong>7</strong>倍
                        <p>月利率 <?php echo $params['manage_cost_money7']; ?>%</p>
                    </li>
                    <li data-times="8">
                        <strong>8</strong>倍
                        <p>月利率 <?php echo $params['manage_cost_money8']; ?>%</p>
                    </li>
                    <li data-times="9">
                        <strong>9</strong>倍
                        <p>月利率 <?php echo $params['manage_cost_money9']; ?>%</p>
                    </li>
                    <li data-times="10">
                        <strong>10</strong>倍
                        <p>月利率 <?php echo $params['manage_cost_money10']; ?>%</p>
                    </li>
                </ul>
            </div>
            <p class="wap_ddw_l">3.选择操作期限</p>
            <span>期限：</span>
            <select id="duration" class="sel-b" name="duration" style="width:120px;height:26px;font-size: 14px">
                <option value="1">1 月</option>
                <option value="2">2 月</option>
                <option value="3">3 月</option>
                <option value="4">4 月</option>
                <option value="5">5 月</option>
                <option value="6">6 月</option>
                <option value="7">7 月</option>
                <option value="8">8 月</option>
                <option value="9">9 月</option>
                <option value="10">10 月</option>
                <option value="11">11 月</option>
                <option value="12">12 月</option>
            </select>
            <p class="wap_ddw_l">4.选择开始交易时间</p>
            <div id="div_trade_time">
                <ul class="clearfix">
                    <li type="0" class="active">立即生效</li>
                    <li type="1">下个交易日</li>
                </ul>
            </div>
            <p class="wap_ddw_l">5.确认操盘信息</p>
            <div style="padding:0 10px" >
                <table class="sure" width="100%" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td class="title">总操盘资金</td>
                            <td><em id="totalAmount">0</em>元</td>
                        </tr>
                        <tr>
                            <td class="title">风险保证金</td>
                            <td><em id="bzjOK">0</em>元</td>
                        </tr>
                        <tr>
                            <td class="title">亏损警戒线</td>
                            <td><em id="warnLine">0</em>元</td>
                        </tr>
                        <tr>
                            <td class="title">亏损平仓线</td>
                            <td><em id="outLine" style="color:#FF0000;">0</em>元</td>
                        </tr>
                        <tr>
                            <td class="title">操盘周期</td>
                            <td><em id="cycle" style="color:#FF0000;">0</em>个月</td>
                        </tr>
                        <tr>
                            <td class="title">账户管理费</td>
                            <td><i id="accountManageFees" class="fs20">0元</i> </td>
                        </tr>
                    </tbody>
                </table>
                <p id="demo" style="font-size:14px;color:#ff3b3b;line-height: 20px;padding: 8px 0 0 0"></p>
                <div style="padding:0px 0px;">
                    <?php if($uid){?>
                    <div style="text-align: center;margin:10px 0">
                        <label style="font-size: 14px;">
                            <input id="agree" type="checkbox" checked="checked">
                            我已阅读并同意 </label>
                        <a target="_blank" href="<?php echo App::URL('web/help/contract')?>" class="link-blue" style="color:blue;font-size: 14px;">《借款协议》</a>
                    </div>
                    <?php }?>
                    <div style="margin: 10px 0px;color:#777;line-height: 26px;font-size: 14px">
                        如您不清楚规则，或有其它疑问，请联系客服
                    </div>
                    <div class="txt-c pdd_20 pt20" style="margin-top:10px">
                        <input type="button" class="btn btn-l" value="我要操盘" id="subBtn" style=" width:100%;display:">
                    </div>
                </div>
            </div>
        </div>
        
        <div onClick="show_rule();" style="position: relative;height: 40px;line-height: 40px;font-size: 16px;background: #f4ddce;border:1px solid #ccc;color:#555;padding:0 10px;margin-bottom: 10px;display: none">
            规则须知
            <div id="rule_arrow" class="arrow_down"></div>
        </div>
        <div id="rule" style="display: none;clear:both;color: #676767;line-height: 29px;padding-left: 8px;margin-bottom: 10px">
            <p>1、风险提示：股市有风险，投资需谨慎！百姓策略股票操盘操作中只收取利息，无其他任何费用。</p>
            <p>2、您的投资本金：您自己投资股票的资金，必须是100的整数倍。</p>
            <p>3、资金使用期限：资金使用期限按交易日计算（节假日免息）。</p>
            <p>4、每天支付管理费：如1月13日操盘，1月13日支付当日管理费，1月14日支付第2日管理费，以此类推。</p>
            <p>5、亏损警告线：当总操盘资金低于警戒线以下时，只能平仓不能建仓，需要尽快补充风险保证金，以免低于亏损平仓线被平仓。</p>
            <p>6、亏损平仓线：当总操盘资金低于平仓线以下时，我们将有权把您的股票进行平仓，为避免平仓发生，请时刻关注保证金是否充足。</p>
            <p>7、开始交易时间：交易日当天15:00之前的申请于当日生效（当天开始收取账户管理费），交易日当天15:00后的申请于下个交易日生效。</p>
            <p>8、操盘到期：操盘到期时，需在到期当日把所有证券账户变现为现金，且不能再做挂单和买入操作，否则自动延期扣除管理费。</p>
            <p style="display:none;"><a target="_blank" href="/help/funding.html#pz-step1">更多规则说明</a></p>
        </div>
        <!--investGuide-end-->
        <!--include file "footer.php"-->
        <!------------------------------------------------------------------------------------------------------> 
        <script type="text/javascript">
            $(function(){
                //#####-选择资金------------------------------------------------------------------------------------------
                $("#reback").click(function(){
                    //显示选择控件
                    $("#pz_sel").show();
                    $("#money_input").hide();
                })
                //开始交易时间
                $("#div_trade_time li").click(function(){
                    $("#div_trade_time li").removeClass("active");
                    $(this).addClass("active");
                    var trade_time = $(this).attr("type");
                    $("#hid_trade_time").val(trade_time);
                })
            })
            function close_confirm(){
                //关闭确认框
                $("#confirm_bg").hide();
                $("#confirm_con").hide();
            }
            //规则显示
            function show_rule(){
                $("#rule").toggle();
                if($("#rule").is(":hidden")){
                    $("#rule_arrow").removeClass("arrow_up").addClass("arrow_down");
                }
                else{
                    $("#rule_arrow").addClass("arrow_up").removeClass("arrow_down");
                }
            }
        </script> 
        <script type="text/javascript">
        $.extend({
            //数值四舍五入
            round:function(n,mantissa){if(!mantissa)mantissa=0;if(mantissa<=0)return Math.round(n);var v=1;for(var i=0;i<mantissa;i++)v*=10;return Math.round(n*v)/v;},
            //金额格式化
            formatMoney : function(num,n) {
                num = String(num.toFixed(n?n:2));
                var re = /(-?\d+)(\d{3})/;
                while(re.test(num)) num = num.replace(re,"$1,$2")
                return n?num:num.replace(/^([0-9,]+\.[1-9])0$/,"$1").replace(/^([0-9,]+)\.00$/,"$1");;
            },
            isN:function(o){return typeof o=="number"},
            isInt:function(o){return $.isN(o)&&Math.round(o)==o},
            replace:function(s,s1,s2){return s.replace(new RegExp(s1,'g'),s2);}
        });
        </script> 
        <script type="text/javascript">
            var warnScale = {alarm_rate1:<?php echo $params['alarm_rate1']?>,alarm_rate2:<?php echo $params['alarm_rate2']?>,alarm_rate3:<?php echo $params['alarm_rate3']?>,alarm_rate4:<?php echo $params['alarm_rate4']?>,alarm_rate5:<?php echo $params['alarm_rate5']?>,alarm_rate6:<?php echo $params['alarm_rate6']?>,alarm_rate7:<?php echo $params['alarm_rate7']?>,alarm_rate8:<?php echo $params['alarm_rate8']?>,alarm_rate9:<?php echo $params['alarm_rate9']?>,alarm_rate10:<?php echo $params['alarm_rate10']?>};
            var stopScale = {stop_rate1:<?php echo $params['stop_rate1']?>,stop_rate2:<?php echo $params['stop_rate2']?>,stop_rate3:<?php echo $params['stop_rate3']?>,stop_rate4:<?php echo $params['stop_rate4']?>,stop_rate5:<?php echo $params['stop_rate5']?>,stop_rate6:<?php echo $params['stop_rate6']?>,stop_rate7:<?php echo $params['stop_rate7']?>,stop_rate8:<?php echo $params['stop_rate8']?>,stop_rate9:<?php echo $params['stop_rate9']?>,stop_rate10:<?php echo $params['stop_rate10']?>};
            var dayFee = {manage_cost_money1:<?php echo $params['manage_cost_money1']/100?>,manage_cost_money2:<?php echo $params['manage_cost_money2']/100?>,manage_cost_money3:<?php echo $params['manage_cost_money3']/100?>,manage_cost_money4:<?php echo $params['manage_cost_money4']/100?>,manage_cost_money5:<?php echo $params['manage_cost_money5']/100?>,manage_cost_money6:<?php echo $params['manage_cost_money6']/100?>,manage_cost_money7:<?php echo $params['manage_cost_money7']/100?>,manage_cost_money8:<?php echo $params['manage_cost_money8']/100?>,manage_cost_money9:<?php echo $params['manage_cost_money9']/100?>,manage_cost_money10:<?php echo $params['manage_cost_money10']/100?>};
            var minLimitMoney = <?php echo $params['minLimitMoney']/100?>; //最低额度
            var maxLimitMoney = <?php echo $params['maxLimitMoney']/100?>; //最大额度 
            $(function() {
                $('#div_risk li').click(function() {
                    $('#div_risk li').removeClass("active");
                    $(this).addClass("active");
                    moneyChange();
                });
                $('#money').keyup(function() {
                    if (isNaN($(this).val())) {
                        $(this).val(0);
                    }
                    moneyChange();
//                    if ($(this).val() > minLimitMoney && $(this).val() < maxLimitMoney) {
//                        moneyChange();
//                    }
                });
                $("#duration").change(function(){
                    moneyChange();
                })
                $('#money').change(function() {
                    if ($(this).val() < minLimitMoney || $(this).val() > maxLimitMoney || $(this).val() % 100 != 0) {
                        layeralert('请输入最少 '+minLimitMoney+' 元最多 '+maxLimitMoney+'元，并且为 100 的倍数。');
                    } else if (isNaN($(this).val())) {
                        $(this).val(0);
                    } else {
                        $(this).val(parseInt($(this).val()));
                        moneyChange();
                    }
                });

                $('#qt').click(function() {
                    $('#pz_sel').slideToggle('fast',
                    function() {
                        $('#pz_inp').toggle();
                        moneyChange();
                    });

                });

                //$('#pz_sel>li').first().click();

                $('#subBtn').click(function() {
                    $(this).prop('disabled',true);
                    var uid = "<?php echo $uid;?>";
                    if(uid == '0'){
                        layerconfirm('您还未登录！',['去登录','取消'],function(){
                            window.location.href = "<?php echo App::URL('wap/member/login')?>";
                        });
                        return;
                    }
                    if(!$("#agree").is(":checked")){
                        layeralert("您必须同意借款协议");
                        return;
                    }
                    var money = $('#money').val() != '' ? parseFloat($('#money').val()) : parseFloat($('#pz_sel .curr').attr('data'));
                    if (money < minLimitMoney || money > maxLimitMoney || money % 100 != 0) {
                        layeralert('请输入最少 '+minLimitMoney+' 元最多 '+maxLimitMoney+'元，并且为 100 的倍数。');
                        return false;
                    }
                    var cpj = $('#hid_total_money').val();//操盘金
                    var deposit = $('#hid_deposit').val();//保证金
                    var jgx = $('#hid_alarm_money').val();//警告线
                    var pcx = $('#hid_stop_money').val();//平仓线
                    var glf = $('#hid_manager_cost_total').val();//管理费
                    var risk = $('#hid_risk').val();//策略比例
                    var duration = $('#hid_cycle').val();//时间周期 
                    var trade_time = $('#hid_trade_time').val();//交易时间 
                    var url = "<?php echo App::URL('web/peiziu/daywinadd')?>";
                    var index = layerloading("提交...");
                    $.post(url,{deposit:deposit,duration:duration,pz_ratio:risk,pz_type:2,trade_time : trade_time},function(res){
                        if(res.status == 0){
                            layer.close(index);
                            layeralert(res.msg);
                            $(this).prop('disabled',false);
                        }
                        else{
                            window.location.href = "<?php echo App::URL('wap/user/peizi');?>" + "&pz_type=2";
                        }
                    },'json');
                });
                
                moneyChange();

            });
            function get_risk(){
                return parseInt($("#div_risk .active").data("times"));
            }
            function xround(x, num){
                return Math.round(x * Math.pow(10, num)) / Math.pow(10, num) ;
            }
            function moneyChange() {
                var deposit = $('#money').val();
                if(deposit==""){
                    deposit = 1000;
                }
                deposit = parseFloat(deposit);
                var cycle = $('#duration').val();//时间周期
                var risk = get_risk();//倍数
                var peizi_money = deposit * risk;
                var total_money = deposit+peizi_money;
                var alarm_money = peizi_money+deposit*warnScale['alarm_rate'+risk]/100;//警戒线
                var stop_money = peizi_money+deposit*stopScale['stop_rate'+risk]/100;//止损线
                var managet_cost = xround(peizi_money*dayFee['manage_cost_money'+risk],2);//单月管理费
                var manager_cost_total = xround(managet_cost*cycle,2);//总管理费


                $("#accountManageFees").html(managet_cost+'元/月 共'+manager_cost_total+'元');//管理费
                $("#totalAmount").html($.formatMoney(total_money));//总操盘金
                $("#tAtips").html(deposit+"(本金)+"+peizi_money+"(操盘资金)");//总操盘金组成
                $("#warnLine").html($.formatMoney(alarm_money));//警戒线
                $("#warnLineTips").html("(预警线=操盘资金+保证金×"+warnScale['alarm_rate'+risk]+"%)");//警戒线组成
                $("#outLine").html($.formatMoney(stop_money));//止损线
                $("#outLineTips").html("(平仓线=操盘资金+保证金×"+stopScale['stop_rate'+risk]+"%)");//止损线组成
                $("#bzjOK").html($.formatMoney(deposit));//保证金
                $("#glfOK").html($.formatMoney(manager_cost_total));//总管理费
                $("#zjeOK").html($.formatMoney(xround(deposit+manager_cost_total,2)));//总费用
                $("#cycle").html(cycle);
                $("#demo").html("备注：您需支付的金额为保证金"+deposit+"元+"+manager_cost_total+"元（利息）= "+(deposit+manager_cost_total)+"元");
                $("#hid_cycle").val(cycle);
                $("#hid_risk").val(risk);
                $("#hid_deposit").val(deposit);
                $("#hid_peizi_money").val(peizi_money);
                $("#hid_total_money").val(total_money);
                $("#hid_alarm_money").val(alarm_money);
                $("#hid_stop_money").val(stop_money);
                $("#hid_managet_cost").val(managet_cost);
                $("#hid_manager_cost_total").val(manager_cost_total);
                
            }
        </script> 
        <input type="hidden" id="hid_cycle" value=""/>
        <input type="hidden" id="hid_risk" value=""/>
        <input type="hidden" id="hid_deposit"/>
        <input type="hidden" id="hid_peizi_money"/>
        <input type="hidden" id="hid_total_money"/>
        <input type="hidden" id="hid_alarm_money"/>
        <input type="hidden" id="hid_stop_money"/>
        <input type="hidden" id="hid_managet_cost"/>
        <input type="hidden" id="hid_manager_cost_total"/>
        <input type="hidden" id="hid_trade_time" value="0"/>
        <!--页脚-->
        
    </body>
</html>