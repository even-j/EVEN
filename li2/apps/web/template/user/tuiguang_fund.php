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
                        <h2><strong>我推广的用户</strong></h2>
                        <div class="ms-c6">
                            <div class="ms-c6-t">
                                <!--include file "tuiguang_header.php"-->
                            </div>
                            <div class="ms-c6-m">
                                <div class="ms-c6-table clearfix">
                                    <table>
                                        <tr class="hd" style="height:40px">
                                            <th class="w200">策略id</th>
                                            <th class="w200">佣金</th>
                                            <th class="w120">时间</th>
                                        </tr>
                                        <?php foreach ($rows as $row) { ?>
                                            <tr>
                                                <td class="w120"><span><?php echo $row['pz_id']; ?></span></td>
                                                <td class="w120"><span><?php echo $row['money']/100; ?>元</span></td>
                                                <td class="w120"><span> <?php echo date('Y-m-d H:i:s',$row['rtime']); ?> </span></td>
                                            </tr>
                                        <?php } ?>
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
