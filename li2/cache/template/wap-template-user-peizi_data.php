<?php foreach ($rows as $row) { ?>
    <div class="ms-c9">
        <table>
            <tbody>
                <tr>
                    <td colspan="2">方案号：<?php echo date('Ymd', $row['pz_time']) . $row['pz_id']; ?></td>
                    <td colspan="2" style="text-align:right">申请时间：<?php echo date('Y-m-d', $row['pz_time']) ?></td>
                </tr>
                <tr>
                    <th style="width:120px;">账户类型：</th>
                    <td style="width:100px;"><?php echo Model\Peizi\Peizi::getPzType($row['pz_type']); ?></td>
                    <th style="width:120px;">证券账号：</th>
                    <td style="width:100px;"><strong class="yellow"><?php echo $row['sp_user']; ?></strong></td>
                </tr>
                <tr>
                    <th>账户状态：</th>
                    <td><?php echo Model\Peizi\Peizi::getStatusName($row['status']); ?></td>
                    <th>操盘资金：</th>
                    <td><?php echo number_format(floatval($row['trade_money_total']) / 100) ?></td>
                </tr>
                <tr>
                    <th>预警线：</th>
                    <td><?php echo number_format(floatval($row['alarm_money']) / 100) ?></td>
                    <th>平仓线：</th>
                    <td><?php echo number_format(floatval($row['stop_money']) / 100) ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div id="btn_view" class="btn" onclick="view(<?php echo $row['pz_id'];?>)">详情</div>
                        <?php if($row['pz_type'] == 1 || $row['pz_type'] == 2){
                            if($row['status'] == 2){?>
                        <div id="btn_add" class="btn" onclick="add(<?php echo $row['pz_id'];?>)">追加</div>
                        <div id="btn_fillloss" class="btn" onclick="fillloss(<?php echo $row['pz_id'];?>)">补亏</div>
                        <div id="btn_profit" class="btn" onclick="profit(<?php echo $row['pz_id'];?>)">提盈</div>
                        <?php   }
                        }?>
                        <?php if($row['status'] == 2){?>
                        <div id="btn_end" class="btn" onclick="end(<?php echo $row['pz_id'];?>)">终止</div>
                        <?php  }?>
                        <?php if($row['status'] != 4){?>
                        <div id="btn_password" class="btn" onclick="password(<?php echo $row['pz_id'];?>)">密码</div>
                        <?php  }?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<?php
}?>