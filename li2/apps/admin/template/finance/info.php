<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
        <div class="result-wrap">
            <div class="result-content">
                <table class="insert-tab" width="100%">
                		<thead><caption class="mb10 font18"><h1>个人资产情况信息</h1></caption></thead>
                        <tbody>
                            <tr>
                                <th width="120">账号：</th>
                                <td><?php echo $user['mobile']?></td>
                            </tr>
                            <tr>
                                <th>姓名：</th>
                                <td><?php echo $user['true_name']?></td>
                            </tr>
                            <tr>
                                <th>身份证号：</th>
                                <td><?php echo $user['id_card']?></td>
                            </tr>
                            <tr>
                                <th>总充值：</th>
                                <td><?php echo number_format(($user['recharge']/100),2)?></td>
                            </tr>
                            <tr>
                                <th>总盈亏：</th>
                                <td><?php echo number_format(($user['yltq']/100),2)?></td>
                            </tr>
                            <tr>
                                <th>总提现：</th>
                                <td><?php echo $user['tixian']>0 ? '-'.number_format(($user['tixian']/100),2) : number_format(($user['tixian']/100),2)?></td>
                            </tr>
                            <tr>
                                <th>总管理费：</th>
                                <td><?php echo $user['gl_fee']>0 ? '-'.number_format(($user['gl_fee']/100),2) : number_format(($user['gl_fee']/100),2)?></td>
                            </tr>
                            <tr>
                                <th>冻结资金：</th>
                                <td><?php echo number_format(($user['frozen']/100),2)?></td>
                            </tr>
                            
                             <tr>
                                <th>余额：</th>
                                <td><?php echo number_format(($user['balance']/100),2)?>&nbsp;&nbsp;<a href="/index.php?app=admin&mod=finance&ac=fund&uid=<?php echo $user['uid'];?>">历史明细查看</a></td>
                            </tr>
                             <tr>
                                <th>收入-支出：</th>
                                <td class="red"><?php echo $user['yingkui']>0 ? number_format(($user['yingkui']/100),2) : number_format(($user['yingkui']/100),2);?></td>
                            </tr>
                            
                        </tbody>
                 </table>
                 
            </div>
        </div>

    </div>
    <!--/main-->
</div>

<!--include file "admin_bottom.php"-->