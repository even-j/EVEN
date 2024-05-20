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
                                <form action="<?php echo \App::URL('web/user/tuiguang_recharge');?>" method="get">
                                    <input name="app" value="web" type="hidden"/>
                                    <input name="mod" value="user" type="hidden"/>
                                    <input name="ac" value="tuiguang_recharge" type="hidden"/>
                                    <div class="search-box">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th width="80">充值时间:</th>
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
                                            <th class="w200">充值人手机号</th>
                                            <th class="w200">充值人姓名</th>
                                            <th class="w200">充值金额</th>
                                            <th class="w120">时间</th>
                                        </tr>
                                        <?php foreach ($rows as $row) { ?>
                                            <tr>
                                                <td class="w120"><span><?php echo $row['mobile']; ?></span></td>
                                                <td class="w120"><span><?php echo $row['true_name']; ?></span></td>
                                                <td class="w120"><span><?php echo $row['money']/100; ?>元</span></td>
                                                <td class="w120"><span> <?php echo date('Y-m-d H:i:s',$row['rtime']); ?> </span></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                                <td class="w120"><span><?php echo isset($total[0]) ?$total[0]['mobile']:''; ?></span></td>
                                                <td class="w120"><span></span></td>
                                                <td class="w120"><span><?php echo isset($total[0]) ?$total[0]['money']/100:''; ?>元</span></td>
                                                <td class="w120"><span></span></td>
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
