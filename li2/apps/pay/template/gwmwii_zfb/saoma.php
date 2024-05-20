<!doctype html>
<html>
<head>
    <meta charset="utf8">
    <title>正在转到付款页</title>
</head>
<body onLoad="document.pay.submit()">
    <form name="pay" action="http://www.gwmwii.cn/gateway" method="get">
        <input type="hidden" name="version" value="<?php echo $var['version']?>">
        <input type="hidden" name="customerid" value="<?php echo $var['customerid']?>">
        <input type="hidden" name="sdorderno" value="<?php echo $var['sdorderno']?>">
        <input type="hidden" name="total_fee" value="<?php echo $var['total_fee']?>">
        <input type="hidden" name="paytype" value="<?php echo $var['paytype']?>">
        <input type="hidden" name="notifyurl" value="<?php echo $var['notifyurl']?>">
        <input type="hidden" name="returnurl" value="<?php echo $var['returnurl']?>">
        <input type="hidden" name="remark" value="<?php echo $var['remark']?>">
        <input type="hidden" name="bankcode" value="<?php echo $var['bankcode']?>">
        <input type="hidden" name="sign" value="<?php echo $var['sign']?>">
        <input type="hidden" name="get_code" value="<?php echo $var['get_code']?>">
    </form>
</body>
</html>