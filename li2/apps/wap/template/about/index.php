<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <!--include file "common.php"-->
        <link rel="stylesheet" href="/public/web/css/mn-20150101.css">
        <style>
            body{background: #f5f5f5}
        </style>
    </head>
    <body>
        <div class="header">
            <h1>关于我们</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu" style="width: 120px;top:15px;right:10px;text-align: right">
            </div>
        </div>
        <div class="clear" style="height:40px"></div>
        <div style="height:160px;background: #5b0f0c ; background-image: url(/public/wap/images/user/bg.png); background-size: 100%; background-repeat: no-repeat; text-align: center">
            <img src="/public/wap/images/user/logo.png" width="90" style="margin-top:30px"/>
            <!--<p style="color:#fff;font-size:14px;line-height: 16px;margin-top: -5px;padding: 0"><?php echo SITE_NAME;?></p>-->
        </div>
        <div class="user_box">
            <ul>
                <li>
                    <a href="<?php echo \App::URL('wap/about/us')?>">
                        <div class="icon"><img src="/public/wap/images/user/a1_icon.png"/></div>
                        <div class="title">公司简介</div>
                        <div class="tips"></div>
                        <div class="more"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo \App::URL('wap/about/qualification')?>">
                        <div class="icon"><img src="/public/wap/images/user/a2_icon.png"/></div>
                        <div class="title">证件荣誉</div>
                        <div class="tips"></div>
                        <div class="more"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo \App::URL('wap/about/job')?>">
                        <div class="icon"><img src="/public/wap/images/user/a3_icon.png"/></div>
                        <div class="title">人才招聘</div>
                        <div class="tips"></div>
                        <div class="more"></div>
                    </a>
                </li>
            </ul>
        </div>
        <div style="height:10px"></div>
        <div class="user_box">
            <ul>
                <li>
                    <a href="<?php echo \App::URL('wap/about/contact')?>">
                        <div class="icon"><img src="/public/wap/images/user/a4_icon.png"/></div>
                        <div class="title">联系我们</div>
                        <div class="tips"></div>
                        <div class="more"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo \App::URL("wap/article/view",array('pid'=>5));?>">
                        <div class="icon"><img src="/public/wap/images/user/a5_icon.png"/></div>
                        <div class="title">最新公告</div>
                        <div class="tips"></div>
                        <div class="more"></div>
                    </a>
                </li>
            </ul>
        </div>
    </body>
</html>