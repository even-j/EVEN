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
            <div class="c1000">
                <div class="box" style="margin:30px auto">
                    <div style="padding:20px 49px;text-align: center">
                        
                        <?php if(!empty($error_msg)){ ?>
                        <?php echo $error_msg;?>
                        <?php }else{?>
                        <img width="300" src="<?php echo App::URL("pay/pub/qrcode",array('text'=> urlencode($qrcode)));?>" />
                        <div class="clear"></div>
                        <div style="font-size:14px">打开<?php echo $pay_type;?>扫描支付<?php echo $money;?>元</div>
                        <?php }?>

                    </div><div class="clear"></div>
                </div>      
            </div>
        </div>
        <!--foot-->
        <div class="clear"></div>

        <script type="text/javascript">
            setInterval(function(){
                var recharge_id = "<?php echo $recharge_id;?>";
                var url = "<?php echo \App::URL('pay/pub/is_recharge_success');?>";
                $.post(url,{recharge_id : recharge_id},function(data){
                    if(data.code==1){
                        var jumpurl = "<?php echo \App::URL('pay/pub/result_ewm');?>";
                        window.location.href = jumpurl;
                    }
                },'json')
            },5000)
        </script>
    </body>
</html>