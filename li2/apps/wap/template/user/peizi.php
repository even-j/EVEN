<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <!--include file "common.php"-->
        <link rel="stylesheet" href="../../public/wap/css/wap_new.css">
        <script>
            var page =1;
            var pagesize = <?php echo $var['pagesize'];?>;
            var rowcount = <?php echo $var['rowcount'];?>;
            $(function(){
                if(pagesize*page >= rowcount){
                    $("#btn_more").hide();
                }
            })
            function get_data(){
                page++;
                var pz_type = "<?php echo $_GET['pz_type'];?>"
                $.post("<?php echo \App::URL('wap/user/peizi_data');?>",{page : page,pz_type : pz_type},function(data){
                    $("#record").append(data);
                    if(pagesize*page >= rowcount){
                        $("#btn_more").hide();
                    }
                })
            }
            function view(pz_id){
                layer.open({
                    type: 1,
                    content: "<iframe style='width:100%;height:410px' src='<?php echo \App::URL('wap/user/peizi_detail');?>&pz_id="+pz_id+"'></iframe>"
                });
            }
            function add(pz_id){
                layer.open({
                    type: 1,
                    content: "<iframe style='width:100%;height:410px' src='<?php echo \App::URL('wap/user/peizi_add');?>&pz_id="+pz_id+"'></iframe>"
                });
            }
            function fillloss(pz_id){
                layer.open({
                    type: 1,
                    content: "<iframe style='width:100%;height:190px' src='<?php echo \App::URL('wap/user/peizi_filllose');?>&pz_id="+pz_id+"'></iframe>"
                });
            }
            function profit(pz_id){
                layer.open({
                    type: 1,
                    content: "<iframe style='width:100%;height:190px' src='<?php echo \App::URL('wap/user/peizi_getprofit');?>&pz_id="+pz_id+"'></iframe>"
                });
            }
            function end(pz_id){
                layer.open({
                    type: 1,
                    content: "<iframe style='width:100%;height:170px' src='<?php echo \App::URL('wap/user/peizi_end');?>&pz_id="+pz_id+"'></iframe>"
                });
            }
            function password(pz_id){
                layer.open({
                    type: 1,
                    content: "<iframe style='width:100%;height:300px' src='<?php echo \App::URL('wap/user/peizi_spaccount');?>&pz_id="+pz_id+"'></iframe>"
                });
            }
        </script>
    </head>
    <body>
        <!--第二行-->
        <!--------头部导航------------>
        <div class="body">
            <div class="header">
                <h1>策略记录</h1>
                <a class="l-link" href="<?php echo \App::URL('wap/user/account');?>"><span>返回</span></a> 
                <div class="top-menu">
                    <!--<button type="button" class="btn"></button>-->
                </div>
            </div>
            <div style="height: 40px"></div>
            <div class="tabsbox">
                <ul>
                    <li class="<?php if($_GET['pz_type']==1){echo 'c';}?>"><a href="<?php echo \App::URL('wap/user/peizi',array('pz_type'=>1));?>">按天策略</a></li>
                    <li class="<?php if($_GET['pz_type']==2){echo 'c';}?>"><a href="<?php echo \App::URL('wap/user/peizi',array('pz_type'=>2));?>">按月策略</a></li>
                    <li class="<?php if($_GET['pz_type']==4){echo 'c';}?>"><a href="<?php echo \App::URL('wap/user/peizi',array('pz_type'=>4));?>">免费体验</a></li>
                </ul>
            </div>
            <div style="padding:5px 5px">
                <?php if($rows){?>
                <div id="record">
                    <?php foreach ($rows as $row){?>
                    <div class="ms-c9">
                        <table>
                            <tbody>
                                <tr>
                                    <td colspan="2">方案号：<?php echo date('Ymd',$row['pz_time']).$row['pz_id'];?></td>
                                    <td colspan="2" style="text-align:right">申请时间：<?php echo date('Y-m-d',$row['pz_time'])?></td>
                                </tr>
                                <tr>
                                    <th style="width:120px;">账户类型：</th>
                                    <td style="width:100px;"><?php echo Model\Peizi\Peizi::getPzType($row['pz_type']);?></td>
                                    <th style="width:120px;">证券账号：</th>
                                    <td style="width:100px;"><strong class="yellow"><?php echo $row['sp_user'];?></strong></td>
                                </tr>
                                <tr>
                                    <th>账户状态：</th>
                                    <td><?php echo Model\Peizi\Peizi::getStatusName($row['status']);?></td>
                                    <th>操盘资金：</th>
                                    <td><?php echo number_format(floatval($row['trade_money_total'])/100)?></td>
                                </tr>
                                <tr>
                                    <th>预警线：</th>
                                    <td><?php echo number_format(floatval($row['alarm_money'])/100)?></td>
                                    <th>平仓线：</th>
                                    <td><?php echo number_format(floatval($row['stop_money'])/100)?></td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div id="btn_view" class="btn" onClick="view(<?php echo $row['pz_id'];?>)">详情</div>
                                        <?php if($row['pz_type'] == 1 || $row['pz_type'] == 2){
                                            if($row['status'] == 2){?>
                                        <div id="btn_add" class="btn" onClick="add(<?php echo $row['pz_id'];?>)">追加</div>
                                        <div id="btn_fillloss" class="btn" onClick="fillloss(<?php echo $row['pz_id'];?>)">补亏</div>
                                        <div id="btn_profit" class="btn" onClick="profit(<?php echo $row['pz_id'];?>)">提盈</div>
                                        <?php   }
                                        }?>
                                        <?php if($row['status'] == 2){?>
                                        <div id="btn_end" class="btn" onClick="end(<?php echo $row['pz_id'];?>)">终止</div>
                                        <?php  }?>
                                        <?php if($row['status'] != 4){?>
                                        <div id="btn_password" class="btn" onClick="password(<?php echo $row['pz_id'];?>)">密码</div>
                                        <?php  }?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php }?>
                </div>
                <div id="btn_more" onClick="get_data();" style="width:60px;height:20px;line-height: 20px;background: #ddd;text-align: center;font-size: 12px;margin: 0 auto">更多...</div>
                <?php }else{?>
                <div class="emptydata">
                    <p>呃...没有策略记录!</p>
                </div>
                <?php }?>
            </div>
        </div>
    </body>
</html>