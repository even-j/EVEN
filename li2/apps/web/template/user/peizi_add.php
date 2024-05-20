<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <link href="/public/web/css/dialog.css?v" rel="stylesheet" type="text/css"/>
        <style>
            body{padding:0 10px}
            .sqyanqi table{ margin:20px 0 15px; border-left:solid 1px #ddd;border-bottom:solid 1px #ddd;}
            .sqyanqi table td{ padding:5px 10px; border-top:solid 1px #ddd;border-right:solid 1px #ddd; text-align:center; line-height:27px;}
            .sqyanqi .fwf-gj{ font-size:14px; line-height:14px; text-align:right; margin:12px 0 0 0;border-top: solid 1px #dfdfdf;padding: 15px 0 5px;}
            .sqyanqi .fwf-gj span{ font-size:20px; color:#b20000; font-family:Arial;}
            .sqyanqi .fwf{ font-size:12px; line-height:14px; text-align:right; margin:8px 0 0 0;}
            .sqyanqi .fwf span{ font-size:12px; color:#b20000}
        </style>
        <script type="text/javascript">
            var dayFee = {manage_cost_money1:<?php echo $params['manage_cost_money1']/100?>,manage_cost_money2:<?php echo $params['manage_cost_money2']/100?>,manage_cost_money3:<?php echo $params['manage_cost_money3']/100?>,manage_cost_money4:<?php echo $params['manage_cost_money4']/100?>,manage_cost_money5:<?php echo $params['manage_cost_money5']/100?>,manage_cost_money6:<?php echo $params['manage_cost_money6']/100?>,manage_cost_money7:<?php echo $params['manage_cost_money7']/100?>,manage_cost_money8:<?php echo $params['manage_cost_money8']/100?>,manage_cost_money9:<?php echo $params['manage_cost_money9']/100?>,manage_cost_money10:<?php echo $params['manage_cost_money10']/100?>};
            $(function(){
                $('#add_money').bind('input',function(){
                    if($(this).val()==''){
                        $('#btnAdd').removeClass('submit').addClass('submit_gray');
                    }
                    else{
                        $('#btnAdd').removeClass('submit_gray').addClass('submit');
                    }
                    var zj_apply_money = parseFloat($(this).val());
                    if (zj_apply_money) {
                        var pz_type = <?php echo $pz_row['pz_type'] ?>;
                        var fukuan = 0;
                        var zj_bond = 0;
                        var zj_manage_cost = 0;
                        var pz_ratio = <?php echo $pz_row['pz_ratio'] ?>;
                        var manage_cost_per = parseFloat(dayFee['manage_cost_money'+pz_ratio]);
                        var sheng_days = "<?php echo $sheng_days; ?>";
                        zj_bond = zj_apply_money;
                        zj_apply_money = zj_bond + zj_bond*pz_ratio;
                        zj_manage_cost = zj_bond*pz_ratio*manage_cost_per;//一个月的管理费
                        if(pz_type == 1){
                            zj_manage_cost = zj_manage_cost*sheng_days;
                        }
                        else{
                            zj_manage_cost = zj_manage_cost/30*sheng_days;
                        }
                        fukuan = zj_bond + zj_manage_cost;
                        $('.zj_apply_money').html(zj_apply_money.toFixed(2));
                        $('.zj_cash_deposit').html(zj_bond.toFixed(2));
                        $('.zj_service_money').html(zj_manage_cost.toFixed(2));
                        $('.service_money').html(zj_manage_cost.toFixed(2)+"("+sheng_days+"天)");
                        $('.dj_cash_deposit').html(zj_bond.toFixed(2));
                        $('.heji_fukuan').html(fukuan.toFixed(2));
                    }
                    else{
                        $('.zj_apply_money').html('');
                    }
                });
                $('#btnAdd').click(function(){
                    var pz_type = <?php echo $pz_row['pz_type'] ?>;
                    var money = $("#add_money").val();
                    var pz_id = $("#pz_id").val();
                    var heji_fukuan = parseFloat($('.heji_fukuan').html());
                    var balance = <?php echo floatval($user['balance'])/100 ?>;
                    if(money == ''){
                        layer.alert('金额不能为空',{icon:2});
                        //top.dialog2('金额不能为空','error');
                        return;
                    }
                    if(isNaN(money)){
                        layer.alert('金额应为数字',{icon:2});
                        //top.dialog2('金额应为数字','error');
                        return;
                    }
                    if(balance<money){
                        layer.alert('余额不足',{icon:2});
                        //top.dialog2('余额不足','error');
                        return;
                    }
                    $('#btnAdd').attr("disabled","true");
                    $.post("<?php echo \App::URL('web/user/do_peizi_add')?>", {money:money,pz_id:pz_id},function(res){
                        if(res.code==0){
                            layer.alert(res.msg,{icon:2});
                            //top.dialog2(res.msg,'error');
                        }else{
                            layer.alert(res.msg,{icon:1},function(index){
                                closeWin();
                            });
                            //dlg.destroy();
                            //top.dialog2(res.msg,'success');
                        }                
                    },'json');
                    $('#btnAdd').attr("disabled","false");
                });
            });
            function closeWin(){
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            }
        //    function diffDay(day1,day2){
        //        var s1 = '2012-05-12';
        //        day1 = new Date(day1.replace(/-/g, "/"));
        //        day2 = new Date(day2.replace(/-/g, "/"));
        //        var days = day2.getTime() - day1.getTime();
        //        var time = parseInt(days / (1000 * 60 * 60 * 24));
        //        return time;
        //    }
        </script>
    </head>
    <body>
        <form action="">
            <!--<div class="tip" id="message">盈利超过10%可提取10%以上部分，同时锁定10%以下部分，每周可提1次</div>-->
            <div class="tip" id="message">
                <em>账户余额：</em>
                <font class="cd22 f16 mymoney"><?php echo number_format(floatval($user['balance'])/100,2) ?></font>元  
                <a href="<?php echo \App::URL('web/user/recharge');?>" target="_blank" class="link-blue f16" style="padding-left:10px">马上充值</a>
            </div>
            <table style="width:100%">
                <tr>
                    <td style="text-align:center">
                        <span style="font-weight:bold">追加金保证金：</span>
                        <input class="text" type="text" id="add_money"> 元
                    </td>
                </tr>
            </table>
            <div class="sqyanqi">
                <table class="info" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <td>当前实盘金</td>
                            <td>当前保证金</td>
                            <td>追加实盘金</td>
                            <td>追加保证金</td>
                            <td>追加服务费</td>
                        </tr>
                    </thead>
                    <tr>
                        <td><?php echo number_format($pz_row['trade_money_total'] / 100, 2) ?></td>
                        <td><?php echo number_format($pz_row['bond_total'] / 100, 2) ?></td>
                        <td class="zj_apply_money"></td>
                        <td class="zj_cash_deposit"></td>
                        <td class="zj_service_money"></td>
                    </tr>
                </table>
                <div class="fwf">服务费：<span class="service_money"></span></div>
                <div class="fwf">冻结保证金：<span class="dj_cash_deposit"></span></div>
                <div class="fwf-gj">共计付款：<span class="heji_fukuan"></span></div>
            </div>


            <div class="actions">
                <input type="hidden" id="pz_id" name="pz_id" value="<?php echo $pz_id;?>">
                <input id="btnAdd" class="submit_gray" type="button" value="确认">
                <input class="cancel" type="button" value="取消" onclick="closeWin()">
                <!--<input class="cancel" type="button" value="取消" onclick="dlg.destroy()">-->
            </div>
        </form>
    </body>
</html>