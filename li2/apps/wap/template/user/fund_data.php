<?php foreach ($rows as $row){?>
<tr>
    <td><?php echo date('m-d H:i',$row['rtime'])?></td>
    <td><?php echo \Model\User\Fund::fundTypeName($row['type'])?></td>
    <td class="r"><b>
        <?php if($row['in_or_out']>0){?>
        <span style="color:red"><?php echo number_format($row['in_or_out']*floatval($row['money'])/100,2) ?></span></b>
        <?php }else{?>
        <span style="color:green"><?php echo number_format($row['in_or_out']*floatval($row['money'])/100,2) ?></span></b>
        <?php }?>
    </td>
    <td class="r"><?php echo number_format(floatval($row['balance'])/100,2) ?></td>
    <td class="r"><?php echo number_format(floatval($row['send'])/100,2) ?></td>
</tr>
<?php }?>