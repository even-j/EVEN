<?php

echo 's';

$skey = 'ebec010935cbbb58b4360ac49abb0dc0'; //秘钥
$bg_url = '/paycallback_bobi.php'; //交易结束时候的通知地址（后台）

$var['currency_id'] = 1;
$var['money'] = 20;
$var['callback_url'] = $bg_url;
$var['cp_order_id'] = time();
$var['show_name'] = time();
$var['mch_id'] = 10994;
$var['time'] = time();
ksort($var);
$str='';
foreach ( $var as $k=> $v){
    $str .= $k.'='.$v.'&';
}
$sign_str = $str.'pri_key=' . $skey;
$sign = strtolower(md5($sign_str));
$var['sign'] = $sign;
$url ='https://gateway.bbpayapp.com/bobi_api/pay_independent';


$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($var)
    )
);


$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
print_r($result);die;
$result1=json_decode($result);


$headers = array(
    'Content-Type: application/x-www-form-urlencoded',
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($var));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
curl_setopt($ch, CURLOPT_HEADER, 1);
print_r($var);
$output = curl_exec($ch);
curl_close($ch);
echo $url;
print_r($output);






?>