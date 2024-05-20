
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
    </head>
    <body>  
        <div class="scroll-wrapper" style="-webkit-overflow-scrolling: touch;overflow-y: scroll;">
            <iframe id="iframe1" src="<?php echo SITE_SERVICE_URL;?>" width="100%" height="100%" scrolling="auto" frameborder="no"></iframe>
        </div>
        <!--include file "footer.php"-->
    </body>
    <script type="text/javascript">
    $(function () {
        var window_height = $(window).height();
        var iframe_height = window_height - 40;
        $(".scroll-wrapper").height(iframe_height);
    });

</script>
</html>