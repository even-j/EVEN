<!DOCTYPE html>
<html lang="zh-CN">
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

        <link rel="stylesheet" href="/public/wap/css/wap_new.css">
    </head>
    <body>
        <!--第二行-->
        <!--------头部导航------------>
        <div class="body">
            <div class="header">
                <h1>操作成功</h1>
                <div class="top-menu">
                    <!--<button type="button" class="btn"></button>-->
                </div>
            </div>
            <!-----------登录框开始----------------->
            <div class="main full">
                <div class="wrap-s">
                    <div class="successbox">
                        <i></i><strong>成功重置密码</strong>
                    </div>
                </div>
                <div class="btnbox m11">
                    <button type="button" class="btn-a" onclick="window.location.href = '<?php echo \App::URL('wap/index/view')?>';">返回</button>
                </div>
                <div class="btnbox m11">
                    <button type="button" class="btn-b" onclick="<?php echo \App::URL('wap/user/account')?>';">进入个人中心</button>
                </div>
            </div>
        </div>
    </body>
</html>