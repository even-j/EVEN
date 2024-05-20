<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
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
                var begindate='<?php echo $search_param['begindate']?>';
                var enddate='<?php echo $search_param['enddate']?>';
                $.post("<?php echo \App::URL('wap/user/tuiguang_peizi_data');?>",{page : page,begindate:begindate,enddate:enddate},function(data){
                    $("#record").append(data);
                    if(pagesize*page >= rowcount){
                        $("#btn_more").hide();
                    }
                })
            }
        </script>
        <style>
        .ms-c6 th{border-bottom: 1px solid #eee;border-top: 1px solid #eee}
        </style>
    </head>

    <body class="index">
        <div class="header">
            <h1>推广用户</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height: 40px"></div>
        <div class="ms-c6-t">
            <!--include file "tuiguang_header.php"-->
        </div>
         <div class="space-main clearfix">
            <div class="ms-c6">
                <form action="<?php echo \App::URL('wap/user/tuiguang_peizi');?>" method="get">
                    <input name="app" value="wap" type="hidden"/>
                    <input name="mod" value="user" type="hidden"/>
                    <input name="ac" value="tuiguang_peizi" type="hidden"/>
                    <div class="search-box">
                        <table>
                            <tbody>
                                <tr>
                                    <td style=""><input class="" placeholder="开始时间" name="begindate" value="<?php echo $search_param['begindate']?>" id="begindate" type="date" style="width:92px"></td>
                                    <td style=""><input class="" placeholder="结束时间" name="enddate" value="<?php echo $search_param['enddate']?>" id="enddate" type="date" style="width:92px"></td>
                                    <?php if(isset($user['introducer_type']) && $user['introducer_type']==1){?>
                                    <td style="">
                                        <select name="status" style="height: 22px;line-height: 22px" >
                                            <option value=""  <?php echo $search_param['status']==''?' selected="true"':'';?>>全部</option>
                                            <option value="1" <?php echo intval($search_param['status'])==1?' selected="true"':'';?>>未结束</option>
                                            <option value="4" <?php echo intval($search_param['status'])==4?' selected="true"':'';?>>已结束</option>
                                        </select>
                                    </td>
                                    <?php }?>
                                    <td style="">
                                        <button class="btn" type="submit" style="background: #f53d52;border:none;color:#fff;line-height: 30px;width:40px;text-align: center">查 询</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
                <?php if($rows){ ?>
                <table>
                    <tbody id="record">
                        <tr>
                            <?php if(isset($user['introducer_type']) && $user['introducer_type']==1){?>
                            <td>合计盈亏</th>
                            <td colspan="3" class="w120"><span><?php echo $total[0]['profit_loss_money']; ?></span>元</td>
                            <?php }else{?>
                            <td>合计利息</th>
                            <td colspan="3" class="w120"><span><?php echo $total[0]['manage_cost_day']; ?></span>元</td>
                            <?php }?>
                        </tr>
                        <?php foreach ($rows as $row){?>
                        <tr><td colspan="4" style="line-height: 5px;padding:0">&nbsp</td></tr>
                        <tr>
                            <th>ID</th>
                            <td class="w120"><span><?php echo $row['pz_id']; ?></span></td>
                            <th>手机号</th>
                            <td class="w120"><span><?php echo $row['mobile']; ?></span></td>
                        </tr>
                        <tr>
                            <th>姓名</th>
                            <td class="w120"><span><?php echo $row['true_name']; ?></span></td>
                            <th>时间</th>
                            <td class="w120"><span> <?php echo date('m-d H:i',$row['pz_time']); ?> </span></td>
                        </tr>
                        <tr>
                            <th>策略资金</th>
                            <td class="w120"><span><?php echo $row['bond_total']*$row['pz_ratio']/100; ?>元</span></td>
                            <th>周期</th>
                            <td class="w120"><span><?php echo $row['pz_times'].($row['pz_type']==1?'天':'月'); ?></span></td>
                        </tr>
                        <tr>
                            <?php if(isset($user['introducer_type']) && $user['introducer_type']==1){?>
                            <th>状态</th>
                            <td class="w120"><span><?php echo $peizistatus[$row['status']] ?></span></td>
                            <th>盈亏</th>
                            <td class="w120"><span><?php echo $row['profit_loss_money']/100; ?>元</span></td>
                            <?php }else{?>
                            <th>利息</th>
                            <td class="w120"><span><?php echo $row['manage_cost_day']/100; ?>元/<?php echo $row['pz_type']==1?'天':'月'; ?></span></td>
                            <th></th>
                            <td></td>
                            <?php }?>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                <div id="btn_more" onclick="get_data();" style="width:60px;height:20px;line-height: 20px;background: #ddd;text-align: center;font-size: 12px;margin: 10px auto">更多...</div>
                <?php }else{ ?>
                <div class="emptydata">
                    <p>呃...没有记录!</p>
                </div>
                <?php } ?>
            </div>
             
        </div>
    </body>
</html>
