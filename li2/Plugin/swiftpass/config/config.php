<?php
class Config{
    private $cfg = array(
        'url'=>'https://pay.swiftpass.cn/pay/gateway',
        'mchId'=>'101500961676',//
        'key'=>'0f49301700e18105b58f13ce1e01c053',//
        'version'=>'2.0',
        'notify_url'=> 'http://pay.5159161.com/paycallback_swiftpass.php'//异步回调通知地址，商户上线需改为自己正式的
       );
    
    public function C($cfgName){
        return $this->cfg[$cfgName];
    }
}
?>