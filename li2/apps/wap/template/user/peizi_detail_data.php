<?php foreach ($fund_rows as $row) { ?>
    <tr>
        <!--td align="center">4428</td-->
        <td align="center"><?php echo \Model\User\Fund::fundTypeName($row['type']); ?>，<?php if ($row['table_name'] == 'user_peizi') {
        echo '配资单号：' . date('Ymd', $pz_row['pz_time']) . $row['rec_id'];
    } ?></td>
        <td align="center"> <strong style="color: red;"><?php echo number_format(intval($row['in_or_out']) * floatval($row['money']) / 100, 2); ?></strong> 元
        </td>
        <td align="center"><?php echo date('Y-m-d H:i:s', $row['rtime']); ?></td>
    </tr>
<?php
}?>