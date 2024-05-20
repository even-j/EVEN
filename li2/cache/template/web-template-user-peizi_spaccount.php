<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php if (isset($title)) echo $title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if($ISHTTPS==true) {?>
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> 
<?php }?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="description" content="<?php if (isset($description)) echo $description ?>" />
<meta name="keywords" content="<?php if (isset($keywords)) echo $keywords ?>" />
<!--<link href="/public/web/css/common.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="/public/web/css/main.css" rel="stylesheet" type="text/css">
-->
<script src="/public/web/js/jquery.js" type="text/javascript"></script>
<script src="/public/web/layer/3.0.3/layer.js" type="text/javascript"></script>
<script src="/public/web/js/common_home.js?v=3" type="text/javascript"></script>
<script src="/public/web/js/main.js" type="text/javascript"></script>

<script type="text/javascript" src="/public/web/js/add/com.js"></script>
<link href="/public/web/css/add/common.css?v=3" rel="stylesheet" type="text/css" />
<link href="/public/web/css/main.css" rel="stylesheet" type="text/css" />

        <style>
            .sqyanqi table{ margin:20px 0 15px;border-collapse:  collapse}
            .sqyanqi table td,.sqyanqi table th{width:120px; padding:5px 10px; border:solid 1px #ddd; text-align:center; line-height:27px;}
        </style>
        <link href="/public/web/css/dialog.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript">
            function closeWin(){
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            }
        </script>
    </head>
    <body>
        <form action="/member/deposit/save.html">
            <div class="tip" id="message">温馨提示：请妥善保管您的账户密码，切勿告诉他人。 </div>
            <div class="sqyanqi">
                <table>
                    <tr>
                        <th>证券账号：</th>
                        <td><?php echo $pz_row['sp_user'] ? $pz_row['sp_user'] : '已注销或未开户'; ?></td>
                    </tr>
                    <tr>
                        <th>交易密码：</th>
                        <td><?php echo $pz_row['sp_pwd'] ? $pz_row['sp_pwd'] : '******'; ?></td>
                    </tr>
                    <tr>
                        <th>交易软件下载：</th>
                        <td><a href="<?php echo \App::URL("web/help/tradeapp"); ?>" target="_blank" style="background: #FF3F00; padding: 5px 30px;color: #fff;margin-right: 10px;border-radius: 3px;cursor: pointer;font-size: 14px">下载</a></td>
                    </tr>
                </table>
            </div>

            <div class="actions">
                <input class="cancel" type="button" value="关闭" onclick="closeWin()">
                <!--<input class="cancel" type="button" value="关闭" onclick="dlg.destroy()">-->
            </div>
        </form>
    </body>
</html>
