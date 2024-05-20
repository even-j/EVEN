<!--include file "admin_include.php"-->

<div class="container clearfix">
    <div class="main-wrap">
       <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="peizi" >
                    <input type="hidden" name="ac" value="view" >
                    <table class="search-tab">
                        
                    </table>
                </form>
            </div>
        </div>
      
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div id="div_content" class="result-content" style="width:100%;overflow: auto">
                    <table class="result-tab" style="width:100%" >
                        <tr>
                            <th style="width: 100px;">策略类型</th>
                            <th style="width: 150px;">订单时间</th>
                            <th style="width: 100px;">姓名</th>
                            <th style="width: 100px;">手机号</th>
                            <th style="width: 100px;">证券帐户</th>
                            <th style="width: 100px;">总实盘金<br>(万元)</th>
                            <th style="width: 60px;">倍数</th>
                            <th style="width: 100px;">总保证金<br>(元)</th>
                            <th style="width: 100px;">当前资产<br>(元)</th>
                            <th style="width: 100px;">盈亏金额<br>(元)</th>
                            <th style="width: 100px;">盈亏比例<br>(%)</th>
                            <th style="width: 100px;">开始操盘时间</th>
                            <th style="width: 100px;">结束操盘时间</th>
                            <th style="width: 120px;">实盘单号</th>
                            <th style="width: 100px;">状态</th>
                        </tr>
                         							
                        <?php foreach ($list as $item){?>
                            <tr>
                                <td><?php echo \Model\Peizi\Peizi::getPzType($item['pz_type'])  ?></td>
                                <td><?php echo date('Y-m-d H:i',$item['pz_time']) ?></td>
                                <td><a href="/index.php?app=admin&mod=user&ac=info&uid=<?php echo $item['uid']?>" ><?php echo $item['true_name']?></a></td>
                                <td><?php echo $item['mobile'] ?></td>
                                <td><?php echo $item['sp_user'] ?></td>
                                <td><?php echo floatval($item['trade_money_total'])/10000/100 ?></td>
                                <td><?php echo floatval($item['pz_ratio'])?></td>
                                <td><?php echo floatval($item['bond_total'])/100 ?></td>
                                <td><?php echo floatval($item['trade_balance'])/100 ?></td>
                                <td><?php echo floatval($item['profit_loss_money'])/100 ?></td>
                                <td><?php echo number_format(floatval($item['profit_loss_money'])/floatval($item['trade_money_total'])*100,2) ?></td>
                                <td><?php echo date('Y-m-d',$item['start_time']) ?></td>
                                <td><?php echo date('Y-m-d',$item['end_time_act']) ?></td>
                                <td><?php echo date('Ymd',$item['pz_time']).$item['pz_id'] ?></td>
                                <td><?php echo \Model\Peizi\Peizi::getStatusName($item['status']) ?></td>
                            </tr>
                        <?php }?>             
                    </table>
                    
                </div>
            </form>
        </div>
       <div class="list-page"><?php echo $pager;?></div>
    </div>
  
    <!--/main-->
</div>
<!--include file "admin_bottom.php"-->