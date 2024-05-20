<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <!--include file "common.php"-->
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