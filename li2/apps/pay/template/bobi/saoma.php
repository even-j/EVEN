<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <title>正在转到付款页</title>
    <script src="/public/web/js/jquery.js" type="text/javascript"></script>
</head>

<body onLoad="document.pay.submit()"> <!-- -->
<form name="pay" action="https://gateway.bbpayapp.com/bobi_api/pay_independent" method="post">
    <input type="hidden" name="currency_id" value="<?php echo $var['currency_id']?>">
    <input type="hidden" name="money" value="<?php echo $var['money']?>">
    <input type="hidden" name="callback_url" value="<?php echo $var['callback_url']?>">
    <input type="hidden" name="cp_order_id" value="<?php echo $var['cp_order_id']?>">
    <input type="hidden" name="show_name" value="<?php echo $var['show_name']?>">
    <input type="hidden" name="mch_id" value="<?php echo $var['mch_id']?>">
    <input type="hidden" name="time" value="<?php echo $var['time']?>">
    <input type="hidden" name="sign" value="<?php echo $var['sign']?>">
    <input type="submit" value="sssss">
</form>

<script>
    $(document).ready(function() {
        // 提交表单
        $('form').submit(function(event) {
            event.preventDefault();
            $.post("https://gateway.bbpayapp.com/bobi_api/pay_independent", {
                currency_id: $('input[name="currency_id"]').val(),
                money: $('input[name="money"]').val(),
                callback_url: $('input[name="callback_url"]').val(),
                cp_order_id: $('input[name="cp_order_id"]').val(),
                show_name: $('input[name="show_name"]').val(),
                mch_id: $('input[name="mch_id"]').val(),
                time: $('input[name="time"]').val(),
                sign: $('input[name="sign"]').val(),
            }, function(response) {
                alert(response.code);
                // 处理服务器响应
                console.log(response);
            }).fail(function(response) {
                alert("请求失败！");
                // 处理请求失败的情况
                console.log(response);
            });
        });
    });
</script>
</body>
</html>