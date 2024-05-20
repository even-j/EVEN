<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>

    <body class="index">
        <!-- Header Start -->
        <div id="top">
            <!--include file "header.php"-->
            <!--include file "nav.php"-->
        </div>
        <!--include file "user_header.php"-->
        <div class="bar">
            <div class="my-space">
                <div class="space-main clearfix">
                    <div class="space-left">
                        <!--include file "user_left_menu.php"-->
                    </div>
                    <div class="space-right">
                        <h2><strong>资金流水</strong></h2>
                        <div class="ms-c8">
                            <dl>
                                <dd><h5>冻结资金</h5><strong><?php echo number_format(floatval($user['frozen'])/100,2) ?></strong>元</dd>
                                <dd class="last"><h5>账户余额</h5><strong><?php echo number_format(floatval($user['balance'])/100,2) ?></strong>元</dd>
                                <dd class="last"><h5>赠送管理费余额</h5><strong><?php echo number_format(floatval($user['send'])/100,2) ?></strong>元</dd>
                                <dt><h5>总资产</h5><strong><?php echo number_format((floatval($user['balance'])+floatval($user['frozen'])+floatval($user['send']))/100,2) ?></strong>元</dt>
                            </dl>
                        </div>
                        <br>
                        <div class="ms-c6">
                            <div class="ms-c6-t">
                                <ul id="accountLogTypes">
                                    <li <?php if(!isset($_GET['fundtype']) || (isset($_GET['fundtype']) && $_GET['fundtype']==0)){echo 'class="current"';}?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>0));?>">全部</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==1){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>1));?>">充值</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==2){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>2));?>">提现</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==5){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>5));?>">冻结保证金</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==6){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>6));?>">解冻保证金</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==7){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>7));?>">补交亏损</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==10){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>10));?>">支付管理费</a>
                                    </li>
                                    <li <?php if(isset($_GET['fundtype']) && $_GET['fundtype']==12){echo 'class="current"';} ?>>
                                        <a href="<?php echo \App::URL("web/user/fund",array('fundtype'=>12));?>">盈利提取</a>
                                    </li>
                                </ul>
                            </div>
                            <div id="accountLogList">
                                <div class="ms-c6-m">
                                    <div class="search-r">
                                        <form id="accountLogListForm" name="accountLogListForm" action="" method="post">
                                            <input id="accountLogType" name="accountLogType" value="all" type="hidden">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <!--th>总记录数：<strong>2</strong></th>
                                                        <th>发生金额汇总：<strong>200.01 元</strong></th-->
                                                        <!--td>
                                                            <div class="sbox">
                                                                <select>
                                                                        <option value="">请选择</option>
                                                                        <option value="27">充值成功</option><option value="80">配资保证金解冻</option>                                            </select>
                                                            </div>
                                                            <div class="sbox">
                                                                <select>
                                                                    <option value="one_week">一星期</option>
                                                                    <option value="one_month">一个月</option>
                                                                    <option value="one_season">三个月</option>
                                                                    <option value="one_year">一年</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td style="width:68px">
                                                            <button id="queryBtn" class="btn" type="button">查询</button>
                                                        </td-->
                                                    </tr>
                                                </tbody>
                                            </table>
                                        <input type="hidden" name="__hash__" value="5731a2cb6647abfdcc77d69fa3ca772e_e081804399179a1a8845e313f4f4f43b"></form>
                                    </div>
                                    <div class="ms-c6-table clearfix">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th style="width:170px">发生具体时间</th>
                                                    <th>类型</th>
                                                    <th style="text-align:right">发生金额</th>
                                                    <th style="text-align:right">账户余额</th>
                                                    <th style="text-align:right">管理费</th>
                                                    <th>备注</th>
                                                </tr>
                                                <?php foreach ($rows as $row){?>
                                                <tr>
                                                    <td><?php echo date('Y-m-d H:i',$row['rtime'])?></td>
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
                                                    <td>
                                                        <?php 
                                                            if(intval($row['rec_id'])>0){
                                                                echo ' <a href="'.\App::URL('web/user/peizi_detail',array('pz_id'=>$row['rec_id'])).'" target="_blank">查看</a>'; 
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                        <div class="list-page">
                                            <?php echo $pager?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
        
        <!--include file "footer.php"-->
    </body>
</html>
