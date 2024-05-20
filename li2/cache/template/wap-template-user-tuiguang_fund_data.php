<?php foreach ($rows as $row){?>
<tr>
    <td class="w120"><span><?php echo $row['pz_id']; ?></span></td>
    <td class="w120"><span><?php echo $row['money']/100; ?>元</span></td>
    <td class="w120"><span> <?php echo date('m-d H:i',$row['rtime']); ?> </span></td>
</tr>
<?php }?>