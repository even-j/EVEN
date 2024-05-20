<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
        <div class="result-wrap">
            <div class="result-content">
                <table class="insert-tab" width="100%">
                		<thead><caption class="mb10 font18"><h1>用户详细信息</h1></caption></thead>
                        <tbody>
                            <tr>
                                <th width="120">手机账号：</th>
                                <td><?php echo $user['mobile']?>&nbsp;&nbsp;&nbsp;<a href="/index.php?app=admin&mod=user&ac=telmsg&uid=<?php echo $user['uid']?>">发送短信</a></td>
                            </tr>
                            <tr><td colspan="2" style="text-align: center;"><span class="blue font16">身份信息</span></td></tr>
                            <tr>
                                <th>姓名：</th>
                                <td><?php echo $user['true_name']?></td>
                            </tr>
                            <tr>
                                <th>身份证号：</th>
                                <td><?php echo $user['id_card']?></td>
                            </tr>
                            <?php if($user['bank_card']){?>
                            <tr><td colspan="2" style="text-align: center;"><span class="blue font16">银行卡信息</span></td></tr>
                            <tr>
	                            <th>开户名：</th>
	                            <td><?php echo $user['true_name']?></td>
                       		</tr>
                       		 <tr>
	                            <th>开户行：</th>
	                            <td><?php echo $user['bank_card']['bank_name']?></td>
                       		</tr>
                       		 <tr>
	                            <th>开户行所在地：</th>
	                            <td><?php echo $user['bank_card']['province_name'].$user['bank_card']['city_name']?></td>
                       		</tr>
                       		 <tr>
	                            <th>银行卡号：</th>
	                            <td><?php echo $user['bank_card']['card_no']?></td>
                       		</tr>
                       		<?php }?>
                        </tbody>
                 </table>
                 <p align="center"><input class="btn mt10 btn-primary btn10" type="button" value="返回" onclick="javascript:history.back();" name="sub"></p>
            </div>
        </div>

    </div>
    <!--/main-->
</div>
<!--include file "admin_bottom.php"-->