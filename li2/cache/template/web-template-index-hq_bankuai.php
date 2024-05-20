<tr class="title">
    <td style="color:#ff3646">领涨板块</td>
    <td></td>
    <td><a style="color:#237c02">领跌板块</a></td>
    <td class="text-right"></td>
</tr>
<tr>
    <td>
        <a><?php echo $hangqing_data[count($hangqing_data) - 1]['name']; ?></a>
    </td>
    <td style="<?php echo $hangqing_data[count($hangqing_data) - 1]['zf'] > 0 ? 'color:#ff3646' : 'color:#237c02'; ?>">
        <?php echo $hangqing_data[count($hangqing_data) - 1]['zf'] > 0 ? ('+' . $hangqing_data[count($hangqing_data) - 1]['zf']) : $hangqing_data[count($hangqing_data) - 1]['zf']; ?>%
    </td>
    <td>
        <a><?php echo $hangqing_data[0]['name']; ?></a>
    </td>
    <td style="<?php echo $hangqing_data[0]['zf'] > 0 ? 'color:#ff3646' : 'color:#237c02'; ?>">
        <?php echo $hangqing_data[0]['zf'] > 0 ? ('+' . $hangqing_data[0]['zf']) : $hangqing_data[0]['zf']; ?>%
    </td>
</tr>
<tr>
    <td>
        <a><?php echo $hangqing_data[count($hangqing_data) - 2]['name']; ?></a>
    </td>
    <td style="<?php echo $hangqing_data[count($hangqing_data) - 2]['zf'] > 0 ? 'color:#ff3646' : 'color:#237c02'; ?>">
        <?php echo $hangqing_data[count($hangqing_data) - 2]['zf'] > 0 ? ('+' . $hangqing_data[count($hangqing_data) - 2]['zf']) : $hangqing_data[count($hangqing_data) - 2]['zf']; ?>%
    </td>
    <td>
        <a><?php echo $hangqing_data[1]['name']; ?></a>
    </td>
    <td style="<?php echo $hangqing_data[1]['zf'] > 0 ? 'color:#ff3646' : 'color:#237c02'; ?>">
        <?php echo $hangqing_data[1]['zf'] > 0 ? ('+' . $hangqing_data[1]['zf']) : $hangqing_data[1]['zf']; ?>%
    </td>
</tr>
<tr>
    <td>
        <a><?php echo $hangqing_data[count($hangqing_data) - 3]['name']; ?></a>
    </td>
    <td style="<?php echo $hangqing_data[count($hangqing_data) - 3]['zf'] > 0 ? 'color:#ff3646' : 'color:#237c02'; ?>">
        <?php echo $hangqing_data[count($hangqing_data) - 3]['zf'] > 0 ? ('+' . $hangqing_data[count($hangqing_data) - 3]['zf']) : $hangqing_data[count($hangqing_data) - 3]['zf']; ?>%
    </td>
    <td>
        <a><?php echo $hangqing_data[2]['name']; ?></a>
    </td>
    <td style="<?php echo $hangqing_data[2]['zf'] > 0 ? 'color:#ff3646' : 'color:#237c02'; ?>">
        <?php echo $hangqing_data[2]['zf'] > 0 ? ('+' . $hangqing_data[2]['zf']) : $hangqing_data[2]['zf']; ?>%
    </td>
</tr>
<tr>
    <td>
        <a><?php echo $hangqing_data[count($hangqing_data) - 4]['name']; ?></a>
    </td>
    <td style="<?php echo $hangqing_data[count($hangqing_data) - 4]['zf'] > 0 ? 'color:#ff3646' : 'color:#237c02'; ?>">
        <?php echo $hangqing_data[count($hangqing_data) - 4]['zf'] > 0 ? ('+' . $hangqing_data[count($hangqing_data) - 4]['zf']) : $hangqing_data[count($hangqing_data) - 4]['zf']; ?>%
    </td>
    <td>
        <a><?php echo $hangqing_data[3]['name']; ?></a>
    </td>
    <td style="<?php echo $hangqing_data[3]['zf'] > 0 ? 'color:#ff3646' : 'color:#237c02'; ?>">
        <?php echo $hangqing_data[3]['zf'] > 0 ? ('+' . $hangqing_data[3]['zf']) : $hangqing_data[3]['zf']; ?>%
    </td>
</tr>