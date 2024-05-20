<?php

// +----------------------------------------------------------------------
// | LG [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014  All rights reserved.
// +----------------------------------------------------------------------
// | Author: Lcm
// +----------------------------------------------------------------------

namespace Model\Api;
use Common\Query;

class Showapi {
    
    public static function sfz($idcard,$name){
        $showapi_set = \apps\Config::getInstance()->showapi;
        $params['idcard'] = $idcard;
        $params['name'] = $name;
        $params['showapi_appid'] = $showapi_set['appid'];
        $showapi_secret = $showapi_set['key'];
        $res = self::request('http://route.showapi.com/1072-1', $params, $showapi_secret);
        if($res['code'] == 0){
            return array('ret'=>0,'msg'=>'匹配');
        }
        else{
            return array('ret'=>1,'msg'=>$res['msg']);
        }
    }

    public static function request($url,$params,$showapi_secret){
        $param = self::createParam($params,$showapi_secret);
        $url = $url.'?'.$param;
        $result_str = file_get_contents($url);
        $result = array();
        try{
            $result = json_decode($result_str,true);
        } catch (Exception $ex) {
            return array();
        }
        if($result['showapi_res_code'] == 0){
            $result = $result['showapi_res_body'];
        }
        return $result;
    }

    //创建参数(包括签名的处理)
    protected static function createParam($paramArr, $showapi_secret) {
        $paraStr = "";
        $signStr = "";
        ksort($paramArr);
        foreach ($paramArr as $key => $val) {
            if ($key != '' && $val != '') {
                $signStr .= $key . $val;
                $paraStr .= $key . '=' . urlencode($val) . '&';
            }
        }
        $signStr .= $showapi_secret; //排好序的参数加上secret,进行md5
        $sign = strtolower(md5($signStr));
        $paraStr .= 'showapi_sign=' . $sign; //将md5后的值作为参数,便于服务器的效验
        //echo "排好序的参数:".$paraStr."\r\n";
        return $paraStr;
    }

}
