<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model\Wechat;

/**
 * Description of User
 *
 * @author Administrator
 */
class Service {

    public static function createurl($url,$openid){
        $key=md5(time());
        $value=array();
        $value['openid']=  $openid;
        $value['key']=  $key;
        \Common\Cache::save($openid, $value);
        return DOMAIN.$url.'&lkey='.rawurlencode($key).'&openid='.$openid;
    }

}
