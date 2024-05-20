<!doctype html>
<html>
<head>
    <meta charset="utf8">
    <title>正在转到付款页</title>
</head>
<body onLoad="document.pay.submit()">
    <form name="pay" action="http://api.jinmpay.com/api/alipayWap/create" method="post">
        <input type="hidden" name="bg_url" value="<?php echo $var['bg_url']?>">
        <input type="hidden" name="biz_code" value="<?php echo $var['biz_code']?>">
        <input type="hidden" name="merchant_no" value="<?php echo $var['merchant_no']?>">
        <input type="hidden" name="merchant_req_no" value="<?php echo $var['merchant_req_no']?>">
        <input type="hidden" name="order_amt" value="<?php echo $var['order_amt']?>">
        <input type="hidden" name="payer_ip" value="<?php echo $var['payer_ip']?>">        
        <input type="hidden" name="return_url" value="<?php echo $var['return_url']?>">
        <input type="hidden" name="sign" value="<?php echo $var['sign']?>">
        <input type="hidden" name="subject" value="<?php echo $var['subject']?>">
    </form>
</body>
</html>
