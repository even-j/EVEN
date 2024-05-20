<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<meta name="format-detection" content="telephone=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title><?php if (isset($title)) echo $title ?></title>
<meta name="keywords" content="<?php if (isset($keywords)) echo $keywords ?>">
<meta name="description" content="<?php if (isset($description)) echo $description ?>">
<link rel="stylesheet" href="/public/wap/css/wap_style.css">
<link rel="stylesheet" href="/public/wap/css/wap_new.css">
<script src="/public/wap/js/jquery.js" type="text/javascript"></script>
<script src="/public/wap/js/layer_mobile/layer.js" type="text/javascript"></script>
<script src="/public/wap/js/common.js" type="text/javascript"></script>

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
                    <style>
            .ms-c6-t { height: 35px; background: #f4f4f4; }
            .ms-c6-t ul li { float: left; line-height: 36px;text-align: center; width: 20%; border-right: 1px solid #eceaea; font-size: 12px;box-sizing:border-box;-moz-box-sizing:border-box; /* Firefox */-webkit-box-sizing:border-box; /* Safari */}
            .ms-c6-t ul li.current { background: #fff; border-top: 3px solid #FFF; border-right: 1px solid #eee; border-left: 1px solid #eee; line-height: 30px; border-bottom: 3px solid #F30; }
            .ms-c6-t ul li a { color: #333 }
            .ms-c6-t ul li a:hover { color: #F30; }
        </style> 

                                <ul>
                                    <li <?php if($_GET['ac'] == 'tuiguang'){echo ' class="current"';}?>>
                                        <a href="<?php echo \App::URL('wap/user/tuiguang'); ?>">推广链接</a>
                                    </li>
                                    <li <?php if($_GET['ac'] == 'tuiguang_user'){echo ' class="current"';}?>>
                                        <a href="<?php echo \App::URL('wap/user/tuiguang_user'); ?>">注册用户</a>
                                    </li>
                                    <li <?php if($_GET['ac'] == 'tuiguang_recharge'){echo ' class="current"';}?>>
                                        <a href="<?php echo \App::URL('wap/user/tuiguang_recharge'); ?>">充值记录</a>
                                    </li>
                                    <?php 
                                        if(isset($user['introducer_type']) && $user['introducer_type']==1){
                                            if($_GET['ac'] == 'tuiguang_withdraw')
                                            {
                                                echo '<li class="current"><a href="'.\App::URL('wap/user/tuiguang_withdraw').'">提现记录</a></li>';
                                            }
                                            else
                                            {
                                                echo '<li ><a href="'.\App::URL('wap/user/tuiguang_withdraw').'">提现记录</a></li>';
                                            }
                                        }
                                    ?>
                                    <li <?php if($_GET['ac'] == 'tuiguang_peizi'){echo ' class="current"';}?>>
                                        <a href="<?php echo \App::URL('wap/user/tuiguang_peizi'); ?>">策略记录</a>
                                    </li>
                                    <?php if(!isset($user['introducer_type']) || $user['introducer_type']==0){?>
                                        <li <?php if($_GET['ac'] == 'tuiguang_fund'){echo ' class="current"';}?>>
                                            <a href="<?php echo \App::URL('wap/user/tuiguang_fund'); ?>">推广收入</a>
                                        </li>
                                    <?php }?>
                                </ul>
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
