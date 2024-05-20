
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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

        <style>
            .bar{padding: 10px}
            .title1{line-height: 40px}
        </style>
    </head>

    <body class="index">
        <!-- Header Start -->
        <div id="top">
            
        </div>
        <div class="header">
            <h1>常见问题</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height:40px;"></div>
        <link href="/public/web/css/article.css" rel="stylesheet" type="text/css" media="screen,projection" />
        <!-- Content Start -->
        <div class="">
            <div class="aboutM">
                <script type="text/javascript">
                    $(function(){
                        $('dt').click(function(){
                            if($(this).parent().attr('class')=='hover'){
                                $(this).parent().removeClass('hover');
                            }else{
                                $(this).parent().addClass('hover');
                            }

                        });
                    });
                </script>
                <style>
                .helpbox { margin-top: -1px; }
                .helpbox .hb-l { width: 250px; min-height: 500px; float: left; }
                .helpbox .hb-l .hb-la { background: url(../images/20150101/bg91.png) 0px -155px no-repeat; height: 63px; }
                .helpbox .hb-l .hb-lb { background: #fff; margin-bottom: 20px; padding: 10px 0; }
                .helpbox .hb-l dl { padding-left: 60px; padding-bottom: 10px; border-bottom: 1px dashed #eee; margin: 0 10px; }
                .helpbox .hb-l dl.s1 { background: url(../images/20150101/bg90.png) 0px 10px no-repeat; }
                .helpbox .hb-l dl.s2 { background: url(../images/20150101/bg90.png) 0px -110px no-repeat; }
                .helpbox .hb-l dl.s3 { background: url(../images/20150101/bg90.png) 0px -235px no-repeat; border-bottom: 0; }
                .helpbox .hb-l dt { color: #6a7883; font-size: 18px; font-weight: 300; line-height: 40px; }
                .helpbox .hb-l dd { font-size: 15px; line-height: 20px; color: #999; }
                .helpbox .hb-l strong { font-size: 20px; color: #e44444; line-height: 30px; }
                .helpbox .hb-l .hb-lc { background: #fff; margin-bottom: 10px; display: none; }
                .helpbox .hb-r { background: #fff; min-height: 675px; width: 690px; float: right; padding: 20px; }
                .helpbox .hbn { height: 40px; border-bottom: 1px solid #eee; margin-bottom: 20px; }
                .helpbox .hbn li { height: 38px; float: left; padding: 0 30px; font: 16px/38px "微软雅黑", tahoma, arial, 宋体; cursor: pointer; }
                .helpbox .hbn li:hover { color: #ff3300; }
                .helpbox .hbn li.c { border-bottom: 5px solid #ff3300; }
                .helpbox .hbc { display: none; }
                .helpbox .hbc dl { padding: 10px 0; margin-bottom: 0px; }
                .helpbox .hbc img { width: 500px; margin: 10px 0; border: 5px solid #f5f5f5; }
                .helpbox .hbc dl dt { font-weight: 600; color: #666; line-height: 40px; background: #f5f5f5 url(/public/web/images/plus.png) 10px center no-repeat; text-indent: 30px; cursor: pointer; }
                .helpbox .hbc dl dt:hover { color: #F30; }
                .helpbox .hbc dl.hover { padding: 10px 0 30px 0; }
                .helpbox .hbc dl.hover dt { background: #FFF7EE url(/public/web/images/plus.png) 10px center no-repeat; }
                .helpbox .hbc dl.hover dd { display: block; }
                .helpbox .hbc dl dd { line-height: 26px; color: #666; font-size: 14px; text-indent: 20px; display: none; }
                .helpbox .c { display: block; }
                </style>
                <div class="helpbox">
                    <div style="display: block;" class="hbc c">
                        <?php foreach ($list as $row) {?>
                        <dl>
                            <dt><?php echo $row['title'];?>
                                <a name="QA-1-1"></a>
                            </dt>
                            <dd>
                                <?php echo html_entity_decode(htmlspecialchars_decode($row['contents']));?>
                            </dd>

                        </dl>
                        <?php }?>
                    </div>
                </div>

                </div>
            <div style="clear: both"></div>
        </div>
        <!-- Content End -->
        <script type="text/javascript">
            $(function(e) {
//                $(window).scroll(function() {
//                    if ($(document).scrollTop() > 140) {
//                        $('.aboutNav').css('position', 'fixed');
//                        $('.aboutNav').css('top', '0px');
//                        $('.aboutMain').css('margin-left', '190px');
//                    } else {
//                        $('.aboutNav').css('position', '');
//                        $('.aboutMain').css('margin-left', '');
//                    }
//                });
            });
        </script>
        <!-- Footer Start -->
    </body>
</html>