
<script src="/public/wap/js/jquery.js" type="text/javascript"></script>
<script src="/public/wap/js/layer_mobile/layer.js" type="text/javascript"></script>
<script src="/public/wap/js/common.js" type="text/javascript"></script>
<link href="/public/wap/css/dialog.css?v" rel="stylesheet" type="text/css"/>
<style>
    .sqyanqi table{ margin:10px 0 10px; border-left:solid 1px #ddd;border-bottom:solid 1px #ddd;font-size:14px}
    .sqyanqi table td{ padding:5px 10px; border-top:solid 1px #ddd;border-right:solid 1px #ddd; text-align:center; line-height:22px;}
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
                layeralert('金额不能为空');
                return;
            }
            if(isNaN(money)){
                layeralert('金额应为数字');
                return;
            }
            if(balance<money){
                layeralert('余额不足');
                return;
            }
            var index = layerloading('提交中');
            $(this).attr("disabled","true");
            $.post("<?php echo \App::URL('wap/user/do_peizi_add')?>", {money:money,pz_id:pz_id},function(res){
                if(res.code==0){
                    layer.close(index);
                    layeralert(res.msg);
                    //closewin();
                    //layeralert(res.msg,'error');
                }else{
                    layerconfirm(res.msg,['确定'],function(){
                        closewin();
                    })
                    //layeralert(res.msg,'success');
                }                
            },'json');
            $(this).attr("disabled","false");
        });
    });
    function closewin(){
        parent.layer.closeAll();
    }
</script>
<form action="">
    <!--<div class="tip" id="message">盈利超过10%可提取10%以上部分，同时锁定10%以下部分，每周可提1次</div>-->
    <div class="tip" id="message" >
        <span>账户余额：</span>
        <font class="cd22 f16 mymoney"><?php echo number_format(floatval($user['balance'])/100,2) ?></font>元  
        <a href="<?php echo \App::URL('wap/user/recharge');?>" target="_blank" class="link-blue f16" style="padding-left:10px">马上充值</a>
    </div>
    <table style="width:100%">
        <tr>
            <td style="width:100px">
                <span style="font-weight:bold;font-size:14px">追加保证金：</span>
            </td>
            <td><input class="text" type="text" id="add_money" style="width:100%"></td>
            <td>元</td>
        </tr>
    </table>
    <div class="sqyanqi">
        <table class="info" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td>当前实盘金</td>
                    <td><?php echo number_format($pz_row['trade_money_total'] / 100, 2) ?></td>
                </tr>
                <tr>
                    <td>当前保证金</td>
                    <td><?php echo number_format($pz_row['bond_total'] / 100, 2) ?></td>
                </tr>
                <tr>
                    <td>追加实盘金</td>
                    <td class="zj_apply_money"></td>
                </tr>
                <tr>
                    <td>追加保证金</td>
                    <td class="zj_cash_deposit"></td>
                </tr>
                <tr>
                    <td>追加服务费</td>
                    <td class="zj_service_money"></td>
                </tr>
            </tbody>
        </table>
        <table class="info" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px">
            <tr>
                <td>服务费</td>
                <td>冻结保证金</td>
                <td>共计付款</td>
            </tr>
            <tr>
                <td style="height:33px;white-space:nowrap;"><span class="service_money"></span></td>
                <td><span class="dj_cash_deposit"></span></td>
                <td><span class="heji_fukuan"></span></td>
            </tr>
        </table>
    </div>
    
    
    <div style="padding: 10px 5px 10px 5px; text-align: center;">
        <input type="hidden" id="pz_id" name="pz_id" value="<?php echo $pz_id;?>">
        <input id="btnAdd" class="submit" type="button" value="确认">
        <input class="cancel" type="button" value="取消" onclick="closewin();">
    </div>
</form>