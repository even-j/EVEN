<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <script>
            function open_add(pz_id){
                var url = "<?php echo \App::URL('web/user/peizi_add');?>&pz_id="+pz_id;
                layer.open({
                    type: 2,
                    title: '追加配资',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['580px', '430px'],
                    content: url //iframe的url
                  }); 
            }
            function open_fill(pz_id){
                var url = "<?php echo \App::URL('web/user/peizi_filllose');?>&pz_id="+pz_id;
                layer.open({
                    type: 2,
                    title: '配资补亏',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['480px', '290px'],
                    content: url //iframe的url
                  }); 
            }
            function open_profit(pz_id){
                var url = "<?php echo \App::URL('web/user/peizi_getprofit');?>&pz_id="+pz_id;
                layer.open({
                    type: 2,
                    title: '配资提盈',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['480px', '250px'],
                    content: url //iframe的url
                  }); 
            }
            function open_end(pz_id){
                var url = "<?php echo \App::URL('web/user/peizi_end');?>&pz_id="+pz_id;
                layer.open({
                    type: 2,
                    title: '配资结束',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['480px', '250px'],
                    content: url //iframe的url
                  }); 
            }
            function open_account(pz_id){
                var url = "<?php echo \App::URL('web/user/peizi_spaccount');?>&pz_id="+pz_id;
                layer.open({
                    type: 2,
                    title: '配资帐户',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['480px', '380px'],
                    content: url //iframe的url
                  }); 
            }
        </script>
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
                        <h2><strong>我的操盘</strong></h2>
                        <form action="<?php echo \App::URL('web/user/peizi');?>" method="get">
                            <input name="app" value="web" type="hidden"/>
                            <input name="mod" value="user" type="hidden"/>
                            <input name="ac" value="peizi" type="hidden"/>
                            <input name="pz_type" value="<?php echo $_GET['pz_type'];?>" type="hidden"/>
                            <div class="search-box">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>状态：</th>
                                            <td>
                                                <select name="status">
                                                    <option value="" <?php echo intval($_GET['status'])==0?' selected="true"':'';?>>全部</option>
                                                    <option value="1" <?php echo intval($_GET['status'])==1?' selected="true"':'';?>>划拨中</option>
                                                    <option value="2" <?php echo intval($_GET['status'])==2?' selected="true"':'';?>>操盘中</option>
                                                    <option value="3" <?php echo intval($_GET['status'])==3?' selected="true"':'';?>>申请结束</option>
                                                    <option value="4" <?php echo intval($_GET['status'])==4?' selected="true"':'';?>>已结束</option>
                                                </select>
                                            </td>
                                            <th>操盘方案号：</th>
                                            <td>
                                                <input class="inp" name="num" style="width:110px;" value="<?php echo isset($_GET['num'])?$_GET['num']:'';?>" type="text">
                                            </td>
                                            <th>交易账号：</th>
                                            <td>
                                                <input class="inp" name="sp_user" style="width:110px;" value="<?php echo isset($_GET['sp_user'])?$_GET['sp_user']:'';?>" type="text">
                                            </td>
                                            <td>
                                                <button class="btn" type="submit">查 询</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <?php if($rows){?>
                            <?php foreach ($rows as $row){?>
                            <div class="ms-c9">
                                <div class="c9title">
                                    <span class="l">操盘方案号：<strong><a title="配资订单" href="<?php echo \App::URL('web/user/peizi_detail',array('pz_id'=>$row['pz_id']));?>"><?php echo date('Ymd',$row['pz_time']).$row['pz_id'];?></a> </strong></span>
                                    <span class="r">申请时间：<?php echo date('Y-m-d',$row['pz_time'])?></span>

                                </div>
                                <table>
                                    <tbody>
                                        <tr>
                                            <th style="width:100px;">账户类型：</th>
                                            <td style="width:150px;"><?php echo Model\Peizi\Peizi::getPzType($row['pz_type']);?></td>
                                            <th style="width:100px;">证券账号：</th>
                                            <td><strong class="yellow"><?php echo $row['sp_user'];?></strong></td>
                                            <th style="width:100px;">账户状态：</th>
                                            <td style="width:150px;"><?php echo Model\Peizi\Peizi::getStatusName($row['status']);?></td>
                                        </tr>
                                        <tr>
                                            <th>总操盘资金：</th>
                                            <td><?php echo number_format(floatval($row['trade_money_total'])/100)?></td>
                                            <th>预警线：</th>
                                            <td><?php echo number_format(floatval($row['alarm_money'])/100)?></td>
                                            <th>平仓线：</th>
                                            <td><?php echo number_format(floatval($row['stop_money'])/100)?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="c9btn">
                                    <a href="<?php echo \App::URL('web/user/peizi_detail',array('pz_id'=>$row['pz_id']));?>">方案详情</a>
                                    <?php 
                                        if($row['pz_type'] == 1 || $row['pz_type'] == 2){
                                            if($row['status'] == 2){?>
                                                <a href="javascript:open_add(<?php echo $row['pz_id'];?>)">追加实盘金</a>
                                                <a href="javascript:open_fill(<?php echo $row['pz_id'];?>)">补充亏损</a>
                                                <a href="javascript:open_profit(<?php echo $row['pz_id'];?>)">盈利提取</a>
                                    <?php   }
                                        }?>
                                    <?php if($row['status'] == 2){?>
                                        <a href="javascript:open_end(<?php echo $row['pz_id'];?>)">终止操盘</a>
                                    <?php  }?>
                                    <!--a href="#ynw" target="dialog" data="stock/asset,18373">实时资产查看</a-->
                                    <?php if($row['status'] != 4){?>
                                        <a href="javascript:open_account(<?php echo $row['pz_id'];?>)">查看交易密码</a>
                                    <?php  }?>
                                    <!--旧-->
                                    <?php 
                                        if($row['pz_type'] == 1 || $row['pz_type'] == 2){
                                            if($row['status'] == 2){?>
                                            <!--<a href=" <?php echo \App::URL('web/user/peizi_add',array('pz_id'=>$row['pz_id']));?>" in="pop">追加实盘金</a>
                                                <a href="<?php echo \App::URL('web/user/peizi_filllose',array('pz_id'=>$row['pz_id']));?>" in="pop">补充亏损</a>
                                                <a href="<?php echo \App::URL('web/user/peizi_getprofit',array('pz_id'=>$row['pz_id']));?>" in="pop">盈利提取</a>-->
                                    <?php   }
                                        }?>
                                    <?php if($row['status'] == 2){?>
                                        <!--<a href="<?php echo \App::URL('web/user/peizi_end',array('pz_id'=>$row['pz_id']));?>" in="pop">终止操盘</a>-->
                                    <?php  }?>
                                    <?php if($row['status'] != 4){?>
                                        <!--<a href="<?php echo \App::URL('web/user/peizi_spaccount',array('pz_id'=>$row['pz_id']));?>" in="pop">查看交易密码</a>-->
                                    <?php  }?>
                                    
                                </div>
                            </div>
                            <?php }?>
                        <?php }else{?>
                        <div style="text-align:center;padding:50px">暂时没有符合要求的数据</div>
                        <?php }?>
                        <div class="list-page">
                            <?php echo $pager?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--include file "footer.php"-->
    </body>
</html>