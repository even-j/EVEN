<?php
/*
1）merchant_private_key，商户私钥;merchant_public_key,商户公钥；商户需要按照《密钥对获取工具说明》操作并获取商户私钥，商户公钥。
2）demo提供的merchant_private_key、merchant_public_key是测试商户号1116668811的商户私钥和商户公钥，请商家自行获取并且替换；
3）使用商户私钥加密时需要调用到openssl_sign函数,需要在php_ini文件里打开php_openssl插件
4）php的商户私钥在格式上要求换行，如下所示；
*/
	$merchant_private_key='-----BEGIN PRIVATE KEY-----
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBANUzlTTpX0sNvKRV
c6+f9Egt6V2zhvqumZVCyTW+kWxdBre722m41mEn5+gpGyCOW9AjZfLQs4ncGP8b
dccbu0d5kM2msTYyjq37+upsJw3XlKMwjT9rXOagdxAMTATvX4puiF1uOTxz+Ccx
DbLCj1/UcOOT1wINqPtx6Fm8OxZBAgMBAAECgYBSQlLBVYGk7anpJec6zdZsuvod
YxUjR5aOVnRXvi1RyBq9bUfc5KoiVklN8/45c3PNPLsrEocTG86xLyEkL3j0CHJJ
Gc0Q2VZo+0qrqUMRSwozVpbEEE2PNXgquRqDiZ5GfwKAxTZEmgGcP3lj2TW1BCiD
7TxbP+LZARBOoILuIQJBAPL+Zurc6D0UIAJ2h23koXpsugdtfEExfmeoTdXq+K4S
hQkurEXlLeKVf+VEdOsIKha2eN4Fny/lDGWdDLOL3RUCQQDgnPSNZeyUmQueZy3N
K4l63YjkVt8teU64A6AKYxtRirymmcfB8S+hdd3auRHqyfI8BZ5OOXU1dcQfVaal
Fld9AkAj1N/YQjr8xrrxogjWa6BkLSRBdCOeeW3qWycfJEcHZDO55ugAZosdnm39
oNqczddnAgFQvAN9TIlHcqEs2LMBAkEAkGsaqpewR9Mnr0+0GUk2+jLaw8Y/dSOc
Q6DBFCyo8gL8TTpvP/ntoCkC3pFEPexevcz2/mDfReJUmbkejuMQmQJBAJXNp8oc
c/9Qr0icsKLbl3AoUyvL3bnAyxZ+2ILPBpZFtkADS4waDPFFU3Pf6H6cQ+/kFy9p
2PTkTk9qcczOv0M=
-----END PRIVATE KEY-----';

	//merchant_public_key,商户公钥，按照说明文档上传此密钥到智得宝商家后台，位置为"支付设置"->"公钥管理"->"设置商户公钥"，代码中不使用到此变量
	$merchant_public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDVM5U06V9LDbykVXOvn/RILeld
s4b6rpmVQsk1vpFsXQa3u9tpuNZhJ+foKRsgjlvQI2Xy0LOJ3Bj/G3XHG7tHeZDN
prE2Mo6t+/rqbCcN15SjMI0/a1zmoHcQDEwE71+Kbohdbjk8c/gnMQ2ywo9f1HDj
-----END PUBLIC KEY-----';
	
/*
1)dinpay_public_key，智得宝公钥，每个商家对应一个固定的智得宝公钥（不是使用工具生成的密钥merchant_public_key，不要混淆），
即为智得宝商家后台"公钥管理"->"智得宝公钥"里的绿色字符串内容,复制出来之后调成4行（换行位置任意，前面三行对齐），
并加上注释"-----BEGIN PUBLIC KEY-----"和"-----END PUBLIC KEY-----"
2)demo提供的dinpay_public_key是测试商户号1116668811的智得宝公钥，请自行复制对应商户号的智得宝公钥进行调整和替换。
3）使用智得宝公钥验证时需要调用openssl_verify函数进行验证,需要在php_ini文件里打开php_openssl插件
*/
		$dinpay_public_key ='-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCBzOT2/XP0i0SOyKVtLoyzVZ14
hKE9GXnd2+Yfv82e5N20bq67FhMhbbd5f5+Cqd8muCopQJAI5ROAO63iSX9WoHxz
Xky+sBlXhBCt4WB9kKNEFgviw0Uox5QD1GaWRv+LQCbTHbIDtdYyAUZeCbaoLOr0
ORx91x8dmdJgt0+1QQIDAQAB
-----END PUBLIC KEY-----'; 	

?>