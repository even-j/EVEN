
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style>
            .article {line-height: 26px;padding:15px;font-size: 14px}
            .article h1{text-align: center;font-size: 16px}
            .article .time{text-align: center;border-bottom: 1px solid #eee;margin-bottom: 10px}
            .article_detail span{display: block;}
        </style>
    </head>

    <body class="index">
        <!-- Header Start -->
        <div id="top">
            <!--include file "header.php"-->
        </div>
        <div class="header">
            <h1>网站公告</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height:40px;"></div>
        <link href="/public/web/css/article.css" rel="stylesheet" type="text/css" media="screen,projection" />
        <!-- Content Start -->
        <div class="bar">
            <div class="article">
                <h1 class="articleT"><?php echo $data['title'];?></h1>
                <div class="time">发布时间：<?php echo date('Y-m-d H:i:s',$data['addtime'])?></div>
                <div class="article_detail">
                    <?php echo html_entity_decode(htmlspecialchars_decode($data['contents']));?>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>
        <!-- Content End -->

    </body>
</html>