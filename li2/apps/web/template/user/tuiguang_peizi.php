<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <link type="text/css" href="/public/admin/css/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
        <link type="text/css" href="/public/admin/css/jquery-ui-timepicker-addon.css" rel="stylesheet" />
        <script type="text/javascript" src="/public/admin/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/public/admin/js/jquery-ui-1.8.17.custom.min.js"></script>
        <script type="text/javascript" src="/public/admin/js/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="/public/admin/js/jquery-ui-timepicker-zh-CN.js"></script>
        <script type="text/javascript">
            $(function () {
                $(".ui_timepicker").datetimepicker();
            })
        </script>
        <style>
            .common-text {
                height: 23px;
                line-height: 23px;
                padding: 2px 4px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
        </style>
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
                        <h2><strong>我推广的用户</strong></h2>
                        <div class="ms-c6">
                            <div class="ms-c6-t">
                                <!--include file "tuiguang_header.php"-->
                            </div>
                            <div class="ms-c6-m">
                                <form action="<?php echo \App::URL('web/user/tuiguang_peizi');?>" method="get">
                                    <input name="app" value="web" type="hidden"/>
                                    <input name="mod" value="user" type="hidden"/>
                                    <input name="ac" value="tuiguang_peizi" type="hidden"/>
                                    <div class="search-box">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <?php if(isset($user['introducer_type']) && $user['introducer_type']==1){?>
                                                    <th width="80">策略状态:</th>
                                                    <td>
                                                        <select name="status">
                                                            <option value=""  <?php echo $search_param['status']==''?' selected="true"':'';?>>全部</option>
                                                            <option value="1" <?php echo intval($search_param['status'])==1?' selected="true"':'';?>>未结束</option>
                                                            <option value="4" <?php echo intval($search_param['status'])==4?' selected="true"':'';?>>已结束</option>
                                                        </select>
                                                    </td>
                                                    <?php }?>
                                                    <th width="80">策略时间:</th>
                                                    <td><input class="common-text ui_timepicker" placeholder="开始时间" name="begindate" value="<?php echo $search_param['begindate']?>" id="begindate" type="text"></td>
                                                    <td>—</td>
                                                    <td><input class="common-text ui_timepicker" placeholder="结束时间" name="enddate" value="<?php echo $search_param['enddate']?>" id="enddate" type="text"></td>
                                                    <td>
                                                        <button class="btn" type="submit">查 询</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                                <div class="ms-c6-table clearfix">
                                    <table>
                                        <tr class="hd" style="height:40px">
                                            <th class="w200">策略id</th>
                                            <th class="w200">策略人手机号</th>
                                            <th class="w200">策略人姓名</th>
                                            <th class="w200">策略时间</th>
                                            <th class="w200">策略资金</th>
                                            <th class="w200">策略周期</th>
                                            <?php if(isset($user['introducer_type']) && $user['introducer_type']==1){?>
                                            <th class="w200">策略状态</th>
                                            <th class="w120">盈亏金额</th> 
                                            <?php }else{?>
                                            <th class="w120">策略利息</th>
                                            <?php }?>
                                        </tr>
                                        <?php foreach ($rows as $row) { ?>
                                            <tr>
                                                <td class="w120"><span><?php echo $row['pz_id']; ?></span></td>
                                                <td class="w120"><span><?php echo $row['mobile']; ?></span></td>
                                                <td class="w120"><span><?php echo $row['true_name']; ?></span></td>
                                                <td class="w120"><span> <?php echo date('Y-m-d H:i:s',$row['pz_time']); ?> </span></td>
                                                <td class="w120"><span><?php echo $row['bond_total']*$row['pz_ratio']/100; ?>元</span></td>
                                                <td class="w120"><span><?php echo $row['pz_times'].($row['pz_type']==1?'天':'月'); ?></span></td>
                                                <?php if(isset($user['introducer_type']) && $user['introducer_type']==1){?>
                                                <td class="w120"><span><?php echo $peizistatus[$row['status']] ?></span></td>
                                                <td class="w120"><span><?php echo $row['profit_loss_money']/100; ?>元</span></td>
                                                <?php }else{?>
                                                <td class="w120"><span><?php echo $row['manage_cost_day']/100; ?>元/<?php echo $row['pz_type']==1?'天':'月'; ?></span></td>
                                                <?php }?>
                                            </tr>
                                        <?php } ?>
                                            <tr>
                                                <td class="w120"><span><?php echo $total[0]['pz_id']; ?></span></td>
                                                <td class="w120"><span></span></td>
                                                <td class="w120"><span></span></td>
                                                <td class="w120"><span></span></td>
                                                <td class="w120"><span><?php echo $total[0]['bond_total']/100; ?>元</span></td>
                                                <td class="w120"><span></span></td>
                                                <?php if(isset($user['introducer_type']) && $user['introducer_type']==1){?>
                                                <td class="w120"><span></span></td>
                                                <td class="w120"><span><?php echo $total[0]['profit_loss_money']/100; ?>元</span></td>
                                                <?php }else{?>
                                                <td class="w120"><span><?php echo $total[0]['manage_cost_day']/100; ?>元</span></td>
                                                <?php }?>
                                            </tr>
                                    </table>
                                    <div id="_page" class="list-page">
                                        <?php echo $pager ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
            });
        </script>
        <!--include file "footer.php"-->
    </body>
</html>
