<?php
/**
1）merchant_private_key，商户私钥;merchant_public_key,商户公钥；商户需要按照《密钥对获取工具说明》操作并获取商户私钥，商户公钥。
2）demo提供的merchant_private_key、merchant_public_key是测试商户号1111110166的商户私钥和商户公钥，请商家自行获取并且替换；
3）使用商户私钥加密时需要调用到openssl_sign函数,需要在php_ini文件里打开php_openssl插件
4）php的商户私钥在格式上要求换行，如下所示；
*/
		$merchant_private_key='-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAN+NxALjDswOEp2m
Z/gI9k2m95isobhYQbJINvh2hVguJ8WfJQ609Ycxnyu33/lPBxfZieXevfFwBIXW
Il/NUIISO3M/7XTcxHhyf5qXnOqiO7GIkdMGg+FUmz+gB0loOGKtEf+QdU2hCOxI
+QlVTiFj9rZ1NA+NXNUq+XuIZLNJAgMBAAECgYBUbMdvh6xY55+kJenxxACwhrPO
1rMkWUBGQftwjeIB0Tx354gpK7Hl4pmH+yL8lhnJqf/n7dyxx2oN2TaWE4WpRJTS
8PdkuV/bXxUXn6i7/TKxFBrV+BxuElJkNe0nv0dg6U+KqbUy6RtBlk3pP+GU6SGR
BtJRD6q6MJwis60bYQJBAP2w/+/5Syw7OQ0ruQoFDZXYs16ntT9KYc0/dZbwzKSF
EhAF57AD3ajK6aWgtAO5Hcd/FBXBO+Jkv9ORCmuTjEUCQQDhlo6kT7SYDrt3R3Di
d72LAQRXQtIjIdnm4r6s1LoomW8EGsKyKwNMZQoMazmZtWbMH/t85IszsNbab2uh
6xU1AkEA01Dif8QKJ/fU1/G5mm0HGfB9yLSttuCAgvT/QBGohMoLd6lTijxOINGU
udAY4pkKAykJU+23sib12ocQRPeMeQJAWRfYEAa2oVM4MJyTda2quypUp43pZhyp
bWlhuups9znZwXo8KJeaPuKsvEjgv9cH2VhMP4AXhfuybySQEqvAfQJARwC8SoQm
Bpqsd52qhYgmtx+9Cl1A6MA4aXZNBj4dWKlc2nBeCwiftjC2B/NgTuHB6ly6c2H6
iU92W3BmkpZw7w==
-----END PRIVATE KEY-----';

	//merchant_public_key,商户公钥，按照说明文档上传此密钥到多的宝商家后台，位置为"支付设置"->"公钥管理"->"设置商户公钥"，代码中不使用到此变量
	//demo提供的merchant_public_key已经上传到测试商家号后台
	$merchant_public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDfjcQC4w7MDhKdpmf4CPZNpveY
rKG4WEGySDb4doVYLifFnyUOtPWHMZ8rt9/5TwcX2Ynl3r3xcASF1iJfzVCCEjtz
P+103MR4cn+al5zqojuxiJHTBoPhVJs/oAdJaDhirRH/kHVNoQjsSPkJVU4hY/a2
dTQPjVzVKvl7iGSzSQIDAQAB
-----END PUBLIC KEY-----';
	
/**
1)ddbill_public_key，多的宝公钥，每个商家对应一个固定的多的宝公钥（不是使用工具生成的密钥merchant_public_key，不要混淆），
即为多的宝商家后台"公钥管理"->"多的宝公钥"里的绿色字符串内容,复制出来之后调成4行（换行位置任意，前面三行对齐），
并加上注释"-----BEGIN PUBLIC KEY-----"和"-----END PUBLIC KEY-----"
2)demo提供的ddbill_public_key是测试商户号1111110166的智付公钥，请自行复制对应商户号的智付公钥进行调整和替换。
3）使用多的宝公钥验证时需要调用openssl_verify函数进行验证,需要在php_ini文件里打开php_openssl插件
*/
	$ddbill_public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCD/Ipau83TOAwyicl7miPc6ciM
PEd8UYWfeNb4JL/QDdce3vVdngGMUKEldMA8Hx5N8afXWWiv43KdY1kVVA8bjhDS
KNexHcelZMcj/49BDghS5W6j89EwA01o+03PDY+Ldv45q1AgvIJophN5V12n9y2e
U5mktfXhsIyeyF7YBQIDAQAB
-----END PUBLIC KEY-----';





	



?>