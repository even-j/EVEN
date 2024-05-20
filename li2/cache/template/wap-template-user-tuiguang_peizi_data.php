<?php foreach ($rows as $row){?>
<tr><td colspan="4" style="line-height: 5px;padding:0">&nbsp</td></tr>
<tr>
    <th>ID</th>
    <td class="w120"><span><?php echo $row['pz_id']; ?></span></td>
    <th>手机号</th>
    <td class="w120"><span><?php echo $row['mobile']; ?></span></td>
</tr>
<tr>
    <th>姓名</th>
    <td class="w120"><span><?php echo $row['true_name']; ?></span></td>
    <th>时间</th>
    <td class="w120"><span> <?php echo date('m-d H:i',$row['pz_time']); ?> </span></td>
</tr>
<tr>
    <th>策略资金</th>
    <td class="w120"><span><?php echo $row['bond_total']*$row['pz_ratio']/100; ?>元</span></td>
    <th>周期</th>
    <td class="w120"><span><?php echo $row['pz_times'].($row['pz_type']==1?'天':'月'); ?></span></td>
</tr>
<tr>
    <?php if(isset($user['introducer_type']) && $user['introducer_type']==1){?>
    <th>状态</th>
    <td class="w120"><span><?php echo $peizistatus[$row['status']] ?></span></td>
    <th>盈亏</th>
    <td class="w120"><span><?php echo $row['profit_loss_money']/100; ?>元</span></td>
    <?php }else{?>
    <th>利息</th>
    <td class="w120"><span><?php echo $row['manage_cost_day']/100; ?>元/<?php echo $row['pz_type']==1?'天':'月'; ?></span></td>
    <th></th>
    <td></td>
    <?php }?>
</tr>
<?php }?>