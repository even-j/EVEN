
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

    </head>
    <body>  
        <div class="scroll-wrapper" style="-webkit-overflow-scrolling: touch;overflow-y: scroll;">
            <iframe id="iframe1" src="<?php echo SITE_SERVICE_URL;?>" width="100%" height="100%" scrolling="auto" frameborder="no"></iframe>
        </div>
                <!--底部开始-->
        <div class="clear" style="height: 60px"></div>
        <div class="wap_footer"> 
            <ul>
                <li class="<?php if(!isset($_GET['mod']) || ($_GET['mod']=='index' && $_GET['ac']=='view')){echo 'active';}?>">
                    <a class="home" href="<?php echo \App::URL('wap/index/view')?>" >首页</a> 
                </li>
                <li class="<?php if($_GET['mod']=='peizi' ){echo 'active';}?>">
                    <a class="day" href="<?php echo \App::URL('wap/peizi/month')?>" >策略</a>
                </li>
                <li>
                    <a class="month" href="<?php echo \App::URL('wap/index/kefu')?>">客服</a>
                </li>
                <li class="<?php if($_GET['mod']=='user'){echo 'active';}?>">
                    <a class="user" href="<?php echo \App::URL('wap/user/account')?>">我的</a> 
                </li>
            </ul>
            
        </div>
        <script>
            $(function(){
                $("#nav_help").click(function(){
                    
                })
            })
        </script>
        <!--脚本开始-->
        <style>
            #MEIQIA-BTN-HOLDER{display:none !important}
        </style>

        <div style="display: none">
        <?php echo str_replace("&#039;", "'", html_entity_decode(SITE_SERVICE_SCRIPT))  ; ?> 
        </div>
        <!--脚本结束-->

        <!--底部结束-->
		</script>
        <script type="text/javascript" src="https://s96.cnzz.com/z_stat.php?id=1276284630&web_id=1276284630"></script>
    </body>
    <script type="text/javascript">
    $(function () {
        var window_height = $(window).height();
        var iframe_height = window_height - 40;
        $(".scroll-wrapper").height(iframe_height);
    });

</script>
</html>