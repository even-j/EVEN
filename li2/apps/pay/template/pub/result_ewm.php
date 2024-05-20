<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--include file "common.php"-->
        <style>
            body{background: #fff}
        </style>
    </head>
    <body>
        <div id="top">
        </div>
        <div id="container" class="daywin" style="margin-top:0px;">
            <div style="width:1000px;margin:0 auto;min-height: 400px">
                <div style="padding:50px 100px;text-align: center">
                    <div style="width:100px;display: inline-block">
                        <img src="/public/web/images/alert-s.png"/>
                    </div>
                    <div style="display: inline-block;color:#777;font-size:20px;font-weight: 700;padding: 20px">
                        充值成功
                    </div>
                </div>
                <div style="text-align: center;margin-top: 40px"><a href="javascript:jump()" class="btn btnBg1" style="line-height: 47px;padding:0 50px">查看资金</a></div>
            </div>
            
        </div>
        <!--foot-->
        <div class="clear"></div>

        <script type="text/javascript">
            function jump(){
                var url = "<?php echo DOMAIN . \App::URL('web/user/fund');?>";
                top.window.location.href = url;
            }
        </script>
    </body>
</html>