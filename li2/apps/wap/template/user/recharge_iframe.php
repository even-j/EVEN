<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>

    <body class="index">
        <div class="header">
            <h1>充值</h1>
            <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
            <div class="top-menu">
                <!--<button type="button" class="btn"></button>-->
            </div>
        </div>
        <div style="height: 40px"></div>
        <div class="scroll-wrapper" style="-webkit-overflow-scrolling: touch;overflow-y: scroll;">
            <iframe id="iframe1" src="<?php echo $url;?>" width="100%" height="100%" scrolling="auto" frameborder="no"></iframe>
        </div>
        <script type="text/javascript">
            $(function () {
                var window_height = $(window).height();
                var iframe_height = window_height - 40;
                $(".scroll-wrapper").height(iframe_height);
            });
        </script>
    </body>
    
</html>