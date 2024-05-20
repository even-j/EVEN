<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style>
            .space-main h4{color:#F60;padding:5px;font-size: 14px}
        </style>
        <script>
            var page =1;
            var pagesize = <?php echo $var['pagesize'];?>;
            var rowcount = <?php echo $var['rowcount'];?>;
            $(function(){
                if(pagesize*page >= rowcount){
                    $("#btn_more").hide();
                }
            })
            function get_data(){
                page++;
                var pz_id = "<?php echo $_GET['pz_id'];?>"
                $.post("<?php echo \App::URL('wap/user/peizi_detail_data');?>",{page : page,pz_id : pz_id},function(data){
                    $("#record").append(data);
                    if(pagesize*page >= rowcount){
                        $("#btn_more").hide();
                    }
                })
            }
        </script>
    </head>

    <body class="index">
        <!-- Header Start -->
        <div class="bar">
            <div class="my-space">
                <div class="space-main clearfix" style="padding:5px">
                    <h4>基本信息</h4>
                    <div class="formbox_new">
                        <table class="h-20">
                            <tbody>
                                <tr>
                                    <th>策略单号：</th>
                                    <td><?php echo date('Ymd',$pz_row['pz_time']).$pz_row['pz_id'];?></td>
                                </tr>
                                <tr>
                                    <th>策略金额：</th>
                                    <td><?php echo number_format(floatval($pz_row['trade_money_total'])/100,2)?> &nbsp;元</td>
                                </tr>
                                <tr>
                                    <th>保证金：</th>
                                    <td><?php echo number_format(floatval($pz_row['bond_total'])/100,2)?> &nbsp;元</td>
                                </tr>
                                <tr>
                                    <th>开始时间：</th>
                                    <td><?php echo date('Y年m月d日',$pz_row['start_time'])?></td>
                                </tr>
                                <tr>
                                    <th>到期时间：</th>
                                    <td><?php echo date('Y年m月d日',$pz_row['end_time'])?></td>
                                </tr>
                                <!--tr>
                                    <th>配资期限：</th>
                                    <td>2 天</td>
                                </tr-->
                                <!--<tr>
                                    <th>配资利息：</th>
                                    <td>0&nbsp;元</td>
                                </tr>-->
                                <tr>
                                    <th>服务费：</th>
                                    <?php if($pz_row['pz_type'] == 1){?>
                                    <td><?php echo number_format(floatval($pz_row['manage_cost_day'])/100,2)?>&nbsp;元/交易日</td>
                                    <?php }elseif($pz_row['pz_type'] == 2){?>
                                    <td><?php echo number_format(floatval($pz_row['manage_cost_day'])/100,2)?>&nbsp;元/自然月</td>
                                    <?php }elseif($pz_row['pz_type'] == 4){?>
                                    <td>免费</td>
                                    <?php }?>
                                </tr>
                                <tr>
                                    <th>借款协议：</th>
                                    <td><a href="<?php echo \App::URL('wap/help/contract',array('pz_id'=>$pz_row['pz_id']))?>" target="_blank" style="color: blue;text-decoration: underline">借款协议</a></td>
                                </tr>
                                <!--tr>
                                    <th>券商通道：</th>
                                    <td><strong>-</strong></td>
                                </tr>
                                <tr>
                                    <th>交易账号：</th>
                                    <td><strong class="red">-</strong></td>
                                </tr-->
                            </tbody>
                        </table>
                    </div>
                    <div style="height:10px"></div>
                    <h4>策略资金记录</h4>
                    <div class="listbox_new">
                        <table>
                            <tbody id="record">
                                <tr>
                                    <!--th style="width:100px;">流水号</th-->
                                    <th style="width:350px;">发生类型</th>
                                    <th style="width:150px;">发生金额</th>
                                    <th style="width:150px;">发生时间</th>
                                </tr>
                                <?php 
                                    foreach ($fund_rows as $row){ ?>
                                        <tr>
                                        <!--td align="center">4428</td-->
                                        <td align="center"><?php echo \Model\User\Fund::fundTypeName($row['type']);?>，<?php if($row['table_name']=='user_peizi'){echo '配资单号：'.date('Ymd',$pz_row['pz_time']).$row['rec_id'];}?></td>
                                        <td align="center"> <strong style="color: red;"><?php echo number_format(intval($row['in_or_out'])*floatval($row['money'])/100,2);?></strong> 元
                                        </td>
                                        <td align="center"><?php echo date('Y-m-d H:i:s',$row['rtime']);?></td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <div id="btn_more" onclick="get_data();" style="width:60px;height:20px;line-height: 20px;background: #ddd;text-align: center;font-size: 12px;margin: 10px auto">更多...</div>
                </div>
            </div>
        </div>
        <div style="height:50px;"></div>
        <div style="position: fixed;bottom: 0;left: 0;width:100%;height:40px;background: #fff;z-index: 2;border-top: 1px solid #ccc">
            <div class="btn_disabled"  style="width:86px;height: 27px;line-height: 27px;margin: 7px auto;background: #DDD;color:#333;font-size: 12px" onclick="parent.layer.closeAll()">关闭</div>
        </div>
        <script type="text/javascript">
        </script>
    </body>
</html>
