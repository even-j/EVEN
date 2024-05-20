
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
        <body style="height: 100%;background: #fff;">
            <iframe id="iframe1" src="http://pay.autoamrb.com.cn<?php echo \App::URL('web/recharge/dorecharge_weixin',array('p3_Amt'=>$var['money'],'uid'=>$var['uid']))?>" width="100%" height="400px" border="0" scrolling="no" frameborder="no"></iframe>
        </body>
        <!-- Footer Start -->
        <!--include file "footer.php"-->
    </body>
</html>