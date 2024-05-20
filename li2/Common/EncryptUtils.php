<?php
namespace Common;
/* 
米迪 php 加密工具类 
*/ 
class EncryptUtils{ 
    const CIPHER = MCRYPT_RIJNDAEL_128; 
    const MODE = MCRYPT_MODE_CBC; 
    const APPENCRYPT_KEY ="6zlxd9yep4ufd1pm";//开发者在米迪后台注册的应用的：应用密码，16 位的 
 
    //米迪的加密算法 
    public function encrptAesBase64($plaintext){ 
    $iv = "\x01\x02\x03\x04\x05\x06\x07\x08\x09\x00\x01\x02\x03\x04\x05\x06"; 
    $padding = 16-(strlen($plaintext)%16); 
    $plaintext .= str_repeat(chr($padding),$padding); 
    $cliphertext = 
    mcrypt_encrypt(self::CIPHER,self::APPENCRYPT_KEY,$plaintext,self::MODE,$iv); 
    $cliphertext = base64_encode($cliphertext); 
    return urlencode($cliphertext); 
    } 
 
    //米迪的链接 URL 
    public function miidi_url(){ 
    $miidi_appid="12345";//开发者在米迪后台注册的应用的：发布 ID 
    $miidi_openId="aabbccee";//微信用户的 openid 
    $miidi_param0="aabbccee";//开发者用来判断唯一用户的标准，可以用 openId 作为值，也可以是开发者自己定义的用户 id，米迪回调开发者的时候会原样返回，开发者需要用这个值区分用户 
    $miidi_appname="光谷盆栽花卉"; //开发者的公众号，也是开发者在米迪后台注册的应用的：应用名称 
    $miidi_wxPetName="昵称 123"; //关注公众号的微信用户的昵称，一定要是用户真实的昵称 
    $miidi_wxUserIcon="http://www.miidi.net/user.png"; //关注公众号的微信用户的头像，一定要是用户真实的头像  
    //五个参数缺一不可，"&wxUserIcon=".urlencode($miidi_wxUserIcon) 这个语法不知道对不对，请开发者自己验证一下 

    $miidi_encryptStr="openId=".$miidi_openId."&appName=".$miidi_appname."&param0=".$miidi_param0."&wxPetName=".urlencode($miidi_wxPetName)."&wxUserIcon=".urlencode($miidi_wxUserIcon); 
    $miidi_encrypt_res=$miidi_appid."_".$this->encrptAesBase64($miidi_encryptStr);// appId+ "_"也必不可缺 

    //打开积分墙 URL 
    $miidi_url_str = "http://ow.miidi.net/ow/wxList.bin?r=".$miidi_encrypt_res; 
    return $miidi_url_str; 
    } 
}  
?>