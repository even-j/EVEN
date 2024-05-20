<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
    	 <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=peizi&ac=loss">补亏划拔</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
             <form action="/index.php?app=admin&mod=peizi&ac=doLossEdit" method="post" onclick="return validateForm();" id="myform" name="myform" enctype="multipart/form-data">
                 <input type="hidden" name="fill_id" value="<?php echo $_GET['fill_id']?>" />
                 <table class="insert-tab" width="100%">
                    <tbody>
                        <tr>
                            <th width="120">策略类型：</th>
                            <td><?php echo \Model\Peizi\Peizi::getPzType($pz_row['pz_type'])  ?></td>
                        </tr>
                        <tr>
                            <th>补亏时间：</th>
                            <td><?php echo date('Y-m-d H:i',$fill_row['add_time']);?></td>
                        </tr>
                        <tr>
                            <th>证券账户：</th>
                            <td><?php echo $pz_row['sp_user'] ?></td>
                        </tr>
                        <tr>
                            <th>补亏金额：</th>
                            <td><?php echo floatval($fill_row['add_loss'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>保证金：</th>
                            <td><?php echo floatval($pz_row['bond_total'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>倍数：</th>
                            <td><?php echo floatval($pz_row['pz_ratio']) ?></td>
                        </tr>
                        <tr>
                            <th>策略金额：</th>
                            <td><?php echo floatval($pz_row['bond_total'])*floatval($pz_row['pz_ratio'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>总操盘金额：</th>
                            <td><?php echo floatval($pz_row['trade_money_total'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>实盘单号：</th>
                            <td><?php echo date('Ymd',$pz_row['pz_time']).$pz_row['pz_id'] ?></td>
                        </tr>
                        <tr>
                            <th><i class="require-red">*</i>划拔状态：</th>
                            <td>
                                <?php if($fill_row['status'] == 0){?>
                                <select name="status" id="status">
                                    <option value="0">未划拔</option>
                                    <option value="1">已划拔</option>
                                </select>
                                <?php }else{?>
                                    已划拔
                                <?php }?>
                            </td>
                        </tr>
                         
                             <tr>
                            <th></th>
                            <td>
                                <?php if($fill_row['status'] == 0){?>
                                <input class="btn btn-primary btn6 mr10" name="submit" value="提交" type="submit">
                                <?php }?>
                                <input class="btn btn6" onClick="goback()" value="返回" type="button">
                                
                            </td>
                        </tr>
                    </tbody>
                 </table>
                </form> 
            </div>
        </div>

    </div>
    <!--/main-->
</div>
<script type="text/javascript">
function validateForm(){
	
	return true;
}
function goback(){
    var url = '/index.php?app=admin&mod=peizi&ac=loss';
    window.location.href = url;
}
</script>
<!--include file "admin_bottom.php"-->