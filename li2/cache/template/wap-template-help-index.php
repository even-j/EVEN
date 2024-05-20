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