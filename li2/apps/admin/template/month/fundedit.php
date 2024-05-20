<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
    	 <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=month&ac=fund">实盘资金划拔</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title;?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
             <form action="/index.php?app=admin&mod=month&ac=doFundEdit" method="post" onclick="return validateForm();" id="myform" name="myform" enctype="multipart/form-data">
                 <input type="hidden" name="pz_id" value="<?php echo $_GET['pz_id']?>" />
                 <table class="insert-tab" width="100%">
                    <tbody>
                        <tr>
                            <th width="120">策略类型：</th>
                            <td><?php echo \Model\Peizi\Peizi::getPzType($pz_row['pz_type'])  ?></td>
                        </tr>
                        <tr>
                            <th>订单时间：</th>
                            <td><?php echo date('Y-m-d H:i',$pz_row['pz_time']);?></td>
                        </tr>
                        <tr>
                            <th><i class="require-red">*</i>证券账户：</th>
                            <td><input type="text" id="sp_user" name="sp_user" value="<?php echo $pz_row['sp_user'] ?>" /><i class="tip left pd10"></i></td>
                        </tr>
                        <tr>
                            <th><i class="require-red">*</i>证券密码：</th>
                            <td><input type="text" id="sp_pwd" name="sp_pwd" value="<?php echo $pz_row['sp_pwd'] ?>" /><i class="tip left pd10"></i></td>
                        </tr>
                        <tr>
                            <th>实盘金额(万元)：</th>
                            <td><?php echo floatval($pz_row['trade_money_total'])/10000/100 ?></td>
                        </tr>
                        <tr>
                            <th>倍数：</th>
                            <td><?php echo floatval($pz_row['pz_ratio'])?></td>
                        </tr>
                        <tr>
                            <th>风险保证金(元)：</th>
                            <td><?php echo floatval($pz_row['bond_total'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>风险警戒线(元)：</th>
                            <td><?php echo floatval($pz_row['alarm_money'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>平仓止损线(元)：</th>
                            <td><?php echo floatval($pz_row['stop_money'])/100 ?></td>
                        </tr>
                        <tr>
                            <th>开始时间：</th>
                            <td><?php echo date('Y-m-d',$pz_row['start_time']) ?></td>
                        </tr>
                        <tr>
                            <th>实盘单号：</th>
                            <td><?php echo date('Ymd',$pz_row['pz_time']).$pz_row['pz_id'] ?></td>
                        </tr>
                        <tr>
                            <th><i class="require-red">*</i>划拔状态：</th>
                            <td>
                                <?php if($pz_row['status'] == 1){?>
                                <select name="status" id="status">
                                    <option value="1">未划拔</option>
                                    <option value="2">已划拔</option>
                                </select>
                                <?php }else{?>
                                    已划拔
                                <?php }?>
                            </td>
                        </tr>
                         
                             <tr>
                            <th></th>
                            <td>
                                <?php if($pz_row['status'] == 1){?>
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
	var sp_user = $('#sp_user');
	var sp_pwd = $('#sp_pwd');
	
	if (sp_user.val() == "") {
            sp_user.next().html('证券用户不能为空');
            return false;
	}else{
            sp_user.next().html('');
	}
        if (sp_pwd.val() == "") {
            sp_pwd.next().html('证券密码不能为空');
            return false;
	}else{
            sp_pwd.next().html('');
	}
	return true;
}
function goback(){
    var url = '/index.php?app=admin&mod=month&ac=fund';
    window.location.href = url;
}
</script>
<!--include file "admin_bottom.php"-->