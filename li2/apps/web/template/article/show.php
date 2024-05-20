
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
        <link href="/public/web/css/article.css" rel="stylesheet" type="text/css" media="screen,projection" />
        <!-- Content Start -->
        <div class="bar">
            <div class="aboutNav">
                <!--include file "about_left_menu.php"-->
            </div>

            <div class="aboutMain">
                <p class="title1"><b>网站公告</b></p>
                <div class="aboutM">
                    <h1 class="articleT"><?php echo $data['title'];?></h1>
                    <span class="time">发布时间：<?php echo date('Y-m-d H:i:s',$data['addtime'])?></span>
                    <div class="articleM">
                        <?php echo html_entity_decode(htmlspecialchars_decode($data['contents']));?>
                    </div>
                </div>	
            </div>
            <div style="clear: both"></div>
        </div>
        <!-- Content End -->

        <!--include file "footer.php"-->
    </body>
</html>