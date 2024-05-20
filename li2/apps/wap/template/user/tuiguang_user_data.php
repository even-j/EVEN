<?php foreach ($rows as $row){?>
    <tr>
        <td class="w120"><span><?php echo $row['mobile'] ?></span></td>
        <td class="w120"><span><?php echo $row['true_name'] ?></span></td>
        <td class="w120"><span> <?php echo date('Y-m-d H:i:s',$row['reg_time']); ?> </span></td>
    </tr>
    <?php }?>