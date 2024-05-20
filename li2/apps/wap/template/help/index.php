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
            <h1>帮助中心</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu" style="width: 120px;top:15px;right:10px;text-align: right">
            </div>
        </div>
        <div class="clear" style="height:40px"></div>
<!--        <div style="height:160px;background: #996666;text-align: center">
            <img src="/public/wap/images/user/logo.png" width="90" style="margin-top:30px"/>
            <p style="color:#fff;font-size:14px;line-height: 16px;margin-top: -5px;padding: 0"><?php echo SITE_NAME;?></p>
        </div>-->
        <div class="user_box">
            <ul>
                <li>
                    <a href="<?php echo \App::URL('wap/help/guide')?>">
                        <div class="title" style="padding-left: 15px">新手指南</div>
                        <div class="tips"></div>
                        <div class="more"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo \App::URL('wap/help/member')?>">
                        <div class="icon"></div>
                        <div class="title" style="padding-left: 15px">常见问题</div>
                        <div class="tips"></div>
                        <div class="more"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo \App::URL('wap/help/storck')?>">
                        <div class="icon"></div>
                        <div class="title" style="padding-left: 15px">策略相关</div>
                        <div class="tips"></div>
                        <div class="more"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo \App::URL('wap/help/safety')?>">
                        <div class="icon"></div>
                        <div class="title" style="padding-left: 15px">安全保障</div>
                        <div class="tips"></div>
                        <div class="more"></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo \App::URL('wap/help/software')?>">
                        <div class="icon"></div>
                        <div class="title" style="padding-left: 15px">APP下载</div>
                        <div class="tips"></div>
                        <div class="more"></div>
                    </a>
                </li>
            </ul>
        </div>
        
    </body>
</html>